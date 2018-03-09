<?php

namespace App\Http\Controllers\Cashier\Promotion;

use App\RMS\SetMenu\SetMenu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\RMS\Promotion\PromotionRepositoryInterface;
use App\RMS\Promotion\Promotion;
use App\RMS\Item\Item;
use App\RMS\PromotionItem\PromotionItem;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;

class PromotionController extends Controller
{
    private $PromotionRepository;

    public function __construct(PromotionRepositoryInterface $PromotionRepository)
    {
        $this->PromotionRepository = $PromotionRepository;
    }

    public function create(){
        $items = Item::all();
        $sets  = SetMenu::all();
        return view('cashier.promotion.promotion')->with('items',$items)->with('sets',$sets);
    }

    public function index(){
        $promotion = Promotion::all();
        $promotion_item = PromotionItem::all();
        return view('cashier.promotion.promotion_listing')->with('promotion',$promotion)->with('promotion_item',$promotion_item);
    }

    public function store(){
        $promotion_type             = Input::get('promotion_type');
        $from_date                  = Carbon::parse(Input::get('from_date'))->format('Y-m-d');
        $to_date                    = Carbon::parse(Input::get('to_date'))->format('Y-m-d');
        $from_time                  = Carbon::parse(Input::get('from_time'))->format('H:i:s');
        $to_time                    = Carbon::parse(Input::get('to_time'))->format('H:i:s');
        $sell_item                  = Input::get('sell_item');
        $sell_item_qty              = Input::get('sell_item_qty');
        $present_item               = Input::get('present_item');
        $present_item_qty           = Input::get('present_item_qty');
        
        $paramObj                   = new Promotion();
        $paramObj->promotion_type   = $promotion_type;
        $paramObj->from_date        = $from_date;
        $paramObj->to_date          = $to_date;
        $paramObj->from_time        = $from_time;
        $paramObj->to_time          = $to_time;
        $paramObj->sell_item_qty    = $sell_item_qty;
        $paramObj->present_item     = $present_item;
        $paramObj->present_item_qty = $present_item_qty;
        $result = $this->PromotionRepository->store($paramObj,$sell_item);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Cashier\Promotion\PromotionController@index')
                ->withMessage(FormatGenerator::message('Success', 'Promotion created ...'));
        }
        else{
            return redirect()->action('Cashier\Promotion\PromotionController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Promotion did not create ...'));
        }

    }

    public function edit($id){
        $promotion          = Promotion::findOrFail($id);
        $items              = Item::all();
        $pro_items          = PromotionItem::where('promotion_id','=',$id)->lists('item_id')->toArray();
        return view('cashier.promotion.promotion')->with('promotion',$promotion)->with('items',$items)->with('pro_items',$pro_items);
    }

    public function update()
    {
        $id                         = Input::get('id');
        $promotion_type             = Input::get('promotion_type');
        $from_date                  = Carbon::parse(Input::get('from_date'))->format('Y-m-d');
        $to_date                    = Carbon::parse(Input::get('to_date'))->format('Y-m-d');
        $from_time                  = Carbon::parse(Input::get('from_time'))->format('H:i:s');
        $to_time                    = Carbon::parse(Input::get('to_time'))->format('H:i:s');
        $sell_item                  = Input::get('sell_item');
        $sell_item_qty              = Input::get('sell_item_qty');
        $present_item               = Input::get('present_item');
        $present_item_qty           = Input::get('present_item_qty');

        $paramObj                   = Promotion::find($id);
        $paramObj->promotion_type   = $promotion_type;
        $paramObj->from_date        = $from_date;
        $paramObj->to_date          = $to_date;
        $paramObj->from_time        = $from_time;
        $paramObj->to_time          = $to_time;
        $paramObj->sell_item_qty    = $sell_item_qty;
        $paramObj->present_item     = $present_item;
        $paramObj->present_item_qty = $present_item_qty;

        $result = $this->PromotionRepository->update($paramObj, $sell_item);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Cashier\Promotion\PromotionController@index')
                ->withMessage(FormatGenerator::message('Success', 'Promotion updated ...'));
        }
        else{
            return redirect()->action('Cashier\Promotion\PromotionController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Promotion did not update ...'));
        }

    }
    public function delete($id)
    {
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->PromotionRepository->delete($id);
        }

        return redirect()->action('Cashier\Promotion\PromotionController@index'); //to redirect listing page
    }
}
