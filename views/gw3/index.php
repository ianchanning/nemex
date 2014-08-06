<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>GW 3</title>
	<style type="text/css">
		table {border: 1px solid #000; border-spacing: 0; border-collapse: collapse;}
		th {border: 1px solid #000; margin: 0;}
		td {border: 1px solid #000; margin: 0;}
	</style>
</head>
<body>

<table>
	<tr>
		<?php foreach ($headers as $name => $col) { ?>
		
		<th id="th<?php echo $col; ?>"><?php echo $name; ?></th>
		<?php } ?>
	
	</tr>
	<?php foreach ($players as $row => $player) { ?>
	
	<tr id="tr<?php echo $row; ?>">
		<?php foreach ($player as $col => $value) { ?>

		<td id="tr<?php echo $row; ?>_td<?php echo $col; ?>"><?php echo $value; ?></td>
	
		<?php } ?>
	
	</tr>
	<?php } ?>

</table>	

</body>
</html>
	