<?php

namespace App\Http\Controllers\Cashier\Member;

use App\RMS\Category\Category;
use App\RMS\Infrastructure\Forms\MemberRegistrationFormRequest;
use App\RMS\Infrastructure\Forms\MemberUpdateFormRequest;
use App\RMS\Member\MemberRepositoryInterface;
use App\RMS\Member\Member;
use App\RMS\MemberType\MemberType;
use App\RMS\Favourite\Favourite;
use App\RMS\Item\Item;
use Auth;
use Carbon\Carbon;
use Session;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;

class MemberController extends Controller
{
    private $MemberRepository;

    public function __construct(MemberRepositoryInterface $MemberRepository){
        $this->MemberRepository = $MemberRepository;
    }

    public function index(){
        $joinType = $this->MemberRepository->getMemberModel();
        $Item     = $this->MemberRepository->getAllItem();
        
        return view('cashier.member.MemberListing', compact('joinType', 'Item'));
    }

    public function create(){
         $member_type = $this->MemberRepository->getAllMemberType();
         $categories  = $this->MemberRepository->getCategories();
         $items       = $this->MemberRepository->getItems();
         return view('cashier.member.NewMember', compact('member_type', 'categories', 'items'));
    }

    public function store(MemberRegistrationFormRequest $request){
        $request->validate();
        $name                     = Input::get('name');
        $phone                    = Input::get('phone');
        $email                    = Input::get('email');
        $birthday                 = Carbon::parse(Input::get('birthday'))->format('Y-m-d');
        $fav                      = Input::get('food');
        $member_type              = Input::get('member_type');
        $today                    = Carbon::now();
        $join_date                = Carbon::parse($today)->format('Y-m-d');
        $member_card_no           = Input::get('member_card_no');

        $paramObj                 = new Member();
        $paramObj->name           = $name;
        $paramObj->phone          = $phone;
        $paramObj->email          = $email;
        $paramObj->birthdate      = $birthday;
        $paramObj->member_type_id = $member_type;
        $paramObj->join_date      = $join_date;
        $paramObj->member_card_no = $member_card_no;
        $result = $this->MemberRepository->store($paramObj, $fav);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Cashier\Member\MemberController@index')
                ->withMessage(FormatGenerator::message('Success', 'Member created ...'));
        }
        else{
            return redirect()->action('Cashier\Member\MemberController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Member did not create ...'));
        }

    }

    public function delete($id)
    {
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->MemberRepository->delete($id);
        }
        return redirect()->action('Cashier\Member\MemberController@index'); //to redirect listing page
    }

    public function edit($id){
        $member_type    = $this->MemberRepository->getAllMemberType();
        $Item           = $this->MemberRepository->getAllItem();
        $categories     = $this->MemberRepository->getCategories();
        $items          = $this->MemberRepository->getItems();
        $favourite      = Favourite::where('member_id', $id)->lists('item_id')->toArray();
        $member         = $this->MemberRepository->getMemberModelById($id);
        return view('cashier.member.NewMember')->with('member_type', $member_type)->with('categories', $categories)->with('items', $items)
                    ->with('member', $member)->with('Item', $Item)->with('favourite', $favourite);
    }

    public function update(MemberUpdateFormRequest $request){
        $request->validate();
        $id             = Input::get('id');
        $name           = Input::get('name');
        $phone          = Input::get('phone');
        $email          = Input::get('email');
        $birthday       = Carbon::parse(Input::get('birthday'))->format('Y-m-d');
        $fav            = $request->food;
        $member_type    = Input::get('member_type');
        $member_card_no = Input::get('member_card_no');
        $member         = $this->MemberRepository->getMemberModelById($id);
        $oldmail        = ($member->email);
        $allmember      = $this->MemberRepository->getMemberModel();
        $flag           = 0;
        if($email == $oldmail ){
            $flag = 0;
        }
        else{
            foreach($allmember as $member){
                if($email == $member->email){
                    $flag = 1;
                }
            }
        }
        if($flag == 0){
            $paramObj                   = Member::find($id);
            $paramObj->name             = $name;
            $paramObj->phone            = $phone;
            $paramObj->email            = $email;
            $paramObj->birthdate        = $birthday;
            $paramObj->member_type_id   = $member_type;
            $paramObj->member_card_no   = $member_card_no;

            $result = $this->MemberRepository->update($paramObj, $fav);

            if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                return redirect()->action('Cashier\Member\MemberController@index')
                    ->withMessage(FormatGenerator::message('Success', 'Member updated ...'));
            }
            else{
                return redirect()->action('Cashier\Member\MemberController@index')
                    ->withMessage(FormatGenerator::message('Fail', 'Member did not update ...'));
            }

        }
        elseif($flag == 1){
            alert()->error('Email is already exists!')->persistent('Close');
            return redirect()->action('Cashier\Member\MemberController@index');
        }
    }
}
