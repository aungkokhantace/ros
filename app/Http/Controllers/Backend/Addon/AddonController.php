<?php

namespace App\Http\Controllers\Backend\Addon;
use App\categoryModel;
use App\RMS\Category\Category;
use App\RMS\Addon\Addon;
use App\RMS\Addon\AddonRepositoryInterface;
use App\Status\StatusConstance;
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
use App\RMS\Utility;
use App\RMS\Restaurant\RestaurantRepository;
use App\RMS\Branch\BranchRepository;
use App\RMS\Category\CategoryRepository;

class AddonController extends Controller
{
    private $extra_repository;
    public function __construct(AddonRepositoryInterface $extra_repository)
    {
        $this->extra_repository = $extra_repository;
        $this->restaurantRepo   = new RestaurantRepository();
        $this->branchRepo       = new BranchRepository();
        $this->catRepo          = new CategoryRepository();
    }

    public function index()
    {

        $category = $this->extra_repository->getCategory(); 
        $extra    = $this->extra_repository->getextra();
             
        return view('Backend.addon.index')->with('ex', $extra)->with('category', $category);
    }
    public function create()
    {
        // $status   = StatusConstance::CATEGORY_AVAILABLE_STATUS;
        // $category = DB::table('category')->where('parent_id','=',0)
        //         ->where('status',$status)
        //         ->whereNull('deleted_at')
        //         ->get();
        $category       = $this->catRepo->getParentCat();     
        $branch         = $this->branchRepo->getAllType();
        $restaurant     = $this->restaurantRepo->getAllType();
        return view('Backend.addon.addon')->with ('category',$category)  
                                         ->with('branchs',$branch)
                                         ->with('restaurants',$restaurant);
    }
    public function store(InsertExtraRequest $request)
    {
        $request->validate();
        $branch_id              = Utility::getCurrentBranch() != 0 ? Utility::getCurrentBranch(): Input::get('branch');     

        $restaurant_id          = Utility::getCurrentRestaurant() != 0 ? Utility::getCurrentRestaurant() : Input::get('restaurant'); 
       

        $food_name              = Input::get('food_name');

        $category_id            = Input::get('category_id');
        $description            = Input::get('description');
        $price                  = Input::get('price');
        //Check if Add on is already exit in category and unique
        $add_on_count            = Addon::where('food_name','=',$food_name)->where('category_id','=',$category_id)->get()->count();
        if ($add_on_count > 0) {
            alert()->warning('Item already Exit in Category.')->persistent('Close');
            return redirect()->back()->withInput();
        }
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
        $paramObj->branch_id    = $branch_id;
        $paramObj->restaurant_id = $restaurant_id;
        $result = $this ->extra_repository->store($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Backend\Addon\AddonController@index')
                ->withMessage(FormatGenerator::message('Success', 'Addon created ...'));
        }
        else{
            return redirect()->action('Backend\Addon\AddonController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Addon did not create ...'));
        }

    }

    public function edit($id)
    {
        $resource   = Addon::find($id);
        $extra_edit = $this->extra_repository->extra_edit($id);
        $status   = StatusConstance::CATEGORY_AVAILABLE_STATUS;
        $category = DB::table('category')->where('parent_id','=',0)
                ->where('status',$status)
                ->whereNull('deleted_at')
                ->get();
        return view('Backend.addon.addon', compact('resource', 'extra_edit', 'category'));
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
        $oldprice    = $old_name->price;
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
                $result = $this->extra_repository->updateall($paramObj,$oldprice);

                if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                    return redirect()->action('Backend\Addon\AddonController@index')
                        ->withMessage(FormatGenerator::message('Success', 'Addon updated ...'));
                }
                else{
                    return redirect()->action('Backend\Addon\AddonController@index')
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
                $result = $this->extra_repository->update($paramObj,$oldprice);

                if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                    return redirect()->action('Backend\Addon\AddonController@index')
                        ->withMessage(FormatGenerator::message('Success', 'Addon updated ...'));
                }
                else{
                    return redirect()->action('Backend\Addon\AddonController@index')
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
        return redirect()->action('Backend\Addon\AddonController@index')->withMessage(FormatGenerator::message('Success', 'Item deleted ...'));
    }

    public function ajax($branch_id,$restaurant_id= null)
    {       

        if($restaurant_id == "undefined"){
            $restaurant_id = null;
        }

        $result     = $this->extra_repository->get_CatBranch($branch_id,$restaurant_id);
         return \Response::json($result);
    }
}
