<?php

namespace App\Http\Controllers\Cashier\TransactionTenders;
use App\RMS\Transactiontender\Postender;
use App\RMS\Transactiontender\Transactiontender;
use App\RMS\Order\Order;
use App\Status\StatusConstance;
use App\RMS\Table\Table;
use App\RMS\Room\Room;
use App\RMS\Utility;
use App\RMS\Transactiontender\TenderRepositoryInterface;
use App\Session;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;
use InterventionImage;
class TransactionTendersController extends Controller
{
    private $extra_repository;
    public function __construct(TenderRepositoryInterface $tender_repository)
    {
        $this->tender_repository = $tender_repository;
    }

    public function storeCash(Request $request)
    {
        $code                   = Input::get('cash_id');
        $order_id               = Input::get('order_id');
        $quantity               = Input::get('quantity');
        $get_tender             = $this->tender_repository->getTenderByCode($code);
        $tender_id              = $get_tender->id;
        $paid_amount            = $get_tender->amount;
        $status                 = StatusConstance::TRANCTION_PAID_STATUS;
        //Flage 0 = ORDER, 1 = PAIDED Before Tender Insert
        $order                  = Order::find($order_id);
        $order_foc              = $order->foc_amount;
        $order_total            = $order->all_total_amount;
        $order_payment          = $order_total - $order_foc;

        $flag                   = $this->tender_repository->getOrderStatus($order_id);

        if ($flag == StatusConstance::ORDER_CREATE_STATUS) {
            try {
                DB::beginTransaction();
                //Check Exactly Payment
                if ($tender_id == 1) {
                    $before_tender_payment  = $this->tender_repository->getTenderPayment($order_id);
                    $paid_amount = $order_payment - $before_tender_payment;
                }
                $paramObj                 = new Transactiontender();
                $paramObj->order_id       = $order_id;
                $paramObj->tender_id      = $tender_id;
                $paramObj->qty            = $quantity;
                $paramObj->paid_amount    = $paid_amount;
                $paramObj->status         = $status;
                $result                   = $this->tender_repository->store($paramObj);

                $insert_id              = $paramObj->id;
                //After Tender Insert
                $after_tender_payment   = $this->tender_repository->getTenderPayment($order_id);
                if ($after_tender_payment >= $order_payment) {
                    //Updat Tender
                    $change_amount      = $after_tender_payment - $order_payment;
                    $tenderObj                  = Transactiontender::find($insert_id);
                    $tenderObj->changed_amount  = $change_amount;
                    $tenderObj->save();

                    //Update Order
                    $orderObj                   = Order::find($order_id);
                    $orderObj->status           = StatusConstance::ORDER_PAID_STATUS;
                    $orderObj->refund           = $change_amount;
                    $orderObj->payment_amount   = $after_tender_payment;
                    $orderObj->save();

                    //Update Table
                    $table_id = Utility::getTableId($order_id);
                    if (count($table_id) > 0) {
                        foreach($table_id as $table) {
                            $id = $table->table_id;
                        };
                        $tempObj = Table::find($id);
                        $tempObj->status = StatusConstance::TABLE_AVAILABLE_STATUS;
                        $tempObj->save();
                    }
                    //Update Room
                    $room_id = Utility::getRoomId($order_id);
                    if (count($room_id) > 0) {
                        foreach($room_id as $room) {
                            $id = $room->room_id;
                        };
                        $tempObj = Room::find($id);
                        $tempObj->status = StatusConstance::ROOM_AVAILABLE_STATUS;
                        $tempObj->save();
                    }
                }
                DB::commit();
                $invoice            = $this->tender_repository->getTenderByOrder($order_id,$order_payment);
                $invoice            = json_encode($invoice);
                $response           = array(
                                            'message'=>'success',
                                            'invoice'=>$invoice,
                                            'foc'=>$order_foc
                                        );
                return \Response::json(($response));
            } catch (\Exception $e){
                DB::rollback();
                $response               = array('message'=>'fail');
                return \Response::json(($response));
            }
        } else {
            $response               = array('message'=>'paid');
            return \Response::json(($response));
        }

    }

    public function storeCard(Request $request)
    {
        $code                   = Input::get('card_id');
        $order_id               = Input::get('order_id');
        $quantity               = Input::get('quantity');
        $card_with_amount       = Input::get('card_with_amount');
        $exact_payment          = Input::get('exact_payment');
        $get_tender             = $this->tender_repository->getTenderByCode($code);
        $tender_id              = $get_tender->id;
        $status                 = StatusConstance::TRANCTION_PAID_STATUS;
        //Flage 0 = ORDER, 1 = PAIDED Before Tender Insert
        $order                  = Order::find($order_id);
        $order_foc              = $order->foc_amount;
        $order_total            = $order->all_total_amount;
        $order_payment          = $order_total - $order_foc;

        $flag                   = $this->tender_repository->getOrderStatus($order_id);

        if ($flag == StatusConstance::ORDER_CREATE_STATUS) {
            try {
                DB::beginTransaction();
                //Check Exactly Payment
                $before_tender_payment  = $this->tender_repository->getTenderPayment($order_id);
                if ($exact_payment == 'yes') {
                    $paid_amount = $order_payment - $before_tender_payment;
                } else {
                    $paid_amount    = $card_with_amount;
                }
                $paramObj                 = new Transactiontender();
                $paramObj->order_id       = $order_id;
                $paramObj->tender_id      = $tender_id;
                $paramObj->qty            = $quantity;
                $paramObj->paid_amount    = $paid_amount;
                $paramObj->status         = $status;
                $result                   = $this->tender_repository->store($paramObj);

                $insert_id              = $paramObj->id;
                //After Tender Insert
                $after_tender_payment   = $this->tender_repository->getTenderPayment($order_id);
                if ($after_tender_payment >= $order_payment) {
                    //Updat Tender
                    $change_amount      = $after_tender_payment - $order_payment;
                    $tenderObj                  = Transactiontender::find($insert_id);
                    $tenderObj->changed_amount  = $change_amount;
                    $tenderObj->save();

                    //Update Order
                    $orderObj                   = Order::find($order_id);
                    $orderObj->status           = StatusConstance::ORDER_PAID_STATUS;
                    $orderObj->refund           = $change_amount;
                    $orderObj->payment_amount   = $after_tender_payment;
                    $orderObj->save();

                    //Update Table
                    $table_id = Utility::getTableId($order_id);
                    if (count($table_id) > 0) {
                        foreach($table_id as $table) {
                            $id = $table->table_id;
                        };
                        $tempObj = Table::find($id);
                        $tempObj->status = StatusConstance::TABLE_AVAILABLE_STATUS;
                        $tempObj->save();
                    }
                    //Update Room
                    $room_id = Utility::getRoomId($order_id);
                    if (count($room_id) > 0) {
                        foreach($room_id as $room) {
                            $id = $room->room_id;
                        };
                        $tempObj = Room::find($id);
                        $tempObj->status = StatusConstance::ROOM_AVAILABLE_STATUS;
                        $tempObj->save();
                    }
                }
                DB::commit();
                $invoice            = $this->tender_repository->getTenderByOrder($order_id,$order_payment);
                $invoice            = json_encode($invoice);
                $response               = array(
                                        'message'=>'success',
                                        'invoice'=>$invoice,
                                        'foc'=>$order_foc
                                        );
                return \Response::json(($response));
            } catch (\Exception $e){
                DB::rollback();
                $error_msg              = $e->getMessage();
                $response               = array('message'=>$error_msg);
                return \Response::json(($response));
            }
        } else {
            $response               = array('message'=>'paid');
            return \Response::json(($response));
        }

    }

    public function delete(Request $request)
    {
        try {
            $id                     = Input::get('void_val');
            $order_id               = Input::get('order_id');
            $flag                   = 0;
            $order                  = Order::find($order_id);
            $order_foc              = $order->foc_amount;
            $order_total            = $order->all_total_amount;
            $order_payment          = $order_total - $order_foc;
            $before_tender_payment  = $this->tender_repository->getTenderPayment($order_id);

            if ($before_tender_payment >= $order_payment) {
                $flag               = 1;
            }
            if ($flag == 0) {
                $today                  = date('Y-m-d H:i:s');
                $paramObj               = Transactiontender::find($id);
                $paramObj->deleted_at   = $today;
                $paramObj->status       = StatusConstance::TRANCTION_VOID_STATUS;
                $result                 = $this->tender_repository->delete($paramObj);
                if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                    $invoice            = $this->tender_repository->getTenderByOrder($order_id,$order_payment);
                    $invoice            = json_encode($invoice);
                    $response           = array(
                                            'message'=>'success',
                                            'invoice'=>$invoice,
                                            'foc'=>$order_foc,
                                            'order_total'=>$order_total
                                            );
                    return \Response::json(($response));
                }
                else{
                    $response               = array('message'=>'fail');
                    return \Response::json(($response));
                }
            }  else {
                $response               = array('message'=>'paid');
                return \Response::json(($response));
            }
        } catch (\Exception $e){
            $error_msg              = $e->getMessage();
            $response               = array('message'=>$error_msg);
            return \Response::json(($response));
        }
    }

    public function updateFoc(Request $request) {
        $order_id               = Input::get('order_id');
        $amount                 = Input::get('amount');
        $flag                   = $this->tender_repository->getOrderStatus($order_id);
        if ($flag == StatusConstance::ORDER_CREATE_STATUS) {
            $paramObj               = Order::find($order_id);
            //Old amount to update new
            $old_foc                = $paramObj->foc_amount;
            $foc_amount             = $old_foc + $amount;
            $paramObj->foc_amount   = $foc_amount;
            $result                 = $this->tender_repository->update($paramObj);
            if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                $order_foc              = $paramObj->foc_amount;
                $order_total            = $paramObj->all_total_amount;
                $order_payment          = $order_total - $order_foc;
                $invoice            = $this->tender_repository->getTenderByOrder($order_id,$order_payment);
                $invoice            = json_encode($invoice);
                $response               = array(
                                            'message'=>'success',
                                            'invoice'=>$invoice,
                                            'foc'=>$order_foc
                                            );
                return \Response::json(($response));
            }
            else{
                $response               = array('message'=>'fail');
                return \Response::json(($response));
            } 
        } else {
            $response               = array('message'=>'paid');
            return \Response::json(($response));
        }

    }

    public function deleteFoc(Request $request) {
        $order_id               = Input::get('order_id');
        $flag                   = $this->tender_repository->getOrderStatus($order_id);
        if ($flag == StatusConstance::ORDER_CREATE_STATUS) {
            $paramObj               = Order::find($order_id);
            //Old amount to update new
            $paramObj->foc_amount   = null;
            $result                 = $this->tender_repository->update($paramObj);
            if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                $order_foc              = $paramObj->foc_amount;
                $order_payment          = $paramObj->all_total_amount;
                $invoice            = $this->tender_repository->getTenderByOrder($order_id,$order_payment);
                $invoice            = json_encode($invoice);
                $response               = array(
                                            'message'=>'success',
                                            'invoice'=>$invoice,
                                            'foc'=>$order_foc
                                            );
                return \Response::json(($response));
            }
            else{
                $response               = array('message'=>'fail');
                return \Response::json(($response));
            } 
        } else {
            $response               = array('message'=>'paid');
            return \Response::json(($response));
        }

    }
}
