<?php

error_reporting(-1);
ini_set('display_errors', 'on');

include 'includes/filter-wrapper.php';

$possible_languages = array(
	'English' => 'English'
	, 'French' => 'French'
	, 'Spanish' => 'Spanish'
);

$errors = array();
$display_thanks = false;
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$username = filter_input(INPUT_POST,'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST,'password', FILTER_SANITIZE_STRING);
$message = filter_input(INPUT_POST,'message', FILTER_SANITIZE_STRING);


$language = filter_input(INPUT_POST, 'language', FILTER_SANITIZE_STRING);
$accept = filter_input(INPUT_POST, 'accept', FILTER_DEFAULT);

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Check to see if the form has been submitted before validating
	if (empty($name)) {
		$errors['name'] = true;
	}
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = true;
	}
		
	if (mb_strlen($username) < 1 || mb_strlen($username) > 25) {
		$errors['username'] = true;
	}
	
	if (!filter_var($password)) { // mb_strlen = multi-byte string length
		$errors['password'] = true;
	}
	
	if (!filter_var($message)) { // mb_strlen = multi-byte string length
		$errors['message'] = true;
	}
	
	
	//if (!isset($_POST['accept'])) {
	//	$errors['accept'] = true;
	//}
	
	if (empty($accept)) {
		$errors['accept'] = true;
	}
	if (!array_key_exists($language, $possible_languages)) {
		$errors['language'] = true;
	}
	
	if(empty($errors)) {
	$display_thanks = true;
	
	$email_message = 'Name: '. $name. "\r\n";
	$email_message = 'Email' . $email. "\r\n";
	$email_message = 'Message:\r\n' . $message ;
	
	$headers = 'From: ' . $name . ' <' . $email . '>'; "\r\n";
	
	mail('mike.harley87@yahoo.com', 'registered', $email_message, $headers);
	//mail($email) 'Thanks for registering
}
}

?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Registration Form</title>
    
	<link href="css/general.css" rel="stylesheet">
</head>
<body>
	<h1> Register For Our Awesome Site!</h1>
    <?php if ($display_thanks) : ?>
    <strong>thanks</strong>
    
    <?php else :?>
	
	<form method="post" action="index.php">
		<div>
			<label for="name">Name<?php if (isset($errors['name'])) : ?> <strong>is required</strong><?php endif; ?></label>
			<input id="name" name="name" value="<?php echo $name; ?>">
		</div>
		<div>
			<label for="email">E-mail Address<?php if (isset($errors['email'])) : ?> <strong>is required</strong><?php endif; ?></label>
			<input type="email" id="email" name="email" value="<?php echo $email; ?>"> 
		</div>
        <div>
			<label for="username">Username<?php if (isset($errors['username'])) : ?> <strong>cannot be more than 25 characters</strong><?php endif; ?></label>
			<input type="username" id="username" name="username" value="<?php echo $username; ?>">
		</div>
        
        <div>
			<label for="password">Password<?php if (isset($errors['password'])) : ?> <strong>required</strong><?php endif; ?></label>
			<input type="password" id="password" name="password" value="<?php echo $password; ?>">
		</div>
        
		<fieldset>
			<legend>Preferred Language</legend>
			<?php if (isset($errors['language'])) : ?><strong>Select a Language</strong><?php endif; ?>
		<?php foreach ($possible_languages as $key => $value) : ?>
			<input type="radio" id="<?php echo $key; ?>" name="language" value="<?php echo $key; ?>"<?php if ($key == $language) { echo ' checked'; } ?>>
			<label for="<?php echo $key; ?>"><?php echo $value; ?></label>
		<?php endforeach; ?>
		</fieldset>
		<div>
			<label for="message">Notes<?php if (isset($errors['message'])) : ?> <strong></strong><?php endif; ?></label>
			<textarea id="message" name="message" ><?php echo $message; ?></textarea>
		</div>
			<input type="checkbox" id="accept" name="accept" <?php if (!empty($accept)) { echo 'checked'; } ?>
            <label for="accept">Terms and Conditions</label>
            <?php if (isset($errors['accept'])) : ?><strong>You must accept the Terms and Conditions</strong><?php endif; ?>
		</fieldset>
		<div>
			<button type="submit">Send Message</button>
		</div>
	</form>
	<?php endif ?>
    
</body>
</html>











