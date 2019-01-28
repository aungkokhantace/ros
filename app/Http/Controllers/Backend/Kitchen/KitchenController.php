<?php

namespace App\Http\Controllers\Backend\Kitchen;

use App\RMS\Infrastructure\Forms\KitchenEditRequest;
use App\RMS\Infrastructure\Forms\KitchenEntryRequest;
use App\RMS\Kitchen\Kitchen;
use App\RMS\Kitchen\KitchenRepositoryInterface;
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

class KitchenController extends Controller
{
    private $KitchenRepository;
    public function __construct(KitchenRepositoryInterface $KitchenRepository,BranchRepository $branchRepo,RestaurantRepository $restaurantRepo)
    {
        $this->KitchenRepository = $KitchenRepository;
        $this->branchRepo        = $branchRepo;
        $this->restaurantRepo = $restaurantRepo;
    }
    public function index(){   
    $kitchen = $this->KitchenRepository->getKitchenByBranch();
 
        return view('Backend.kitchen.kitchenListing')->with('kitchens', $kitchen);
    }

    //To show kitchen entry form
   
 public function create(){
        $branch     = $this->branchRepo->getAllType();
        $restaurant = $this->restaurantRepo->getAllType();

        return view('Backend.kitchen.kitchen_form')->with('branchs',$branch)->with('restaurants',$restaurant);
    }
    public function store(KitchenEntryRequest $request){
        $request->validate();
        $name           = $request->get('name');
        $branch_id      = Utility::getCurrentBranch() != 0 ? Utility::getCurrentBranch(): Input::get('branch');     

        $restaurant_id  = Auth::guard('Cashier')->user()->restaurant_id != null ? Auth::guard('Cashier')->user()->restaurant_id : Input::get('restaurant'); 
        // dd($branch_id,$restaurant_id);

        

        $paramObj                = new Kitchen();
        $paramObj->name          = $name;
        $paramObj->restaurant_id = $restaurant_id;
        $paramObj->branch_id     = $branch_id;

        $result = $this->KitchenRepository->store($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Backend\Kitchen\KitchenController@index')
                ->withMessage(FormatGenerator::message('Success', 'Kitchen created ...'));
        }
        else{
            return redirect()->action('Backend\Kitchen\KitchenController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Kitchen did not create ...'));
        }

    }

    public function edit($id){
        $record=Kitchen::find($id);
        $branch     = $this->branchRepo->getAllType();
        $restaurant = $this->restaurantRepo->getAllType();
        return view('Backend.kitchen.kitchen_form')->with('kitchen',$record)->with('branchs',$branch)->with('restaurants',$restaurant);
    }

    public function update(KitchenEditRequest $request){
        $request->validate();
        $branch_id              = Utility::getCurrentBranch() != 0 ? Utility::getCurrentBranch(): Input::get('branch');     

        $restaurant_id          = Utility::getCurrentRestaurant() != 0 ? Utility::getCurrentRestaurant() : Input::get('restaurant'); 
        $id             = $request->get('id');
        $name           = $request->get('name');
        $lower_name     = strtolower($name);//to change all letter which user edited in form to lower case
        $oldname        = Kitchen::find($id);
        $lower_old_name = strtolower($oldname->name); //to change old name from database to lower
        $flag           = 1;

        $paramObj = Kitchen::find($id);

        //if users don't want to edit name and want to edit other field
        if($lower_name == $lower_old_name ){
            $flag = 1;
        }
        else{
            //select all data from items table
            $all_name = Kitchen::all();
            foreach($all_name as $allname){
                $lower_all_name = strtolower($allname->name);
                //edited name already exists in database
                if($lower_name ==  $lower_all_name){
                    $flag = 0;
                }
            }
        }

//      user is allowed to edit
        if($flag == 1){
            $paramObj->name = $name;
            $result = $this->KitchenRepository->update($paramObj);

            if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                return redirect()->action('Backend\Kitchen\KitchenController@index')
                    ->withMessage(FormatGenerator::message('Success', 'Kitchen updated ...'));
            }
            else{
                return redirect()->action('Backend\Kitchen\KitchenController@index')
                    ->withMessage(FormatGenerator::message('Fail', 'Kitchen did not update ...'));
            }


        }
//        user is not allowed to edit because the edited name already exists in database
        else{
            alert()->error('The kitchen with the same name already exists. ')->persistent('Close');
            return back();
        }
    }

    public function delete($id){
        
        $new_string = explode(',', $id);

        //check category from kitchen
        $cat    =   $this->KitchenRepository->check_category($id);
        //check user from kitchen
        $staff  =   $this->KitchenRepository->check_staff($id);
        if($cat){
            alert()->error('There are categories from this kitchen, you must delete them first!')->persistent('Close');
        }
        elseif($staff){
            alert()->error('There are staffs from this kitchen, you must delete them first!')->persistent('Close');
        }
        else{
            foreach($new_string as $id){
               $this->KitchenRepository->delete($id);
            }
        }
        return redirect()->action('Backend\Kitchen\KitchenController@index'); //to redirect listing page

    }
}
