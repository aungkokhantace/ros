<?php 
namespace App\RMS\CategorySaleSummary;

/**
 * Created by PhpStorm.
 * User: Soe Thandar Aung
 * Date: 10/25/2016
 * Time: 11:36 AM
 */
interface CategorySaleSummaryRepositoryInterface
{
    public function getStartDate();
    public function getEndDate();
    public function getChildCategory();
    public function DailyDetailReport();
    public function MonthlyDetailReport();
    public function YearlyDetailReport();
    public function getDetailReportWithDate($start_date, $end_date,$child);
    public function saleSummaryDailyDetailExportWithDate($start_date, $end_date,$child);
    public function saleSummaryMonthlyDetailExport($start, $end);
    public function getYearlyDetailReportWithDate($year,$child);
    public function getMonthlyDetailReportWithDate($from_date,$to_date,$child);
    public function saleSummaryDailyDetailExport($start, $end);
    public function saleSummaryMonthlyDetailExportWithDate($from_date, $to_date,$child);
    public function saleSummaryYearlyDetailExportWithDate($year,$child);
}