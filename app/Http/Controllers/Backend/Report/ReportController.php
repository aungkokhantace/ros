<?php
namespace App\Http\Controllers\Backend\Report;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\RMS\Report\ReportRepositoryInterface;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\RMS\Orderdetail\Orderdetail;
use App\RMS\Order\Order;
use App\RMS\Item\Item;

use Illuminate\Support\Facades\Input;
//use Input;
use Excel;
use App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection as Collection;


class ReportController extends Controller
{
    private $orderRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }
    
    public function invoiceList()
    {
        $order = $this->reportRepository->getinvoice();

        return view('cashier.invoice.index',compact('orders'));

    } 

    //Item Report & Excel Download
    public function itemReport()
    {
        $start  = $this->reportRepository->getStartDate();
        $end    = $this->reportRepository->getEndDate();
        $orders = $this->reportRepository->getItemReport($start, $end);
        // dd($orders);
        return view('Backend.report.itemReport', compact('orders', 'start', 'end'));
    }

    public function downloadItemReport(){
        ob_end_clean();
        ob_start();
        $start  = $this->reportRepository->getStartDate();
        $end    = $this->reportRepository->getEndDate();
        $orders = $this->reportRepository->getExcel($start, $end);
        foreach ($orders as $key => $order) {
            $items[$key]['Item Name']       = $order->Item_Name;
            $items[$key]['Quantity']        = $order->Quantity;
            $items[$key]['Price']           = $order->Price;
            $items[$key]['Discount Price']  = $order->DiscountAmount;
            $items[$key]['Total Amount']    = $order->TotalAmount;
        }
        Excel::create('BestSellingItemReport', function($excel)use($orders,$items) {
            $excel->sheet('ItemReport', function($sheet)use($orders,$items) {
                $sheet->fromArray($items);
                $totalamt=null;
                foreach($orders as $order){
                    $totalamt+=$order->TotalAmount;
                }
                $sheet->appendRow(array(
                    '','','','Total Amount',$totalamt
                ));
                $sheet->row(1,function($row){
                    $row->setBackground('#f3a42e');
                });
            });
        })
            ->download('xls');
        ob_flush();
        return Redirect();
    }//END

    //Item Report With Date & Excel
    public function itemReportWithDate()
    {
        $start_date   = Date('Y-m-d',strtotime(Input::get('from')));
        $end_date     = Date('Y-m-d',strtotime(Input::get('to')));
        $from_amount  = Input::get('from_amount');
        $to_amount    = Input::get('to_amount');
        $number       = Input::get('number');
        $from_amt     = (double)$from_amount;
        $to_amt       = (double)$to_amount;
        if($start_date == "1970-01-01"||$end_date == "1970-01-01"){
            alert()->warning('Please Choose Date!')->persistent('Close');
//            return back();
            return redirect()->action('Backend\Report\ReportController@itemReport');
        }
        elseif(($from_amt != "" && $to_amt == "") || ($from_amt == "" && $to_amt != "")){
            alert()->warning('Please Choose Amount!')->persistent('Close');
            return redirect()->action('Backend\Report\ReportController@itemReport');
//            return back();
        }
        elseif($to_amt < $from_amt){
            alert()->warning('End Amount must be greater than Start Amount!')->persistent('Close');
            return redirect()->action('Backend\Report\ReportController@itemReport');
        }
        else{
            $orders = $this->reportRepository->getItemReportWithDate($start_date, $end_date,$number,$from_amount,$to_amount);
            return view('Backend.report.itemReport',compact('orders','start_date','end_date','number','from_amount','to_amount'));
        }
    }

    public function downloadItemReportWithDateAndNumber($start_date,$end_date,$number)
    {
        $start_date     = $start_date.' 00:00:00';
        $end_date       = $end_date.' 23:00:00';

        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->getExcelWithDateAndNumber($start_date, $end_date,$number);
        foreach ($orders as $key => $order) {
            $items[$key]['Item Name']       = $order->Item_Name;
            $items[$key]['Quantity']        = $order->Quantity;
            $items[$key]['Price']           = $order->Price;
            $items[$key]['Discount Price']  = $order->DiscountAmount;
            $items[$key]['Amount']          = $order->Amount;
            $items[$key]['Total Amount']    = $order->TotalAmount;
        }
        Excel::create('BestSellingItemReport', function($excel)use($orders,$items) {
            $excel->sheet('ItemReport', function($sheet)use($orders,$items) {
                $sheet->fromArray($items);

                $totalamt=null;
                foreach($orders as $order){
                    $totalamt+=$order->TotalAmount;
                }
                $sheet->appendRow(array(
                    '','','','','Total Amount',$totalamt
                ));
                $sheet->row(1,function($row){
                    $row->setBackground('#f3a42e');
                });
            });
        })
            ->download('xls');
        ob_flush();
        return Redirect();
    }

    public function downloadItemReportWithDateAndAmount($start_date,$end_date,$from_amount,$to_amount)
    {
        $start_date     = $start_date.' 00:00:00';
        $end_date       = $end_date.' 23:00:00';
        $from_amount    = $from_amount;
        $to_amount      = $to_amount;
        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->getExcelWithDateAndAmount($start_date, $end_date,$from_amount,$to_amount);
        foreach ($orders as $key => $order) {
            $items[$key]['Item Name']       = $order->Item_Name;
            $items[$key]['Quantity']        = $order->Quantity;
            $items[$key]['Price']           = $order->Price;
            $items[$key]['Discount Price']  = $order->DiscountAmount;
            $items[$key]['Amount']          = $order->Amount;
            $items[$key]['Total Amount']    = $order->TotalAmount;
        }
        Excel::create('BestSellingItemReport', function($excel)use($orders,$items) {
            $excel->sheet('ItemReport', function($sheet)use($orders,$items) {
                $sheet->fromArray($items);

                $totalamt=null;
                foreach($orders as $order){
                    $totalamt+=$order->TotalAmount;
                }
                $sheet->appendRow(array(
                    '','','','','Total Amount',$totalamt
                ));
                $sheet->row(1,function($row){
                    $row->setBackground('#f3a42e');
                });
            });
        })
            ->download('xls');
        ob_flush();
        return Redirect();
    }

    public function downloadItemReportWithAll($start_date,$end_date,$number,$from_amount,$to_amount)
    {
        $start_date     = $start_date.' 00:00:00';
        $end_date       = $end_date.' 23:00:00';
        $from_amount    = $from_amount;
        $to_amount      = $to_amount;
        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->getExcelWithDate($start_date, $end_date,$number,$from_amount,$to_amount);
        foreach ($orders as $key => $order) {
            $items[$key]['Item Name']       = $order->Item_Name;
            $items[$key]['Quantity']        = $order->Quantity;
            $items[$key]['Price']           = $order->Price;
            $items[$key]['Discount Price']  = $order->DiscountAmount;
            $items[$key]['Amount']          = $order->Amount;
            $items[$key]['Total Amount']    = $order->TotalAmount;
        }
        Excel::create('BestSellingItemReport', function($excel)use($orders,$items) {
            $excel->sheet('ItemReport', function($sheet)use($orders,$items) {
                $sheet->fromArray($items);

                $totalamt=null;
                foreach($orders as $order){
                    $totalamt+=$order->TotalAmount;
                }
                $sheet->appendRow(array(
                    '','','','','Total Amount',$totalamt
                ));
                $sheet->row(1,function($row){
                    $row->setBackground('#f3a42e');
                });
            });
        })
            ->download('xls');
        ob_flush();
        return Redirect();
    }
    
    public function downloadItemReportWithDateWithNull($start_date,$end_date)
    {
        $start_date     = $start_date.' 00:00:00';
        $end_date       = $end_date.' 23:00:00';
        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->getExcelWithDateWithNull($start_date, $end_date);
        foreach ($orders as $key => $order) {
            $items[$key]['Item Name']       = $order->Item_Name;
            $items[$key]['Quantity']        = $order->Quantity;
            $items[$key]['Price']           = $order->Price;
            $items[$key]['Discount Price']  = $order->DiscountAmount;
            // $items[$key]['Amount']          = $order->Amount;
            $items[$key]['Total Amount']    = $order->TotalAmount;
        }
        Excel::create('BestSellingItemReport', function($excel)use($items,$orders) {
            $excel->sheet('ItemReport', function($sheet)use($items,$orders) {
                $sheet->fromArray($items);

                $totalamt=null;
                foreach($orders as $order){
                    $totalamt+=$order->TotalAmount;
                }
                $sheet->appendRow(array(
                    '', '','','Total Amount',$totalamt
                ));
                $sheet->row(1,function($row){
                    $row->setBackground('#f3a42e');
                });
            });
        })
            ->download('xls');
        ob_flush();
        return Redirect();
    }
    //END

    //Favourite Set Menu Report & Excel Download
    public function favourite_set_menus()
    {
        $start      = $this->reportRepository->getStartDate();
        $end        = $this->reportRepository->getEndDate();
        $sub_orders = $this->reportRepository->getset($start,$end);
        return view('Backend.report.sub_menus_report', compact('sub_orders', 'start', 'end'));
    }

    public function downloadsubReport(){
        ob_end_clean();
        ob_start();
        $start      = $this->reportRepository->getStartDate();
        $end        = $this->reportRepository->getEndDate();
        $orders     = $this->reportRepository->getset($start,$end);

        Excel::create('BestSellingSet_menusReport', function($excel)use($orders) {
            $excel->sheet('Set_menus_Report', function($sheet)use($orders) {

                $sheet->fromArray($orders);
                $total_amt=null;
                foreach($orders as $order){
                    $total_amt+=$order->TotalAmount;
                }
                $sheet->appendRow(array(
                    '','','Total Amount',$total_amt
                ));
                $sheet->row(1,function($row){
                    $row->setBackground('#f3a42e');
                });
            });
        })->download('xls');
        ob_flush();
        return Redirect();
    }

    public function fav_set_date_report()
    {
        $start_date     = Date('Y-m-d',strtotime(Input::get('from')));
        $end_date       = Date('Y-m-d',strtotime(Input::get('to')));
        $number         = Input::get('number');
        if($start_date == "1970-01-01"||$end_date == "1970-01-01"){
            alert()->warning('Please Choose Date!')->persistent('Close');
            return back();
        }
        else{
            $sub_orders = $this->reportRepository->fav_set_date_report($start_date, $end_date, $number);
            return view('Backend.report.sub_menus_report')->with('start_date',$start_date)->with('end_date',$end_date)->with('sub_orders',$sub_orders)->with('number',$number);
        }
    }
    public function downloadsubReportWithDateWithNull($start_date,$end_date)
    {
        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->fav_set_date_report_with_null($start_date, $end_date);
        Excel::create('BestSellingSet_menusReport', function($excel)use($orders) {
            $excel->sheet('Set_menu_Report', function($sheet)use($orders) {
                $sheet->fromArray($orders);
                $total_amt=null;
                foreach($orders as $order){
                    $total_amt+=$order->TotalAmount;
                }
                $sheet->appendRow(array(
                    '','','Total Amount',$total_amt
                ));
                $sheet->row(1,function($row){
                    $row->setBackground('#f3a42e');
                });
            });
        })
            ->download('xls');
        ob_flush();
        return Redirect();
    }
    public function downloadsubReportWithDate($start_date,$end_date,$number)
    {
        ob_end_clean();
        ob_start();
        $orders = $this->reportRepository->fav_set_date_report($start_date, $end_date, $number);
        Excel::create('BestSellingSet_menusReport', function($excel)use($orders) {
            $excel->sheet('Set_menu_Report', function($sheet)use($orders) {
                $sheet->fromArray($orders);
                $total_amt=null;
                foreach($orders as $order){
                    $total_amt+=$order->TotalAmount;
                }
                $sheet->appendRow(array(
                  '','','Total Amount',$total_amt
                ));
                $sheet->row(1,function($row){
                    $row->setBackground('#f3a42e');
                });
            });
        })
            ->download('xls');
        ob_flush();
        return Redirect();
    }

    public function saleSummaryDetailReport_checked($checked){
        return view('cashier.report.SaleSummaryDetailReport')->with('checked',$checked);
    }

    public function index()
    {
        return view('Backend.report.CategorySaleReport');
    }

    public function getCategorySaleAjax(Request $request)
    {
        $limit  = (int) $request->input('length');
        $offset = (int) $request->input('start');

        $categories = $this->reportRepository->getCategorySaleReportByParams($limit, $offset);
        $data       = $this->getFinalResultForCategorySaleReport($categories);
        $result     = [];
        $total      = 0;

        foreach ($data as $category) {
            $nestedData[0] = $category->category_name;
            $nestedData[1] = $category->item_name;
            $nestedData[2] = $category->quantity;
            $nestedData[3] = $category->amount;
            $total += $category->amount;
            $result[] = $nestedData;
        }

            $nestedData[0] = '';
            $nestedData[1] = '';
            $nestedData[2] = '<b>Grand Total</b>';
            $nestedData[3] = '<b>'.$total.'</b>';
            $result[] = $nestedData;

        $count = $this->reportRepository->getCategorySaleReportCount();

        $array = [
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($count),
            "recordsFiltered" => intval($count),
            "data"            => $result
        ];

        return \Response::json($array);
    }

    public function getCategorySaleByDate(Request $request)
    {
        if (empty($request->from) || empty($request->to)) {
            alert()->warning('Please Choose Date!')->persistent('Close');
            return redirect()->back()->withInput();
        }

        $date = [
            'from' => $request->from,
            'to'   => $request->to
        ];

        $request->from = Date('Y-m-d', strtotime($request->from));
        $request->to   = Date('Y-m-d', strtotime($request->to));
        $category_sale_reports = $this->reportRepository->getCategorySaleReportByDate($request);
        $result = $this->getFinalResultForCategorySaleReport($category_sale_reports);
        return view('Backend.report.CategorySaleReport', compact('result', 'date'));
    }

    public function getCategorySaleExport()
    {
        ob_end_clean();
        ob_start();

        $category_sale_reports = $this->reportRepository->getCategorySaleReport();
        $data = $this->getFinalResultForCategorySaleReport($category_sale_reports);

        foreach ($data as $key => $category_sale_report) {
            $items[$key]['Parent Category Name'] = $category_sale_report->category_name;
            $items[$key]['Category Name']        = $category_sale_report->item_name;
            $items[$key]['Quantity']             = $category_sale_report->quantity;
            $items[$key]['Total Amount']         = $category_sale_report->amount;
        }

        Excel::create('Category Sale Report', function ($excel) use ($data, $items) {
            $excel->sheet('Category Sale Report', function ($sheet) use ($data, $items) {
                $sheet->fromArray($items);
                $total = 0;
                foreach ($data as $value) {
                    $total += $value->amount;
                }

                $sheet->appendRow(array('', '', 'Grand Total', $total));
                $sheet->row(1, function($row) {
                    $row->setBackground('#f3a42e');
                });
            });
        })->download('xls');

        ob_flush();
        return Redirect();
    }

    public function getCategorySaleExportByDate($from, $to)
    {
        ob_end_clean();
        ob_start();

        $date = [
            'from' => Date('Y-m-d', strtotime($from)),
            'to'   => Date('Y-m-d', strtotime($to))
        ];

        $category_sale_reports = $this->reportRepository->getCategorySaleReportByDate((object)$date);
        $data = $this->getFinalResultForCategorySaleReport($category_sale_reports);

        foreach ($data as $key => $category_sale_report) {
            $items[$key]['Parent Category Name'] = $category_sale_report->category_name;
            $items[$key]['Category Name']        = $category_sale_report->item_name;
            $items[$key]['Quantity']             = $category_sale_report->quantity;
            $items[$key]['Total Amount']         = $category_sale_report->amount;
        }

        Excel::create('Category Sale Report', function($excel)use($data, $items) {
            $excel->sheet('Category Sale Report', function($sheet)use($data, $items) {
                $sheet->fromArray($items);
                $total = 0;
                foreach ($data as $value) {
                    $total += $value->amount;
                }
                $sheet->appendRow(array('', '', 'Grand Total', $total));
                $sheet->row(1,function($row) {
                    $row->setBackground('#f3a42e');
                });
            });
        })->download('xls');

        ob_flush();
        return Redirect();
    }

    public function getFinalResultForCategorySaleReport(array $data)
    {
        $result = [];
        $item   = [];
        $i = 0;
        if (!empty($data)) {
            foreach ($data as $category_sale_report) {
                if (array_search($category_sale_report->item_id, $item)) {
                    $duplicate = array_search($category_sale_report->item_id, $item);
                    $data = $result[$duplicate];
                    $category_sale_report->quantity += $data->quantity;
                    $category_sale_report->amount   += $data->amount;
                    unset($result[$duplicate]);
                    unset($item[$duplicate]);
                }
                $parent_id = $category_sale_report->parent_id;
                if ($parent_id !== 0) {
                    $child = $this->reportRepository->getParentCategory($parent_id);
                    if ($child->parent_id !== 0) {
                        $sub_child = $child = $this->reportRepository->getParentCategory($child->parent_id);
                        $category_sale_report->item_name = $sub_child->item_name;
                    }
                    $category_sale_report->item_name     = $category_sale_report->category_name;
                    $category_sale_report->category_name = $child->name;
                }

                $item['id'.$i] = $category_sale_report->item_id;
                $result['id'.$i] = $category_sale_report;
                $i++;
            }
        }

        return $result;
    }
}

