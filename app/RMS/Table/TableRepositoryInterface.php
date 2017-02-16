<?php


namespace App\RMS\Table;

interface TableRepositoryInterface
{
    public function getAllTable();
    public function All();
    //public function table_insert($name,$capacity,$location,$area);
    public function store($paramObj);
    public function table_edit($id);
    public function update($paramObj);
    public function table_delete($id);
    public function saveBooking($paramObj,$table_id);
    public function saveBookingWithRoom($paramObj,$room_id);
    public function getTodayBooking($cur_date);
    // public function getBooking($cur_date);
    public function getBookings($cur_date);
    public function getBookinglist($cur_date);
    public function bookingDelete($id);
    public function bookingUpdate($paramObj,$btable);
    public function bookingUpdateWithRoom($paramObj,$broom);
    public function get_locations();
}