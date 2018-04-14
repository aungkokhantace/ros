<script>
    var swiper = new Swiper('.swiper-container', {
      spaceBetween: 30,
      centeredSlides: true,
      /*autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },*/
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        //For DataTable Plugin
        var t = $('#example1').DataTable( {
            "ordering":false,
            "columnDefs": [ {
                "searchable": false,
                "orderable": false,
                "targets": 0
            } ],
            "order": [[ 1, 'asc' ]]
        } );

        t.on( 'order.dt search.dt', function () {
            t.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    });
</script>

<div class="footer text-center">  
            <img src="/assets/cashier/images/aceplus_logo.png" alt="Aceplus logo">
        </div><!-- footer -->
    </div><!-- wrapper -->

</body>
</html>