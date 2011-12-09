<?php

require_once('settings.php');
require_once('rb.php');

R::setup();

$family = R::find('family');

?>

<!DOCTYPE html>
<html>
<head>
<title>Suggesties</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>
$(function() {
	$('a.ask').click(function() {
		prompt('Ben je zeker dat je suggesties wilt vragen voor deze persoon? Door deze actie zal jij de enige zijn de suggesties kan bekijken.');	
	});
	
	$('a.show').click(function() {

	});
});
</script>
</head>
<body>

<p><a href="mail.php">Suggesties</a></p>

<ul>

<table>
	<?php foreach($family as $member): ?> 
	<tr>
		<td><?php echo $member->id; ?></td>
		<td><?php echo $member->name; ?></td>
		<td><a href="mail.php?sleutel=<?php echo $member->key; ?>"><?php echo $member->key; ?></a></td>
		<td><?php echo $member->suggestions; ?></td>
	<tr>
	<?php endforeach; ?>
<table>

</body>
</html>