<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 4/28/2016
 * Time: 11:49 AM
 */

namespace App\RMS\Transactiontender;

use App\RMS\Transactiontender\Postender;
use App\Status\StatusConstance;
use App\RMS\Utility;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use Monolog\Handler\Curl\Util;
use App\RMS\ReturnMessage;
use App\RMS\Order\Order;

class TenderRepository  implements  TenderRepositoryInterface
{
    public function getTenderByCode($code) {
        $get_tender        = Postender::where('code','=',$code)->first();
        return $get_tender;
    }
    public function store($paramObj){

        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj        = Utility::addCreatedBy($paramObj);
            $tempObj->save();

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }


    }

    public function getOrderStatus($order_id) {
        $tempObj        = Order::select('status')
                          ->where('id','=',$order_id)
                          ->first();
        $status         = $tempObj->status;
        return $status;
    }

    public function getTenderByOrder($order_id,$order_payment) {
        $status         = StatusConstance::TRANCTION_PAID_STATUS;
        $transactions   = Transactiontender::leftjoin('pos_tenders','pos_tenders.id','=','transaction_tenders.tender_id')
                            ->select('transaction_tenders.id','transaction_tenders.paid_amount','transaction_tenders.changed_amount','transaction_tenders.qty','pos_tenders.description','pos_tenders.card_type')
                            ->where('transaction_tenders.status','=',$status)
                            ->where('transaction_tenders.order_id','=',$order_id)
                            ->get();
        $balance        = DB::table('transaction_tenders')
                          ->select(DB::raw("SUM(paid_amount * qty) as count"))
                          ->where('status',$status)
                          ->where('order_id',$order_id)
                          ->whereNull('deleted_at')
                          ->first();
        $change         = Transactiontender::select('changed_amount')
                          ->where('status',$status)
                          ->where('order_id',$order_id)
                          ->whereNotNull('changed_amount')
                          ->first();
        $tenders        = array();
        $invoice        = array();
        foreach ($transactions as $key => $transaction) {
            $t['id']    = $transaction->id;
            $t['paid']  = $transaction->paid_amount;
            $t['card']  = $transaction->card_type;
            $t['description']   = $transaction->description;
            $t['qty']           = $transaction->qty;
            $t['total']         = $t['paid'] * $t['qty'];
            array_push($tenders, $t);
        }
        $invoice['pay']     =  $tenders;
        $invoice['balance'] =  $order_payment - $balance->count;
        $invoice['payment_done']    = 'no';
        if ($invoice['balance'] <= 0) {
            $invoice['payment_done']    = 'yes';
        }

        //If Balance is less than zero balance equal zero
        if ($invoice['balance'] < 0) {
            $invoice['balance']     = 0;
        }
        if (count($change) > 0) {
            $invoice['change']  =  $change->changed_amount;
        } else {
            $invoice['change']  =  0;
        }

        //If payment is done show print
        $payment_print      = $this->getPayment($order_id);
        $invoice['payment_print']   = $payment_print;
        return $invoice;
    }

    public function getPayment($id) {
        $status         = StatusConstance::TRANCTION_PAID_STATUS;
        $payment        = Transactiontender::leftjoin('pos_tenders','transaction_tenders.tender_id','=','pos_tenders.id')
                          ->leftjoin('card_tenders','pos_tenders.card_type','=','card_tenders.id')
                          ->select(DB::raw("SUM(transaction_tenders.paid_amount * transaction_tenders.qty) as paid_amount"),'card_tenders.code as name')
                          ->groupBy('card_tenders.code')
                          ->where('transaction_tenders.order_id',$id)
                          ->where('transaction_tenders.status',$status)
                          ->whereNull('transaction_tenders.deleted_at')
                          ->get()
                          ->toArray();
        return $payment;
    }

    public function getTenderPayment($order_id) {
        $status         = StatusConstance::TRANCTION_PAID_STATUS;
        $tempObj       = DB::table('transaction_tenders')
                                  ->select(DB::raw('SUM(paid_amount * qty) AS paid'))
                                  ->where('order_id','=',$order_id)
                                  ->where('status','=',$status)
                                  ->whereNull('deleted_at')
                                  ->first();
        $tender_payment = $tempObj->paid;
        return $tender_payment;
    }
    
    public function delete($paramObj)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj        = Utility::addDeletedBy($paramObj);
            $tempObj->save();

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }   
    }

    public function update($paramObj)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj        = Utility::addUpdatedBy($paramObj);
            $tempObj->save();

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }

    }
}