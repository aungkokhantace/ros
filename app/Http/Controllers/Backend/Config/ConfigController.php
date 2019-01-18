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
use Validator;
use App\RMS\CoreSetting\CoreSetting;

class ConfigController extends Controller
{
    private $ConfigRepository;
    public function __construct(ConfigRepositoryInterface $ConfigRepository)
    {
        $this->ConfigRepository = $ConfigRepository;
    }

    public function general_config()
    {
        $core_setting = new CoreSetting();
        $voucher = $core_setting->select('value')->where('code', '=', 'VOUCHER')->first();
        $prefix  = $core_setting->select('value')->where('code', '=', 'VOUCHER_PREFIX')->first();

        $config=$this->ConfigRepository->getAllConfig();
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
            return view('Backend.config.config')->with('config',$config)
              ->with('warning_time',$warning_time)->with('waiting_time',$waiting_time)
              ->with('service_time',$service_time)->with('voucher', $voucher)->with('prefix', $prefix);
        }
    }

    public function store(GeneralConfigRequest $request){

        $request->validate();
        $tax                            = $request->get('tax');
        $service                        = $request->get('service');
        $room                           = $request->get('room_charge');
        $before                         = $request->get('before');
        $before_time                    = gmdate("H:i:s", $before);
        $after                          = $request->get('after');
        $after_time                     = gmdate("H:i:s", $after);
        $service_t                      = $request->get('service_time');
        $service_time                   = gmdate("H:i:s", $service_t);
        // $message                        = $request->get('message');
        // $remark                         = $request->get('remark');
        $message                        = 'Message';
        $remark                         = 'Remark';

        $backup_url                     = $request->get('backup_url');
        $backup_frequency               = $request->get('backup_frequency');
        $db_name                        = $request->get('db_name');

        $paramObj                       = new Config();
        $paramObj->tax                  = $tax;
        $paramObj->service              = $service;
        $paramObj->room_charge          = $room;
        // $paramObj->booking_warning_time = $before_time;
        // $paramObj->booking_waiting_time = $after_time;
        // $paramObj->booking_service_time = $service_time;
        $paramObj->message              = $message;
        $paramObj->remark               = $remark;
        $paramObj->backup_url           = $backup_url;
        $paramObj->backup_frequency     = $backup_frequency;
        $paramObj->db_name              = $db_name;
        $this->ConfigRepository->insert_config($paramObj);
        return redirect()->action('Cashier\Config\ConfigController@general_config');
    }

    public function update(GeneralConfigRequest $request)
    {
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
        $remark                         = $request->get('remark');
        $backup_url                     = $request->get('backup_url');
        $backup_frequency               = $request->get('backup_frequency');
        $db_name                        = $request->get('db_name');
        $paramObj                       = Config::find($id);
        $paramObj->tax                  = $tax;
        $paramObj->service              = $service;
        $paramObj->room_charge          = $room;
        $paramObj->booking_warning_time = $before_time;
        $paramObj->booking_waiting_time = $after_time;
        $paramObj->booking_service_time = $service_time;
        $paramObj->message              = $message;
        $paramObj->remark               = $remark;
        $paramObj->backup_url           = $backup_url;
        $paramObj->backup_frequency     = $backup_frequency;
        $paramObj->db_name              = $db_name;
        $this->ConfigRepository->update_config($paramObj);

        $core_setting = new CoreSetting();

        if (!empty($request->voucher)) {
          $core_setting->where('code', '=', 'VOUCHER')
            ->update(['value' => $request->voucher]);
        }

        if (!empty($request->prefix)) {
          $core_setting->where('code', '=', 'VOUCHER_PREFIX')
            ->update(['value' => $request->prefix]);
        }

        return redirect()->action('Backend\Config\ConfigController@general_config');
    }

    public function delete($id){
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            DB::table('config')->where('id', $id)->delete();
        }
        return redirect()->action('Backend\Config\ConfigController@config_listing'); //to redirect listing page
    }
}
