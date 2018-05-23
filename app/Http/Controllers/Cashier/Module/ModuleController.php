<?php

namespace App\Http\Controllers\Cashier\Module;

use App\RMS\FormatGenerator;
use App\RMS\Module\Module;
use App\RMS\Module\ModuleRepositoryInterface;
use App\RMS\ReturnMessage;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ModuleController extends Controller
{
    private $moduleRepository;

    public function __construct(ModuleRepositoryInterface $moduleRepository){
        $this->moduleRepository = $moduleRepository;
    }

    public function index(){
        $modules = $this->moduleRepository->getModules();
        return view('Backend.permission.index')->with('modules',$modules);
    }

    public function create(){
        return view('cashier.permission.permission');
    }

    public function store(){
        $module_name        = Input::get('module_name');
        $paramObj           = new Module();
        $paramObj->module   = $module_name;
        $result             = $this->moduleRepository->store($paramObj);
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Cashier\Module\ModuleController@index')
                ->withMessage(FormatGenerator::message('Success', 'Permission created ...'));
        }
        else{
            return redirect()->action('Cashier\Module\ModuleController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Permission did not create ...'));
        }
    }

    public function edit($id){
        $module = $this->moduleRepository->getModuleById($id);
        return view('cashier.permission.permission')->with('module',$module);
    }

    public function update(){
        $id          = Input::get('id');
        $module_name = Input::get('module_name');
        //check module exist or not
        $old_module   = $this->moduleRepository->getModuleById($id);
        $all_module   = $this->moduleRepository->getModules();
        $flag         = 0;
        if($module_name == $old_module->module ){
            $flag = 0;
        }
        else{
            foreach($all_module as $module){
                if($module_name == $module->staff_id){
                    $flag = 1;
                }
            }
        }
        if($flag == 0){
            $paramObj           = $this->moduleRepository->getModuleById($id);
            $paramObj->module   = $module_name;
            $result = $this->moduleRepository->update($paramObj);

            if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                    return redirect()->action('Cashier\Module\ModuleController@index')
                        ->withMessage(FormatGenerator::message('Success', 'Permission updated ...'));
            }
            else{
                    return redirect()->action('Cashier\Module\ModuleController@index')
                        ->withMessage(FormatGenerator::message('Fail', 'Permission did not update ...'));
            }
        }
        elseif($flag == 1){
            //show warning message if permission has already existed.
            alert()->warning('Permission already exists.Please Try Again!')->persistent('Close');
            return back();
        }
    }
}
