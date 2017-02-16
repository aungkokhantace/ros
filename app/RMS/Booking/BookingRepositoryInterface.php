<?php


namespace App\RMS\Booking;

interface BookingRepositoryInterface
{
  
    public function saveBooking($paramObj,$table_id);
    public function saveBookingWithRoom($paramObj,$room_id);
    public function getTodayBooking($cur_date);
    // public function getBooking($cur_date);
    public function getBookings($cur_date);
    public function getBookinglist();
    public function bookingDelete($id);
    public function bookingUpdate($paramObj,$btable);
    public function bookingUpdateWithRoom($paramObj,$broom);
    public function get_locations();
}