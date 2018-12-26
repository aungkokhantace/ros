<?php

namespace App\Http\Controllers\Backend\Config;

use App\RMS\Config\Config;

use App\RMS\Config\ConfigRepositoryInterface;
use App\RMS\Infrastructure\Forms\GeneralConfigRequest;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\RMS\Utility;
use App\RMS\Restaurant\RestaurantRepository;
use App\RMS\Branch\BranchRepository;

class ConfigController extends Controller
{
    private $ConfigRepository;
    public function __construct(ConfigRepositoryInterface $ConfigRepository)
    {
        $this->ConfigRepository = $ConfigRepository;
        $this->restaurantRepo   = new RestaurantRepository();
        $this->branchRepo       = new BranchRepository();
    }

    public function index()
    {
        $config         = $this->ConfigRepository->getAllConfig();
        // dd($config);
        return view('Backend.config.config_list')->with('configs',$config);
    }

      public function create()
    {
        //dd("create");
        $branch         = $this->branchRepo->getAllType();
        $restaurant     = $this->restaurantRepo->getAllType();
        return view('Backend.config.config')->with('branchs',$branch)->with('restaurants',$restaurant);
    }


    public function general_config()
    {
        $branch         = $this->branchRepo->getAllType();
        $restaurant     = $this->restaurantRepo->getAllType();
        $config=$this->ConfigRepository->getAllConfig();
        // dd($config);

        // dd($config);
        if($config == null){
            return view('Backend.config.config')->with('config',$config);
        }
                else if(($config->tax == 0.0 && $config->service == 0.0 && $config->room_charge == 0 && $config->booking_warning_time == "00:00:00" && $config->booking_waiting_time == "00:00:00" && $config->booking_service_time == "00:00:00" && $config->message == "" && $config->remark == "") && ($config->restaurant_name != "" || $config->logo != "" || $config->mobile_logo != "" || $config->website != "" || $config->phone != "" || $config->address != "")){
                    return view('Backend.config.config')->with('record',$config->id);
                }
                else{
                    $warning_time = strtotime($config->booking_warning_time)-strtotime('Today');
                    $waiting_time = strtotime($config->booking_waiting_time)-strtotime('Today');
                    $service_time = strtotime($config->booking_service_time)-strtotime('Today');
                    return view('Backend.config.config')->with('config',$config)->with('warning_time',$warning_time)->with('waiting_time',$waiting_time)->with('service_time',$service_time)->with('branchs',$branch)->with('restaurants',$restaurant);
                }
    }

    public function store(GeneralConfigRequest $request){
        $request->validate();
        // dd($request->all());

        $tax                            = $request->get('tax');
        $service                        = $request->get('service');
        $room                           = $request->get('room_charge');
        $before                         = $request->get('before');
        $before_time                    = gmdate("H:i:s", $before);       
        $after                          = $request->get('after');
        $after_time                     = gmdate("H:i:s", $after);
        $service_t                      = $request->get('service_time');
        $service_time                   = gmdate("H:i:s", $service_t);
        $message                        = $request->get('message');
        $remark                         = $request->get('remarks');
        $restaurant_id                  = Utility::getCurrentRestaurant() != 0 ? Utility::getCurrentRestaurant(): $request->get('restaurant');

        $paramObj                       = new Config();
        $paramObj->tax                  = $tax;
        $paramObj->site_activation_key  = 'ap1';
        $paramObj->service              = $service;
        $paramObj->room_charge          = $room;
        $paramObj->booking_warning_time = $before_time;
        $paramObj->booking_waiting_time = $after_time;
        $paramObj->booking_service_time = $service_time;
        $paramObj->message              = $message;
        $paramObj->remark               = $remark;
        $paramObj->restaurant_id        = $restaurant_id;

        $this->ConfigRepository->insert_config($paramObj);
        return redirect()->action('Backend\Config\ConfigController@index');

        // return redirect()->action('Cashier\Config\ConfigController@general_config');
    }
     public function edit($id)
    {
        // dd($id);
        $configs        = Config::find($id);       
        $restaurant     = $this->restaurantRepo->getAllType();
        return view('Backend.config.config')->with('config',$configs)->with('restaurants',$restaurant);
       }

    public function update(GeneralConfigRequest $request){
        // dd($request->all());
        $request->validate();
        $id                             = $request->get('id');
        $tax                            = $request->get('tax');
        $service                        = $request->get('service');
        $room                           = $request->get('room_charge');
        $before                         = $request->get('before');
        $before_time                    = gmdate("H:i:s", $before);
        $after                          = $request->get('after');
        $after_time                     = gmdate("H:i:s", $after);
        $service_t                      = $request->get('service_time');
        $service_time                   = gmdate("H:i:s", $service_t);
        $message                        = $request->get('message');
        $remark                         = $request->get('remarks');
        $restaurant_id                  = Utility::getCurrentRestaurant() != 0 ? Utility::getCurrentRestaurant(): $request->get('restaurant');

        $paramObj                       = Config::find($id);
        $paramObj->tax                  = $tax;
        $paramObj->service              = $service;
        $paramObj->room_charge          = $room;
        $paramObj->booking_warning_time = $before_time;
        $paramObj->booking_waiting_time = $after_time;
        $paramObj->booking_service_time = $service_time;
        $paramObj->message              = $message;
        $paramObj->remark               = $remark;
        $paramObj->restaurant_id        = $restaurant_id;
        // dd($paramObj);


        $this->ConfigRepository->update_config($paramObj);
        return redirect()->action('Backend\Config\ConfigController@index');
    }

    public function delete($id){
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            DB::table('config')->where('id', $id)->delete();
        }
        return redirect()->action('Backend\Config\ConfigController@index'); //to redirect listing page
    }
}
