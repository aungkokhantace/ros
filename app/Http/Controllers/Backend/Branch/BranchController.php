<?php

namespace App\Http\Controllers\Backend\Branch;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;
use App\RMS\Branch\BranchRepository;
use App\RMS\Utility;
use App\RMS\Restaurant\RestaurantRepository;
use App\RMS\Infrastructure\Forms\BranchEntryRequest;
use App\RMS\Infrastructure\Forms\BranchEditRequest;
use App\RMS\Branch\BranchRepositoryInterface;
use App\RMS\Branch\Branch;


class BranchController extends Controller
{
     private $BranchRepository;
    public function __construct(BranchRepositoryInterface $BranchRepository)
    {
        $this->BranchRepository = $BranchRepository;
        $this->restaurantRepo 	= new RestaurantRepository();
    }

    public function index(){   
    	$branch 				= $this->BranchRepository->getAllType(); 
        return view('Backend.branch.index')->with('branchs', $branch);
    }

     public function create(){
        // $branch     = $this->branchRepo->getAllType();
        $restaurant = $this->restaurantRepo->getAllType();

        return view('Backend.branch.branch')->with('restaurants',$restaurant);
    }
    public function store(BranchEntryRequest $request){
        // dd($request->all());
    	try{
    		$request->validate();
    		 $restaurant_id          = Utility::getCurrentRestaurant() != 0 ? Utility::getCurrentRestaurant() : Input::get('restaurant');   
             // dd($restaurant_id);    

	        $name      	         	= $request->get('name');	      
	        $description            = $request->get('description');
            // dd($name,$description);
	        $paramObj 				= new Branch();
	        $paramObj->name 		= $name;
	        $paramObj->description 	= $description;
            $paramObj->status       = 1;
            $paramObj->restaurant_id= $restaurant_id;

	        $result 				= $this->BranchRepository->store($paramObj);

	        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
	            return redirect()->action('Backend\Branch\BranchController@index')
	                ->withMessage(FormatGenerator::message('Success', 'Branch created ...'));
	        }
	        else{
	            return redirect()->action('Backend\Branch\BranchController@index')
	                ->withMessage(FormatGenerator::message('Fail', 'Branch did not create ...'));
	        }
	 
    	}
    	catch(\Exception $e){
            dd($e);
    		return redirect()->action('Backend\Branch\BranchController@index')
	                ->withMessage(FormatGenerator::message('Fail', 'Branch did not create ...'));

    	}
    }

     public function edit($id)
    {
        $branch                 = Branch::find($id);
        $restaurants            = $this->restaurantRepo->getAllType();
        
        return view('Backend.branch.branch', compact('branch', 'restaurants'));
    }

     public function update(BranchEditRequest $request)
    {
        try{
            $request->validate();
             $id                        = Input::get('id');
             $name                      = Input::get('name');         
             $description               = Input::get('description');

             $paramObj                  = Branch::find($id);
             $paramObj->name            = $name;
             $paramObj->description     = $description;
             $result                    = $this->restaurantRepo->update($paramObj);

              if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                return redirect()->action('Backend\Branch\BranchController@index')
                    ->withMessage(FormatGenerator::message('Success', 'Branch created ...'));
            }
            else{
                return redirect()->action('Backend\Branch\BranchController@index')
                    ->withMessage(FormatGenerator::message('Fail', 'Branch did not create ...'));
            }           

        }
        catch(\Exception $e){
            return redirect()->action('Backend\Branch\BranchController@index')
                    ->withMessage(FormatGenerator::message('Fail', 'Branch did not create ...'));

        }
       
    }

    


}
