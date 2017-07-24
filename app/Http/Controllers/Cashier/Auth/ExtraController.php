<?php

namespace App\Http\Controllers\Cashier;
use App\categoryModel;
use App\RMS\Category\Category;
use App\RMS\Extra\ExtraModel;
use App\RMS\Extra\ExtraRepositoryInterface;
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

class ExtraController extends Controller
{
    private $extra_repository;
    public function __construct(ExtraRepositoryInterface $extra_repository)
    {
        $this->extra_repository = $extra_repository;
    }
    public function paginate($value)
    {
        $category =DB::table('category')->where('parent_id','=',0)->get();
        $extra =  ExtraModel::paginate($value);
        return view('cashier.extra.extra_listing')->with('ex', $extra)->with('category',$category);
    }
    public function index()
    {
        if (Auth::guard('Cashier')->check()) {
            if (Auth::guard('Cashier')->user()->role_id == 1) {
                $category = DB::table('category')->where('parent_id', '=', 0)->get();
                $extra = ExtraModel::paginate(5);

                return view('cashier.extra.extra_listing')->with('ex', $extra)->with('category', $category);
            }
        }
    }
    public function selectcategory()
    {

        $category =DB::table('category')->where('parent_id','=',0)->get();
        return view('cashier.extra.extra')->with ('category',$category);
    }
    public function extra_insert(InsertExtraRequest $request)
    {
        $request->validate();
        $food_name=Input::get('food_name');
        $category_id=Input::get('category_id');
        $description=Input::get('description');
        $price=Input::get('price');
        $image = $request->file('fileupload');
        $imageName = $image->getClientOriginalName();

        $destination = 'uploads';
        $image->move($destination, $imageName);
        $status=Input::get('status');
        $this -> extra_repository->extra_insert($food_name,$category_id,$description,$price,$imageName,$status);
        return redirect()->action('Cashier\ExtraController@index');
    }
    public function extra_delete($id)
    {
        $new_string= explode(',',$id);
        foreach($new_string as $id)
        {
            $this ->extra_repository->extra_delete($id);
        }
        return redirect()->action('Cashier\ExtraController@index');
    }

    public function extra_edit($id)
    {
        if (Auth::guard('Cashier')->check()) {
            if (Auth::guard('Cashier')->user()->role_id == 1) {
                $resource = ExtraModel::find($id);
                $extra_edit = $this->extra_repository->extra_edit($id);
                $category = DB::table('category')->where('parent_id', '=', 0)->get();
                return view('cashier.extra.extra', compact('resource', 'extra_edit', 'category'));
            }
        }
    }

    public function extra_update(EditExtraRequest $request)
    {
        $request->validate();
        $food_name = Input::get('food_name');
        $category_id = Input::get('category_id');
        $description = Input::get('description');
        $price = Input::get('price');
        $status = Input::get('status');
            $id=Input::get('id');

            $image = $request->file('fileupload');
        $data=DB::table('extra')->get();
            if($image != null){
               $food_name = Input::get('food_name');

                $imageName = $image->getClientOriginalName();
                $destination = 'uploads';
                $image->move($destination, $imageName);

                $this->extra_repository->updateallextra($id,$food_name,$imageName,$description,$price,$status);
                return redirect()->action('Cashier\ExtraController@index');
            }
            else{
                $name = $request->get('name');

                $data=DB::table('extra')->get();
                $description = $request->get('description');
                $price = $request->get('price');
                $status = $request->get('status');
                $this->extra_repository->extra_update($id,$name,$description,$price,$status);
                return redirect()->action('Cashier\ExtraController@index');
            }
        }
    public function searchextra(){
        $result = [];
        $text = Input::get('term');
        $select = Input::get('term1');
        $filter = 'food_name like "%'.$text.'%"';


        if($text != "" && $select != ""){
            $result = extraModel::select('id','extra.food_name','extra.category_id','extra.description','extra.image','extra.price','extra.status')
                ->where('status',$select)
                ->whereRaw($filter)->get();
        }
        else{
            if($text != "" && $select == ""){
                $result = extraModel::select('id','extra.food_name','extra.category_id','extra.description','extra.image','extra.price','extra.status')
                          ->whereRaw($filter)->get();;
            }
            if($text == "" && $select != ""){
                $result = extraModel::select('id','extra.food_name','extra.category_id','extra.description','extra.image','extra.price','extra.status')->where('status',$select)->get();
            }
        }
        foreach($result as $key=>$value){
            $value->name = Category::select('name')->where('id','=',$value->category_id)->first()->name;
        }
        return \Response::json($result);
    }
}
