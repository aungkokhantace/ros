@extends('Backend/layouts.master')
@section('title','CSV')
@section('content')
    <div class="content-wrapper">
      <div class="box">
       <div class="box-header">
    <div class="col-md-8 user-border-left">
        <h3 class="h3-font"><b>CSV </b></h3>
     </div>
 </div>
</div>
 {!! Form::open(array('url' => '/Backend/import/store','id'=>'csv_import', 'files' => true,'enctype'=>'multipart/form-data' ,'class'=> 'form-horizontal user-form-border')) !!}
   <div class="container">
     <div class="form-group">
            <label for="category-name" class="col-sm-3 control-label left-align label-font">Restuarant <span class="require">*</span></label>
            <div class="col-sm-7">
               <select class="form-control" id="restauranat" name="restauranat">
                <option selected disabled>Select Restuarant</option>
                @foreach($restaurants as $restauranat)
                <option value="{{$restauranat->id}}">{{$restauranat->name}}</option>
                @endforeach
                
               </select>
            </div>
        </div>

         <div class="form-group">
            <label for="category-name" class="col-sm-3 control-label left-align label-font">Branch <span class="require">*</span></label>
            <div class="col-sm-7">
               <select class="form-control" id="branch" name="branch">
                <option selected disabled>Select Branch</option>
                @foreach($branchs as $branch)
                <option value="{{$branch->id}}">{{$branch->name}}</option>
                @endforeach
                
               </select>
            </div>
        </div>
       

        <div class="form-group">
            <label for="category-name" class="col-sm-3 control-label left-align label-font">Table Name <span class="require">*</span></label>
            <div class="col-sm-7">
               <select class="form-control" id="tbl_name" name="tbl_name">
                <option selected disabled>Select Table</option>
                <option value="category">Category</option>
                <option value="items">Item</option>
                <option value="add_on">Add on</option>
               {{-- <option value="set_menu">Set Menu</option>--}}
               </select>
            </div>
        </div>

        <div class="form-group">
            <label for="category-name" class="col-sm-3 control-label left-align label-font">File <span class="require">*</span></label>
            <div class="col-sm-7">
                <input id="csv_upl" type="file" class="upload" name="csv_upl" />
            </div>


        </div>


   
       
        <div class="form-group">
            <div class="col-sm-8 col-sm-offset-3">
                <input type="submit" name="submit" value="Import" class="user-button-ok">
                <input type="reset" value="CANCEL" class="user-button-cancel" onclick="{{ "csv();" }}">
            </div>
        </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>

@endsection