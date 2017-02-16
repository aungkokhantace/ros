<?php 
namespace App\RMS\SaleSummary;

/**
 * Created by PhpStorm.
 * User: Soe Thandar Aung
 * Date: 10/25/2016
 * Time: 11:36 AM
 */
interface SaleSummaryRepositoryInterface
{
    public function saleSummary(); 
    public function sale($year,$month);  
    public function dailySale($d,$m);
    public function searchDailySummary($from_date,$to_date);
    public function MonthlySaleSummary();
    public function searchMonthlySummary($from_date,$to_date);
    public function YearlySaleSummary();
    public function yearlysale($year);
}
