<?php
namespace App\Http\Controllers\Cashier\Category;
use App\RMS\Category\Category;
use App\RMS\Infrastructure\Forms\CreateCategoryRequest;
use App\RMS\Infrastructure\Forms\EditCategoryRequest;
use App\RMS\Kitchen\Kitchen;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\RMS\Category\CategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\LengthAwarePaginator;

use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;
use InterventionImage;
class CategoryController extends Controller
{
    private $CategoryRepository;
    public function __construct(CategoryRepositoryInterface $CategoryRepository){
        $this->CategoryRepository = $CategoryRepository;
    }


    public function index(){
        $title        = 'Category List';
        $categorylist = $this->CategoryRepository->getAllCategory();
    
        return view('cashier.category.category_listing')->with('categorylist',$categorylist)->with('title',$title);
    }

}
