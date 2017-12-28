function getSocketPort() {
    var port    = "3333";
    return port;
}
function socketConnect() {
    var port    = getSocketPort();
    var socket  = io.connect( 'http://'+window.location.hostname  +':' + port);
    return socket;
}

function socketEmit(socketKey,socketValue) {
    var port    = getSocketPort();
    var socket  = io.connect( 'http://'+window.location.hostname  +':' + port);
    socket.emit(socketKey,socketValue);
}

function socketOn(name,url,divID) {
    var port    = getSocketPort();
    var socket  = io.connect( 'http://'+window.location.hostname  +':' + port);
     socket.on( name, function( data ) {
        $.ajax({
            type: 'GET',
            url: url,
            success: function (Response) {
                console.log(Response);
                $('#' + divID).html('');
                $('#' + divID).append(Response);
            }
        });
    });
}

function socketOnPayment(name,id) {
    var port    = getSocketPort();
    var socket  = io.connect( 'http://'+window.location.hostname  +':' + port);
     socket.on( name, function( data ) {
         if (id == data) {
            swal({
                title: "Order Update !",
                text: "New Order Update !",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#86CCEB",
                confirmButtonText: "OK",
                closeOnConfirm: true
            }, function(isConfirm){
                if (isConfirm) {
                    location.reload();
                }
            });
         }
    });
}

function socketOnTable(name,url,divID) {
    var port    = getSocketPort();
    var socket  = io.connect( 'http://'+window.location.hostname  +':' + port);
     socket.on( name, function( data ) {
        $.ajax({
            type: 'GET',
            url: url,
            success: function (Response) {
                console.log(Response);
                $('#' + divID).html('');
                $('#' + divID).append(Response);
            }
        });
    });
}