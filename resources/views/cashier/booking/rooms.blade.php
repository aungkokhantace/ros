@foreach($rooms as $room)
    <div class="col-md-3">
        <div class="info-box">
            @if($room->status == 1)
                <span class="info-box-icon bg-lred">
                    <i class="ion ion-fork"></i><i class="ion ion-knife"></i>
                </span>
            @elseif(in_array($room->id,$warning))
                <span class="info-box-icon bg-yellow">
                    <i class="ion ion-fork"></i><i class="ion ion-knife"></i>
                </span>
            @elseif(in_array($room->id,$waiting))
                <span class="info-box-icon bg-pink">
                    <i class="ion ion-fork"></i><i class="ion ion-knife"></i>
                </span>
            @else
                <span class="info-box-icon bg-lgreen">
                    <i class="ion ion-fork"></i><i class="ion ion-knife"></i>
                </span>
            @endif
            <div class="info-box-content">
                <span class="info-box-text"><b>Room Name: </b></span>{{$room->room_name}}
                <span class="info-box-text"><b>Capacity:</b></span>{{$room->capacity}}
            </div>
        </div>
    </div>
@endforeach