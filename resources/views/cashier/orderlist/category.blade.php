@if(count($categories) > 0)
    @foreach($categories as $category)
        <div class="cat-box"> 
            <button onclick="getCategories({{ $category->id }})">
                <figure>  
                    <img src="/uploads/{{ $category->image }}" class="img-responsive">
                    <figcaption>{{ $category->name }}</figcaption>
                </figure>
            </button>
        </div>
    @endforeach
@else
    @foreach($itemArr as $item)
        <div class="cat-box"> 
            <button onclick="orderItem({{ $item['id'] }})">
                <figure>  
                    <img src="/uploads/{{ $item['image'] }}" class="img-responsive">
                    <figcaption>{{ $item['name'] }}</figcaption>
                </figure>
            </button>
        </div>
    @endforeach
@endif

 <input type="hidden" name="shift_id" id="shift_id" value="{{$shift_id}}">
