<?php

namespace App\RMS;

use App\RMS\Config\ConfigRepository;
use Auth;
use DB;
use PDF;
use App\Http\Requests;
use App\Session;
use App\RMS\User\UserRepository;
use App\User;
use App\RMS\Order\Order;
use App\RMS\Orderdetail\Orderdetail;
use App\RMS\SyncsTable\SyncsTable;
use App\RMS\Category\Category;
use Carbon\Carbon;
use App\RMS\Order\OrderRepository;
use App\RMS\Config\ConfigRepositoryInterface;
use App\RMS\Kitchen\Kitchen;


class Utility
{


    public static function addCreatedBy($newObj)
    {
        if(Auth::guard('Cashier')->check()){

            $loginUserId = Auth::guard('Cashier')->user()->id;
            $newObj->updated_by = $loginUserId;
            $newObj->created_by = $loginUserId;
        }
        Utility::updateSyncsTable($newObj);
        return $newObj;
    }

    public static function addUpdatedBy($newObj)
    {

        if(Auth::guard('Cashier')->check()){

            $loginUserId = Auth::guard('Cashier')->user()->id;

            $newObj->updated_by = $loginUserId;
        }
        Utility::updateSyncsTable($newObj);
        return $newObj;
    }

    public static function addDeletedBy($newObj)
    {
        if(Auth::guard('Cashier')->check()){
            $loginUserId = Auth::guard('Cashier')->user()->id;
            $newObj->deleted_by = $loginUserId;
        }
        Utility::updateSyncsTable($newObj);
        return $newObj;
    }

    public static function updateSyncsTable($newObj)
    {
        $table_name = $newObj->getTable();
        $tempSyncTable = new SyncsTable();
        $syncTableName = $tempSyncTable->getTable();
        $syncTableObj = DB::table($syncTableName)
            ->select('*')
            ->where('table_name' , '=' , $table_name)
            ->first();

        if(isset($syncTableObj) && count($syncTableObj)>0) {
            $id = $syncTableObj->id;
            $version = $syncTableObj->version + 1;
            $syncTable = SyncsTable::find($id);

            if (Auth::guard('Cashier')->check()) {

                $loginUserId = Auth::guard('Cashier')->user()->id;
                $syncTable->updated_by = $loginUserId;
            }
            $syncTable->version = $version++;
            $syncTable->save();
        }
    }

    public static function getCurrentUserID(){
        $id = Auth::guard('Cashier')->user()->id;
        return $id;
    }

    public static function savePriceTracking($table_name,$table_id,$table_id_type,$action,$old_price,$new_price,$created_by,$created_at) {
        DB::table('setup_price_tracking')->insert([
            ['table_name'=>$table_name, 'table_id'=>$table_id, 'table_id_type'=>$table_id_type,
                'action'=>$action, 'old_price'=> $old_price , 'new_price'=>$new_price, 'created_by'=>$created_by, 'created_at'=>$created_at]
        ]);
    }

    public static function exportPDF($html)
    {
        PDF::SetTitle('exportPDF');
        PDF::AddPage();
        PDF::writeHTML($html, true, false, false, false, '');

        /* PDF::writeHTML($html, $ln = true, $fill = false, $reseth = false, $cell = false, $align = '');

        Parameter Definitions
         $html      (string) text to display
         $ln        (boolean) if true add a new line after text (default = true)
         $fill      (boolean) Indicates if the background must be painted (true) or transparent (false).
         $reseth    (boolean) if true reset the last cell height (default false).
         $cell      (boolean) if true add the current left (or right for RTL) padding to each Write (default false).
         $align     (string) Allows to center or align the text. Possible values are:
                        L  : left align
                        C  : center
                        R  : right align
                        '' : empty string : left for LTR or right for RTL */

        PDF::Output('exportPDF.pdf');
    }

    public static function generateStockCode()
    {
        $path_length     = 4;
        $maxCode         = Category::where('stock_code','regexp', '^[0-9]+')->max('stock_code') ?: str_repeat('0',$path_length);
        $category_code   = intval($maxCode);
        $category_code++;
        $stock_code      = str_pad($category_code,$path_length,0,STR_PAD_LEFT);

        return $stock_code;
    }

    public static function getTableId($order_id) {
        $tables = DB::table('order_tables')
            ->select('table_id')
            ->WHERE ('order_id','=',$order_id)
            ->get();

        return $tables;
    }

    public static function getRoomId($order_id) {
        $rooms = DB::table('order_room')
            ->select('room_id')
            ->WHERE ('order_id','=',$order_id)
            ->get();

        return $rooms;
    }

    public static function generateStaffId()
    {
        $pad_length = 5;
        $maxID      = User::max('staff_id') ?: str_repeat('0',$pad_length);
        $staff_id   = intval($maxID);
        $staff_id++;
        $id         = str_pad($staff_id,$pad_length,0,STR_PAD_LEFT);
        return $id;
    }

    public static function dateCodeString()
    {
        $now = Carbon::now()->format('y-m-d');
        $dateCode = implode(explode('-' , $now));

        return $dateCode;
    }

    public static function dateString()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $date_string = implode('T', explode(' ', $now)).'Z';

        return $date_string;
    }

    public static function generateRequisitionNo()
    {
        $date = self::dateCodeString();
        $repository = new ConfigRepository();
        $config = $repository->getAllConfig();
        $int = 00000;
        if (!empty($config->requisition_no)) {
            $old_digit = substr($config->requisition_no, 8, 5);
            $old_date  = substr($config->requisition_no, 2, 6);
            if ($old_date == $date) {
                $int = $old_digit;
            }
        }

        $digit  = str_pad($int + 1, 5, 0, STR_PAD_LEFT);
        $code   = 'RP'.$date.$digit;
        $result = [
            'code' => $code,
            'id'   => $config->id
        ];
        return $result;
    }

    public static function generateKitchenCode()
    {
        $path_length     = 3;
        $prefix          = 'loc';
        $maxCode         = Kitchen::where('kitchen_code', 'like', $prefix.'%')->max('kitchen_code') ?: $prefix.str_repeat('0',$path_length);
        $code            =  substr($maxCode,3,6);
        $category_code    = intval($code);
        $category_code++;
        $code             = str_pad($category_code,$path_length,0,STR_PAD_LEFT);
        return $prefix . $code;
    }


    public static function saledate($date)
    {
        $date_string = implode('T', explode(' ' , $date)).'Z';

        return $date_string;
    }



    public static function getnoticount(){
      $orderRepo = new OrderRepository();
      $orders    = $orderRepo->getwillpayOrder();
      return $orders;
    }

    public static function VoucherID(){

        $date            = Carbon::now()->format('ymd');

        $setting         = DB::table('core_settings')->where('code','VOUCHER')->select('value')->first();
        $length          = $setting->value;
        $prefix          = DB::table('core_settings')->where('code','VOUCHER_PREFIX')->select('value')->first();
        if($prefix != ''){
            $prefix = $prefix->value.'-' . $date;
        }else{
            $prefix = $date;
        }

        $maxID           = Order::where('id', 'like', '%' .$prefix. '%')->max('id');

        $maxID           = str_replace($prefix,"",$maxID);
        
        $vocher_code     = intval($maxID);

        $vocher_code++;
        $voucher_id      = str_pad($vocher_code,$length,0,STR_PAD_LEFT);
        $voucher_id      = $prefix.$voucher_id;

        return $voucher_id;
    }

    public static function OrderDetailId($order_id){
        $date            = Carbon::now()->format('ymd');
        $maxID           = Orderdetail::where('order_detail_id', 'like', '%' .$order_id. '%')->max('order_detail_id');
        $length          = 2;
        $maxID           = str_replace($order_id,"",$maxID);
        $detail_code     = intval($maxID);
        $detail_code++;
        $detail_id       = str_pad($detail_code,$length,0,STR_PAD_LEFT);

        $detail_id       = $order_id . $detail_id;
        return $detail_id;
    }





}
