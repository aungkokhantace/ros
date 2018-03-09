<?php
namespace App\Http\Controllers\Backend\Report;
use App\RMS\Category\Category;
use App\RMS\Favourite\Favourite;
use App\RMS\Item\Item;
use App\RMS\Member\Member;
use App\RMS\MemberType\MemberType;
use App\RMS\Report\ReportRepositoryInterface;
use Illuminate\Http\Request;
use Excel;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class FavouriteFoodReportController extends Controller
{
    private $favreportRepository;
    public function __construct(ReportRepositoryInterface $favreportRepository)
    {
        $this->favreportRepository = $favreportRepository;
    }
    public function favReportView($type)
    {
        $favourites     = $this->favreportRepository->getMemberFavouriteFood($type);
        $categories     = $this->favreportRepository->getCategories();
        $memberTypes    = $this->favreportRepository->getMemberTypes();

        return view('Backend.report.FavouriteFood')->with('favourites',$favourites)->with('categories',$categories)->with('memberTypes',$memberTypes);
    }

    public function filterByMemberType($type){
        $favourites     = $this->favreportRepository->getMemberFavouriteFood($type);
        $categories     = $this->favreportRepository->getCategories();
        $memberTypes    = $this->favreportRepository->getMemberTypes();
        return view('Backend.report.FavouriteFood',compact('favourites','categories','memberTypes','type'));
    }
    public function downloadExcelWithID($typeId){
        ob_end_clean();     // ob = output buffer
        ob_start();         // At the very top of your program (first line)
        $data = $this->favreportRepository->getMemberFavouriteFoodWithJoin($typeId);
        return Excel::create('FavouriteFoodReport', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download('xls');
        ob_flush();
    }
}
