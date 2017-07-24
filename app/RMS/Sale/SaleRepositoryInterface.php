<?php 
namespace App\RMS\Sale;

/**
 * Created by PhpStorm.
 * User: Soe Thandar Aung
 * Date: 10/25/2016
 * Time: 11:36 AM
 */
interface SaleRepositoryInterface
{
    public function saleReport(); 
    public function saleExcelReport();
 	public function saleExcelDetailReport($from,$to);
}