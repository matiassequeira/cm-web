<?php

// configure
$from = '';
$sendTo = 'Crossed Minds <info@crossedminds.com>';
$subject = 'New message from CrossedMinds.com';
$fields = array('name' => 'Name', 'email' => 'Email', 'company' => 'Company', 'telephone' => 'Telephone', 'website' => 'Website', 'skype' => 'Skype', 'message' => 'Message');
$okMessage = 'Form successfully submitted. Thank you, We will get back to you soon!';
$errorMessage = 'There was an error while submitting the form. Please try again later';

// let's do the sending

try
{
    $emailText = "You have new message from CrossedMinds.com\n=============================\n";

    foreach ($_POST as $key => $value) {

        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }
    $senderEmail = "<" . $_POST['email'] . ">";
    $from = $_POST['name'] . " " . $senderEmail;

    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );
    
    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
else {
    echo $responseArray['message'];
}
