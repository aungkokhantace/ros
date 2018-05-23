<?php

namespace App\Http\Controllers\Backend\Staff;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\RMS\Infrastructure\Forms\StaffTypeRequest;
use App\RMS\Infrastructure\Forms\StaffTyeEditRequest;
use App\RMS\Role\RoleRepositoryInterface;
use App\RMS\Role\Role;
use App\RMS\Module\Module;
use App\RMS\Permission\Permission;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;

class RoleController extends Controller
{
    private $roleRepository;
    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }


    public function index()
    {
        $roles          = $this->roleRepository->getRoles();
        $permissions     = $this->roleRepository->getPermissionWithModules();

        return view('Backend.user.Staff_Type_List')->with('roles', $roles)->with('permissions',$permissions);
    }

    public function create(){
        $modules = Module::all();

        return view('Backend.user.Staff_Type')->with('modules',$modules);
    }
    public function store(StaffTypeRequest $request)
    {
        $request->validate();
        $id             = Auth::guard('Cashier')->user()->id;
        $name           = Input::get('name');
        $description    = Input::get('description');
        $permission     = Input::get('permission');
        $result = $this->roleRepository->store($name,$description,$permission,$id);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Backend\Staff\RoleController@index')
                ->withMessage(FormatGenerator::message('Success', 'Role created ...'));
        }
        else{
            return redirect()->action('Backend\Staff\RoleController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Role did not create ...'));
        }

    }

    public function edit($id){
        $roles          = $this->roleRepository->getID($id);
        $modules = Module::all();
        $permissions    = Permission::where('role_id','=',$id)->lists('module_id')->toArray();

        return view('Backend.user.Staff_Type')->with('roles', $roles)->with('permissions',$permissions)->with('modules',$modules);

    }

    public function update(StaffTyeEditRequest $request)
    {
        $id             = Input::get('id');
        $name           = Input::get('name');
        $description    = Input::get('description');
        $permission     = Input::get('permission');
        $updated_by     = Auth::guard('Cashier')->user()->id;
        $result = $this->roleRepository->update($id,$name,$description,$permission,$updated_by);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Backend\Staff\RoleController@index')
                ->withMessage(FormatGenerator::message('Success', 'Role updated ...'));
        }
        else{
            return redirect()->action('Backend\Staff\RoleController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Role did not update ...'));
        }

    }

     public function delete($id){
        $new_string = explode(',', $id);
         $deleted_by     = Auth::guard('Cashier')->user()->id;
        $role       = $this->roleRepository->check_staff($id);
        if($role){
            alert()->error('There are staffs of this type, you must delete them first!')->persistent('Close');
        }
        else{
            foreach($new_string as $id){
                $this->roleRepository->delete_role($id,$deleted_by);
            }
        }
        return redirect()->action('Cashier\Staff\RoleController@index'); //to redirect listing page
    }
}
