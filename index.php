<?php

require_once('settings.php');

?>

<!DOCTYPE html>
<html>
<head>
<title>Suggesties</title>
</head>
<body>

<p>Suggesties</p>

<ul>
<?php foreach($family as $name => $email): ?> 
	<li><?php echo $name; ?> with password <?php echo generatePassword(4, 1) ?> </li>
<?php endforeach; ?>
</ul>
</body>
</html>