<?php

namespace App\Http\Controllers\Cashier\Item;

use App\RMS\Item\ItemRepositoryInterface;
use Illuminate\Http\Request;
use App\RMS\Item\Item;
use App\RMS\Utility;
use App\RMS\Item\Continent;
use Auth;
use App\RMS\Category\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use InterventionImage;
use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;

class ItemController extends Controller
{
    private $ItemRepository;
    public function __construct(ItemRepositoryInterface $ItemRepository)
    {
       $this->ItemRepository = $ItemRepository;
    }
    //Item Listing Page
    public function index()
    {
       $items   = Item::all();
       $cat     = $this->ItemRepository->allCat();
       return view('cashier.item.ItemListing')->with('items', $items)->with('cat', $cat);
    }
}
