@extends('cashier.layouts.master')
@section('title','Favourite Food Report')
@section('content')
    {{--title--}}
    <div class="container">
        {{--Favourite Food Listing Table--}}
        <div class="container">
            <div class="row">
                <div class="col-md-11">
                    <div class="form-group">
                        <div class="col-sm-5">
                            <h3 class="h3 report_heading"><b>Member Favourite Food List</b></h3>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <select name="type" id="fav-report" class="form-control">
                                <option value="0">Choose Member Type</option>
                                @if(isset($type))
                                    @foreach($memberTypes as $memberType)
                                        @if($memberType->id == $type)
                                            <option value="{{$memberType->id}}" selected>{{$memberType->type}}</option>
                                        @else
                                            <option value="{{$memberType->id}}">{{$memberType->type}}</option>
                                        @endif
                                    @endforeach
                                @else
                                    @foreach($memberTypes as $memberType)
                                        <option value="{{$memberType->id}}">{{$memberType->type}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-sm-1">
                            @if(isset($type))
                                <a href="{{URL::to('/Cashier/downloadFavourite',$type) }}"><button id="fav_export" class="btn btn_export btn-success" style="border-radius:0px;">Export</button></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div><br/>
            <div class="container">
                <div class="row" id="autoDiv">
                    <div class="col-md-11">
                        <table class="table table-bordered" >
                            <thead class="thead_report">
                            <tr class="report-th">
                                <th>No.</th>
                                <th>Item Name</th>
                                <th>Total</th>
                                <th>Category</th>
                            </tr>
                            </thead>

                            <?php $i = 1; ?>
                            @foreach($favourites as $fav)
                                <tr class="tr-row active">
                                    <td><?php echo $i++; ?></td>
                                    <td>{{$fav->item->name}}</td>
                                    <td>{{$fav->total}}</td>
                                    <td>
                                        @foreach($categories as $cat)
                                            @if($fav->item->category_id == $cat->id)
                                                {{$cat->name}}
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#fav-report').change(function(e){
            var txt = $(this).val();
            console.log(txt);
            window.location.href = '/Cashier/memberFavaourite/'+txt
        });
    </script>
@endsection
