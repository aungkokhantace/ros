<?php

namespace App\Http\Controllers\Backend\Config;

use App\RMS\Config\Config;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\RMS\Infrastructure\Forms\RestaurantProfilesRequest;
use App\RMS\Profile\ProfileRepositoryInterface;
use App\RMS\Profile\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;

class ProfileController extends Controller
{
    private $ProfileRepository;
    public function __construct(ProfileRepositoryInterface $ProfileRepository){
        $this->ProfileRepository = $ProfileRepository;
    }

    public function index(){
        $profiles = Profile::all();
        return view('cashier.profile.profile')->with('profiles',$profiles);
    }

    public function save(RestaurantProfilesRequest $request){
        $request->validate();
        $name           = $request->get('restaurant_name');
        $image          = $request->file('logo');
        $imageName      = $image->getClientOriginalName();
        $destination    = 'uploads';
        $image->move($destination, $imageName);
        //Image
        $website        = Input::get('website');
        $email          = Input::get('email');
        $phone          = Input::get('phone');
        $address        = Input::get('address');
        $message        = Input::get('message');
        $remark         = Input::get('remark');
        $this->ProfileRepository->save($name,$imageName,$website,$email,$phone,$address,$message,$remark);
        return redirect()->action('Cashier\Config\ProfileController@index');
    }

    public function profile()
    {
        $profile=$this->ProfileRepository->getAllProfile();
      
        if($profile == null){
            return view('cashier.profile.profile')->with('profile',$profile);
        }
        else if(($profile->tax != 0.0 || $profile->service != 0.0 || $profile->room_charge != 0 ||$profile->booking_warning_time != "00:00:00" || $profile->booking_waiting_time != "00:00:00" || $profile->booking_service_time != "00:00:00" || $profile->message != "" || $profile->remark != "") && ($profile->restaurant_name == "" && $profile->logo == "" && $profile->mobile_logo == "" && $profile->website == "" && $profile->phone == "" && $profile->address == "")){
            return view('cashier.profile.profile')->with('record',$profile);
        }
        else{
            return view('Backend.profile.profile')->with('profile',$profile);
        }
    }

    public function store(RestaurantProfilesRequest $request){
        $request->validate();
        $name                           = $request->get('name');
        $logo                           = $request->file('fileupload');
        $mobile_logo                    = $request->file('mobile_fileupload');
        $website                        = $request->get('website');
        $email                          = $request->get('email');
        $phone                          = $request->get('phone');
        $address                        = $request->get('address');
        $paramObj                       = new Config();
        $paramObj->restaurant_name      = $name;
        $paramObj->email                = $email;
        $paramObj->website              = $website;
        $paramObj->phone                = $phone;
        $paramObj->address              = $address;
        if(isset($logo) && isset($mobile_logo)){
            $imageName                  = $logo->getClientOriginalName();
            $destination                = 'uploads';
            $logo->move($destination, $imageName);
            $imagedata                  = file_get_contents($mobile_logo);
            $mobile_image               = base64_encode($imagedata);
            $mobile_imageName           = $mobile_logo->getClientOriginalName();
            $destination                = 'uploads';
            $mobile_logo->move($destination, $mobile_imageName);
            $paramObj->logo             = $imageName;
            $paramObj->mobile_logo      = $mobile_imageName;
            $paramObj->mobile_image     = $mobile_image;
            $this->ProfileRepository->saveall($paramObj);
            return redirect()->action('Backend\ProfileController@profile');
        }
        elseif(isset($logo) && !isset($mobile_logo)){
            $imageName                  = $logo->getClientOriginalName();
            $destination                = 'uploads';
            $logo->move($destination, $imageName);
            $paramObj->logo             = $imageName;
            $this->ProfileRepository->savelogo($paramObj);
            return redirect()->action('Backend\ProfileController@profile');
        }
        elseif(isset($mobile_logo) && !isset($logo)){
            $imagedata                  = file_get_contents($mobile_logo);
            $mobile_image               = base64_encode($imagedata);
            $mobile_imageName           = $mobile_logo->getClientOriginalName();
            $destination                = 'uploads';
            $mobile_logo->move($destination, $mobile_imageName);
            $paramObj->mobile_logo      = $mobile_imageName;
            $paramObj->mobile_image     = $mobile_image;
            $this->ProfileRepository->savemobilelogo($paramObj);
            return redirect()->action('Backend\Config\ProfileController@profile');
        }
        else{
            $this->ProfileRepository->save($paramObj);
            return redirect()->action('Backend\Config\ProfileController@profile');
        }
    }

    public function update(RestaurantProfilesRequest $request){
        $request->validate();
        $id                             = $request->get('id');
        $name                           = $request->get('name');
        $logo                           = $request->file('fileupload');
        $mobile_logo                    = $request->file('mobile_fileupload');
        $website                        = $request->get('website');
        $email                          = $request->get('email');
        $phone                          = $request->get('phone');
        $address                        = $request->get('address');
        $paramObj                       = Config::find($id);
        $paramObj->restaurant_name      = $name;
        $paramObj->email                = $email;
        $paramObj->website              = $website;
        $paramObj->phone                = $phone;
        $paramObj->address              = $address;
        if(($logo != null) && ($mobile_logo != null)){
            $imageName                  = $logo->getClientOriginalName();
            $destination                = 'uploads';
            $logo->move($destination, $imageName);
            $imagedata                  = file_get_contents($mobile_logo);
            $mobile_image               = base64_encode($imagedata);
            $mobile_imageName           = $mobile_logo->getClientOriginalName();
            $destination                = 'uploads';
            $mobile_logo->move($destination, $mobile_imageName);
            $paramObj->logo             = $imageName;
            $paramObj->mobile_logo      = $mobile_imageName;
            $paramObj->mobile_image     = $mobile_image;
            $this->ProfileRepository->updateAll($paramObj);
            return redirect()->action('Backend\Config\ProfileController@profile');
        }
        elseif(($logo != null) && ($mobile_logo == null)){
            $imageName                  = $logo->getClientOriginalName();
            $destination                = 'uploads';
            $logo->move($destination, $imageName);
            $paramObj->logo             = $imageName;
            $this->ProfileRepository->updatelogo($paramObj);
            return redirect()->action('Backend\Config\ProfileController@profile');
        }
        elseif(($logo == null) && ($mobile_logo != null)){
            $imagedata                  = file_get_contents($mobile_logo);
            $mobile_image               = base64_encode($imagedata);
            $mobile_imageName           = $mobile_logo->getClientOriginalName();
            $destination                = 'uploads';
            $mobile_logo->move($destination, $mobile_imageName);
            $paramObj->mobile_logo      = $mobile_imageName;
            $paramObj->mobile_image     = $mobile_image;
            $this->ProfileRepository->updatemobilelogo($paramObj);
            return redirect()->action('Backend\Config\ProfileController@profile');
        }
        else{
            $this->ProfileRepository->update($paramObj);
            return redirect()->action('Backend\Config\ProfileController@profile');
        }
    }

}
