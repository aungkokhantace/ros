<?php

namespace App\Http\Controllers\Cashier\Addon;
use App\categoryModel;
use App\RMS\Category\Category;
use App\RMS\Addon\Addon;
use App\RMS\Addon\AddonRepositoryInterface;
use App\Session;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use App\RMS\Infrastructure\Forms\InsertExtraRequest;
use App\RMS\Infrastructure\Forms\EditExtraRequest;

use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;
use InterventionImage;
class AddonController extends Controller
{
    private $extra_repository;
    public function __construct(AddonRepositoryInterface $extra_repository)
    {
        $this->extra_repository = $extra_repository;
    }

    public function index()
    {
        $category = DB::table('category')->where('parent_id', '=', 0)->get();
        $extra    = Addon::all();

        return view('cashier.addon.index')->with('ex', $extra)->with('category', $category);
    }
    public function create()
    {
        $category = DB::table('category')->where('parent_id','=',0)->get();
        return view('cashier.addon.addon')->with ('category',$category);
    }
    public function store(InsertExtraRequest $request)
    {
        $request->validate();
        $food_name              = Input::get('food_name');

        $category_id            = Input::get('category_id');
        $description            = Input::get('description');
        $price                  = Input::get('price');
        $file                   = $request->file('fileupload');
        $imagedata              = file_get_contents($file);
        $photo                  = uniqid().'.'.$file->getClientOriginalExtension();
        $file->move('uploads', $photo);
        // resizing image
        $image = InterventionImage::make(sprintf('uploads' .'/%s',$photo))->resize(200, 200)->save();

        $status                 = Input::get('status');
        $paramObj               = new Addon();
        $paramObj->food_name    = $food_name;
        $paramObj->category_id  = $category_id;
        $paramObj->description  = $description;
        $paramObj->image        = $photo;
        $paramObj->mobile_image = base64_encode($image->encoded);
        $paramObj->price        = $price;
        $paramObj->status       = $status;
        $result = $this ->extra_repository->store($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Cashier\Addon\AddonController@index')
                ->withMessage(FormatGenerator::message('Success', 'Addon created ...'));
        }
        else{
            return redirect()->action('Cashier\Addon\AddonController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Addon did not create ...'));
        }

    }

    public function edit($id)
    {
        $resource   = Addon::find($id);
        $extra_edit = $this->extra_repository->extra_edit($id);
        $category   = DB::table('category')->where('parent_id', '=', 0)->get();
        return view('cashier.addon.addon', compact('resource', 'extra_edit', 'category'));
    }

    public function update(EditExtraRequest $request)
    {
        $request->validate();
        $food_name   = Input::get('food_name');
        $category_id = Input::get('category_id');
        $description = Input::get('description');
        $price       = Input::get('price');
        $status      = Input::get('status');
        $id          = Input::get('id');
        $file        = $request->file('fileupload');
        $old_name    = $this->extra_repository->getOldName($id);
        $all_names   = $this->extra_repository->getAllNames();
        $flag        = 1;
        if($food_name == $old_name->food_name ){
            $flag = 1;
        }
        else{
            //select all data from category table
            foreach($all_names as $all_name){
                //edited name is already exist in database
                if($food_name ==  $all_name->food_name){
                    $flag = 0;
                }
            }
        }
        if($flag == 1){
            if($file != null){
                $food_name   = Input::get('food_name');
                $imagedata   = file_get_contents($file);
                $photo        = uniqid().'.'.$file->getClientOriginalExtension();
                $file->move('uploads', $photo);
                // resizing image
                $image = InterventionImage::make(sprintf('uploads' .'/%s', $photo))->resize(200, 200)->save();

                $paramObj               = Addon::find($id);
                $paramObj->food_name    = $food_name;
                $paramObj->category_id  = $category_id;
                $paramObj->description  = $description;
                $paramObj->image        = $photo;
                $paramObj->mobile_image = base64_encode($image->encoded);
                $paramObj->price        = $price;
                $paramObj->status       = $status;
                $result = $this->extra_repository->updateall($paramObj);

                if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                    return redirect()->action('Cashier\Addon\AddonController@index')
                        ->withMessage(FormatGenerator::message('Success', 'Addon updated ...'));
                }
                else{
                    return redirect()->action('Cashier\Addon\AddonController@index')
                        ->withMessage(FormatGenerator::message('Fail', 'Addon did not update ...'));
                }

            }
            else{
                $paramObj               = Addon::find($id);
                $paramObj->food_name    = $food_name;
                $paramObj->category_id  = $category_id;
                $paramObj->description  = $description;
                $paramObj->price        = $price;
                $paramObj->status       = $status;
                $result = $this->extra_repository->update($paramObj);

                if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                    return redirect()->action('Cashier\Addon\AddonController@index')
                        ->withMessage(FormatGenerator::message('Success', 'Addon updated ...'));
                }
                else{
                    return redirect()->action('Cashier\Addon\AddonController@index')
                        ->withMessage(FormatGenerator::message('Fail', 'Addon did not update ...'));
                }
            }
        }
        elseif($flag == 0){
            alert()->error('The add on with the same name already exists')->persistent('Close');
            return back();
        }

    }
    public function delete($id)
    {
        $new_string = explode(',',$id);
        foreach($new_string as $id)
        {
            $this ->extra_repository->extra_delete($id);
        }
        return redirect()->action('Cashier\Addon\AddonController@index');
    }
}
