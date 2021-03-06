@extends('Cashier.layouts.kitchen.master')
@section('title','Order View')
@section('content')
    {{--title--}}
    <div class="container">
        {{--Order Listing Table--}}
        <div class="container">

            <div class="row" id="autoDiv">
                @include('kitchen.product')
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
        
            var myVar = setInterval(myTimer ,1000);
            function myTimer() {
                $("table tr.tr-row").each(function () {
                   var currentTime = moment();                    

                    var orderTime = moment($(this).data("ordertime"), 'YYYY-MM-DD hh:mm:ss tt');

                    var diff = currentTime.diff(orderTime);
                    var d = moment.duration(diff);
                    var s = Math.floor(d.asHours()) + moment.utc(diff).format(":mm:ss");
                   
                    $(this).find(".duration").text(s);
                    $(this).find(".txt_duration").val(s);

                    var orderDuration = $(this).find("[name=order_duration]").val();
                    var duration      = moment(orderDuration,'YYYY-MM-DD hh:mm:ss tt');
                    var result        = currentTime.diff(duration);
                    var time          = moment.duration(result);
                    var cooking_time  = Math.floor(d.asHours()) + moment.utc(result).format(":mm:ss");
                    
                    $(this).find(".cooking_duration").text( cooking_time );
                    $(this).find(".txt_cooking_duration").val( cooking_time );
                });
            };

            setInterval(ajaxCall, 20000); //300000 MS == 5 minutes
            function ajaxCall() {
                $.ajax({
                    type:'GET',
                    url:'/Kitchen/kitchen/ajaxRequestProduct',
                    success: function(Response) {
                        console.log(Response);
                        $('#autoDiv').html('');
                        $('#autoDiv').append(Response);
                    }
               });
            }

            $('#viewBy').change(function(e){
                var url = 'getTableView?view='+ $(this).value();
            })
            $('#autoDiv').on('click', '.start_duration_item',function(e){
                window.location.href = "/Kitchen/productView/CookingItem/" +$(this).attr('id');
            });
            $('#autoDiv').on('click','.complete_duration_item', function (e) {
                window.location.href = "/Kitchen/productView/CookedItem/" + $(this).attr('id');
            });
            $('#autoDiv').on('click','.start_duration_setmenu',function(e){
                window.location.href = "/Kitchen/productView/CookingSetMenuItem/" +$(this).attr('id');
            });
            $('#autoDiv').on('click','.complete_duration_setmenu',function(e){
                window.location.href = "/Kitchen/productView/CookedSetMenuItem/" +$(this).attr('id');
            });
           
        });
    </script>
@endsection

