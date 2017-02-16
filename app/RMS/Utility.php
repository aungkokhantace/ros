<?php namespace App\RMS;
use Auth;
use DB;
use PDF;
use App\Http\Requests;
use App\Session;
use App\RMS\User\UserRepository;
use App\RMS\SyncsTable\SyncsTable;

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
}