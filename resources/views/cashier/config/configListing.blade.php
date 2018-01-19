@extends('cashier.layouts.master')
@section('title','General Listing')
@section('content')
    <?php //dd($config);?>
    <?php //dd('arrived the blade.');?>
    <div class="container">
        <div class="row">
            {{--Start heading title--}}
            <div class="col-md-12">
                <div class="col-md-3">
                    <h3 class="h3 list-heading-align"><strong>General Listing</strong></h3>
                </div>
                {{--End heading title--}}
                <div class="col-md-9">
                    <div class="buttons">
                        <button type="button" class="btn btn-default btn-md first_btn" onclick="config_create()">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-default btn-md second_btn" onclick="config_edit()">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-default btn-md third_btn" onclick="config_delete()">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{--End Buttons--}}
    </div>


    {{--Start table--}}
    <div class="container">
        <div class="row">
            <div class="col-md-12 tbl-container">
                <table id="tableconfig" class="table table-striped list-table">
                    <thead>
                    {{--Start Text box and combo boxes for searching--}}
                    <tr>
                        <td colspan="7">
                            <div class="col-md-4">
                                <label>Search: </label><input type="textbox" id="config_search" class="search" placeholder="Tax or Service">
                            </div>
                        </td>
                    </tr>
                    {{--End Text box and combo boxes for searching--}}


                    <tr class="active">
                        {{--Master checkbox--}}
                        <th> <input type='checkbox' name='check' id='check_all'/></th>
                        {{--Master checkbox--}}
                        <th>Tax</th>
                        <th>Service</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $count = 1;
                    $i = (($config->currentPage() - 1 ) * $config->perPage() ) + $count;
                    ?>
                    @foreach($config as $configs)
                        <tr class="active">
                            <td>
                                <input type="checkbox" class="source" name="check_config" value="{{$configs->id}}">
                                <?php
                                echo $i++;
                                ?>
                            </td>
                            {{--<td><a href="/Cashier/item_edit/{{$configs->id}}">{{ $configs->name}}</a></td>--}}
                            <td>{{$configs->tax}} %</td>
                            <td>{{ $configs->service}} %</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="form-group">
                <div class="col-sm-2 list-table-align">
                    {{--Start Select box for pagination--}}
                    <select class="form-control" id="status" name="status" onchange="config_paginate(value);">
                        <option value="0" selected>Paginate by: </option>
                        <option value="5">5 </option>
                        <option value="10">10 </option>
                        <option value="15">15 </option>
                        <option value="20">20 </option>
                        <option value="25">25 </option>
                        <option value="50">50 </option>
                    </select>
                    {{--End Select box for pagination--}}
                </div>
            </div>
            <?php echo $config->render()?>
        </div>
    </div>
@endsection
