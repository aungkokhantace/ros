<?php
namespace App\RMS\Orderdetail;
use App\RMS\Order\Order;
use App\RMS\Orderdetail\Orderdetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\RMS\Category\Category;
use App\RMS\Item\Item;
use App\RMS\OrderTable\OrderTable;
use App\RMS\OrderRoom\OrderRoom;
use App\RMS\OrderExtra\OrderExtra;
use App\RMS\Kitchen\Kitchen;
use App\RMS\Setmenu\SetMenu;
class OrderdetailRepository implements OrderdetailRepositoryInterface
{
   public function getCategories(){
    $categories = Category::where('parent_id',0)->where('deleted_at',NULL)->get();
    return $categories;
   }
   public function getsetmenu(){
      $setmenus = SetMenu::where('deleted_at',NULL)->get();
      return $setmenus;
   }
   public function getitem($id){
      $category    = Item::find($id);
      $category_id = $category->category_id;

      $items = Item::where('category_id',$category_id)->where('deleted_at',NULL)->get();
      return $items;
   }
   public function categoryDetail($id){
     	$categories    = Category::where('parent_id',$id)->where('deleted_at',NULL)->get()->count();
      
      if($categories == 0){
         $items = Item::where('category_id',$id)->where('deleted_at',NULL)->get();

         return $items;
      }
      if($categories > 0){
         $categoryObj = Category::where('parent_id',$id)->where('deleted_at',NULL)->get();
         return $categoryObj;
      }
      
    
   }
   public function searchItem($id){
   	$category_id = $id;
   	$items = Item::all();
   	$products = array();
   	foreach ($items as $item){
   		$categories = Category::select('id')->where('id',$item->category_id)->get();
   		if(isset($categories)){
   			foreach($categories as $category){
   				if($category->id == $category_id){
   					array_push($products,$item);
   				}
   			}
   		}
   	}
   	return $products;
   	//dd($products);
   }
    
}