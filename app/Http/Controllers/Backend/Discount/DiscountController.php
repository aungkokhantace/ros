<?php

namespace App\Http\Controllers\Backend\Discount;

use App\RMS\Discount\DiscountModel;
use App\RMS\Discount\DiscountRepository;
use App\RMS\Discount\DiscountRepositoryInterface;
use App\RMS\Item\ItemRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use App\RMS\Infrastructure\Forms\EditDiscountRequest;
use App\RMS\Infrastructure\Forms\InsertDiscountRequest;
use App\RMS\Item\Item;

use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;
use App\RMS\Utility;
use App\RMS\Restaurant\RestaurantRepository;
use App\RMS\Branch\BranchRepository;


class DiscountController extends Controller
{
    private $DiscountRepository;

    public function __construct(DiscountRepositoryInterface $DiscountRepository)
    {
        $this->DiscountRepository = $DiscountRepository;
        $this->restaurantRepo     = new RestaurantRepository();
        $this->branchRepo         = new BranchRepository();
        $this->itemRepo           = new ItemRepository();

    }

    public function index()
    {
        $discounts     = DiscountModel::get();
        $items         = DB::table('items')->WhereNull('deleted_at')->get();
        $discounts     = $this->DiscountRepository->getAll();
        return view('Backend.discount.discount_listing', compact('discounts', 'items', 'restaurants', 'branches'));
    }

    public function price($id)
    {
        $prices = DB::table('items')->where('id', $id)->value('price');
        return \Response::json($prices);
    }

    public function create()
    {
        $items       = $this->itemRepo->getItem();
        $branches    = $this->branchRepo->getAllType();
        $restaurants =  $this->restaurantRepo->getAllType();
        $continent   = $this->DiscountRepository->getContinent();
        return view('Backend.discount.discount')
            ->with('continent', $continent)
            ->with('items', $items)
            ->with('branch', $branches)
            ->with('restaurant', $restaurants);
    }

    public function store(InsertDiscountRequest $request)
    {
        $request->validate();
        $branch_id              = Utility::getCurrentBranch() != 0 ? Utility::getCurrentBranch(): Input::get('branch');

        $restaurant_id          = Utility::getCurrentRestaurant() != 0 ? Utility::getCurrentRestaurant() : Input::get('restaurant');

        $name                      = Input::get('name');
        $amount                    = Input::get('amount');
        $type                      = Input::get('choose');
        $product                   = Input::get('product');
        $start_date                = Carbon::parse(Input::get('from_date'))->format('Y-m-d');
        $end_date                  = Carbon::parse(Input::get('to_date'))->format('Y-m-d');
        $paramObj                  = new DiscountModel();
        $paramObj->name            = $name;
        $paramObj->restaurant_id   = $restaurant_id;
        $paramObj->branch_id       = $branch_id;
        $paramObj->amount          = $amount;
        $paramObj->type            = $type;
        $paramObj->start_date      = $start_date;
        $paramObj->end_date        = $end_date;
        $paramObj->item_id         = $product;
        $result                    = $this->DiscountRepository->store($paramObj);


        if ($result['aceplusStatusCode'] == ReturnMessage::OK) {
            return redirect()->action('Backend\Discount\DiscountController@index')
                ->withMessage(FormatGenerator::message('Success', 'Discount created ...'));
        } else {
            return redirect()->action('Backend\Discount\DiscountController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Discount did not create ...'));
        }

    }

    public function edit($id)
    {
        $resource      = DiscountModel::find($id);
        $discount_edit = $this->DiscountRepository->discount_edit($id);
        $items         = DB::table('items')->get();
        $restaurant    = DB::table('restaurant')->get();
        $branch        = DB::table('branch')->get();
        $continent     = $this->DiscountRepository->getContinent();
        return view('Backend.discount.discount', compact('resource', 'discount_edit', 'items', 'restaurant', 'branch', 'continent'));
    }

    public function delete($id)
    {
        $new_string = explode(',', $id);
        foreach ($new_string as $id) {
            $this->DiscountRepository->discount_delete($id);
        }
        return redirect()->action('Backend\Discount\DiscountController@index')->withMessage(FormatGenerator::message('Success', 'Discount Deleted ...'));
    }

    public function update(EditDiscountRequest $request)
    {
        $request->validate();
        $id                         = Input::get('id');
        $name                       = Input::get('name');
        $restaurant_id              = Input::get('restaurant');
        $branch_id                  = Input::get('branch');
        $amount                     = Input::get('amount');
        $type                       = Input::get('choose');
        $product                    = Input::get('product');
        $start_date                 = Carbon::parse(Input::get('from_date'))->format('Y-m-d');
        $end_date                   = Carbon::parse(Input::get('to_date'))->format('Y-m-d');
        $paramObj                   = DiscountModel::find($id);
        $paramObj->name             = $name;
        $paramObj->restaurant_id    = $restaurant_id;
        $paramObj->branch_id        = $branch_id;
        $paramObj->amount           = $amount;
        $paramObj->type             = $type;
        $paramObj->start_date       = $start_date;
        $paramObj->end_date         = $end_date;
        $paramObj->item_id          = $product;
        $result                     = $this->DiscountRepository->update($paramObj);

        if ($result['aceplusStatusCode'] == ReturnMessage::OK) {
            return redirect()->action('Backend\Discount\DiscountController@index')
                ->withMessage(FormatGenerator::message('Success', 'Discount updated ...'));
        } else {
            return redirect()->action('Backend\Discount\DiscountController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Discount did not update ...'));
        }

    }
}
