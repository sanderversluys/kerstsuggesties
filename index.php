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

<p>Suggesties</p>

<ul>
<?php foreach($family as $member): ?> 
	<li rel="<?php echo $member->id; ?>"><?php echo $member->name; ?> - suggesties <a href="#" class="ask">vragen</a> voor of <a href="#" class="show">tonen</a> van deze persoon</li>
<?php endforeach; ?>
</ul>
</body>
</html>