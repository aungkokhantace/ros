<?php

namespace App\Http\Controllers\Cashier\Item;

use App\RMS\Infrastructure\Forms\ItemEntryRequest;
use App\RMS\Infrastructure\Forms\ItemEditRequest;
use App\RMS\Item\ItemRepositoryInterface;
use Illuminate\Http\Request;
use App\RMS\Item\Item;
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

class ItemController extends Controller
{
    private $ItemRepository;
    public function __construct(ItemRepositoryInterface $ItemRepository)
    {
       $this->ItemRepository = $ItemRepository;
    }
    //Item Listing Page
    public function index()
    {
       $items   = Item::all();
       $cat     = $this->ItemRepository->allCat();
       return view('cashier.item.ItemListing')->with('items', $items)->with('cat', $cat);
    }
    public function itemenabled($id)
    {
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->ItemRepository->itemenabled($id);
        }
        return redirect()->action('Cashier\Item\ItemController@index');
    }
    public function itemdisabled($id)
    {
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->ItemRepository->itemdisabled($id);
        }
        return redirect()->action('Cashier\Item\ItemController@index');
    }

    //Item Entry Form
    public function create(){
        $result = $this->ItemRepository->ChooseCat();
        $parents = Category::select('parent_id')->where('parent_id','!=', 0)->groupBy('parent_id')->get();

        $parent_id_arr = array();
        foreach($parents as $parent){
            array_push($parent_id_arr,$parent->parent_id);
        }
        return view('cashier.item.item', ['categories' => $result],['parent_id_arr'=>$parent_id_arr]);

    }

    public function store(ItemEntryRequest $request)
    {
        $request->validate();

        $name                   = $request->get('name');
        $category               = Input::get('parent_category');
        $description            = $request->get('description');
        $price                  = $request->get('price');
        $file                   = $request->file('fileupload');
        $cooking_time           = Input::get('standard_cooking_time');
        $imagedata              = file_get_contents($file);
        $photo                  = uniqid().'.'.$file->getClientOriginalExtension();
        $file->move('uploads', $photo );
        // resizing image
        $image = InterventionImage::make(sprintf('uploads' .'/%s', $photo))->resize(200, 200)->save();

        $status                             = Input::get('status');
        $paramObj                           = new Item();
        $paramObj->name                     = $name;
        $paramObj->image                    = $photo;
        $paramObj->mobile_image             = base64_encode($image->encoded);
        $paramObj->description              = $description;
        $paramObj->price                    = $price;
        $paramObj->status                   = $status;
        $paramObj->category_id              = $category;
        $paramObj->standard_cooking_time    = $cooking_time;
        $result = $this->ItemRepository->store($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Cashier\Item\ItemController@index')
                ->withMessage(FormatGenerator::message('Success', 'Item created ...'));
        }
        else{
            return redirect()->action('Cashier\Item\ItemController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Item did not create ...'));
        }


    }

    public function edit($id)
    {
        $record = $this->ItemRepository->find($id);
        $result = $this->ItemRepository->ChooseCat();
        $r_cat  = DB::table('category')->where('id', $record->category_id)->first()->name;
        $parents = Category::select('parent_id')->where('parent_id','!=', 0)->groupBy('parent_id')->get();

        $parent_id_arr = array();
        foreach($parents as $parent){
            array_push($parent_id_arr,$parent->parent_id);
        }
         return view('cashier.item.item', ['categories' => $result])->with('record', $record)->with('r_cat', $r_cat)->with('parent_id_arr',$parent_id_arr);
    }

    public function update(ItemEditRequest $request)
    {
        $category_id = "";
        $request->validate();
        $id=$request->get('id');

        $name           = $request->get('name');
        $lower_name     = strtolower($name);//to change all letter which user edited in form to lower case
        $category       = $request->get('parent_category');
        $description    = $request->get('description');
        $price          = $request->get('price');
        $status         = $request->get('status');
        $cooking_time   = Input::get('standard_cooking_time');
        $oldname        = $this->ItemRepository->find(Input::get('id'));
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

//        user is allowed to edit
        if($flag == 1){
         $file = $request->file('fileupload');
            //if users want to upload new photo,"if" condition will work.and if users don't want to upload new photo,'else' function will work
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
                    $result = $this->ItemRepository->updateAllItem($paramObj);

                    if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                        return redirect()->action('Cashier\Item\ItemController@index')
                            ->withMessage(FormatGenerator::message('Success', 'Item updated ...'));
                    }
                    else{
                        return redirect()->action('Cashier\Item\ItemController@index')
                            ->withMessage(FormatGenerator::message('Fail', 'Item did not update ...'));
                    }


                }
            else{
                $name                   = $request->get('name');
                $category               = $request->get('parent_category');
                $data                   = DB::table('category')->get();
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
                $result = $this->ItemRepository->updateItem($paramObj);

                if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                    return redirect()->action('Cashier\Item\ItemController@index')
                        ->withMessage(FormatGenerator::message('Success', 'Item updated ...'));
                }
                else{
                    return redirect()->action('Cashier\Item\ItemController@index')
                        ->withMessage(FormatGenerator::message('Fail', 'Item did not update ...'));
                }

            }
        }
        //user is not allowed to edit because the edited name already exists in database
        elseif($flag == 0){
            alert()->error('The item with the same name already exists. ')->persistent('Close');
            return redirect()->action('Cashier\Item\ItemController@index');
        }
    }

//  To multi-delete items
    public function delete($id)
    {
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->ItemRepository->delete($id);
        }
        return redirect()->action('Cashier\Item\ItemController@index'); //to redirect listing page
    }
}
