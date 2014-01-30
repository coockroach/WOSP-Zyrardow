<?php

$requiredFields = array(
    'email',
    'phone',
    'full_name',
    'topic',
    'body',
    'secret43',
);

foreach ($requiredFields as $requiredField) {
    if (!isset($_POST[$requiredField])
		|| empty($_POST[$requiredField])
    ) {
		die();
	}
}

$email       = $_POST['email'];
$phone       = $_POST['phone'];
$fullName    = $_POST['full_name'];
$topic       = $_POST['topic'];
$body        = $_POST['body'];
$recipientId = $_POST['secret43'];

$recipient = '';

$recipients = array(
    'contact'    => '',
    'licitation' => '',
);

if (isset($recipients[$recipientId])) {
	$recipient = $recipients[$recipientId];
}

if (!is_string($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
	die(
		json_encode(
			array(
				'status' => 'error',
				'reason' => 'Invalid email',
			)
		)
	);
}

if (!is_string($phone) || strlen($phone) < 9 || strlen($phone) > 20) {
	die(
		json_encode(
			array(
				'status' => 'error',
				'reason' => 'Invalid phone number',
			)
		)
	);
}

if (!is_string($fullName) || strlen($fullName) < 9 || strlen($fullName) > 50) {
	die(
		json_encode(
			array(
				'status' => 'error',
				'reason' => 'Invalid full name',
			)
		)
	);
}

if (!is_string($topic) || strlen($topic) < 3 || strlen($topic) > 100) {
	die(
		json_encode(
			array(
				'status' => 'error',
				'reason' => 'Invalid topic length; min = 3; max = 100',
			)
		)
	);
}

if (!is_string($body) || strlen($body) < 3 || strlen($body) > 5000) {
	die(
		json_encode(
			array(
				'status' => 'error',
				'reason' => 'Invalid body length; min=3; max=5000',
			)
		)
	);
}

$emailBody = 'From: ' . $fullName . "\n"
           . 'Email: ' . $email . "\n"
           . 'Phone: ' . $phone . "\n"
           . 'Content: ' . $body . "\n";

$headers = 'From: ' . $recipient . "\r\n" .
   'Reply-To: ' . $recipient . "\r\n" .
   'X-Mailer: PHP/' . phpversion();

mail($recipient, 'Formularz kontaktowy strony WOŚP', htmlentities($emailBody), $headers);

echo json_encode(
	array(
		'status' => 'ok',
		'reason' => 'Wiadomosc wyslana pomyslnie',
	)
);
