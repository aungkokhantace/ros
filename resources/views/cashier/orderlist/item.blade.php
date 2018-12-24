<tr class="item-tr" id="item-tr-{{$itemRepo->uniqid }}">
    <td>
        @if(isset($itemRepo->continent))
        <p data-toggle="modal" data-target="#continent-{{$itemRepo->id . '-' . $itemRepo->uniqid}}" id="continent-{{$itemRepo->uniqid}}">{{ $itemRepo->name }}</p>
        <!-- Modal for Continent -->
        <div class="modal fade" id="continent-{{$itemRepo->id . '-' . $itemRepo->uniqid}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content extra-box">
                    <h3>Continent</h3>    
                    <form>
                        <label>Choose Continent</label>
                        <select style="width: 80%;height: 30px;" id="continent-select-{{$itemRepo->uniqid}}">
                            @foreach($itemRepo->continent as $continent)
                                <option value="{{ $continent['cid'] }}">{{ $continent['cname'] }}</option>
                            @endforeach
                        </select>                                     
                        <div class="modal-footer cashier-footer">
                            <button type="button" data-dismiss="modal" class="ok-btn" onclick="continentOK({{$itemRepo->id . ',"' . $itemRepo->uniqid . '"' }})">OK</button>
                            <button type="reset" class="cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>  
        <!-- end of Modal for Choose Continent -->
        @else 
            <p>{{ $itemRepo->name }}</p>
        @endif
    </td>
    <td class="cart_quantity">
        <div class="qty-box">
            <input type='button' value='-' class='qtyminus' field='quantity' onclick="quantityMinus({{$itemRepo->id . ',"' . $itemRepo->uniqid . '"'}})" />
            <input type='text' name='quantity[]' value='1' class='qty' id="qty-{{$itemRepo->uniqid}}"/>
            <input type='button' value='+' class='qtyplus' field='quantity' onclick="quantityPlus({{$itemRepo->id . ',"' . $itemRepo->uniqid . '"'}})" />
        </div>
    </td>

    
    <td id="price-{{$itemRepo->uniqid}}"> {{ $itemRepo->price }}</td>
    @if ($itemRepo->discount_type == '')
        <td id="discount-{{$itemRepo->uniqid}}">&nbsp;</td>
    @else
        <td id="discount-{{$itemRepo->uniqid}}">{{ $itemRepo->discount_price }}</td>
    @endif
    <td>
        <button class="extra-btn" data-toggle="modal" data-target="#extra-choose-{{$itemRepo->id . '-' . $itemRepo->uniqid}}" type="button">Add On</button>
        @if(isset($itemRepo->add_on))
            <!-- Modal for Extra Choose -->
            <div class="modal fade" id="extra-choose-{{$itemRepo->id . '-' . $itemRepo->uniqid}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content extra-box">
                        <h3>Choose Extra</h3>    
                        <form id="addon-{{$itemRepo->id . '-' . $itemRepo->uniqid }}">
                            @foreach($itemRepo->add_on as $addon)
                            <label class="control">{{ $addon['food_name'] }}
                                <input type="checkbox" value="{{ $addon['id'] . ',' . $addon['price'] }}"/>
                                <div class="check-mark"></div>
                            </label>
                            @endforeach                         
                            <div class="modal-footer cashier-footer">
                                <button type="button" data-dismiss="modal" class="ok-btn" onclick="addOnOK({{$itemRepo->id . ',"' . $itemRepo->uniqid . '"' }})">OK</button>
                                <button type="reset" data-dismiss="modal" class="cancel-btn">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>  
            <!-- end of Modal for Extra Choose -->
        @endif
    </td>
    <td><input type="text" id="extra-{{ $itemRepo->id . '-' . $itemRepo->uniqid }}" name="extra[]" value="0" style="border:none;background:none;" readonly /></td>
    <td>
    @if ($itemRepo->discount_type == '')
        <input type="text" value="{{ $itemRepo->price }}" style="border:none;background:none;" readonly id="amount-{{$itemRepo->uniqid}}" />
    @else
        <input type="text" value="{{$itemRepo->price_with_discount }}" style="border:none;background:none;" readonly id="amount-{{$itemRepo->uniqid}}" />
    @endif
    </td>

    <td>
        <label class="control">
          <input type="hidden" value="0" name="take_{{$itemRepo->uniqid}}" />
          <input type="checkbox" value="1" name="take_{{$itemRepo->uniqid}}" {{ ($take == 0 ? "" : "checked disabled ")}} />
          <div class="check-mark"></div>
        </label>
    </td>
    <td>
        <button class="cancel-btn" type="button" onclick="cancelBtn(0,'{{$itemRepo['uniqid']}}')">Cancel</button>
    </td>

    <input type="hidden" name="item[]" value="{{$itemRepo->id }}" id="item-{{$itemRepo->uniqid }}" />
    <input type="hidden" name="addon[]" value="" id="addon-{{$itemRepo->id . '-' . $itemRepo->uniqid }}" />
    <input type="hidden" name="originamount[]" value="{{$itemRepo->price }}" id="amount-without-discount-{{$itemRepo->uniqid }}" />

    @if ($itemRepo->discount_type == '')
        <input type="hidden" name="price[]" value="{{$itemRepo->price }}" id="price-{{$itemRepo->id . '-' . $itemRepo->uniqid }}" />
    @else
        <input type="hidden" name="price[]" value="{{$itemRepo->price_with_discount }}" id="price-{{$itemRepo->id . '-' . $itemRepo->uniqid }}" />
    @endif
    <input type="hidden" name="discount[]" value="{{$itemRepo->discount_price }}" id="discount-{{$itemRepo->id }}" />
    <input type="hidden" value="{{ $itemRepo->uniqid }}" name="uniqid[]" />
    <input type="hidden" value="0" name="type[]" />
</tr>