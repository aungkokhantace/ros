
$("#restaurant").change(function(){
//            var tmp=$('#userType').val();
            var restaurant_id =$("#restaurant").val();
            console.log(restaurant_id);
             $.ajax({
                  type: "GET",
                  url: "/Backend/Staff/ajaxRequest/"+restaurant_id,
                  data: {
                    "_token": "{{ csrf_token() }}"
                  }
            }).done(function(result){
                console.log(result);
                $('#branch').empty();
                $('#branch').append("<option disabled selected>Select Branch</option>");
                $(result).each(function(){
                  console.log(this.id,this.name);
                  $('#branch').append($('<option>',{
                    value : this.id,
                    text: this.name,
                  }));
                })
              })
           
        });