<?php
namespace App\Http\Controllers\Cashier\Category;
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
class CategoryController extends Controller
{
    private $CategoryRepository;
    public function __construct(CategoryRepositoryInterface $CategoryRepository){
        $this->CategoryRepository = $CategoryRepository;
    }


    public function index(){
        $title        = 'Category List';
        $categorylist = $this->CategoryRepository->getAllCategory();

        return view('cashier.category.category_listing')->with('categorylist',$categorylist)->with('title',$title);
    }

    public function create(){
        $kitchen = $this->CategoryRepository->getKitchen();
        $result  = $this->CategoryRepository->ChooseCat();

        return view('cashier.category.category', ['categories' => $result])->with('kitchen',$kitchen);
    }

     public function store(CreateCategoryRequest $request){
        $name                   = $request->get('name');
        $category               = $request->get('parent_category');
        $kitchen                = $request->get('kitchen');
        $file                   = $request->file('fileupload');
        $imagedata              = file_get_contents($file);
        $photo                  = uniqid().'.'.$file->getClientOriginalExtension();
        $file->move('uploads', $photo);
         // resizing image
         $image = InterventionImage::make(sprintf('uploads' .'/%s', $photo))->resize(200, 200)->save();

        $status                 = Input::get('status');
        $description            = Input::get('description');
        $paramObj               = new Category();
        $paramObj->name         = $name;
        $paramObj->parent_id    = $category;
        $paramObj->kitchen_id   = $kitchen;
        $paramObj->image        = $photo;
        $paramObj->mobile_image = base64_encode($image->encoded);
        $paramObj->status       = $status;
        $paramObj->description  = $description;
        $result = $this->CategoryRepository->store($paramObj);

         if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
             return redirect()->action('Cashier\Category\CategoryController@index')
                 ->withMessage(FormatGenerator::message('Success', 'Category created ...'));
         }
         else{
             return redirect()->action('Cashier\Category\CategoryController@index')
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
                return redirect()->action('Cashier\CategoryController@index');
            }
            elseif($item){
                //there is items record.
                alert()->error('This category is sub category and has child items,you must delete the child items first!')->persistent('Close');

                return redirect()->action('Cashier\CategoryController@index');
            }
            else{
                foreach($new_string as $maincategory_id){
                    $this->CategoryRepository->deleteCategory($maincategory_id);
                }

                return redirect()->action('Cashier\Category\CategoryController@index');
            }
        }
    }

    public function edit($id){
        $cats                = $this->CategoryRepository->ChooseCat();
        $editcategory        = $this->CategoryRepository->find($id);
        $title               = 'Edit Category';
        //start generating subtree of current category
        $result              =  $this->CategoryRepository->find($id);
        $result->subcategory = $this->disabledcategoriesTree($result);
        $selected            = $editcategory->parent_id;
        $kitchen=$this->CategoryRepository->getKitchen();

        return view('cashier.category.category', ['categories' => $cats])->with('editcategory',$editcategory)
            ->with('selected',$selected)->with('title',$title)->with('subtree',$result)->with('kitchen',$kitchen);
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
                $result->subCategories=$this->disabledcategoriesTree($result);
            }
            //user enabled a category and all children subcategories and items must be enabled
            elseif($status == 1){
                $result=$this->CategoryRepository->find($id);
                $result->subCategories=$this->enabledcategoriesTree($result);
            }

            $file = $request->file('fileupload');
            //if users don't want to upload new photo,"if" condition will work.and if users want to upload new photo,'else' function will work
            if($file != null){
                $imagedata              = file_get_contents($file);
                $photo                  = uniqid().'.'.$file->getClientOriginalExtension();
                $file->move('uploads', $photo);
                $image = InterventionImage::make(sprintf('uploads' .'/%s', $photo))->resize(200, 200)->save();

                $paramObj               = Category::find($id);
                $paramObj->name         = $name;
                $paramObj->parent_id    = $category;
                $paramObj->kitchen_id   = $kitchen;
                $paramObj->image        = $photo;
                $paramObj->mobile_image = base64_encode($image->encoded);
                $paramObj->status       = $status;
                $paramObj->description  = $description;
                $result = $this->CategoryRepository->updateAllCategory($paramObj);

                if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                    return redirect()->action('Cashier\Category\CategoryController@index')
                        ->withMessage(FormatGenerator::message('Success', 'Category updated ...'));
                }
                else{
                    return redirect()->action('Cashier\Category\CategoryController@index')
                        ->withMessage(FormatGenerator::message('Fail', 'Category did not update ...'));
                }

            }
            else{
                $paramObj               = Category::find($id);
                $paramObj->name         = $name;
                $paramObj->parent_id    = $category;
                $paramObj->kitchen_id   = $kitchen;
                $paramObj->status       = $status;
                $paramObj->description  = $description;
                $result = $this->CategoryRepository->updateCategory($paramObj);

                if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                    return redirect()->action('Cashier\Category\CategoryController@index')
                        ->withMessage(FormatGenerator::message('Success', 'Category updated ...'));
                }
                else{
                    return redirect()->action('Cashier\Category\CategoryController@index')
                        ->withMessage(FormatGenerator::message('Fail', 'Category did not create ...'));
                }

            }
        }
        elseif($flag == 0){
            alert()->error('The category with the same name already exists')->persistent('Close');
            return redirect()->action('Cashier\Category\CategoryController@index');
        }
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
}
