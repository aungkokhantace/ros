<?php


namespace App\Http\Controllers\Cashier\Member;
use App\RMS\Infrastructure\Forms\MemberTypeEditRequest;
use App\RMS\Infrastructure\Forms\MemberTypeRequest;
use App\RMS\MemberType\MemberType;
use App\RMS\MemberType\MemberTypeRepositoryInterface;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Validator;
use Auth;
use Illuminate\Pagination\LengthAwarePaginator;

use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;

class MemberTypeController extends Controller
{
    private $member_type_Repository;
    public function __construct(MemberTypeRepositoryInterface $member_type_Repository){
        $this->member_type_Repository = $member_type_Repository;
    }

    public function index(){
         $member_types              = $this->member_type_Repository->getAllType();
         return view('cashier.member_type.member_type_listing')->with('member_types', $member_types);
    }
    public function create(){
        $member_types               = DB::table('member_type')->get();
        return view('cashier.member_type.member_type')->with('items', $member_types);
    }

    public function store(MemberTypeRequest $request){
        $request->validate();
        $type                           = Input::get('type');
        $description                    = Input::get('description');
        $discount_amount                = Input::get('discount_amount');
        $life_time                      = Input::get('life_time');
        $paramObj                       = new MemberType();
        $paramObj->type                 = $type;
        $paramObj->description          = $description;
        $paramObj->discount_amount      = $discount_amount;
        $paramObj->life_time            = $life_time;
        $result = $this->member_type_Repository->store($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Cashier\Member\MemberTypeController@index')
                ->withMessage(FormatGenerator::message('Success', 'Member Type created ...'));
        }
        else{
            return redirect()->action('Cashier\Member\MemberTypeController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Member Type did not create ...'));
        }

    }
    public function edit($id){
        $resource                       = MemberType::find($id);
        $member_type_edit               = $this->member_type_Repository->member_type_edit($id);
        return view('cashier.member_type.member_type', compact('resource', 'member_type_edit'));
    }

    public function delete($id){
        $new_string                     = explode(',', $id);
        $member                         = $this->member_type_Repository->check_member($id);
        if($member){
            alert()->error('There are members of this type, you must delete them first!')->persistent('Close');
        }
        else{
            foreach ($new_string as $id) {
                $this->member_type_Repository->member_type_delete($id);
            }
        }
        return redirect()->action('Cashier\Member\MemberTypeController@index'); //to redirect listing page
    }

    public function update(MemberTypeEditRequest $request){
        $request->Validate();
        $id                             = Input::get('id');
        $type                           = Input::get('type');
        $lowertype                      = strtolower($type);
        $description                    = Input::get('description');
        $discount_amount                = Input::get('discount_amount');
        $oldtype                        = $this->member_type_Repository->member_type_edit($id);
        $old                            = strtolower($oldtype->type);
        $alltypes                       = $this->member_type_Repository->All();
        $life_time                      = Input::get('life_time');
        $flag = 1;
        if ($lowertype == $old) {
            $flag = 1;
        }
        else{
            foreach ($alltypes as $alltype) {
                $all = strtolower($alltype->type);
                if ($lowertype == $all) {
                    $flag = 0;
                }
            }
        }
        if ($flag == 1) {
            $paramObj                   = MemberType::find($id);
            $paramObj->type             = $type;
            $paramObj->description      = $description;
            $paramObj->discount_amount  = $discount_amount;
            $paramObj->life_time        = $life_time;
            $result = $this->member_type_Repository->update($paramObj);

            if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                return redirect()->action('Cashier\Member\MemberTypeController@index')
                    ->withMessage(FormatGenerator::message('Success', 'Member Type updated ...'));
            }
            else{
                return redirect()->action('Cashier\Member\MemberTypeController@index')
                    ->withMessage(FormatGenerator::message('Fail', 'Member Type did not update ...'));
            }

        }
        elseif($flag == 0)
        {
            alert()->error('This member type is unique.Please Try Again!')->persistent('Close');
            return redirect()->action('Cashier\Member\MemberTypeController@index');
        }
    }

}
