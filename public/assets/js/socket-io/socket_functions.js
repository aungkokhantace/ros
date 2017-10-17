function getSocketPort() {
    var port    = "3333";
    return port;
}

function socketConnect() {
    var port    = getSocketPort();
    var socket  = io.connect( 'http://'+window.location.hostname + ':' + port );
    return socket;
}

function socketEmit(key,value) {
    var port    = getSocketPort();
    var socket  = io.connect( 'http://'+window.location.hostname + ':' + port );
    socket.emit(key, value);
}

function socketOn(name,url,div) {
    var port    = getSocketPort();
    var socket  = io.connect( 'http://'+window.location.hostname + ':' + port );
    socket.on(name,function(data){
        ajaxCall();

        //Put Data to html
        function ajaxCall() {
            $.ajax({
                type: 'GET',
                url: url,
                success: function (Response) {
                    console.log(Response);
                    $('#' + div).html('');
                    $('#' + div).append(Response);
                }
            })
        }
    });
}