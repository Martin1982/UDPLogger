<?php
$server_ip = '127.0.0.1';
$server_port = 8044;
$beat_period = 1;
$message = array(
    json_encode(array(
        'errorCode' => '0',
        'errorMessage' => 'Debug error'
    )),
    json_encode(array(
        'errorCode' => '1',
        'errorMessage' => 'Cold case'
    )),
    json_encode(array(
        'errorCode' => '2',
        'errorMessage' => 'Medium case'
    )),
    json_encode(array(
        'errorCode' => '3',
        'errorMessage' => 'Warm case'
    )),
    json_encode(array(
        'errorCode' => '4',
        'errorMessage' => 'Overheated case'
    ))
);

print "Sending heartbeat to IP $server_ip, port $server_port\n";
print "press Ctrl-C to stop\n";
if ($socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP)) {
    while (1) {
        $sendable = $message[rand(0,4)];
        socket_sendto($socket, $sendable, strlen($sendable), 0, $server_ip, $server_port);
        print "Time: " . date("%r") . "\n";
        sleep($beat_period);
    }
} else {
    print("can't create socket\n");
}