@extends('Backend/layouts.master')
@section('title','Discount Listing')
@section('content')
    <div class="content-wrapper">
      <div class="box">
       <div class="box-header">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-3">
                    <h3 class="h3 list-heading-align"><strong>Discount Listing</strong></h3>
                    @if(count(Session::get('message')) != 0)
                        <div ></div>
                    @endif
                </div>
            </div>
        
                <div class="col-md-9 pull-right ">
                    <div class="buttons ">
                        <button name="create category" type="button" class="btn btn-default btn-md first_btn" onclick="discount_entry_form_create();">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button name="edit category" type="button" class="btn btn-default btn-md second_btn" onclick="discount_edit();">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>
                        <button name="delete category" type="button" class="btn btn-default btn-md third_btn" onclick="discount_delete();">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>

        </div>

    </div>
    {{--three btns--}}
    {{--tables--}}
    <div class="container">
        <div class="row">
            <div class="col-md-12 tbl-container">
                <div class="col-md-12"></div>
                <table class="table table-striped list-table" id="example1">
                    <thead>
                        <tr class="active">
                            {{--listing--}}
                            <th><input type='checkbox' name='check' id='check_all'/></th>
                            <th>No</th>
                            <th>Discount Name</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Item</th>
                            <th>Discount Amount / Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($discounts as $discount)
                            <tr class="active">
                                <td><input class="source" type="checkbox" name="check" value="{{$discount->id}}" ></td>
                                <td></td>
                                <td><a href="/Backend/Discount/edit/{{$discount->id}}">{{ $discount->name}}</a></td>
                                <td>{{ \Carbon\Carbon::parse($discount->start_date)->format('d-m-Y')}}</td>
                                <td>{{ \Carbon\Carbon::parse($discount->end_date)->format('d-m-Y')}}</td>
                                {{--start item id joining--}}
                                <td>
                                    @foreach($items as $item)
                                        <?php
                                        if($item->id == $discount->item_id)
                                        {
                                            echo $item->name;
                                        }
                                        ?>
                                    @endforeach
                                </td>

                                <td>{{ $discount->amount}}

                                    <?php
                                    if($discount->type=="%")
                                    {
                                        echo " %";
                                    }
                                    else
                                    {
                                        echo "Ks (Kyats)";
                                    }
                                    ?>
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
