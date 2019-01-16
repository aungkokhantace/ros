@extends('Backend.error.layout.master')
@section('title','404')
@section('content')
<style>
/*start 404 page template css*/
#fof{display:block; width:100%; padding:150px 0; line-height:1.6em; text-align:center;}
#fof .hgroup{display:block; width:80%; margin:0 auto; padding:0;}
#fof .hgroup h1, #fof .hgroup h2{margin:0 0 0 40px; padding:0; float:left; text-transform:uppercase;}
#fof .hgroup h1{margin-top:-90px; font-size:200px;}
#fof .hgroup h2{font-size:60px;}
#fof .hgroup h2 span{display:block; font-size:30px;}
#fof p{margin:25px 0 0 0; padding:0; font-size:16px;}
#fof p:first-child{margin-top:0;}
/*end 404 page template css*/
.colour {
    color: gray !important;
}
</style>
        <!-- begin #content -->
<div id="content" class="content">
    <div class="error-header-space"></div>
    <!-- <h1 class="page-header error-page-text">Error !</h1>

    <div class="row">
        <div class="col-md-12">
            <h2 class="page-header error-page-text">Sorry, the requested page is not found</h2>
        </div>
    </div> -->
    <!-- start 404 template -->
    <div class="wrapper row2">
      <div id="container" class="clear">

        <section id="fof" class="clear colour">

          <div class="hgroup clear">
            <h1>404</h1>
            <h2>Error !</h2>
          </div>
          <p>For Some Reason The Page You Requested Could Not Be Found On Our Server</p>

        </section>

      </div>
    </div>
    <!-- End 404 template -->
</div>
<div style="height: 90px"></div>
@stop

@section('page_script')
@stop