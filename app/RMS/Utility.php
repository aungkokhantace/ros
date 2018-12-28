<?php namespace App\RMS;
use App\RMS\Config\ConfigRepository;
use Auth;
use DB;
use PDF;
use App\Http\Requests;
use App\Session;
use App\RMS\User\UserRepository;
use App\RMS\SyncsTable\SyncsTable;
use Carbon\Carbon;
use App\RMS\Config\ConfigRepositoryInterface;

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

    public static function generateStockCode($inserted_id,$product_type)
    {
        $generate_codes = DB::table('core_settings')
                        ->select('code')
                        ->WHERE ('value','=',$product_type)
                        ->get();

        foreach($generate_codes as $generate_code) {
            $code = $generate_code->code;
        }

        $inserted_id_length =  strlen($inserted_id);
        $limit_length = 4;
        $remain_length = $limit_length - $inserted_id_length;
        $remain_length_arr = array();
        for ($i = 1;$i <= $remain_length; $i++) {
            $remain_length_arr[$i] = 0;
        }

        $code_length = implode('',$remain_length_arr);

        // $stock_code = $code . "_" . $code_length . $inserted_id;
        $stock_code = $code . "" . $code_length . $inserted_id;
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

    public static function dateCodeString()
    {
        $now = Carbon::now()->format('y-m-d');
        $dateCode = implode(explode('-' , $now));

        return $dateCode;
    }

    public static function dateString()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $date_string = implode('T', explode(' ' , $now)).'Z';

        return $date_string;
    }
}