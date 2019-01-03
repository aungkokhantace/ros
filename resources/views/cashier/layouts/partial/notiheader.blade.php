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
</a>
