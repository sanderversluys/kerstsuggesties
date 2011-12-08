<?php

require_once('settings.php');
require_once('rb.php');

function generatePassword($length=9, $strength=0) {
	$vowels = 'aeuy';
	$consonants = 'bdghjmnpqrstvz';
	if ($strength & 1) {
		$consonants .= 'BDGHJLMNPQRSTVWXZ';
	}
	if ($strength & 2) {
		$vowels .= "AEUY";
	}
	if ($strength & 4) {
		$consonants .= '23456789';
	}
	if ($strength & 8) {
		$consonants .= '@#$%';
	}
 
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
}

function mailAndStorePasswords($member, $email) {

	$password = generatePassword(4, 1);
	
	$bean = R::findOne('family', 'name=?', array($member));	
	
	if (!$bean) {
		$bean = R::dispense('family');
	}
	$bean->name = $member;
	$bean->email = $email;
	$bean->hash = sha1($password);
	$bean->suggestions = '';

	$id = R::store($bean);
			
	$to      = $email;
	$subject = 'Kerst suggesties';
	$message = 'Je kan suggesties vragen en bekijken op niob.be/kerst met password "' . $password . '"';
	$headers = 'From: kerst@niob.be' . "\r\n" .
		'Reply-To: kerst@niob.be' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
	
	//mail($to, $subject, $message, $headers);
	
}

R::setup(); 

foreach($family as $member => $email) {
	mailAndStorePasswords($member, $email);
}

