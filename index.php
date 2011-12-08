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
</head>
<body>

<p>Suggesties</p>

<ul>
<?php foreach($family as $member): ?> 
	<li><?php echo $member->name; ?> - suggesties <a href="#"> vragen</a> of <a href="#">tonen</a></li>
<?php endforeach; ?>
</ul>
</body>
</html>