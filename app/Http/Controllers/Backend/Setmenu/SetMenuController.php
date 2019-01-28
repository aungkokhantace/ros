<?php

namespace App\Http\Controllers\Backend\Setmenu;

use App\RMS\Infrastructure\Forms\SetMenuEditRequest;
use App\RMS\Infrastructure\Forms\SetMenuInsertRequest;
use App\RMS\Item\Item;
use App\RMS\Kitchen\Kitchen;
use App\RMS\SetMenu\SetMenu;
use App\RMS\SetItem\SetItem;
use App\RMS\SetMenu\SetMenuRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;

use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;
use InterventionImage;
use App\RMS\Utility;
use App\RMS\Restaurant\RestaurantRepository;
use App\RMS\Branch\BranchRepository;

class SetMenuController extends Controller
{
    private $setMenuRepository;

    public function __construct(SetMenuRepositoryInterface $setMenuRepository){
        $this->setMenuRepository = $setMenuRepository;
        $this->restaurantRepo    = new RestaurantRepository();
        $this->branchRepo        = new BranchRepository();
    }

    public function index(){
        // $set_menu = SetMenu::whereNull('deleted_at')->get();
        $set_menu = $this->setMenuRepository->getAllSet();
        $set_item = $this->setMenuRepository->getSetItem();
        $items    = $this->setMenuRepository->getAllItem();
        return view('Backend.set.set_menus_listing', compact('set_menu', 'set_item', 'items'));
    }

    public function create(){
        $category   = $this->setMenuRepository->getCategories();
        $items      = $this->setMenuRepository->getItems();
        $kitchens   = $this->setMenuRepository->getKitchen();
        $continents = $this->setMenuRepository->getContinent();

        $branchs    = $this->branchRepo->getAllType();
        $restaurants= $this->restaurantRepo->getAllType();
        return view('Backend.set.set_menus', compact('category', 'items','kitchens','continents','restaurants','branchs'));
    }

    public function store(SetMenuInsertRequest $request)
    {
        $branch_id                  = Utility::getCurrentBranch() != 0 ? Utility::getCurrentBranch(): Input::get('branch');     

        $restaurant_id              = Utility::getCurrentRestaurant() != 0 ? Utility::getCurrentRestaurant() : Input::get('restaurant'); 

        $set_menus_name             = Input::get('set_menus_name');
        $set_menus_price            = Input::get('set_menus_price');
        $file                       = $request->file('fileupload');
        $imagedata                  = file_get_contents($file);
        $items                      = Input::get('item');
        $photo                      = uniqid().'.'.$file->getClientOriginalExtension();  
        $file->move('uploads', $photo);
        // resizing image
        $image = InterventionImage::make(sprintf('uploads' .'/%s', $photo))->resize(200, 200)->save();

        $status                     = Input::get('status');
        $paramObj                   = new SetMenu();
        $paramObj->set_menus_name   = $set_menus_name;
        $paramObj->set_menus_price  = $set_menus_price;
        $paramObj->image            = $photo;
        $paramObj->mobile_image     = base64_encode($image->encoded);
        $paramObj->status           = $status;
        $paramObj->restaurant_id    = $restaurant_id;
        $paramObj->branch_id        = $branch_id;
        
        $result                     = $this->setMenuRepository->store($paramObj, $items);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Backend\Setmenu\SetMenuController@index')
                ->withMessage(FormatGenerator::message('Success', 'Set Menu created ...'));
        }
        else{
            return redirect()->action('Backend\Setmenu\SetMenuController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Set Menu did not create ...'));
        }

    }

    public function delete($id)
    {
        $new_string = explode(',', $id);
        
        foreach($new_string as $id){
            $this->setMenuRepository->delete($id);
        }

        return redirect()->action('Backend\Setmenu\SetMenuController@index')->withMessage(FormatGenerator::message('Success', 'Items deleted ...')); //to redirect listing page
    }

    public function edit($id){
        $resource    = SetMenu::find($id);
        $restaurant_id = $resource->restaurant_id;
        $branch_id     = $resource->branch_id;

        $set_item    = SetItem::where('set_menu_id','=',$id)->lists('item_id')->toArray();

        $member_type = $this->setMenuRepository->getAllSet();
        $Item        = $this->setMenuRepository->getItemsByBranch($branch_id,$restaurant_id);
        $category    = $this->setMenuRepository->getCategoriesByBranch($branch_id,$restaurant_id);
        $items       = $this->setMenuRepository->getItemsByBranch($branch_id,$restaurant_id);
        $continents  = $this->setMenuRepository->getContinentByBranch($branch_id,$restaurant_id);

        $branch     = $this->branchRepo->getAllType();
        $restaurant = $this->restaurantRepo->getAllType();
        return view('Backend.set.set_menus')->with('member_type', $member_type)
                                            ->with('category', $category)
                                            ->with('items', $items)
                                            ->with('Item', $Item)
                                            ->with('resource', $resource)
                                            ->with('set_item',$set_item)
                                            ->with('continents',$continents)
                                            ->with('branchs',$branch)
                                            ->with('restaurants',$restaurant);
    }

    public function update(SetMenuEditRequest $request){
        $request->validate();
         $branch_id                  = Utility::getCurrentBranch() != 0 ? Utility::getCurrentBranch(): Input::get('branch');     

        $restaurant_id              = Utility::getCurrentRestaurant() != 0 ? Utility::getCurrentRestaurant() : Input::get('restaurant'); 
        $id                             = Input::get('id');
        $set_menus_price                = Input::get('set_menus_price');
        $status                         = Input::get('status');
        $set_menus_name                 = Input::get('set_menus_name');
        $item                           = Input::get('item');
        $file                           = $request->file('fileupload');
        $old_name                       = $this->setMenuRepository->getOldName($id);
        $all_names                      = $this->setMenuRepository->getAllNames();
        $oldprice                       = $old_name->set_menus_price;
        $flag                           = 1;

        if($set_menus_name == $old_name->set_menus_name ){
            $flag = 1;
        }
        else{
            //select all data from category table
            foreach($all_names as $all_name){
                //edited name is already exist in database
                if($set_menus_name ==  $all_name->set_menus_name){
                    $flag = 0;
                }
            }
        }
        if($flag == 1){
            if($file != null){
                $imagedata                  = file_get_contents($file);
                $photo                      = uniqid().'.'.$file->getClientOriginalExtension();
                $file->move('uploads', $photo);
                // resizing image
                $image = InterventionImage::make(sprintf('uploads' .'/%s', $photo))->resize(200, 200)->save();

                $paramObj                   = SetMenu::find($id);
                $paramObj->set_menus_name   = $set_menus_name;
                $paramObj->set_menus_price  = $set_menus_price;
                $paramObj->image            = $photo;
                $paramObj->mobile_image     = base64_encode($image->encoded);
                $paramObj->status           = $status;
                $result = $this->setMenuRepository->setMenuUpdate($paramObj,$item,$oldprice);

                if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                    return redirect()->action('Backend\Setmenu\SetMenuController@index')
                        ->withMessage(FormatGenerator::message('Success', 'Set Menu updated ...'));
                }
                else{
                    return redirect()->action('Backend\Setmenu\SetMenuController@index')
                        ->withMessage(FormatGenerator::message('Fail', 'Set Menu did not update ...'));
                }

            }
            else{
                $set_menus_name             = $request->get('set_menus_name');
                $set_menus_price            = $request->get('set_menus_price');
                $status                     = $request->get('status');
                $paramObj                   = SetMenu::find($id);
                $paramObj->set_menus_name   = $set_menus_name;
                $paramObj->set_menus_price  = $set_menus_price;
                $paramObj->status           = $status;
                $result  = $this->setMenuRepository->itemUpdate($paramObj,$item,$oldprice);

                if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                    return redirect()->action('Backend\Setmenu\SetMenuController@index')
                        ->withMessage(FormatGenerator::message('Success', 'Set Menu updated ...'));
                }
                else{
                    return redirect()->action('Backend\Setmenu\SetMenuController@index')
                        ->withMessage(FormatGenerator::message('Fail', 'Set Menu did not update ...'));
                }

            }
        }
        elseif($flag == 0){
            alert()->error('The set menu with the same name already exists')->persistent('Close');
            return back();
        }

    }
     public function  render_SetMenu($branch_id,$restaurant_id = null){
      
        if($restaurant_id == "undefined"){
            $restaurant_id = null;
        }

        $category   = $this->setMenuRepository->getCategoriesByBranch($branch_id,$restaurant_id);
        $items      = $this->setMenuRepository->getItemsByBranch($branch_id,$restaurant_id);
        $kitchens   = $this->setMenuRepository->getKitchenByBranch($branch_id,$restaurant_id);
        $continents = $this->setMenuRepository->getContinentByBranch($branch_id,$restaurant_id);
        // dd($items);
        if($restaurant_id != 0 || $restaurant_id != null || $restaurant_id != ''){
            $branchs        = $this->branchRepo->getByRestaurant($restaurant_id);
             $restaurants   = $this->restaurantRepo->getAllType();  
        }
        else{
            $restaurant_id   = Utility::getCurrentRestaurant(); 
            $branchs         = $this->branchRepo->getByRestaurant($restaurant_id);
        }     
      
        // $items               = $this->setMenuRepository->getItems();
        $view                = view("Backend.set.set_menus_ajax",compact('category','items','kitchens','continents','branch_id','restaurant_id','restaurants','branchs'))->render();

        return response()->json(['html'=>$view]);
        }
}