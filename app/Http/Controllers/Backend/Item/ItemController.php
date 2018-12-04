<?php

namespace App\Http\Controllers\Backend\Item;

use App\RMS\Infrastructure\Forms\ItemEntryRequest;
use App\RMS\Infrastructure\Forms\ItemEditRequest;
use App\RMS\Item\ItemRepositoryInterface;
use Illuminate\Http\Request;
use App\RMS\Item\Item;
use App\RMS\Utility;
use App\RMS\Item\Continent;
use Auth;
use App\RMS\Category\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use InterventionImage;
use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;
use App\RMS\Remark\RemarkRepository;
use App\RMS\Item_Remark\Item_RemarkRepository;
use App\RMS\Item_Remark\Item_Remark;


class ItemController extends Controller
{
    private $ItemRepository;
    public function __construct(ItemRepositoryInterface $ItemRepository)
    {
       $this->ItemRepository = $ItemRepository;
       $this->RemarkRepo     = new RemarkRepository();
       $this->Item_RemarkRepo= new Item_RemarkRepository();
    }
    //Item Listing Page
    public function index()
    {
       $items   = Item::all();
       $cat     = $this->ItemRepository->allCat();
       return view('Backend.item.ItemListing')->with('items', $items)->with('cat', $cat);
    }
    public function itemenabled($id)
    {
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->ItemRepository->itemenabled($id);
        }
        return redirect()->action('Backend\Item\ItemController@index');
    }
    public function itemdisabled($id)
    {
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->ItemRepository->itemdisabled($id);
        }
        return redirect()->action('Backend\Item\ItemController@index');
    }

    //Item Entry Form
    public function create(){
        $result = $this->ItemRepository->ChooseCat();
        $parents = Category::select('parent_id')->where('parent_id','!=', 0)->groupBy('parent_id')->get();

        $parent_id_arr = array();
        foreach($parents as $parent){
            array_push($parent_id_arr,$parent->parent_id);
        }
        $continent_arr  = $this->ItemRepository->getContinent();
        $remark         = $this->RemarkRepo->getRemark();

        return view('Backend.item.item')->with(array('categories'=>$result, 'parent_id_arr'=>$parent_id_arr,'continent_arr'=>$continent_arr,'remarks'=>$remark));
    }
    //ItemEntryRequest
    public function store(Request $request)
    {
        // $request->validate();
       try{
         $input                  = $request->all();
        $name                   = $request->get('name');
        $category               = Input::get('parent_category');
        $description            = $request->get('description');
        $check                  = $request->get('check');
        $price                  = $request->get('price');
        $check                  = $request->get('check');
        $remark                 = $request->get('remark');       
        $cooking_time           = Input::get('standard_cooking_time');
        if ($check == 0) {
            $file                   = $request->file('fileupload');
            $imagedata              = file_get_contents($file);
            $photo                  = uniqid().'.'.$file->getClientOriginalExtension();
            $file->move('uploads', $photo );
            // resizing image
            $image = InterventionImage::make(sprintf('uploads' .'/%s', $photo))->resize(200, 200)->save();
        }

        $status                             = Input::get('status');
        DB::beginTransaction();
        $paramObj                           = new Item();
        $paramObj->name                     = $name;
        if ($check == 0) {
            $paramObj->image                    = $photo;
            $paramObj->mobile_image             = base64_encode($image->encoded);
        }
        $paramObj->description              = $description;
        $paramObj->price                    = $price;
        $paramObj->status                   = $status;
        $paramObj->category_id              = $category;
        $paramObj->standard_cooking_time    = $cooking_time;
        $paramObj->has_continent            = $check;
        $result                             = $this->ItemRepository->store($paramObj,$input,$remark);
        // dd($result);
        $item_arr                           = $result['data'];       
        if($result['aceplusStatusCode']     !=  ReturnMessage::OK){
          DB::rollback();            
            return redirect()->action('Backend\Item\ItemController@index')
                ->withMessage(FormatGenerator::message('Success', 'Item did not created ...'));
        }

      if(count($remark) >0){
        foreach ($remark as $rkey => $rvalue) {
            foreach ($item_arr as $key => $value) {
            $obj                              = new Item_Remark();
            $obj->item_id                     = $value;
            $obj->remark_id                   = $rvalue;
            $itemRemark                       = $this->Item_RemarkRepo->store($obj);
              if($result['aceplusStatusCode']     !=  ReturnMessage::OK){
                DB::rollback();            
                    return redirect()->action('Backend\Item\ItemController@index')
                ->withMessage(FormatGenerator::message('Success', 'Item Remark did not created ...'));
                }       

            }                 
        }//foreach
      }//if
        DB::commit();
         return redirect()->action('Backend\Item\ItemController@index')
                ->withMessage(FormatGenerator::message('Success', 'Item created ...'));


       }//try
       catch(\Expection $e){        
        return redirect()->action('Backend\Item\ItemController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Item did not create ...'));
       }
    }

    public function edit($id)
    {
        $remark             = $this->RemarkRepo->getRemark();
        $record             = $this->ItemRepository->find($id);

        $result             = $this->ItemRepository->ChooseCat();        
        $r_cat              = DB::table('category')->where('id', $record->category_id)->first()->name;        
        $parents            = Category::select('parent_id')->where('parent_id','!=', 0)->groupBy('parent_id')->get();     
        $remark_item        = $this->Item_RemarkRepo->findRemark_Item($id);    

        $groupID            = $record->group_id;   
        
        $parent_id_arr      = array();
        foreach($parents as $parent){
            array_push($parent_id_arr,$parent->parent_id);
        }

        $continent_arr      = $this->ItemRepository->getContinent();
        $has_continent      = $record->has_continent;
        $continent_items    = [];
        if ($has_continent  == 1) {        
            $continent_items    = $this->ItemRepository->getContinentByGroupID($groupID);
        }
        $remark_arr                = array();
            foreach ($remark_item as $key => $value) {                
                array_push($remark_arr,$value->remark_id);
        }          

        
         return view('Backend.item.item', ['categories' => $result])->with('record', $record)
                ->with('r_cat', $r_cat)
                ->with('parent_id_arr',$parent_id_arr)
                ->with('continent_arr',$continent_arr)
                ->with('continent_items',$continent_items)               
                ->with('remarks',$remark)
                ->with('remark_arr',$remark_arr);
    }

    //ItemEditRequest
    public function update(Request $request)
    {
       
        $category_id    = "";
        // $request->validate();
        $id             = $request->get('id');

        $name           = $request->get('name');
        $lower_name     = strtolower($name);//to change all letter which user edited in form to lower case
        $category       = $request->get('parent_category');
        $description    = $request->get('description');
        $price          = $request->get('price');
        $status         = $request->get('status');
        $remark         = $request->get('remark');
        $cooking_time   = Input::get('standard_cooking_time');
        $oldname        = $this->ItemRepository->find(Input::get('id'));
        $oldprice       = $oldname->price;

        $lower_old_name = strtolower($oldname->name); //to change old name from database to lower
        $flag = 1;

        //if users don't want to edit name and want to edit other field
        if($lower_name == $lower_old_name ){
            $flag = 1;           

        }
        else{

            //select all data from items table
            $all_item_name = $this->ItemRepository->getAllItemName();
            foreach($all_item_name as $allname){
                $lower_all_name = strtolower($allname->name);
                //edited name already exists in database
                if($lower_name ==  $lower_all_name){
                    $flag = 0;
                }
            }
        }

//       user is allowed to edit
        if($flag == 1){
        $checkConti           = count($request->get('continent-price'));
        if ($checkConti > 0) {
            $group_id_attr    = DB::table('items')->select('group_id')
                                ->WHERE('id','=',$id)
                                ->first();           
            $group_id         =  $group_id_attr->group_id;
            $file             = $request->file('input-file-preview');
            $itemID           = $request->get('item-id');
            
            $continents       = $request->get('continent');
            $continentPrice   = $request->get('continent-price');
            $oldItemCount     = Item::where('group_id','=',$group_id)
                                ->whereNull('deleted_at')
                                ->get()
                                ->count();

            //Check if User add new Continent
            $flagItem           = 0;
            if (count($itemID)  > count($continents)) {
                $flagItem       = 1;
                // dd('item if ',$flagItem);
            }

            $count              = 0;            
            foreach($continents as $key => $continent) {               
                $count                  = $count + 1;

                if ($count <= $oldItemCount) {                   
                    $postID                 = $itemID[$key];                 
                    $paramObj               = Item::find($postID);
                    //Get Old Price for Price History
                    $oldprice               = $paramObj->price;
                    $paramObj->name         = $name;
                    $paramObj->description  = $description;
                    $paramObj->price        = $continentPrice[$key];
                    $paramObj->continent_id = $continent;
                    $paramObj->category_id  = $category;
                    $paramObj->status       = $status;
                    $paramObj->standard_cooking_time = $cooking_time;

                    //For File Upload
                    if ($file[$key] != null) {
                        $imagedata              = file_get_contents($file[$key]);
                        $photo  = uniqid().'.'.$file[$key]->getClientOriginalExtension();
                        $file[$key]->move('uploads', $photo);
                        
                        // resizing image
                        $image = InterventionImage::make(sprintf('uploads' .'/%s', $photo))->resize(200, 200)->save();
                        $mobileImg = base64_encode($image->encoded);
                        $paramObj->image        = $photo;
                        $paramObj->mobile_image = $mobileImg;
                       
                    }                    
                    $result                     = $this->ItemRepository->updateContinent($paramObj,$oldprice);

                } 
/* ------------------start contient is > itemid -------------------------------------*/
                else {
                    dd("update new");

                    $imagedata              = file_get_contents($file[$key]);
                    $photo  = uniqid().'.'.$file[$key]->getClientOriginalExtension();
                    $file[$key]->move('uploads', $photo);
                    
                    // resizing image
                    $image = InterventionImage::make(sprintf('uploads' .'/%s', $photo))->resize(200, 200)->save();
                    $mobileImg = base64_encode($image->encoded);

                    $paramObj               = new Item();
                    $paramObj->name         = $name;
                    $paramObj->description  = $description;
                    $paramObj->price        = $continentPrice[$key];
                    $paramObj->continent_id = $continent;
                    $paramObj->category_id  = $category;
                    $paramObj->standard_cooking_time = $cooking_time;
                    $paramObj->image        = $photo;
                    $paramObj->mobile_image = $mobileImg;
                    $paramObj->group_id     = $group_id;
                    $paramObj->has_continent= 1;
                    $paramObj->status       = $status;
                    $result                 = $this->ItemRepository->updateNewContinent($paramObj);
                }
/* ------------------end  contient is > itemid -------------------------------------*/
            }
/*----------------- start item remark -----------------------------------------------------------*/

                    foreach ($itemID as $key => $value) {
                        Item_Remark::where('item_id',$value)->delete();                   
                        
                    }
                    if(count($remark) >0){
                    foreach ($remark as $rkey => $rvalue) {
                    foreach ($itemID as $key => $value) {
                    $obj                              = new Item_Remark();
                    $obj->item_id                     = $value;
                    $obj->remark_id                   = $rvalue;
                    $itemRemark                       = $this->Item_RemarkRepo->store($obj);
                      if($result['aceplusStatusCode']     !=  ReturnMessage::OK){
                        DB::rollback();            
                            return redirect()->action('Backend\Item\ItemController@index')
                        ->withMessage(FormatGenerator::message('Success', 'Item Remark did not created ...'));
                        }       

                    }                 
                }//foreach
              }//if
/*----------------- end item remark -----------------------------------------------------------*/
            if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                return redirect()->action('Backend\Item\ItemController@index')
                    ->withMessage(FormatGenerator::message('Success', 'Item updated ...'));
            }

         }
/*----------------- start item does not contain contient -----------------------------------*/
         else {       
//Not Comtinent item
            $file = $request->file('fileupload');
/*--------- if users want to upload new photo,"if" condition will work.and if users don't want to upload new photo,'else' function will work ----*/
            if($file != null){               
                    $imagedata              = file_get_contents($file);
                    $name                   = Input::get('name');
                    $photo  = uniqid().'.'.$file->getClientOriginalExtension();

                    $file->move('uploads', $photo);
                    
                    // resizing image
                    $image = InterventionImage::make(sprintf('uploads' .'/%s', $photo))->resize(200, 200)->save();
                    
                    $paramObj                           = Item::find($id);
                    $paramObj->name                     = $name;
                    $paramObj->image                    = $photo;
                    $paramObj->mobile_image             = base64_encode($image->encoded);
                    $paramObj->description              = $description;
                    $paramObj->price                    = $price;
                    $paramObj->status                   = $status;
                    $paramObj->category_id              = $category;
                    $paramObj->standard_cooking_time    = $cooking_time;
                    $result = $this->ItemRepository->updateAllItem($paramObj,$oldprice);

                    if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                        return redirect()->action('Backend\Item\ItemController@index')
                            ->withMessage(FormatGenerator::message('Success', 'Item updated ...'));
                    }
                    else{
                        return redirect()->action('Backend\Item\ItemController@index')
                            ->withMessage(FormatGenerator::message('Fail', 'Item did not update ...'));
                    }
                }


            else{              
                $name                            = $request->get('name');
                $category                        = $request->get('parent_category');
                $data                            = DB::table('category')->get();
                foreach ($data as $item) {
                    if ($item->name == $category) {
                        $category_id = $item->id;
                    }
                }
                $description                     = $request->get('description');
                $price                           = $request->get('price');
                $status                          = $request->get('status');
                $paramObj                        = Item::find($id);
                $paramObj->name                  = $name;
                $paramObj->description           = $description;
                $paramObj->price                 = $price;
                $paramObj->status                = $status;
                $paramObj->category_id           = $category;
                $paramObj->standard_cooking_time = $cooking_time;
               
                $result                          = $this->ItemRepository->updateItem($paramObj,$oldprice);

                if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                    return redirect()->action('Backend\Item\ItemController@index')
                        ->withMessage(FormatGenerator::message('Success', 'Item updated ...'));
                }
                else{
                    return redirect()->action('Backend\Item\ItemController@index')
                        ->withMessage(FormatGenerator::message('Fail', 'Item did not update ...'));
                }

        }
                

         } 
/*----------------- end item does not contain contient -----------------------------------*/
           

}
/*----------------- end flag 1 -- -----------------------------------*/
        //user is not allowed to edit because the edited name already exists in database
        elseif($flag == 0){
            alert()->error('The item with the same name already exists. ')->persistent('Close');
            return redirect()->action('Backend\Item\ItemController@index');
        }


    }

//  To multi-delete items
    public function delete($id){
        $group_id_arr       = [];
        $id_arr             = array();
        $id_arr_val         =[];
        $new_string         = explode(',', $id);       
        $groups             = DB::table('items')
                    ->whereIn('id', $new_string)
                    ->select('group_id')
                    ->get();
       
        foreach ($groups as $key => $value) {
            $group_id_arr[]= $value->group_id;            
        } 

         $id_arr     = DB::table('items')
                    ->whereIn('group_id', $group_id_arr)
                    ->select('id')
                    ->get();
        
       foreach ($id_arr as $id_key =>$id_value) {        
        $aa         = (array)$id_value;      

             $this->ItemRepository->delete($aa);
             $this->Item_RemarkRepo->delete($aa);
        }  

       
        return redirect()->action('Backend\Item\ItemController@index')->withMessage(FormatGenerator::message('Success', 'Item Deleted ...')); //to redirect listing page
    }
}