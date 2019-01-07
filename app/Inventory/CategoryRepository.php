<?php
namespace App\inventory;
use App\RMS\Order\Order;
use App\RMS\Orderdetail\Orderdetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\RMS\Category\Category;
use App\RMS\OrderTable\OrderTable;
use App\RMS\OrderRoom\OrderRoom;
use App\RMS\OrderExtra\OrderExtra;
use App\RMS\OrderSetMenuDetail\OrderSetMenuDetail;
use App\RMS\Kitchen\Kitchen;
use App\Status\StatusConstance;

class CategoryRepository implements CategoryRepositoryInterface
{
    
    public function SelectParentId($id){
        $parent = DB::table('category')->where('id',$id)->select('parent_id')->first();
        return $parent;
    }

    public function getParentCate(){
    $parent = Category::where('parent_id',0)->whereNull('deleted_at')->where('status',1)->select('id as Id','name as Description','stock_code as CategoryNo')->get();
    return $parent;
    }
    public function getGroup($groups){
    $groups =  Category::whereIn('parent_id',$groups)->whereNull('deleted_at')->where('status',1)->select('id as Id','name as Description','stock_code as GroupNo')->get();
    return $groups;
    }

    public function getCalss($classes){
      $class =   Category::whereIn('parent_id',$classes)->whereNull('deleted_at')->where('status',1)->select('id as Id','stock_code as ClassNo','name as Description')->get();
      return $class;
    }
    
}