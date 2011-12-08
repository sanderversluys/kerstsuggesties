<?php

$family = array('Sander Versluys' => 'versluyssander@gmail.com',
				'Marijke Versluys' => 'marijkeversluys@gmail.com',
				'Freya Versluys' => 'freyaversluys@telenet.be',
				'Filip Schouteet' => 'filipschouteet@telenet.be',
				'Jan Versluys' => 'janversluys@yahoo.com',
				'Martine Vereecken' => 'martine.vereecken@telenet.be', 
				'Marc Versluys' => 'marc.versluys@gmail.com');
				
if (isset($_POST['who']) && isset($_POST['type']) && isset($_POST['suggestions'])) {

	$who = $_POST['type'];
	$type = $_POST['type'];
	$suggestions = $_POST['suggestions'];
	
	if ($type == 'ask') {
		
		foreach($family as $name => $email) {
		
			
		
		}
	
	} elseif ($type == 'send') {
	
		
	
	}
	
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Suggesties</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>
$(function() {
	var sug = $('#suggestions').hide();
	$('input[name=type]').change(function() {	
		$(this).val() == 'send' ? sug.show() : sug.hide();
	});
});
</script>
</head>
<body>

<p>Kerst 2011</p>

<form action="<? echo $_SERVER['php_self']?>" method="post">
	<p>Voor wie wil je suggesties vragen of doorsturen?</p>
	<select name="who">
		<?php foreach($family as $name => $email): ?> 
			<option value="<?php echo $name; ?>"><?php echo $name; ?></option>
		<?php endforeach; ?>
	</select>
	<p>
		<label><input type="radio" name="type" value="ask" checked> aanvragen</label>
		<label><input type="radio" name="type" value="send"> doorsturen</label>
	</p>
	<div id="suggestions">
	<p>Suggesties</p>
	<textarea name="suggestions"></textarea/>
	</div>
	<p>
		<input type="submit" value="Okidoki"/>
	</p>
</form>

<ul>

</ul>
</body>
</html>