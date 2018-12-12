<?php 
namespace App\RMS\Report;

/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/18/2016
 * Time: 9:35 AM
 */
interface ReportRepositoryInterface
{

    public function getStartDate();
    public function getEndDate();
    // public function getCategory();
    public function getItemReport($start, $end);
    public function getExcel($start, $end);
    public function getItemReportWithDate($start_date,$end_date,$number,$from_amount,$to_amount);
    public function getset($start,$end);
    public function fav_set_date_report($start_date, $end_date, $number);
    public function getExcelWithDateAndNumber($start_date, $end_date,$number);
    public function getExcelWithDateAndAmount($start_date,$end_date,$from_amount,$to_amount);
    public function getExcelWithDate($start_date, $end_date,$number,$from_amount,$to_amount);
    public function getExcelWithDateWithNull($start_date,$end_date);
    public function fav_set_date_report_with_null($start_date, $end_date);

    //Favourite Food
    public function getMemberFavouriteFood($type);
    public function getCategories();
    public function getMemberTypes();
    public function getMemberFavouriteFoodWithJoin($typeId);

    /**
     * Get category_sale_report
     *
     * @return mixed
     */
    public function getCategorySaleReport();

    /**
     * @param $limit
     * @param $offset
     * @return mixed
     */
    public function getCategorySaleReportByParams($limit, $offset);

    /**
     * Get category by parent_id
     *
     * @param $parent_id
     * @return mixed
     */
    public function getParentCategory($parent_id);

    /**
     * @param $params
     * @return mixed
     */
    public function getCategorySaleReportByDate($params);

    public function getCategorySaleReportCount();

   
    
    
   
    
    // public function getBestSellingItem($value,$start_date,$end_date);
    // public function getBestSellingItemWithDate($value, $start_date, $end_date);
   
}