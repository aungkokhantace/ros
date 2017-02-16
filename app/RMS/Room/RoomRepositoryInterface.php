<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/6/2016
 * Time: 10:57 AM
 */

namespace App\RMS\Room;


interface RoomRepositoryInterface
{
    public function store($paramObj);
    public function getRooms();
    public function getRoomById($id);
    public function update($paramObj);
    public function deleteRoomData($room_id);
}