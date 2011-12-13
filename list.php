<?php

require_once('rb.php');

R::setup();

$family = R::find('family');


?>

<!DOCTYPE html>
<html>
<head>
<title>Suggesties list</title>
</head>
<body>

<table>
	<?php foreach($family as $member): ?> 
	<tr>
		<td><?php echo $member->id; ?></td>
		<td><?php echo $member->name; ?></td>
		<td><?php echo $member->hash; ?></td>
		<td><?php echo $member->email; ?></td>
		<td><?php echo $member->suggestions; ?></td>
	<tr>
	<?php endforeach; ?>
<table>

</body>
</html>