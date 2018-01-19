<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\RMS\Config\Config;
use App\RMS\Booking\BookingRepository;
use App\RMS\Booking\Booking;
use App\RMS\BookingTable\BookingTable;
use App\RMS\BookingRoom\BookingRoom;
use App\RMS\Table\Table;
use App\Status\StatusConstance;
use Carbon\Carbon;

class BookingReservation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'BookingReservation:reserve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Booking Reservation';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $booking_setup        = Config::select('booking_warning_time','booking_waiting_time')->first();
        $setup_warning        = $booking_setup->booking_warning_time;
        $setup_waiting        = $booking_setup->booking_waiting_time;
        $cur_date             = date('Y-m-d');
        $bookingRepo          = new BookingRepository();
        $bookings             = $bookingRepo->getTodayBooking($cur_date);
        $table_warning_status = StatusConstance::TABLE_WARNING_STATUS;
        $table_waiting_status = StatusConstance::TABLE_WAITING_STATUS;
        //Warning Status
        $default_status         = StatusConstance::BOOKING_DEFAULT_STATUS;
        $warning_status         = StatusConstance::BOOKING_WARNING_STATUS;
        $waiting_status         = StatusConstance::BOOKING_WAITING_STATUS;
        $done_status            = StatusConstance::BOOKING_DONE_STATUS;
        foreach($bookings as $booking) {
            $cur_date_time      = Carbon::now()->format('Y-m-d H:i:s');
            $from_date          = $booking->booking_date;
            $from_time          = $booking->from_time;
            $to_time            = $booking->to_time;
            $booking_from_date  = Carbon::parse($from_date . " " . $from_time)->format('Y-m-d H:i:s');
            $booking_to_date    = Carbon::parse($from_date . " " . $to_time)->format('Y-m-d H:i:s');

            //Calculate Booking Warning Date Time
            $warning_arr        = explode(':',$setup_warning);
            $booking_warning_time   = date('Y-m-d H:i:s',strtotime('-' . $warning_arr[0] . ' hour -' . $warning_arr[1] . ' minutes -' . $warning_arr[2]. ' seconds',strtotime($booking_from_date)));
            //Calculate Booking Waiting Date Time
            $waiting_arr        = explode(':',$setup_waiting);
            $booking_waiting_time   = date('Y-m-d H:i:s',strtotime('+' . $waiting_arr[0] . ' hour +' . $waiting_arr[1] . ' minutes +' . $waiting_arr[2]. ' seconds',strtotime($from_time)));
            
            //If Current Time is Warning Time Change Table Status
            if ($cur_date_time > $booking_warning_time && $cur_date_time < $booking_from_date) {
                //Check Default Status and Update Warning Status
                $update_status  = Booking::where('id','=',$booking->id)
                                ->where('status','=',$default_status)
                                ->whereNull('deleted_at')
                                ->get();
                if (count($update_status) > 0) {
                    $db_update = DB::table('booking')
                    ->where('id', $booking->id)
                    ->update(['status' => $warning_status]);
                }
            }
        
            //If Current Time is Waiting Time Change Waiting Status
            if ($cur_date_time > $booking_from_date && $cur_date_time < $booking_waiting_time) {
                //Check Default Status and Update Warning Status
                $array          = array($default_status,$warning_status);
                $update_status  = Booking::where('id','=',$booking->id)
                                ->whereIn('status',$array)
                                ->whereNull('deleted_at')
                                ->get();
                if (count($update_status) > 0) {
                    $db_update = DB::table('booking')
                    ->where('id', $booking->id)
                    ->update(['status' => $waiting_status]);
                }
            }

            //If Current Time is Over Waiting Time Change Done Status
            if ($cur_date_time > $booking_waiting_time) {
                $array          = array($default_status,$warning_status,$waiting_status);
                 $update_status  = Booking::where('id','=',$booking->id)
                                ->whereIn('status',$array)
                                ->whereNull('deleted_at')
                                ->get();
                if (count($update_status) > 0) {
                    $db_update = DB::table('booking')
                    ->where('id', $booking->id)
                    ->update(['status' => $done_status]);
                }
            }
        }
    }
}
