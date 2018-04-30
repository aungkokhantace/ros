
@extends('cashier.layouts.master')
@section('title','Table')
@section('content')
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="swiper-inr container">  
                    <div class="row">
                        <div class="col-md-11">
                            <button class="btn btn-large dash-btn pull-right" style="margin-left: 10px;" data-toggle="modal" data-target="#transfer">Transfer</button>
                            <button class="btn btn-large dash-btn pull-right" id="group-tables">Group</button>
                        </div>
                    </div>
                    <div class="row">
                    @foreach($tables as $table)
                        <div class="col-md-3 heightLine_02 item-btn">
                            <button>
                                <span><input type="checkbox" value="{{ $table->id }}" class="table-choose"></span><br />
                                <img src="/assets/cashier/images/dashboard/Invoice List.png" alt="Member" class="heightLine_03" onclick="tableOrder({{$table->id}})" />
                                <span class="label-type">{{ $table->table_no}}</span>
                            </button> 
                        </div> 
                    @endforeach 
                    </div>  
                </div>
            </div>
        </div>
    </div><!-- swiper-container -->

    <div class="modal fade" id="transfer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content extra-box">
                    <h3>Transfer</h3>    
                    <form id="transfer-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <label>From Table</label>
                        <select style="width: 80%;height: 30px;" name="from">
                            @foreach($transfer_from as $from)
                                <option value="{{ $from->id }}">{{ $from->table_no }}</option>
                            @endforeach
                        </select>

                        <label>To Table &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <select style="width: 80%;height: 30px;" name="to">
                            @foreach($tables as $table)
                                <option value="{{ $table->id }}">{{ $table->table_no }}</option>
                            @endforeach
                        </select>                                     
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="ok-btn">OK</button>
                            <button type="reset" class="cancel-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#group-tables').click(function(){
                table_array       = new Array();
                count       = 0;
                $('input:checkbox.table-choose').each(function () {
                    var checked_tables = (this.checked ? $(this).val() : "");
                    if (checked_tables != "") {
                        table_array.push($(this).val());
                        count       = count + 1;
                    }
                });
                tables  = table_array.join(",");
                if (count <= 1) {
                    swal({
                        title: "Choose Table!",
                        text: "You need to choose one more table.",
                        type: "warning",
                        showCancelButton: false,
                        confirmButtonColor: "#86CCEB",
                        confirmButtonText: "Confirm",
                        closeOnConfirm: false
                    });
                } else {
                    tableOrder(tables);
                }
            });

            $('.ok-btn').click(function(){
                var data     = $('#transfer-form').serialize();
                $.ajax({
                    type: 'POST',
                    url: '/Cashier/MakeOrder/transfer',
                    data: data,
                    dataType: "json",
                    success: function (Response) {
                        console.log(Response);
                        // var returnResp        = Response.message;
                        // var order_id          = Response.order_id;
                        // if (returnResp == 'success') {
                        //     $("#" + modalID).modal("hide");
                        //     $('body').removeClass('modal-open');
                        //     $('.modal-backdrop').remove();
                        //     var port   = getSocketPort();
                        //     var socket = io.connect( 'http://'+window.location.hostname+':' + port );
                        //     socket.emit('order_cancel',{
                        //         'order_cancel' : order_id
                        //     });
                        // }
                    },
                    error: function(Response) {
                        alert('hihi');
                    }
                });
                
            });
        });
        function tableOrder(tableID) {
            redirect_url    = "/Cashier/MakeOrder/table/" + tableID;
            window.location.href = redirect_url; 
        }
    </script>
@endsection
