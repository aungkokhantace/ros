<?php

namespace App\Http\Controllers\Backend\Table;
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
use App\RMS\Utility;
use App\RMS\Restaurant\RestaurantRepository;
use App\RMS\Branch\BranchRepository;


class LocationController extends Controller
{
    private $LocationRepository;
    public function __construct(LocationRepositoryInterface $LocationRepository)
    {
        $this->LocationRepository = $LocationRepository;
        $this->restaurantRepo   = new RestaurantRepository();
        $this->branchRepo       = new BranchRepository();
    }
    public function index(){
        $locations = $this->LocationRepository->get_location();
        // $locations = Location::all();
        return view('Backend.Location.index')->with('locations', $locations);
    }

    public function create(){
        $branch         = $this->branchRepo->getAllType();
        $restaurant     = $this->restaurantRepo->getAllType();
      
        return view('Backend.Location.location')->with('branchs',$branch)
                                         ->with('restaurants',$restaurant);
       
    }

    public function store(LocationEntryRequest $request){
        $request->validate();
        $branch_id              = Utility::getCurrentBranch() != 0 ? Utility::getCurrentBranch(): Input::get('branch');     

        $restaurant_id          = Utility::getCurrentRestaurant() != 0 ? Utility::getCurrentRestaurant() : Input::get('restaurant'); 
        $name                   = $request->get('location_type');

        $paramObj                = new Location();
        $paramObj->location_type = $name;
        $paramObj->restaurant_id = $restaurant_id;
        $paramObj->branch_id     = $branch_id;

        $result = $this->LocationRepository->store($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Backend\Table\LocationController@index')
                ->withMessage(FormatGenerator::message('Success', 'Location created ...'));
        }
        else{
            return redirect()->action('Backend\Table\LocationController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Location did not create ...'));
        }

    }

    public function edit($id){
        $location	=	Location::find($id);
        return view('Backend.Location.location')->with('location',$location);
    }

    public function update(LocationEditRequest $request){
        $request->validate();
        $id             = $request->get('id');
        $name           = $request->get('location_type');
        
        $paramObj 		= Location::find($id);
        if($name == $paramObj->location_type){
            
        	return redirect()->action('Backend\Table\LocationController@index')
                    ->withMessage(FormatGenerator::message('Fail', 'Location Name is already exist'));
        }else{
        	$paramObj->location_type = $name;
            
            $result = $this->LocationRepository->update($paramObj);

            if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                return redirect()->action('Backend\Table\LocationController@index')
                    ->withMessage(FormatGenerator::message('Success', 'Location updated ...'));
            }
            else{
                return redirect()->action('Backend\Table\LocationController@index')
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
        return redirect()->action('Backend\Table\LocationController@index')->withMessage(FormatGenerator::message('Success', 'Location Deleted ...'));

    }

   
}
