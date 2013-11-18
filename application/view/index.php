<?php $data =  $this->viewData ?>

<!DOCTYPE html>
<html>
<head>
	<title>Top 10 Weather Data</title>
</head>
<body>
<h1><?= $data['h1']?></h1>
<div class="content">
<? $selfUrl = $_SERVER['PHP_SELF'];?>
<table class="styled-select">
	<form action="<?php echo $selfUrl; ?>" method="POST">
																			<!--<form action="<?php echo $selfUrl; ?>" method="POST">-->
	<tr><td><label for="city">Select city: </label>
		<select name="city" id="city">
			<?php $selectVal = $data['selectedCity'];
			foreach($data['cityOptions'] as $cityKey => $cityName):
				$selected = ($selectVal===$cityKey) ? ' selected="selected"' : '';?>
				<option value="<?= $cityKey?>" <?=$selected?>><?= $cityName ?></option>
			<?php endforeach; ?>
		</select>
	</td></tr>
	<tr><td>
		<label for="units">Select unit: </label>
			<select name="units" id="units" onchange="this.form.submit()">
			<?php $selectVal = $data['selectedUnit'];
			foreach($data['unitOptions'] as $unitKey => $unitName):
				$selected = ($selectVal===$unitKey) ? ' selected="selected"' : '';?>
				<option value="<?= $unitKey?>" <?=$selected?>><?= $unitName ?></option>
			<?php endforeach; ?>
		</select><br>
	</td></tr>
	<tr><td>
		<input type="submit" value="Submit" class="submit">
	</td></tr>
	</form>
</table>

<?
	if ($data['selectedUnit'] == 'metric') {
				$formatTemp = 'C';
				$formatWind = 'm/s';
			} else {
				$formatTemp = 'F';
				$formatWind = 'mph';
			}
	?>

<table><tr><td colspan="2"><?= date('d/m/y @ H:m') ?></td></tr>
<tr><td>Sunrise:</td><td><?= date('H:m', $data['result']->sys->sunrise) ?></td></tr>
<tr><td>Sunset:</td><td><?= date('H:m', $data['result']->sys->sunset) ?></td></tr>
<tr><td class="none"></td></tr>

<tr><td>City:</td><td><?= $data['result']->name.', ' . $data['result']->sys->country ?></td></tr>
<?	$coords = $data['result']->coord->lat . '&deg, ' . $data['result']->coord->lon . '&deg';
	$linker = "http://maps.google.com/?q=" . $coords; ?>
<tr><td>Latitude / Longitude</td><td><a target="_blank" href="<?= $linker ?>"><?= $coords ?></a></td></tr>
<!--<tr><td>Latitude / Longitude</td><td><?= $coords ?></td></tr>-->
<tr><td>Description:</td><td><?= ucwords($data['result']->weather[0]->description) ?></td></tr>
<tr><td class="none"></td></tr>


<tr><td>Temperature:</td><td><?= number_format($data['result']->main->temp, 2) ?>&deg<?= $formatTemp ?></td></tr>
<tr><td>Min Temperature:</td><td><?= number_format($data['result']->main->temp_min, 2) ?>&deg<?= $formatTemp?></td></tr>
<tr><td>Max Temperature:</td><td><?= number_format($data['result']->main->temp_max, 2) ?>&deg<?= $formatTemp?></td></tr>
<tr><td class="none"></td></tr>

<tr><td>Humidity:</td><td><?= $data['result']->main->humidity ?>%</td></tr><br>
<tr><td>Wind:</td><td><?= number_format($data['result']->wind->speed, 1) . ' ' . $formatWind ?></td></tr></table><br>
</div>

<? //print_r("Speed: " . number_format($data['result']->time, 3)); ?>

</body>

</html>
