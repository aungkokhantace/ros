function getSocketPort() {
    var port    = "3333";
    return port;
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