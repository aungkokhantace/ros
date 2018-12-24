@if(count($setmenu) > 0)
    @foreach($setmenu as $set)
        <div class="cat-box"> 
            <button onclick="orderSetMenu({{ $set->id }})">
                <figure>  
                    <img src="/uploads/{{ $set->image }}" class="img-responsive">
                    <figcaption>{{ $set->set_menus_name }}</figcaption>
                </figure>
            </button>
        </div>
    @endforeach
@endif
 <input type="hidden" name="shift_id" id="shift_id" value="{{$shift_id}}">