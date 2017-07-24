@extends('cashier/layouts.master')
@section('title','Add-on Listing')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-3">
                    <h3 class="h3 list-heading-align"><strong>Add-on Listing</strong></h3>
                    @if(count(Session::get('message')) != 0)
                        <div ></div>
                    @endif
                </div>
                <div class="col-md-9">
                    <div class="buttons">
                        <button name="create category" type="button" class="btn btn-default btn-md first_btn" onclick="extra_create();">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button name="edit category" type="button" class="btn btn-default btn-md second_btn" onclick="extra_edit();">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>
                        <button name="delete category" type="button" class="btn btn-default btn-md third_btn" onclick="extra_delete();">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{--tables--}}

    <div class="container">
        <div class="row">
            <div class="col-md-12 tbl-container">
                <div class="col-md-12"></div>
                <table class="table table-striped list-table" id="example1">
                    <thead>
                        <tr class="active">
                            <th><input type='checkbox' name='check_all' id='check_all'  onclick="check(value);" />  </th>
                            <th>No</th>
                            <th>Add-on Name</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>image</th>
                            <th>Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($ex as $extras)
                        <tr class="active">
                            <input type="hidden" value="{{$extras->id}}">

                            <td> <input class="source" type="checkbox" name="extra_check" value="{{ $extras->id }}" id="check" />

                            </td>
                            <td></td>
                            <td><a href="/Cashier/AddOn/edit/{{$extras->id}}">{{ $extras->food_name }}</a></td>
                            <td>  @foreach($category as $cat)
                                    <?php
                                    if($cat->id == $extras->category_id)
                                    {
                                        echo $cat->name;
                                    }
                                    ?>
                                @endforeach
                            </td>
                            <td>{{ $extras->description }}</td>
                            <td>{{ $extras->image }}</td>
                            <td>{{ $extras->price }}</td>
                            <td>
                            @if( $extras->status==0)
                                {{"Not Available"}}
                                @else
                               {{"Available"}}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
</div>
@endsection
