<?php 
    if(isset($fcmToken) && !empty($fcmToken) && isset($data) && !empty($data)) {
    	foreach ($fcmToken as $key => $value):
        	send($value, $data);
        endforeach;
    }
    function send($to, $message) {
	    $fields = array(
	        'to' => $to,
	        'data' => $message,
	    );
	    sendPushNotification($fields);
	}
	function sendPushNotification($fields) {
	    $FIREBASE_API_KEY = FIRE_BASE_API_KEY;

	    // Set POST variables
	    $url = 'https://fcm.googleapis.com/fcm/send';

	    $headers = array(
	        'Authorization: key=' . $FIREBASE_API_KEY,
	        'Content-Type: application/json'
	    );
	    // Open connection
	    $ch = curl_init();

	    // Set the url, number of POST vars, POST data
	    curl_setopt($ch, CURLOPT_URL, $url);

	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	    // Disabling SSL Certificate support temporarly
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

	    // Execute post
	    $check= 0;
	    $result = curl_exec($ch);
	    // Close connection
	    curl_close($ch);

	    return $result;
	}
	?>