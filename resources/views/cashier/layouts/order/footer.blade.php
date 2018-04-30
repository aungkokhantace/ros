        <script type="text/javascript">
        function scrollBottom() {
          var elmnt = document.getElementById("cat-tab-content");
          elmnt.scrollTop += 150;
        }

        function scrollFromTop() {
          var elmnt = document.getElementById("cat-tab-content");
          elmnt.scrollTop += -150;
        }
        
        function scrollBottom2() {
          var elmnt = document.getElementById("cat-table-body");
          elmnt.scrollTop += 150;
        }

        function scrollFromTop2() {
          var elmnt = document.getElementById("cat-table-body");
          elmnt.scrollTop += -150;
        }
    </script>

    <script>
        $(function () {
            $('#myList a:first-child').tab('show');
        });
    </script>
</body>
</html>