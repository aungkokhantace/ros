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

    private $Item_RemarkRepo;

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
        $is_ready_food           = Input::get('is_ready_food');
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

        $paramObj->is_ready_food            = $is_ready_food;
        $result                             = $this->ItemRepository->store($paramObj,$input,$remark);        
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
        $item_details_count = count($continent_items);
        // return compact('categories','record','r_cat','parent_id_arr','continent_arr','continent_items','remarks','remark_arr');
        return view('Backend.item.item', ['categories' => $result])->with('record', $record)
                ->with('r_cat', $r_cat)
                ->with('parent_id_arr',$parent_id_arr)
                ->with('continent_arr',$continent_arr)
                ->with('continent_items',$continent_items)
                ->with('remarks',$remark)
                ->with('item_count',$item_details_count)
                ->with('remark_arr',$remark_arr);
    }

    //ItemEditRequest
    public function update(Request $request)
    {
        // return $request->all();
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
        $is_ready_food  = $request->get('is_ready_food');
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
        if($flag == 1){ // end 485
        $checkConti           = count($request->get('continent-price'));
        if ($checkConti > 0) { // end line 356
            $group_id_attr    = DB::table('items')->select('group_id')
                                ->WHERE('id','=',$id)
                                ->first();
            $group_id         =  $group_id_attr->group_id;
            $file             = $request->file('input-file-preview');
            $item_request      = $request->get('item-id');
            $itemID           = array_unique($item_request);

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

                if (isset($itemID[$key]) ?: false) {
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
                    $paramObj->is_ready_food= $is_ready_food;
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
                    // dd("update new");
                    $photo='';
                    $mobileImg='';
                    if (isset($file[$key]) ?: false) {
                    $imagedata              = file_get_contents($file[$key]);
                    $photo  = uniqid().'.'.$file[$key]->getClientOriginalExtension();
                    $file[$key]->move('uploads', $photo);

                    // resizing image
                    $image = InterventionImage::make(sprintf('uploads' .'/%s', $photo))->resize(200, 200)->save();
                    $mobileImg = base64_encode($image->encoded);
                    }


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
                    $paramObj->is_ready_food = $is_ready_food;
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
                }
                //foreach
              }
              //if
/*----------------- start Normalize Item -----------------------------------------------------------*/
            /* if Updated , selected item's updated_at column is not modifide delete it. */
                $max_date = Item::where('name',$name)->get()->max('updated_at');
                $update_item = $itemID;
                Item::where('name',$name)->whereNotIn('id',$update_item)->each(function ($item)use($max_date){
                    if ($item->updated_at < $max_date && $item->isdefault == 0) {
                        $item->normalizeItem();
                    }
                });
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
            if($file != null){ // end 481
                    $imagedata              = file_get_contents($file);
                    $name                   = Input::get('name');
                    $photo  = uniqid().'.'.$file->getClientOriginalExtension();

                    $file->move('uploads', $photo);

                    // resizing image
                    $image = InterventionImage::make(sprintf('uploads' .'/%s', $photo))->resize(200, 200)->save();

                    $paramObj                           = Item::find($id);
                    $itemID[]                           = $paramObj->id;
                    $paramObj->name                     = $name;
                    $paramObj->image                    = $photo;
                    $paramObj->mobile_image             = base64_encode($image->encoded);
                    $paramObj->description              = $description;
                    $paramObj->price                    = $price;
                    $paramObj->status                   = $status;
                    $paramObj->category_id              = $category;
                    $paramObj->is_ready_food            = $is_ready_food;
                    $paramObj->standard_cooking_time    = $cooking_time;
                    $result = $this->ItemRepository->updateAllItem($paramObj,$oldprice);

                    /* start item remark */
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
                      if($itemRemark['aceplusStatusCode']     !=  ReturnMessage::OK){
                        // DB::rollback();
                            return redirect()->action('Backend\Item\ItemController@index')
                        ->withMessage(FormatGenerator::message('Success', 'Item Remark did not created ...'));
                        }

                    }
                }
                //foreach
              }
              //if
              /* end item remark */

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
                $itemID[]                        = $paramObj->id;
                $paramObj->name                  = $name;
                $paramObj->description           = $description;
                $paramObj->price                 = $price;
                $paramObj->status                = $status;
                $paramObj->category_id           = $category;
                $paramObj->standard_cooking_time = $cooking_time;
                $paramObj->is_ready_food         = $is_ready_food;

                $result                          = $this->ItemRepository->updateItem($paramObj,$oldprice);
                  /* start item remark */
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
                  if($itemRemark['aceplusStatusCode']     !=  ReturnMessage::OK){
                    // DB::rollback();
                        return redirect()->action('Backend\Item\ItemController@index')
                    ->withMessage(FormatGenerator::message('Success', 'Item Remark did not created ...'));
                    }

                }
            }
            //foreach
          }
          //if
          /* end item remark */

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
    public function delete($id)
    {
        $new_string   = explode(',', $id);

        foreach ($new_string as $item_id) {
            $group = DB::table('items')
                ->where('id', '=', $item_id)
                ->select('group_id')
                ->first();

            if ($group->group_id !== "" && !empty($group)) {
                $items = DB::table('items')
                    ->where('group_id', '=', $group->group_id)
                    ->select('id')
                    ->get();
                foreach ($items as $item) {
                    $this->ItemRepository->delete($item->id);
                    $this->Item_RemarkRepo->delete($item->id);
                }
            } else {
                $this->ItemRepository->delete($item_id);
                $this->Item_RemarkRepo->delete($item_id);
            }
        }

        return redirect()->action('Backend\Item\ItemController@index')->withMessage(FormatGenerator::message('Success', 'Item Deleted ...')); //to redirect listing page
    }
}
