<?php

namespace App\Http\Controllers\Cashier\Table;
use App\RMS\Infrastructure\Forms\LocationEditRequest;
use App\RMS\Infrastructure\Forms\LocationEntryRequest;
use App\RMS\Location\Location;
use App\RMS\Location\LocationRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;

class LocationController extends Controller
{
    private $LocationRepository;
    public function __construct(LocationRepositoryInterface $LocationRepository)
    {
        $this->LocationRepository = $LocationRepository;
    }
    public function index(){
        $locations = Location::all();
        return view('cashier.Location.index')->with('locations', $locations);
    }

    public function create(){
        return view('cashier.Location.location');
    }

    public function store(LocationEntryRequest $request){
        $request->validate();

        $name = $request->get('location_type');

        $paramObj = new Location();
        $paramObj->location_type = $name;

        $result = $this->LocationRepository->store($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Cashier\Table\LocationController@index')
                ->withMessage(FormatGenerator::message('Success', 'Location created ...'));
        }
        else{
            return redirect()->action('Cashier\Table\LocationController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Location did not create ...'));
        }

    }

    public function edit($id){
        $location	=	Location::find($id);
        return view('cashier.location.location')->with('location',$location);
    }

    public function update(LocationEditRequest $request){
        $request->validate();
        $id             = $request->get('id');
        $name           = $request->get('location_type');
        
        $paramObj 		= Location::find($id);
        if($name == $paramObj->location_type){
            
        	return redirect()->action('Cashier\Table\LocationController@index')
                    ->withMessage(FormatGenerator::message('Fail', 'Location Name is already exist'));
        }else{
        	$paramObj->location_type = $name;
            
            $result = $this->LocationRepository->update($paramObj);

            if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                return redirect()->action('Cashier\Table\LocationController@index')
                    ->withMessage(FormatGenerator::message('Success', 'Location updated ...'));
            }
            else{
                return redirect()->action('Cashier\Table\LocationController@index')
                    ->withMessage(FormatGenerator::message('Fail', 'Location did not update ...'));
            }

        }
        
    }

    public function delete($id){
        $new_string = explode(',',$id);
        foreach($new_string as $id)
        {
            $this ->LocationRepository->delete($id);
        }
        return redirect()->action('Cashier\Table\LocationController@index');

    }
}
