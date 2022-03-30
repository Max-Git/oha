<?php
require_once './sendgrid-php/sendgrid-php.php';
use SendGrid\Mail\Mail;


if(!empty($_POST['website'])) die();

// Check for empty fields
if(empty($_POST['name'])      ||
   empty($_POST['email'])     ||
   //empty($_POST['phone'])     ||
   empty($_POST['message'])   ||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
   echo "No arguments Provided!";
   return false;
   }
   
$name = strip_tags(htmlspecialchars($_POST['name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
$phone = strip_tags(htmlspecialchars($_POST['phone']));
$message = strip_tags(htmlspecialchars($_POST['message']));
   
// Create the email and send the message
$to = 'maxime@onehundredacorns.com'; 
$email_subject = "Contact depuis onehundredacorns de :  $name";
$email_body = "<h2>Vous avez reçu un message depuis le formulaire de contact.</h2><br/>"."<h3>Details:</h3></br><b>Nom:</b> $name<br/><b>Email:</b> $email_address<br/><b>Tel:</b> $phone<br/><b>Message:</b><br/>$message";

$SGApiKey = getenv("SGApiKey");

$email = new Mail(); 
$email->setFrom("contact@onehundredacorns.com", "Contact OHA");
$email->setSubject($email_subject);
$email->addTo($to, "Maxime");
$email->addContent("text/html", $email_body);

$sendgrid = new \SendGrid($SGApiKey);

try {
    $response = $sendgrid->send($email);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: '.  $e->getMessage(). "\n";
}

return true;

?>
