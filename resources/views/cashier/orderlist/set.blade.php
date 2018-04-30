<tr class="item-tr" id="item-tr-{{$setmenuRepo->uniqid }}">
    <td>
        <p>{{ $setmenuRepo->set_menus_name }}</p>
    </td>
    <td class="cart_quantity">
        <div class="qty-box">
            <input type='button' value='-' class='qtyminus' field='quantity' onclick="quantityMinus({{$setmenuRepo->id . ',"' . $setmenuRepo->uniqid . '"'}})" />
            <input type='text' name='quantity[]' value='1' class='qty' id="qty-{{$setmenuRepo->uniqid}}"/>
            <input type='button' value='+' class='qtyplus' field='quantity' onclick="quantityPlus({{$setmenuRepo->id . ',"' . $setmenuRepo->uniqid . '"'}})" />
        </div>
    </td>

    
    <td id="price-{{$setmenuRepo->uniqid}}"> {{ $setmenuRepo->set_menus_price }}</td>
        <td id="discount-{{$setmenuRepo->uniqid}}">&nbsp;</td>
    <td>
        <button class="extra-btn" data-toggle="modal" data-target="#extra-choose-{{$setmenuRepo->id . '-' . $setmenuRepo->uniqid}}" type="button">Add On</button>
    </td>
    <td><input type="text" id="extra-{{ $setmenuRepo->id . '-' . $setmenuRepo->uniqid }}" name="extra[]" value="0" style="border:none;background:none;" readonly /></td>
    <td>
        <input type="text" value="{{ $setmenuRepo->set_menus_price }}" style="border:none;background:none;" readonly id="amount-{{$setmenuRepo->uniqid}}" />
    </td>

    <td>
        <label class="control">
          <input type="hidden" value="0" name="take_{{$setmenuRepo->uniqid}}" />
          <input type="checkbox" value="1" name="take_{{$setmenuRepo->uniqid}}" {{ ($take == 0 ? "" : "checked")}} />
          <div class="check-mark"></div>
        </label>
    </td>
    <td>
        <button class="cancel-btn" type="button" onclick="cancelBtn(0,'{{$setmenuRepo['uniqid']}}')">Cancel</button>
    </td>

    <input type="hidden" name="item[]" value="{{$setmenuRepo->id }}" id="item-{{$setmenuRepo->uniqid }}" />
    <input type="hidden" name="addon[]" value="" id="addon-{{$setmenuRepo->id . '-' . $setmenuRepo->uniqid }}" />
    <input type="hidden" name="originamount[]" value="{{$setmenuRepo->set_menus_price }}" id="amount-without-discount-{{$setmenuRepo->uniqid }}" />

    <input type="hidden" name="price[]" value="{{$setmenuRepo->set_menus_price }}" id="price-{{$setmenuRepo->id . '-' . $setmenuRepo->uniqid }}" />
    <input type="hidden" name="discount[]" value="" id="discount-{{$setmenuRepo->id }}" />
    <input type="hidden" value="{{ $setmenuRepo->uniqid }}" name="uniqid[]" />
    <input type="hidden" value="1" name="type[]" />
</tr>