<?php
namespace App\Http\Controllers\Backend\Category;
use App\RMS\Category\Category;
use App\RMS\Infrastructure\Forms\CreateCategoryRequest;
use App\RMS\Infrastructure\Forms\EditCategoryRequest;
use App\RMS\Kitchen\Kitchen;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\RMS\Category\CategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\LengthAwarePaginator;


use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;
use InterventionImage;
use App\RMS\Branch\BranchRepository;
use App\RMS\Utility;
use App\RMS\Restaurant\RestaurantRepository;
use App\RMS\Kitchen\KitchenRepository;

class CategoryController extends Controller
{
    private $CategoryRepository;
    public function __construct(CategoryRepositoryInterface $CategoryRepository){
        $this->CategoryRepository = $CategoryRepository;
        $this->branchRepo         = new BranchRepository();
        $this->restaurantRepo     = new RestaurantRepository();
        $this->kitchenRepo        = new KitchenRepository();
    }


    public function index(){
        $title        = 'Category List';
        $categorylist = $this->CategoryRepository->getAllCategory();
    
        return view('Backend.category.category_listing')->with('categorylist',$categorylist)->with('title',$title);
    }

    public function create(){
        $kitchen = $this->kitchenRepo->getKitchenByBranch();
        $result  = $this->CategoryRepository->ChooseCat();
        $branch  = $this->branchRepo->getAllType();
        $restaurant = $this->restaurantRepo->getAllType();

        
        return view('Backend.category.category', ['categories' => $result])->with('kitchen',$kitchen)->with('branchs',$branch)->with('restaurants',$restaurant);
    }

     public function store(CreateCategoryRequest $request){
        $name                   = $request->get('name');
        $category               = $request->get('parent_category');
        $branch_id              = Utility::getCurrentBranch() != 0 ? Utility::getCurrentBranch(): Input::get('branch');     

        $restaurant_id          = Utility::getCurrentRestaurant() != 0 ? Utility::getCurrentRestaurant() : Input::get('restaurant'); 
        //if Parent Category
        if ($category == 0) {
            $kitchen            = $request->get('kitchen');
            $level              = 1;
        } else {
            $kitchen_attr       = $this->CategoryRepository->getKitchenByCat($category);
            $kitchen            = $kitchen_attr->kitchen_id;
            $parent_level       = $this->CategoryRepository->getLevelByParentCat($category);
            $level              = $parent_level + 1;
        }
        $file                   = $request->file('fileupload');
        $imagedata              = file_get_contents($file);
        $photo                  = uniqid().'.'.$file->getClientOriginalExtension();
        $file->move('uploads', $photo);
         // resizing image
         $image = InterventionImage::make(sprintf('uploads' .'/%s', $photo))->resize(200, 200)->save();
        if ($category == 0) {
            $group_id           = uniqid();
        } else {
            $parent_category    = Category::find($category);
            $group_id           = $parent_category->group_id;
        }
        
        $status                 = Input::get('status');
        $description            = Input::get('description');
        $paramObj               = new Category();
        $paramObj->name         = $name;
        $paramObj->parent_id    = $category;
        $paramObj->kitchen_id   = $kitchen;
        $paramObj->group_id     = $group_id;
        $paramObj->image        = $photo;
        $paramObj->mobile_image = base64_encode($image->encoded);
        $paramObj->status       = $status;
        $paramObj->level        = $level;
        $paramObj->description  = $description;
        $paramObj->restaurant_id = $restaurant_id;
        $paramObj->branch_id     = $branch_id;


        $result = $this->CategoryRepository->store($paramObj);

         if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
             return redirect()->action('Backend\Category\CategoryController@index')
                 ->withMessage(FormatGenerator::message('Success', 'Category created ...'));
         }
         else{
             return redirect()->action('Backend\Category\CategoryController@index')
                 ->withMessage(FormatGenerator::message('Fail', 'Category did not create ...'));
         }

    }

    //multiple deletion of category
    public function delete($id){
        $new_string             = explode(',', $id); //convert to array
        foreach($new_string as $send_id){
            $maincategories     = $this->CategoryRepository->find($send_id);
            $subcategory        = $this->CategoryRepository->subCategory($send_id);
            $item               = $this->CategoryRepository->item($send_id);
            //checking sub category of send id exist or not
            if($subcategory){
                alert()->error('This category is parent category and has subcategories, you must delete the subcategories first!')->persistent('Close');
                return redirect()->action('Backend\Category\CategoryController@index');
            }
            elseif($item){
                //there is items record.
                alert()->error('This category is sub category and has child items,you must delete the child items first!')->persistent('Close');

                return redirect()->action('Backend\Category\CategoryController@index');
            }
            else{
                foreach($new_string as $maincategory_id){
                    $this->CategoryRepository->deleteCategory($maincategory_id);
                }

                return redirect()->action('Backend\Category\CategoryController@index');
            }
        }
    }

    public function edit($id){
        $cats                = $this->CategoryRepository->ChooseCat();
        $editcategory        = $this->CategoryRepository->find($id);
        $title               = 'Edit Category';
        //start generating subtree of current category
        $result              = $this->CategoryRepository->find($id);
        // $result->subcategory = $this->disabledcategoriesTree($result);
        $selected            = $editcategory->parent_id;
        $branch              = $this->branchRepo->getAllType();
        $restaurant          = $this->restaurantRepo->getAllType();
        $kitchen=$this->CategoryRepository->getKitchen();
        return view('Backend.category.category', ['categories' => $cats])->with('editcategory',$editcategory)
            ->with('selected',$selected)->with('title',$title)->with('subtree',$result)->with('kitchen',$kitchen)->with('branchs',$branch)->with('restaurants',$restaurant);
    }

    //to update edited data in database
    public function update(EditCategoryRequest $request){
        $id                 = Input::get('id');
        $name               = Input::get('name');
        $lower_name         = strtolower($name); //to change all letter which user edited in form to lower case
        $status             = Input::get('status');
        $description        = Input::get('description');
        $category           = Input::get('parent_category');
        $kitchen            = $request->get('kitchen');
        $parent_category    = Category::find($id);
        $group_id           = $parent_category->group_id;
        $oldname            = $this->CategoryRepository->find(Input::get('id'));
        $lower_old_name     = strtolower($oldname->name); //to change old name from database to lower
        $all_category_name  = $this->CategoryRepository->getAllCategoryName();
        $flag = 1;
        //if users don't want to edit name and want to edit other field
        if($lower_name == $lower_old_name ){
            $flag = 1;
        }
        else{
            //select all data from category table
            foreach($all_category_name as $allname){
                $lower_all_name = strtolower($allname->name);
                //edited name is already exist in database
                if($lower_name ==  $lower_all_name){
                    $flag = 0;
                }
            }
        }

        if($flag == 1){
            //user disabled a category and all children subcategories and items must be disabled
            if($status == 0){
                $result=$this->CategoryRepository->find($id);
                // $result->subCategories=$this->disabledcategoriesTree($result);
                $result->subCategories = $this->statusDisableSubCat($result);
            }
            //user enabled a category and all children subcategories and items must be enabled
            elseif($status == 1){
                $result=$this->CategoryRepository->find($id);
                // $result->subCategories=$this->enabledcategoriesTree($result);
                $result->subCategories = $this->statusEnableSubCat($result);
            }

            $file = $request->file('fileupload');
            //if users don't want to upload new photo,"if" condition will work.and if users want to upload new photo,'else' function will work
            if($file != null){
                $file_flag      = 0;
                $extension              = $file->getClientOriginalExtension();
                switch ($extension) {
                    case 'jpg':
                        $photo      = uniqid().'.'.$extension;
                        break;

                    case 'jpeg':
                        $photo      = uniqid().'.'.$extension;
                        break;

                    case 'png':
                        $photo      = uniqid().'.'.$extension;
                        break;

                    case 'gif':
                        $photo      = uniqid().'.'.$extension;
                        break;
                    
                    default:
                        $file_flag  = 1;
                        break;
                }
                
                if ($file_flag == 1) {
                    alert()->error('File Upload must be only image!')->persistent('Close');
                    return back();
                } else {
                    $file->move('uploads', $photo);
                    $image = InterventionImage::make(sprintf('uploads' .'/%s', $photo))->resize(200, 200)->save();

                    $paramObj               = Category::find($id);
                    $paramObj->name         = $name;
                    $paramObj->kitchen_id   = $kitchen;
                    $paramObj->group_id     = $group_id;
                    $paramObj->image        = $photo;
                    $paramObj->mobile_image = base64_encode($image->encoded);
                    $paramObj->status       = $status;
                    $paramObj->description  = $description;
                    $result = $this->CategoryRepository->updateAllCategory($paramObj);

                    if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                        return redirect()->action('Backend\Category\CategoryController@index')
                            ->withMessage(FormatGenerator::message('Success', 'Category updated ...'));
                    }
                    else{
                        return redirect()->action('Backend\Category\CategoryController@index')
                            ->withMessage(FormatGenerator::message('Fail', 'Category did not update ...'));
                    }

                }
            }
            else{
                $paramObj               = Category::find($id);
                $paramObj->name         = $name;
                $paramObj->kitchen_id   = $kitchen;
                $paramObj->group_id     = $group_id;
                $paramObj->status       = $status;
                $paramObj->description  = $description;
                $result = $this->CategoryRepository->updateCategory($paramObj);

                if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                    return redirect()->action('Backend\Category\CategoryController@index')
                        ->withMessage(FormatGenerator::message('Success', 'Category updated ...'));
                }
                else{
                    return redirect()->action('Backend\Category\CategoryController@index')
                        ->withMessage(FormatGenerator::message('Fail', 'Category did not create ...'));
                }

            }
        }
        elseif($flag == 0){
            alert()->error('The category with the same name already exists')->persistent('Close');
            return redirect()->action('Backend\Category\CategoryController@index');
        }
    }

    //Disable Lower Level Sub Category
    function statusDisableSubCat($result) {
        $cat_id         = $result->id;
        $level          = $result->level;
        $group_id       = $result->group_id;
        $max_level      = $this->getMaxLevelByGroupID($group_id);
        
        //Loop Count For Child Sub Category
        $loop_count     = $max_level - $level;
        $cat_arr        = array();
        for ($i = 1; $i <= $loop_count; $i++)
        {
            //First Time
            if ($i == 1) {
                $child_cat    = Category::select('id')->where('parent_id','=',$cat_id)->get();
                foreach($child_cat as $child) 
                {
                    $cat_arr[]  = $child->id;
                }
            } else {
                $round_cat  = Category::select('id')->whereIn('parent_id',$cat_arr)->get();
                foreach($round_cat as $round) {
                    $round      = $round->id;
                    if (!in_array($round,$cat_arr)) {
                        array_push($cat_arr,$round);
                    }
                }
            }
        }
        $disableStatus  = DB::table('category')
                            ->where('group_id', $group_id)
                            ->whereIn('id',$cat_arr)
                            ->update(['status' => 0]);
        return $disableStatus;
    }

     //Disable Lower Level Sub Category
    function statusEnableSubCat($result) {
        $cat_id         = $result->id;
        $level          = $result->level;
        $group_id       = $result->group_id;
        $max_level      = $this->getMaxLevelByGroupID($group_id);
        
        //Loop Count For Child Sub Category
        $loop_count     = $max_level - $level;
        $cat_arr        = array();
        for ($i = 1; $i <= $loop_count; $i++)
        {
            //First Time
            if ($i == 1) {
                $child_cat    = Category::select('id')->where('parent_id','=',$cat_id)->get();
                foreach($child_cat as $child) 
                {
                    $cat_arr[]  = $child->id;
                }
            } else {
                $round_cat  = Category::select('id')->whereIn('parent_id',$cat_arr)->get();
                foreach($round_cat as $round) {
                    $round      = $round->id;
                    if (!in_array($round,$cat_arr)) {
                        array_push($cat_arr,$round);
                    }
                }
            }
        }

        $enableStatus  = DB::table('category')
                            ->where('group_id', $group_id)
                            ->whereIn('id',$cat_arr)
                            ->update(['status' => 1]);
        return $enableStatus;
    }
    

    function getMaxLevelByGroupID($group_id)
    {
        // $max_level_attr = Category::select('level')
        //                 ->whereRaw('level = (select max(`level`) from category)')
        //                 ->where('group_id','=',$group_id)
        //                 ->first();
        $max_level    = Category::where('group_id','=',$group_id)->max('level');
           
        return $max_level;
    }
    //To generate category tree for disabling all children
    function disabledcategoriesTree($result){
        $id      = $result->id;
        $sresult = $this->CategoryRepository->disabledmulti($id);//to choose subcategories in category table where parent_id=$id and disable those children
        foreach($sresult as $k=>$v){
           $sresult[$k]->subCategories= $this->disabledcategoriesTree($sresult[$k]);
        }

        return $sresult;

    }

    //To generate category tree for enabling all children
    function enabledcategoriesTree($result){
        $id      = $result->id;
        $sresult = $this->CategoryRepository->enabledmulti($id);//to choose subcategories in category table where parent_id=$id and enable those children
        foreach($sresult as $k=>$v){
            $sresult[$k]->subCategories= $this->enabledcategoriesTree($sresult[$k]);
        }

        return $sresult;
    }

    //To generate subtree of the current category
    function categoriesTree($result){
        $id      = $result->id;
        $sresult = $this->CategoryRepository->multi($id);//to choose subcategories in category table where parent_id=$id
        foreach($sresult as $k=>$v){
            $sresult[$k]->subCategories= $this->categoriesTree($sresult[$k]);
        }

        return $sresult;
    }

   public function catenabled($id){
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->CategoryRepository->catenabled($id);
        }

        return redirect()->action('Cashier\Category\CategoryController@index');
    }

    public function catdisabled($id){
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->CategoryRepository->catdisabled($id);
        }

        return redirect()->action('Cashier\Category\CategoryController@index');
    }

     public function ajax($id){
        // dd("aaa");
        $obj            =  Kitchen::where('branch_id',$id)->whereNull('deleted_at')->get();
        return \Response::json($obj);
    }

}
