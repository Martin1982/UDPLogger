var dgram = require("dgram"),
    udpListener = dgram.createSocket("udp4"),
    httpServer = require('http').createServer(httpHandler),
    io = require('socket.io').listen(httpServer),
    fs = require('fs');

// Listen for incoming udp messages
udpListener.on("message", function(msg, rinfo) {
    console.log("server got: " + msg + " from " + rinfo.address + ": " + rinfo.port);
    io.sockets.send(msg);
});

// Expose information when the listener starts
udpListener.on("listening", function () {
  var address = udpListener.address();
  console.log("server listening " + address.address + ":" + address.port);
});

// Handle incoming http-requests to show the dashboard
function httpHandler (req, res) {
    if (req.url === '/') {
        req.url = '/index.html';
    }
    fs.readFile(__dirname + '/httpdocs' + req.url,
    function (err, data) {
        if (err) {
            res.writeHead(500);
            return res.end('Error loading ' + req.url);
        }
        res.writeHead(200);
        res.end(data);
    });
}

// bind the server
udpListener.bind(8044, '127.0.0.1');
httpServer.listen(8040);