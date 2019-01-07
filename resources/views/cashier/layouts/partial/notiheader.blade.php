<a href="/Cashier/WillPayView">
<button role="button"  class="btn btn-primary user-btn">

  <img src="/assets/cashier/images/noti.png" alt="login image" style="height:15px !important">
  <span class="badge">@if(isset($orders) && count($orders)>0)
                           {{count($orders)}}
                      @else
                           {{0}}
                      @endif

    </span>
</button>
<button role="button" id="dropdownMenuLink" class="btn btn-primary user-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
     <img src="/assets/cashier/images/login_img.png" alt="login image" style="height:15px !important">
</button>
<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
     <a class="dropdown-item" href="/Cashier/logout">Logout</a>
</div>
</a>
