<?php

namespace App\Http\Controllers\Cashier\Setmenu;

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
class SetMenuController extends Controller
{
    private $setMenuRepository;

    public function __construct(SetMenuRepositoryInterface $setMenuRepository){
        $this->setMenuRepository = $setMenuRepository;
    }

    public function index(){
        $set_menu = SetMenu::all();
        $set_item = $this->setMenuRepository->getSetItem();
        $items    = $this->setMenuRepository->getAllItem();
        return view('cashier.set.set_menus_listing', compact('set_menu', 'set_item', 'items'));
    }

    public function create(){
        $category = $this->setMenuRepository->getCategories();
        $items    = $this->setMenuRepository->getItems();
        $kitchens  = $this->setMenuRepository->getKitchen();
        return view('cashier.set.set_menus', compact('category', 'items','kitchens'));
    }

    public function store(SetMenuInsertRequest $request)
    {
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
        $result                     = $this->setMenuRepository->store($paramObj, $items);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Cashier\Setmenu\SetMenuController@index')
                ->withMessage(FormatGenerator::message('Success', 'Set Menu created ...'));
        }
        else{
            return redirect()->action('Cashier\Setmenu\SetMenuController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Set Menu did not create ...'));
        }

    }

    public function delete($id)
    {
        $new_string = explode(',', $id);
        
        foreach($new_string as $id){
            $this->setMenuRepository->delete($id);
        }

        return redirect()->action('Cashier\Setmenu\SetMenuController@index'); //to redirect listing page
    }

    public function edit($id){
        $resource    = SetMenu::find($id);
        $set_item    = SetItem::where('set_menu_id','=',$id)->lists('item_id')->toArray();
        $member_type = $this->setMenuRepository->getAllSet();
        $Item        = $this->setMenuRepository->getAllItem();
        $category    = $this->setMenuRepository->getCategories();
        $items       = $this->setMenuRepository->getItems();
        return view('cashier.set.set_menus')->with('member_type', $member_type)
                                            ->with('category', $category)
                                            ->with('items', $items)
                                            ->with('Item', $Item)
                                            ->with('resource', $resource)
                                            ->with('set_item',$set_item);
    }

    public function update(SetMenuEditRequest $request){
        $request->validate();
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
                    return redirect()->action('Cashier\Setmenu\SetMenuController@index')
                        ->withMessage(FormatGenerator::message('Success', 'Set Menu updated ...'));
                }
                else{
                    return redirect()->action('Cashier\Setmenu\SetMenuController@index')
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
                    return redirect()->action('Cashier\Setmenu\SetMenuController@index')
                        ->withMessage(FormatGenerator::message('Success', 'Set Menu updated ...'));
                }
                else{
                    return redirect()->action('Cashier\Setmenu\SetMenuController@index')
                        ->withMessage(FormatGenerator::message('Fail', 'Set Menu did not update ...'));
                }

            }
        }
        elseif($flag == 0){
            alert()->error('The set menu with the same name already exists')->persistent('Close');
            return back();
        }

    }
}