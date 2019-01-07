@extends('Backend.layouts.master')
@section('title',isset($record)?'Edit Item':'New Item')
@section('content')
    <style>
        .image-preview-input input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
        }
    </style>
    <div class="content-wrapper">
      <div class="box">
       <div class="box-header">
        {{--title--}}
        <h3 class="font">{{isset($record)? "Edit Item":"Create New Item"}}</h3>
       </div>
   </div>
        <div class="container">
        <div class="col-md-8">
        {{--title--}}
        @if(isset($record))
            {!! Form::open(array('url' => 'Backend/Item/update', 'method' => 'post', 'files' => true, 'class'=> 'form-horizontal', 'id'=>'item-validate')) !!}
        @else
            {!! Form::open(array('url' => 'Backend/Item/store', 'method' => 'post', 'files' => true, 'class'=> 'form-horizontal', 'id'=>'item-validate', 'onsubmit' => 'return validate();')) !!}
        @endif

        @if(isset($record))
        <input type="hidden" name="id" value={{$record->id}}>
        <input type="hidden" id="is_update" value={{isset($record)?true:false}}>
        @endif

        <div class="form-group">
            <label for="item-name" class="col-sm-3 control-label">Item Name<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="item-name" name="name" placeholder="Enter Item Name"
                       value="{{isset($record)? $record->name:Input::old('name')}}" />
                <p class="text-danger">{{$errors->first('name')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="category" class="col-sm-3 control-label">Item Category<span class="require">*</span></label>
            <div class="col-sm-7">
                <select name="parent_category" id="parent_category" class="form-control ">
                    @if(isset($record))

                        {!! generateItemCategoryListEdit($categories, $parentId=0, $indent=0,$parent_id_arr,$record->category_id) !!}

                    @else
                        <option value="0" selected disabled>Select Item Category</option>
                        {!! generateItemCategoryList($categories, $parentId=0, $indent=0,$parent_id_arr) !!}
                    @endif
                </select>
                <p class="text-danger">{{$errors->first('parent_category')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="item-description" class="col-sm-3 control-label">Item Description<span class="require">*</span></label>
            <div class="col-sm-7">
                <textarea class="form-control" id="item-description" name="description" placeholder="Enter Item Description" rows="7" cols="40">{{isset($record)? $record->description:Input::old('description')}}</textarea>
                <p class="text-danger">{{$errors->first('description')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="item-ready_food" class="col-sm-3 control-label">Is Ready Food<span class="require"></span></label>
            <div class="col-sm-7">
                <input name="is_ready_food" value="0" type="hidden">
                @if(isset($record))
                <input type="checkbox" name="is_ready_food" id="item-ready_food" value="1" @if($record->is_ready_food == 1) checked @endif />
                @else
                <input type="checkbox" name="is_ready_food" id="item-ready_food" value="1" @if(Input::old('is_ready_food') == 1) checked @endif/>
                @endif
                <p class="text-danger">{{$errors->first('price')}}</p>
            </div>
        </div>
       <div class="form-group">
            <label for="item-continent" class="col-sm-3 control-label">Has Contiuent<span class="require">*</span></label>
            <div class="col-sm-7">
                <input name="check" value="0" type="hidden">
                @if(isset($record))
                <input type="checkbox" name="check" id="item-continent" value="1" @if($record->has_continent == 1) checked @endif disabled/>
                @else
                <input type="checkbox" name="check" id="item-continent" value="1" @if(Input::old('check') == 1) checked @endif/>
                @endif
                <p class="text-danger">{{$errors->first('price')}}</p>
            </div>
        </div>

        @if(isset($record))
            {{--@include('Backend.item._multi_condiment_edit')   --}}
            @include('Backend.item.continent_edit')     
        @else
            @include('Backend.item.continent')
        @endif

        

        <div class="form-group price-item">
            <label for="item-price" class="col-sm-3 control-label">Item Price<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="item-price" name="price" placeholder="Enter Item Price" value="{{isset($record)? $record->price:Input::old('price')}}" />
                <p class="text-danger">{{$errors->first('price')}}</p>
            </div>
        </div>

        <div class="form-group price-item">
            <label for="item-image" class="col-sm-3 control-label">Item Image<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="file" class="form-control" id="item_browse" onchange="item_upload();"
                       name="fileupload" style="display: none"/>
                <input type="text" class="form-control" name="filename" id="filename1" placeholder="Choose Item Image" readonly="true" value="{{isset($record)? $record->image :  Request::old('image')}}"/><br>
                @if(isset($record))
                    <img id="img_filename" class="bottom image" src= "../../../uploads/{{$record->image}}" width="385px" height="270px">
                @endif
                <p class="text-danger">{{$errors->first('fileupload')}}</p>
            </div>
            <span for="camera" class="col-md-1 glyphicon glyphicon-camera camera" onclick="item_HandleBrowseClick();"></span>
        </div>

         <div class="form-group">
            <label for="item-status" class="col-sm-3 control-label">Remark </label>
            <div class="col-sm-7">
                <select class="form-control" id="remark" name="remark[]" multiple="multiple">
                    @if(isset($record))
                    @foreach ($remarks as $remark)                  
                     @if(in_array($remark->id,$remark_arr))                       
                        <option value="{{$remark->id}}" selected="">{{$remark->name}}</option>
                    @else
                     <option value="{{$remark->id}}" >{{$remark->name}}</option>
                    @endif                 
                    @endforeach 
                                           
                    @else
                    @foreach ($remarks as $remark)
                        <option value="{{$remark->id}}">{{$remark->name}}</option>
                    @endforeach
                    @endif
                </select>
                <p class="text-danger">{{$errors->first('status')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="item-status" class="col-sm-3 control-label">Item Status</label>
            <div class="col-sm-7">
                <select class="form-control" id="item-status" name="status">
                    @if(isset($record)){
                        @if( $record->status == 1 )
                            <option value="1" selected>Available </option>
                            <option value="0">Not Available </option>
                        @else
                            <option value="0" selected>Not Available </option>
                            <option value="1">Available </option>
                        @endif
                    @else
                            <option value="1">Available</option>
                            <option value="0">Not Available</option>
                    @endif
                </select>
                <p class="text-danger">{{$errors->first('status')}}</p>
            </div>
        </div>
        <div class="form-group">
            <label for="item-price" class="col-sm-3 control-label">Standard Cooking Time<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="number" class="form-control" id="item-price" name="standard_cooking_time" placeholder="Enter Standard Cooking Time" value="{{isset($record)? $record->standard_cooking_time:Input::old('standard_cooking_time')}}" />
              
            </div>
            <div class="col-sm-1">Minutes</div>
        </div>
        {{--End item Status--}}
        <div class="form-group">
            <div class="col-sm-7 col-sm-offset-3">
                <input type="submit" name="submit" value="{{isset($record)? 'UPDATE' : 'ADD'}}" class="user-button-ok"> {{--Add Button--}}
                <input type="reset" value="CANCEL" class="user-button-cancel" onclick="show_item_list();"> {{--Cancel Button--}}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
</div>
<script>

$(document).ready(function(){
    if ( $('input[id="item-continent"]').is(':checked') ) {
        $('.price-item').hide();
        $('.continent').show();

    } else {
        $('.price-item').show();
        $('.continent').hide();   
    }

    //If Checkbox is check
    $('input[id="item-continent"]').on('click', function(){
        if ( $(this).is(':checked') ) {
            $('.price-item').hide();
            $('.continent').show();
            $('#product_detail_count').val('1');
        } 
        else {
            $('.price-item').show();
            $('.continent').hide();
        }
    });
});
</script>

<script>
function isEmptyPrice() {
    var isValid     = true;
    var itemPrice      = $('.item-price').map(function() { return this.value; }).get();
    var count   = -1;
    $(".item-price").each(function() {
        var element = $(this);
        count   = count + 1;
        if (element.val() == "") {
            $('.price-error:eq(' + count + ')').css('display','block');
            isValid = false;
        }

        if (isNaN(parseInt(element.val()))) {
            $('.integer-error:eq(' + count + ')').css('display','block');
            isValid = false;
        }
        
    });
    return isValid;
    
}

function isEmptyContinent() {
    var Valid     = true;
    var itemPrice      = $('.item-select').map(function() { return this.value; }).get();
    var count   = -1;
    $(".item-select").each(function() {
        var element = $(this);
        count   = count + 1;
        if (element.val() == "") {
            $('.select-error:eq(' + count + ')').css('display','block');
            Valid = false;
        }
    });
    return Valid;
    
}

function isEmptyBrowse() {
    var isValid      = true;
    var browseFile   = $('.input-file').map(function() { return this.value; }).get();
    var count   = -1;
    $(".input-file").each(function() {
        var element = $(this);
        count   = count + 1;
        if (element.val() == "") {
            $('.browse-error:eq(' + count + ')').css('display','block');
            isValid = false;
        }
    });
    return isValid;
    
}

function validate()
{
    var empty       = isEmptyPrice();
    var emptyCon    = isEmptyContinent();
    var emptyFile   = isEmptyBrowse();
    $(document).ready(function(){
        if ( $('input[id="item-continent"]').is(':checked') ) {
            //Do Nothing
        } else {
            empty       = true;
            emptyCon    = true;
            emptyFile   = true;   
        }

        //If Checkbox is check
        $('input[id="item-continent"]').on('click', function(){
            if ( $(this).is(':checked') ) {
                //Do Nothing
            } 
            else {
                empty       = true;
                emptyCon    = true;
                emptyFile   = true;
            }
        });
    });

    //If Valadtion Pass Form Submit
    if (empty == false || emptyCon == false || emptyFile == false) {
        return false;
    } else {
       return true; 
    }
}



function getFileName() {
    $(document).ready(function() {
        var addBrowseCount = $('#browseCount').val();
        var eqCount        = $('#browseCount').val();
        $(".input-file").each(function() {
            var inputFile   = $('.input-file:eq(' + eqCount + ')').val();
            $('.image-preview-filename:eq(' + eqCount + ')').val(inputFile);
        });
    });
}

$(document).ready(function() {
    $('.input-file').click(function(){
        $(document).on('click', '.input-file', function (event) { 
            var i   = $(this).closest('.input-file').index('.input-file');
            $('#browseCount').val(i);
            getFileName();      
        });
    });

    $('#parent_category').change(function(e){
        // console.log($(this).val());
      load_continent($(this).val());
    });

    function load_continent(continentId) {
    $.ajax({
      type: "GET",
      url: "/Backend/Continent/ajax/"+continentId
    }).done(function (data) {
        $('#wrap_contient').siblings().each(function () {
            $(this).find('select').empty();
            $(data).each((index,continent)=>{
            $(this).find('select').append($('<option>', {value:continent.id, text: continent.name}));
            });
        });
    });
  }

});
</script>
@endsection