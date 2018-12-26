<?php

namespace App\Http\Controllers\Backend\Restaurant;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Status\StatusConstance;
use App\Session;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;
use InterventionImage;
use App\RMS\Utility;
use App\RMS\Restaurant\RestaurantRepository;
use App\RMS\Branch\BranchRepository;
use App\RMS\Restaurant\RestaurantRepositoryInterface;
use App\RMS\Infrastructure\Forms\RestaurantEntryRequest;
use App\RMS\Infrastructure\Forms\RestaurantEditRequest;

use  App\RMS\Restaurant\Restaurant;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $restaurantRepo;
    public function __construct(RestaurantRepositoryInterface $restaurantRepo)
    {
        $this->restaurantRepo = $restaurantRepo;
      
    }

    public function index()
    {
        $restaurant         = $this->restaurantRepo->getAllType();
       return view('Backend.restaurant.restaurant_listing')->with('restaurants',$restaurant);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Backend.restaurant.restaurant');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RestaurantEntryRequest $request)
    {
        try{
            // dd($request->all());
            $request->validate();
            $name               =  $request->get('name');
            // $mobile_image       =  $request->get('mobile_image');
            // $image              =  $request->get('image');
            $website            =  $request->get('website');
            $email              =  $request->get('email');
            $phone              =  $request->get('phone');
            $address            =  $request->get('address');
            $file               = $request->file('fileupload');
            $imagedata          = file_get_contents($file);
            $photo              = uniqid().'.'.$file->getClientOriginalExtension();
            $file->move('uploads', $photo);
            // resizing image
            $image             = InterventionImage::make(sprintf('uploads' .'/%s', $photo))->resize(200, 200)->save();

            $mobile_file        = $request->file('fileupload_mobile');
            $imagedata          = file_get_contents($mobile_file);
            $mobile_photo       = uniqid().'.'.$mobile_file->getClientOriginalExtension();
            $mobile_file->move('uploads', $mobile_photo);
            $mobile_image       = InterventionImage::make(sprintf('uploads' .'/%s', $mobile_photo))->resize(200, 200)->save();
            $description        = $request->get('description');

            $paramObj                       = new Restaurant();
            $paramObj->name                 = $name;
            $paramObj->logo                 = $photo;
            $paramObj->mobile_logo          = $mobile_photo;
            $paramObj->phone_no             = $phone;
            $paramObj->email                = $email;
            $paramObj->address              = $address;
            $paramObj->website              = $website;
            $paramObj->status               = StatusConstance::RESTAURANT_AVAILABLE_STATUS;
            $paramObj->description          = $description;
            $result                         = $this->restaurantRepo->store($paramObj);
            if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
             return redirect()->action('Backend\Restaurant\RestaurantController@index')
                 ->withMessage(FormatGenerator::message('Success', 'Restaurant created ...'));
         }
         else{
             return redirect()->action('Backend\Restaurant\RestaurantController@index')
                 ->withMessage(FormatGenerator::message('Fail', 'Restaurant did not create ...'));
         }

        }catch(\Exception $e){
          
            return redirect()->action('Backend\Restaurant\RestaurantController@index')
                 ->withMessage(FormatGenerator::message('Fail', 'Restaurant did not create ...'));

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $restaurant  = Restaurant::find($id);
        return view('Backend.restaurant.restaurant')->with('editrestaurant',$restaurant);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RestaurantEditRequest $request)
    {
           try{
            $request->validate();
            // dd($request->all());
            $id                 = Input::get('id');
            $name               =  $request->get('name');            
            $website            =  $request->get('website');
            $email              =  $request->get('email');
            $phone              =  $request->get('phone');
            $address            =  $request->get('address');

            $file               = $request->file('fileupload');
            // dd($file);
            if($file != null){
                $imagedata          = file_get_contents($file);
                $photo              = uniqid().'.'.$file->getClientOriginalExtension();
                $file->move('uploads', $photo);
                // resizing image
                $image             = InterventionImage::make(sprintf('uploads' .'/%s', $photo))->resize(200, 200)->save();
            }
            else{
                $photo             = $request->get('image');
            }

           

            $mobile_file        = $request->file('fileupload_mobile');
            if($mobile_file != null){
                $imagedata          = file_get_contents($mobile_file);
                $mobile_photo       = uniqid().'.'.$mobile_file->getClientOriginalExtension();
                $mobile_file->move('uploads', $mobile_photo);
                $mobile_image       = InterventionImage::make(sprintf('uploads' .'/%s', $mobile_photo))->resize(200, 200)->save();
            }
            else{
                $mobile_photo       = $request->get('mobile_image');
            }
           
            $description        = $request->get('description');

            $paramObj                       = Restaurant::find($id);
            $paramObj->name                 = $name;
            $paramObj->logo                 = $photo;
            $paramObj->mobile_logo          = $mobile_photo;
            $paramObj->phone_no             = $phone;
            $paramObj->email                = $email;
            $paramObj->address              = $address;
            $paramObj->website              = $website;
            $paramObj->status               = StatusConstance::RESTAURANT_AVAILABLE_STATUS;
            $paramObj->description          = $description;
            $result                         = $this->restaurantRepo->update($paramObj);
            if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
             return redirect()->action('Backend\Restaurant\RestaurantController@index')
                 ->withMessage(FormatGenerator::message('Success', 'Restaurant updated ...'));
         }
         else{
             return redirect()->action('Backend\Restaurant\RestaurantController@index')
                 ->withMessage(FormatGenerator::message('Fail', 'Restaurant did not update ...'));
         }
           }catch(\Expection $e){
            
            return redirect()->action('Backend\Restaurant\RestaurantController@index')
                 ->withMessage(FormatGenerator::message('Fail', 'Restaurant did not update ...'));

           }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $new_string = explode(',',$id);
        foreach($new_string as $id)
        {
            $this ->restaurantRepo->delete($id);
        }
        return redirect()->action('Backend\Restaurant\RestaurantController@index')->withMessage(FormatGenerator::message('Success', 'Restaurant deleted ...'));
    }
}
