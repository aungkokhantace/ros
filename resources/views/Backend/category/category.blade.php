@extends('Backend.layouts.master')
@section('title',isset($editcategory)?'Edit Category':'New Category')
@section('content')
    <div class="content-wrapper">
      <div class="box">
       <div class="box-header">
    <div class="col-md-8 user-border-left">
        <h3 class="h3-font"><b>{{isset($editcategory)? "Edit":"New"}}</b></h3>
     </div>
 </div>
</div>
   <div class="container">
        @if(isset($editcategory))
            {!! Form::open(array('url' => '/Backend/Category/update', 'method' => 'post', 'files' => true, 'class'=> 'form-horizontal user-form-border','id'=>'categoryForm')) !!}
        @else
            {!! Form::open(array('url' => '/Backend/Category/store','method' => 'post', 'files' => true, 'class'=> 'form-horizontal user-form-border','id'=>'categoryForm')) !!}
        @endif

        @if(isset($editcategory))
            {{ Form::hidden('id', $editcategory->id) }}
        @endif
           <!-- restaturant session -->
        @if (Auth::guard('Cashier')->user()->restaurant_id == null)
         <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label left-align label-font">Restaurant <span class="require">*</span></label>
            <div class="col-sm-7">                 
                 @if(isset($editcategory))
                    @foreach($restaurants as $restaurant)
                        @if($restaurant->id == $editcategory->restaurant_id)
                         <input type="text" class="form-control" value="{{ $restaurant->name }}" readonly />
                         <input type="hidden" class="form-control" id="restaurant" name="restaurant" value="{{ $restaurant->id }}" />                         
                       
                        @endif
                    @endforeach                 
                @else
                <select class="form-control" name="restaurant" id="restaurant">            
                <option selected disabled>Select Restaurant </option>
                    @foreach($restaurants as $restaurant)
                      <option value="{{$restaurant->id}}">{{$restaurant->name}}</option>                
                    @endforeach
                @endif
                </select>
              
            </div>
        </div>
     

         <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label left-align label-font">Branch <span class="require">*</span></label>
            <div class="col-sm-7">                 
                 @if(isset($editcategory))
                    @foreach($branchs as $branch)
                        @if($branch->id == $editcategory->branch_id)
                         <input type="text" class="form-control" value="{{ $branch->name }}" readonly />
                         <input type="hidden" class="form-control" id="branch" name="branch" value="{{ $branch->id }}" />                         
                       
                        @endif
                    @endforeach                 
                @else
                <select class="form-control" name="branch" id="branch">            
                <option selected disabled>Select Branch </option>
                   
                @endif
                </select>
              
            </div>
        </div>
         @elseif (Auth::guard('Cashier')->user()->branch_id == null || Auth::guard('Cashier')->user()->branch_id == 0 )

        <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label left-align label-font">Branch <span class="require">*</span></label>
            <div class="col-sm-7">                 
                 @if(isset($editcategory))
                    @foreach($branchs as $branch)
                        @if($branch->id == $editcategory->branch_id)
                         <input type="text" class="form-control" value="{{ $branch->name }}" readonly />
                         <input type="hidden" class="form-control" id="branch" name="branch" value="{{ $branch->id }}" />                         
                       
                        @endif
                    @endforeach                 
                @else
                <select class="form-control" name="branch" id="branch" >            
                <option selected disabled>Select Branch </option>
                    @foreach($branchs as $branch)
                      <option value="{{$branch->id}}">{{$branch->name}}</option>                
                    @endforeach
                @endif
                </select>
              
            </div>
        </div>
        @endif
        <!--end restaturant session -->

        <div class="form-group">
            <label for="category-name" class="col-sm-3 control-label left-align label-font">Category Name<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="category-name" name="name" placeholder="Enter Category Name" value="{{isset($editcategory)? $editcategory->name:Request::old('name')}}"  />
                <p class="text-danger">{{$errors->first('name')}}</p>
            </div>
        </div>
        
        <div class="form-group">
            <label for="product" class="col-sm-3 form-label left-align label-font">Parent Category</label>
            <div class="col-sm-7">
            @if(isset($editcategory))
                <input type="text" class="form-control" id="category-name" value="{{ $editcategory->name }}" readonly />
            @else
            <select name="parent_category" id="parent_category" class="form-control" onchange="getCatID()" {{isset($editcategory)? "disabled":""}}>
                <option value="0">None</option>
                {!! generateCategoryLists($categories, $parentId=0, $indent=0) !!}
            </select>
            @endif
            <p class="text-danger">{{$errors->first('parent_category')}}</p>
            </div>
        </div>

        @if(isset($editcategory))
        <input type="hidden" value="{{ $editcategory->id }}" name="parent_category" />
        @endif
        
        @if(isset($editcategory))
            @if ($subtree->parent_id <= 0)
            <div class="form-group" id="kitchen">
                <label for="product" class="col-sm-3 form-label left-align label-font">Kitchen<span class="require">*</span></label>
                <div class="col-sm-7">
                    <select name="kitchen" id="kitchen" class="form-control">
                        @foreach($kitchen as $k)
                            @if($k->id == $editcategory->kitchen_id)
                                <option value="{{$k->id}}" selected>{{$k->name}}</option>
                            @else
                                <option value="{{$k->id}}">{{$k->name}}</option>
                            @endif
                        @endforeach
                    </select>
                    <p class="text-danger">{{$errors->first('parent_category')}}</p>
                </div>
            </div>
            @else
                <input type="hidden" value="{{$editcategory->kitchen_id}}" name = "kitchen" />
            @endif
        @else
        <div class="form-group" id="kitchen">
            <label for="product" class="col-sm-3 form-label left-align label-font">Kitchen<span class="require">*</span></label>
            <div class="col-sm-7">
                <select name="kitchen" class="form-control kitchen">
                    <option selected disabled>Select Kitchen</option>
                    @foreach($kitchen as $k)
                        <option value="{{$k->id}}">{{$k->name}}</option>
                    @endforeach
                </select>
                <p class="text-danger">{{$errors->first('parent_category')}}</p>
            </div>
        </div>
        @endif

        <div class="form-group">
            <label for="category-image"  class="col-sm-3 form-label left-align label-font">Category Image<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="file" id="category_browse" class="form-control" onchange="category_upload();" name="fileupload" style="display: none"/>
                <input type="text" id="filename1" name="image" placeholder="Choose Category Image" class="form-control" readonly="true" value="{{isset($editcategory)? $editcategory->image:""}}"/><br>
                @if(isset($editcategory))
                    <img id="img" class="bottom image" src= "../../../uploads/{{$editcategory->image}}" width="385px" height="270px">
                @endif
                <p class="text-danger">{{$errors->first('fileupload')}}</p>
            </div>
            <div class="col-sm-1">
                <span for="camera" class="col-md-1 glyphicon glyphicon-camera camera" onclick="category_HandleBrowseClick();"></span>
            </div>
        </div>

        <div class="form-group">
            <label for="status" class="col-sm-3 form-label left-align label-font">Status</label>
            <div class="col-sm-7">
                <select class="form-control" id="status" name="status">
                    @if(isset($editcategory)){
                    @if( $editcategory->status == 1 )
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
                <p class="text-danger"></p>
            </div>
        </div>

        <div class="form-group">
            <label for="description" class="col-sm-3 form-label left-align label-font">Description<span class="require">*</span></label>
            <div class="col-sm-7">
                <textarea class="form-control" id="Category-description" name="description" placeholder="Enter Category Description" rows="7" cols="40">{{isset($editcategory)? $editcategory->description:Input::old('description')}}</textarea>
                <p class="text-danger">{{$errors->first('description')}}</p>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-8 col-sm-offset-3">
                <input type="submit" name="submit" value="{{isset($editcategory)? 'UPDATE' : 'ADD'}}" class="user-button-ok">
                <input type="reset" value="CANCEL" class="user-button-cancel" onclick="{{ "categoryList();" }}">
            </div>
        </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
    <script>
        function getCatID() {
            var category    = document.getElementById("parent_category").value;
            $(document).ready(function(){
                if (category == 0) {
                    $('#kitchen').show();
                } else {
                    $('#kitchen').hide();  
                }
            });
        } 
       

       if( $('select[id=branch] option:selected') ) {
            console.log("id is slected ");
            $("#branch").change(function(){
//            var tmp=$('#userType').val();
            var branch =$("#branch").val();
            console.log(branch+"branch_id");
             $.ajax({
                  type: "GET",
                  url: "/Backend/Branch/ajaxRequest/"+branch,
                  data: {
                    "_token": "{{ csrf_token() }}"
                  }
            }).done(function(result){
                console.log(result);
                $('.kitchen').empty();
                $('.kitchen').append("<option disabled selected>Select Branch</option>");
                $(result).each(function(){
                  console.log(this.id,this.name);
                  $('.kitchen').append($('<option>',{
                    value : this.id,
                    text: this.name,
                  }));
                })
              })
           
        });

                
        }  ///if

    </script>
<script src="/assets/backend_js/branch/branch.js"></script>
@endsection