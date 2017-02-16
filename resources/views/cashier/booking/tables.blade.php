@foreach($tables as $table)
    <div class="col-md-3">
        <div class="info-box">
            @if($table->status == 1)
                <span class="info-box-icon bg-lred" data-toggle="modal" data-target="#{{$table->id}}modal">
                    <a href="#"><i class="ion ion-fork"></i><i class="ion ion-knife"></i></a>
                </span>
            @elseif(in_array($table->id,$warning))
                <span class="info-box-icon bg-yellow">
                    <i class="ion ion-fork"></i><i class="ion ion-knife"></i>
                </span>
            @elseif(in_array($table->id,$waiting))
                <span class="info-box-icon bg-pink">
                    <i class="ion ion-fork"></i><i class="ion ion-knife"></i>
                </span>
            @else
                <span class="info-box-icon bg-lgreen" data-toggle="modal" data-target="#{{$table->id}}modal">
                    <a href="#"><i class="ion ion-fork"></i><i class="ion ion-knife"></i></a>
                </span>
            @endif
            <div class="info-box-content">
                <span class="info-box-text"><b>Table Name: </b></span>{{$table->table_no}}
                <span class="info-box-text"><b>Capacity:</b></span>{{$table->capacity}}
            </div>
        </div>
    </div>
@endforeach