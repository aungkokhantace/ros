function check_date(from_date, to_date){

    var dateFirst = from_date.split('-');
    var dateSecond = to_date.split('-');
    var dateFistTemp = new Date(dateFirst[2], dateFirst[1], dateFirst[0]); //Year, Month, Date
    var dateSecondTemp = new Date(dateSecond[2], dateSecond[1], dateSecond[0]);

    if(dateSecondTemp < dateFistTemp){
        return false;
    }
    else{
        return true;
    }
}

function check_month(from_month, to_month){
    var dateFirst = from_month.split('-');
    var dateSecond = to_month.split('-');
    var dateFistTemp = new Date(dateFirst[1], dateFirst[0]); //Year, Month
    var dateSecondTemp = new Date(dateSecond[1], dateSecond[0]);   

    if(dateSecondTemp < dateFistTemp){
        return false;
    }
    else{
        return true;
    }
}

function check_year(from_year, to_year){

    var dateFirst = from_year.split('-');
    var dateSecond = to_year.split('-');
    var dateFistTemp = new Date(dateFirst[0]); //Year
    var dateSecondTemp = new Date(dateSecond[0]);

    if(dateSecondTemp < dateFistTemp){
        return false;
    }
    else{
        return true;
    }
}

function report_search_with_type(module){
    var type        =  $('input[name="sale"]:checked', '#sale_summary').val();   
    var form_action = "";

    if(type == "Yearly"){           //type is yearly
        var from_year = $("#from_year").val();
        var to_year = '';

        if(from_year == ""){
            sweetAlert("Oops...", "Please Choose the year !");
            return;
        }     
        else{           
            if(from_year != null){
                form_action = "/Backend/"+module+"/search/" + type + "/" + from_year + "/" + to_year;
               
            }
            else{
                sweetAlert("Oops...", "Please Choose the valid year rr !");
                return;
            }
        }
    }
    else if(type == "Monthly"){      
    console.log("month " + type);   //type is monthly
        var from_month = $("#from_month").val();
        var to_month = $("#to_month").val();

        if(from_month == "" && to_month == ""){
            sweetAlert("Oops...", "Please Choose the month !");
            return;
        }
        else if(from_month == "" && to_month != "") {
            sweetAlert("Oops...", "Please Choose the month !");
            return;
        }
        else if(from_month != "" && to_month == "") {
            sweetAlert("Oops...", "Please Choose the month !");
            return;
        }
        else{
            var dateComparison = check_month(from_month, to_month);

            if(dateComparison){
                form_action = "/Backend/"+module+"/search/" + type + "/" + from_month + "/" + to_month;
            }
            else{
                sweetAlert("Oops...", "Please Choose the valid month !");
                return;
            }
        }
    }
    else{       //type is daily
        var from_date = $("#from_date").val();
        var to_date = $("#to_date").val();

        if(from_date == "" && to_date == ""){
            sweetAlert("Oops...", "Please Choose the date !");
            return;
        }
        else if(from_date == "" && to_date != "") {
            sweetAlert("Oops...", "Please Choose the date !");
            return;
        }
        else if(from_date != "" && to_date == "") {
            sweetAlert("Oops...", "Please Choose the date !");
            return;
        }
        else{

            var dateComparison = check_date(from_date, to_date);
            if(dateComparison){
                form_action = "/Backend/"+module+"/search/" + type + "/" + from_date + "/" + to_date;               
            }
            else{
                sweetAlert("Oops...", "Please Choose the valid date !");
                return;
            }
        }
    }

    window.location = form_action;
}

function report_export_with_type(module){
    var type        =  $('input[name="sale"]:checked', '#sale_summary').val();   
    var form_action = "";

    if(type == "Yearly"){           //type is yearly
        var from_year = $("#from_year").val();
        var to_year = '';

        if(from_year == ""){
            sweetAlert("Oops...", "Please Choose the year !");
            return;
        }     
        else{           
            if(from_year != null){
                form_action = "/Backend/"+module+"/exportexcel/" + type + "/" + from_year + "/" + to_year;
               
            }
            else{
                sweetAlert("Oops...", "Please Choose the valid year !");
                return;
            }
        }
    }
    else if(type == "Monthly"){         //type is monthly
        var from_month = $("#from_month").val();
        var to_month = $("#to_month").val();

        if(from_month == "" && to_month == ""){
            sweetAlert("Oops...", "Please Choose the month !");
            return;
        }
        else if(from_month == "" && to_month != "") {
            sweetAlert("Oops...", "Please Choose the month !");
            return;
        }
        else if(from_month != "" && to_month == "") {
            sweetAlert("Oops...", "Please Choose the month !");
            return;
        }
        else{
            var dateComparison = check_month(from_month, to_month);

            if(dateComparison){
                form_action = "/Backend/"+module+"/exportexcel/" + type + "/" + from_month + "/" + to_month;                
            }
            else{
                sweetAlert("Oops...", "Please Choose the valid month !");
                return;
            }
        }
    }
    else{       //type is daily
        var from_date = $("#from_date").val();
        var to_date = $("#to_date").val();

        if(from_date == "" && to_date == ""){
            sweetAlert("Oops...", "Please Choose the date !");
            return;
        }
        else if(from_date == "" && to_date != "") {
            sweetAlert("Oops...", "Please Choose the date !");
            return;
        }
        else if(from_date != "" && to_date == "") {
            sweetAlert("Oops...", "Please Choose the date !");
            return;
        }
        else{
            var dateComparison = check_date(from_date, to_date);
            if(dateComparison){
                form_action = "/Backend/"+module+"/exportexcel/" + type + "/" + from_date + "/" + to_date;
               
            }
            else{
                sweetAlert("Oops...", "Please Choose the valid date !");
                return;
            }
        }
    }

    window.location = form_action;
}

function report_search_with_sort(module){
 
    // var type        =  $('select[name="sort"]:selected', '#invoice-form').val(); 
    var sort        = $("#invoice-form option:selected").val();   
    console.log("sort",sort); 
    var date        = $("#date").val();
    var type        = $("#type").val();
    var from        = $("#from").val();
    var to          = $("#to").val();
    console.log(from+to);

    var form_action = "";       
    form_action     = "/Backend/"+module+"/detail_sort/" + date + "/" + type + "/" + sort +'/'+from +'/' + to;
    
    window.location = form_action;
    // sale_SummaryReport/detail/2018-11/monthly
}

function report_export_with_sort(module){
    var sort        = $("#invoice-form option:selected").val();   
    console.log("sort",sort); 
    var date        = $("#date").val();
    var type        = $("#type").val();
    var from        = $("#from").val();
    var to          = $("#to").val();

    var form_action = "";       
    form_action     = "/Backend/"+module+"/detail_exprot/" + date + "/" + type + "/" + sort+'/'+from +'/' + to;
    
    window.location = form_action;
}

// function best_item_search(module){   
//     var form_action = "";
//     var from_date           = $("#from_date").val();
//     var to_date             = $("#to_date").val();
//     var number              = $("#number").val();
//     var from_amount         = $("#from_amount").val();
//     var to_amount           = $("#to_amount").val();   
//      if(from_date == "" && to_date == ""){
//             sweetAlert("Oops...", "Please Choose the date !");
//             return;
//         }
//     else{
//             var dateComparison = check_date(from_date, to_date);
//             if(dateComparison){
//                 form_action = "/Backend/"+module+"/search/" + from_date + "/" + to_date + "/" + number + "/" + from_amount + "/" +to_amount;
               
//             }
//             else{
//                 sweetAlert("Oops...", "Please Choose the valid date !");
//                 return;
//             }       
//     } 
//     window.location = form_action;
// }

function checkamount(from_amount, to_amount){     

    if( to_amount > from_amount ){
        return false;
    }
    else{
         // sweetAlert("Oops...", "Please Enter valid amount !");
        return true;
    }
}

function best_item_search(module){   
    var form_action = "";
    var from_date           = $("#from_date").val();
    var to_date             = $("#to_date").val();
    var number              = $("#number").val();
    var from_amount         = $("#from_amount").val();
    var to_amount           = $("#to_amount").val();  
    // console.log(number);
    if(number == '' || number == null){
        number = ' ';
    
    } 
      
     if(from_date == "" && to_date == ""){
            sweetAlert("Oops...", "Please Choose the date !");
            return;
        }
    else{           
            if(from_amount  && to_amount ==''){
                sweetAlert("Oops...", "Please Enter valid amount !");
                return;

            }
            else if(from_amount=='' && to_amount ){
                 sweetAlert("Oops...", "Please Enter valid amount !");
                return;
            }
            var dateComparison      = check_date(from_date, to_date);  

            if(from_amount !='' && to_amount !=''){ 
            var test1 = parseInt(to_amount);
            var test2 = parseInt(from_amount);            
               
               if( parseInt(to_amount) < parseInt(from_amount) ){

                   sweetAlert("Oops...", "Please Enter valid amount !");
                    return;
                }               
            }      
           
           if(dateComparison){
                form_action = "/Backend/"+module+"/search/" + from_date + "/" + to_date + "/" + number + "/" + from_amount + "/" +to_amount;
               
            }            
            else{
                sweetAlert("Oops...", "Please Choose the valid date !");
                return;
            }      
           } 
    window.location = form_action;
}


function best_item_excel(module){   
   
    var form_action = "";
    var from_date           = $("#from_date").val();
    var to_date             = $("#to_date").val();
    var number              = $("#number").val();
    var from_amount         = $("#from_amount").val();
    var to_amount           = $("#to_amount").val();
    if(number == '' || number == null){
        number = ' ';
    
    } 
    
     if(from_date == "" && to_date == ""){
            sweetAlert("Oops...", "Please Choose the date !");
            return;
        }
    else{

        if(from_amount  && to_amount ==''){
            sweetAlert("Oops...", "Please Enter valid amount !");
            return;

        }
        else if(from_amount=='' && to_amount ){
             sweetAlert("Oops...", "Please Enter valid amount !");
            return;
        }


         if(from_amount !='' && to_amount !=''){             
               
               if( parseInt(to_amount) < parseInt(from_amount) ){

                   sweetAlert("Oops...", "Please Enter valid amount !");
                    return;
                }               
            }      
           
        var dateComparison = check_date(from_date, to_date);
        // var amountComparison = checkamount(from_amount,to_amount);
        // console.log(amountComparison);
        if(dateComparison){               
            form_action = "/Backend/"+module+"/export/" + from_date + "/" + to_date + "/" + number + "/" + from_amount + "/" +to_amount;
           
        }
        else{
            sweetAlert("Oops...", "Please Choose the valid date !");
            return;
        }       
    } 
    window.location = form_action;
}

function best_category_search(module){   
    var form_action = "";
    var from_date           = $("#from_date").val();
    var to_date             = $("#to_date").val();
     
     if(from_date == "" && to_date == ""){
            sweetAlert("Oops...", "Please Choose the date !");
            return;
        }
    else{
            var dateComparison = check_date(from_date, to_date);
            if(dateComparison){
                form_action = "/Backend/"+module+"/search/" + from_date + "/" + to_date ;
               
            }
            else{
                sweetAlert("Oops...", "Please Choose the valid date !");
                return;
            }       
    } 
    window.location = form_action;
}

function best_category_excel(module){   
    var form_action = "";
    var from_date           = $("#from_date").val();
    var to_date             = $("#to_date").val();
     
     if(from_date == "" && to_date == ""){
            sweetAlert("Oops...", "Please Choose the date !");
            return;
        }
    else{
            var dateComparison = check_date(from_date, to_date);
            if(dateComparison){
                form_action = "/Backend/"+module+"/export/" + from_date + "/" + to_date ;
               
            }
            else{
                sweetAlert("Oops...", "Please Choose the valid date !");
                return;
            }       
    } 
    window.location = form_action;
}