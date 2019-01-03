<input type="hidden" name="browseCount" id="browseCount" value="0" />
<div class="form-group continent">
    <label for="item-name" class="col-sm-3 control-label">Item Continent<span class="require">*</span></label>
    <div class="col-sm-7">
        <input type="hidden" id="product_detail_count" name="product_detail_count" value="0" />
            <table class="table table-striped" id="product_detail_table">
                <tbody class="table table-striped" id="wrap_body">                     
                    <tr class="tr_product_detail_" id="tr_product_detail_">
                        <td>

                            <div class="form-group">
                                <div class="col-md-10">
                                    <select class="continent form-control item-select" id="continent" name="continent[]" required>
                                        <option value="" selected>Select Continent</option>
                                        @foreach($continent_arr as $continent)
                                            <option value="{{ $continent['id'] }}" >{{ $continent['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <label class="select-error text-danger" style="display:none">Choose Continent</label>
                                    <p class="text-danger">{{$errors->first('continent')}}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-10">
                                    <input type="text" class="form-control item-price" id="item-price" name="continent-price[]" placeholder="Enter Item Price" value="{{isset($record)? $record->price:Input::old('price')}}" required />
                                    <label class="price-error text-danger" style="display:none">Required Price</label>
                                    <label class="integer-error text-danger" style="display:none">Price Must be Number</label>
                                    <p class="text-danger">{{$errors->first('price')}}</p>
                                </div>
                            </div>

                             <div class="form-group">
                               <div class="col-sm-12">
                                    <div class="input-group image-preview">
                                        <input type="text" class="form-control image-preview-filename" disabled="disabled" value=""> <!-- don't give a name === doesn't send on POST/GET -->
                                        <span class="input-group-btn">
                                            <!-- image-preview-input -->
                                            <div class="btn btn-primary image-preview-input">
                                                <span class="glyphicon glyphicon-folder-open"></span>
                                                <span class="image-preview-input-title">Browse</span>
                                                <input type="file" accept="image/png, image/jpeg, image/gif" name="input-file-preview[]" class="input-file" onchange="getFileName()" /> <!-- rename it -->
                                            </div>
                                        </span>
                                    </div><!-- /input-group image-preview [TO HERE]--> 
                                    <label class="browse-error text-danger" style="display:none">Required Image Upload</label>
                                    
                                    @if(isset($record))
                                        <img id="img_filename" class="bottom image" src= "../../../uploads/{{$record->image}}" width="385px" height="270px">
                                    @endif
                                    <p class="text-danger">{{$errors->first('fileupload')}}</p>
                                </div>
                            </div><br />
                                                      
                        </td>
               
                        <td>
                            <button type="button" class="btn green btn-sm btn-add-product-detail" ><span class="glyphicon-plus">Add</span></button>

                            <button type="button" class="btn red btn-sm btn-remove-product-detail"><span class="glyphicon-minus">Remove</span></button>
                        </td>
                            
                    </tr>

                </tbody> 
            </table>
        </div>
    </div>