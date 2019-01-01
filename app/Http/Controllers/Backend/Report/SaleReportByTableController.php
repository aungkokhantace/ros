<?php
/**
 * Created by PhpStorm.
 * User: myothantkyaw
 * Date: 12/13/18
 * Time: 10:30 AM
 */
namespace App\Http\Controllers\Backend\Report;

use App\RMS\Report\ReportRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;

class SaleReportByTableController extends Controller
{
    private $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $response = $this->reportRepository->getSaleReportByTable();
        $result   = (object) $this->getResultForReport($response);
        $reports  = $result->data;
        $total    = $result->total;


        return view('Backend.report.SaleReportByTable', compact('reports', 'total'));
    }

    /**
     * @param Request $requests
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (empty($request->from) || empty($request->to)) {
            alert()->warning('Please Choose Date!')->persistent('Close');
            return redirect()->back()->withInput();
        }

        $date = [
            'from' => Date('Y-m-d', strtotime($request->from)),
            'to'   => Date('Y-m-d', strtotime($request->to))
        ];

        $response = $this->reportRepository->getSaleReportByTableByDate((object)$date);
        $result   = (object) $this->getResultForReport($response);
        $reports  = $result->data;
        $total    = $result->total;

        return view('Backend.report.SaleReportByTable', compact('reports', 'total', 'date'));
    }

    /**
     * @param array $data
     * @return array
     */
    protected function getResultForReport(array $data)
    {
        $tableIds     = [];
        $duplicate    = [];
        $table_count  = [];
        $reports      = [];
        $total_amount = 0;
        foreach ($data as $table_sale_report) {
            $total_amount += $table_sale_report->amount;
            $table_id   = $table_sale_report->table_id;
            $tableIds[] = $table_id;
            $duplicate[$table_sale_report->table_no]   = $table_id;
            $table_count[$table_sale_report->table_no] = 1;

            if (in_array($table_id, $tableIds)) {
                $table_count[$table_sale_report->table_no] += 1;
            }

            $table_sale_report->quantity = $table_count[$table_sale_report->table_no];
            $reports[$table_sale_report->table_no] = $table_sale_report;

            if (in_array($table_id, $duplicate)) {
                $table_sale_report->amount += $reports[$table_sale_report->table_no]->amount;
                unset($reports[$table_id]);
                unset($duplicate[$table_id]);
            }
        }

        $result = [
            'data' => $reports,
            'total' => $total_amount
        ];

        return $result;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getTableSaleReportExport()
    {
        ob_end_clean();
        ob_start();

        $response = $this->reportRepository->getSaleReportByTable();
        $result   = (object) $this->getResultForReport($response);
        $data     = $result->data;

        foreach ($data as $key => $table_sale_report) {
            $items[$key]['Table No']          = $table_sale_report->table_no;
            $items[$key]['Number of Invoice'] = $table_sale_report->quantity;
            $items[$key]['Amount']            = $table_sale_report->amount;
        }

        Excel::create('Sale Report By Table', function($excel)use($data, $items){
            $excel->sheet('Sale Report By Table', function($sheet)use($data, $items){
                $sheet->fromArray($items);
                $total = 0;
                foreach ($data as $value) {
                    $total += $value->amount;
                }

                $sheet->appendRow(array('', 'Grand Total', $total));
                $sheet->row(1, function($row) {
                    $row->setBackground('#f3a42e');
                });
            });
        })->download('xls');

        ob_flush();
        return Redirect();
    }

    /**
     * @param $from
     * @param $to
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getTableSaleReportExportByDate($from, $to)
    {
        ob_end_clean();
        ob_start();

        $date = [
            'from' => $from,
            'to'   => $to
        ];
        
        $response = $this->reportRepository->getSaleReportByTableByDate((object)$date);
        $result   = (object) $this->getResultForReport($response);
        $data     = $result->data;

        foreach ($data as $key => $table_sale_report) {
            $items[$key]['Table No']          = $table_sale_report->table_no;
            $items[$key]['Number of Invoice'] = $table_sale_report->quantity;
            $items[$key]['Amount']            = $table_sale_report->amount;
        }

        Excel::create('Sale Report By Table', function($excel)use($data, $items){
            $excel->sheet('Sale Report By Table', function($sheet)use($data, $items){
                dd(count($items));
                $sheet->limitColumns();
                $sheet->fromArray($items);
                $total = 0;
                foreach ($data as $value) {
                    $total += $value->amount;
                }

                $sheet->appendRow(array('', 'Grand Total', $total));
                $sheet->row(1, function($row) {
                    $row->setBackground('#f3a42e');
                });
            });
        })->download('xls');

        ob_flush();
        return Redirect();
    }
}