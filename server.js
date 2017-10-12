var socket  = require( './public/node_modules/socket.io' );
var express = require('./public/node_modules/express');
var app     = express();
var server  = require('http').createServer(app);
var io      = socket.listen( server );
var port    = process.env.PORT || 3333;

server.listen(port, function () {
  console.log('Server listening at port %d', port);
});


io.on('connection', function (socket) {
  console.log('Socket Connected!!!');
  io.sockets.emit('user_connected','user_connected');
  //Socket Fire For Start Cooking
  socket.on('start_cooking', function( data ) {
    console.log('Start Cooking');
    io.sockets.emit('cooked','cooking');
  });

  socket.on('table_message', function( data ) {
    console.log('Success Function');

    io.sockets.emit( 'tableChange','tableChange');
  });

  socket.on('room_message', function( data ) {
    console.log('Success Room Function');

    io.sockets.emit( 'roomChange','roomChange');
  });

  socket.on('room_transfer', function( data ) {
    console.log('Success Room Transfer Function');

    io.sockets.emit( 'roomChange','roomChange');
  });

  socket.on('table_transfer', function( data ) {
    console.log('Success Table Transfer Function');

    io.sockets.emit( 'tableChange','tableChange');
  });

  //Order Update From Invoice List Cancel Paid Order
  socket.on('order_update', function( data ) {
    console.log('Success Invoice Cancel');

    io.sockets.emit( 'invoice_update','invoice_update');
  });
  //Socket Fire From Order Paid
  socket.on('order_payment', function( data ) {
    console.log('Success Invoice Order Paid');

    io.sockets.emit( 'invoice_update','invoice_update');
  });

  //Socket Fire From Order Create
  socket.on('order', function( data ) {
    console.log('Success Order Create');

    io.sockets.emit( 'invoice_update','invoice_update');
  });

  //Socket Fire From Order Cancel
  socket.on('order_cancel', function( data ) {
    var order_remove_id = data.order_cancel;
    console.log('Socket Connect Order Cancel');

    io.sockets.emit( 'order_remove',{
        'order_remove_id' : order_remove_id
      });
  });

  //Socket Fire From Cooking Complete
  socket.on('cooking_complete', function( data ) {
    console.log('Socket Connect Cooking Complete');

    io.sockets.emit( 'cooking_done','cooking_done');
  });

});
