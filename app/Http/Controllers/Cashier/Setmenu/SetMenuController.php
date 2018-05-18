<?php

namespace App\Http\Controllers\Cashier\Setmenu;

use App\RMS\Infrastructure\Forms\SetMenuEditRequest;
use App\RMS\Infrastructure\Forms\SetMenuInsertRequest;
use App\RMS\Item\Item;
use App\RMS\Kitchen\Kitchen;
use App\RMS\SetMenu\SetMenu;
use App\RMS\SetItem\SetItem;
use App\RMS\SetMenu\SetMenuRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;

use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;
use InterventionImage;
class SetMenuController extends Controller
{
    private $setMenuRepository;

    public function __construct(SetMenuRepositoryInterface $setMenuRepository){
        $this->setMenuRepository = $setMenuRepository;
    }

    public function index(){
        $set_menu = SetMenu::all();
        $set_item = $this->setMenuRepository->getSetItem();
        $items    = $this->setMenuRepository->getAllItem();
        return view('cashier.set.set_menus_listing', compact('set_menu', 'set_item', 'items'));
    }
}