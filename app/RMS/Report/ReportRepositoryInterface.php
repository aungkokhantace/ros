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

    //------------------ For Category Sale Report ----------------------//

    /**
     * Get a list of category sale report.
     *
     * @return mixed
     */
    public function getCategorySaleReport();

    /**
     * Get a list of category sale report by params.
     *
     * @param $limit
     * @param $offset
     * @return mixed
     */
    public function getCategorySaleReportByParams($limit, $offset);

    /**
     * Get a category by parent_id
     *
     * @param $parent_id
     * @return mixed
     */
    public function getParentCategory($parent_id);

    /**
     * Get a list of category sale report by date.
     *
     * @param $params
     * @return mixed
     */
    public function getCategorySaleReportByDate($params);

    /**
     * Get a total count of category sale report.
     *
     * @return mixed
     */
    public function getCategorySaleReportCount();

    //----------------------------- End --------------------------------//


    //------------------ For Sale Report By Table ----------------------//

    /**
     * Get a list of Sale Report By Table.
     *
     * @return mixed
     */
    public function getSaleReportByTable();

    /**
     * Get a list of Sale Report By Table by Date.
     *
     * @param $date
     * @return mixed
     */
    public function getSaleReportByTableByDate($date);

    //----------------------------- End --------------------------------//

    // public function getBestSellingItem($value,$start_date,$end_date);
    // public function getBestSellingItemWithDate($value, $start_date, $end_date);
   
}