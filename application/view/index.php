<?php $data = $this->viewData ?>

<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="../../lib/jquery/jquery-1.10.2.min.js"></script>
	<title>Top 10 Weather Data</title>
</head>
<body>
<?= "API Speed: " . number_format($data['time'], 3) . 's'; ?>
<h1><?= $data['h1'] ?></h1>
<div class="content">
	<? $selfUrl = $_SERVER['PHP_SELF']; ?>
	<form action="<?php echo $selfUrl; ?>" method="POST">
		<table class="styled-select">
			<!--<form action="/index.php" method="POST">-->
			<tr>
				<td>
					<label for="city">Select city</label>
				</td>
				<td>
					<select name="city" id="city">
						<?php $selectVal = $data['selectedCity'];
						foreach ($data['cityOptions'] as $cityKey => $cityName) {
							$selected = ($selectVal === $cityKey) ? ' selected="selected"' : '';?>
							<option value="<?= $cityKey ?>" <?= $selected ?>><?= $cityName ?></option>
						<?php
						} ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<label for="units">Select unit</label>
				</td>
				<td>
					<select name="units" id="units" onchange="this.form.submit()">
						<?php $selectVal = $data['selectedUnit'];
						foreach ($data['unitOptions'] as $unitKey => $unitName) {
							$selected = ($selectVal === $unitKey) ? ' selected="selected"' : '';?>
							<option value="<?= $unitKey ?>" <?= $selected ?>><?= $unitName ?></option>
						<?php
						} ?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" value="Submit" class="submit">
				</td>
			</tr>
		</table>
	</form>

	<?
	if($data['selectedUnit'] == 'metric') {
		$formatTemp = 'C';
		$formatWind = 'm/s';
	} else {
		$formatTemp = 'F';
		$formatWind = 'mph';
	}
	?>

	<table>
		<tr>
			<td colspan="2"><?= date('d/m/y @ H:m') ?></td>
		</tr>
		<tr>
			<td>Sunrise</td>
			<td><?= date('H:m', $data['result']->sys->sunrise) ?></td>
		</tr>
		<tr>
			<td>Sunset</td>
			<td><?= date('H:m', $data['result']->sys->sunset) ?></td>
		</tr>
		<tr>
			<td class="none"></td>
		</tr>

		<tr>
			<td>City</td>
			<td><?= $data['result']->name . ', ' . $data['result']->sys->country ?></td>
		</tr>
		<?    $coords = $data['result']->coord->lat . '&deg, ' . $data['result']->coord->lon . '&deg';
		$linker = "http://maps.google.com/?q=" . $coords; ?>
		<tr>
			<td>Latitude / Longitude</td>
			<td><a target="_blank" href="<?= $linker ?>"><?= $coords ?></a></td>
		</tr>
		<!--<tr><td>Latitude / Longitude</td><td><?= $coords ?></td></tr>-->
		<tr>
			<td>Description</td>
			<td><?= ucwords($data['result']->weather[0]->description) ?></td>
		</tr>
		<tr>
			<td class="none"></td>
		</tr>


		<tr>
			<td>Temperature</td>
			<td><?= number_format($data['result']->main->temp, 2) ?>&deg<?= $formatTemp ?></td>
		</tr>
		<tr>
			<td>Min Temperature</td>
			<td><?= number_format($data['result']->main->temp_min, 2) ?>&deg<?= $formatTemp ?></td>
		</tr>
		<tr>
			<td>Max Temperature</td>
			<td><?= number_format($data['result']->main->temp_max, 2) ?>&deg<?= $formatTemp ?></td>
		</tr>
		<tr>
			<td class="none"></td>
		</tr>

		<tr>
			<td>Humidity</td>
			<td><?= $data['result']->main->humidity ?>%</td>
		</tr>
		<br>
		<tr>
			<td>Wind</td>
			<td><?= number_format($data['result']->wind->speed, 1) . ' ' . $formatWind ?></td>
		</tr>
	</table>
	<br>

<table>
	<tr>
		<td>
			<img href="#info" src="../../resource/images/info.PNG" onclick="$('#info').toggle()" />
			<div id="info" style="display:none">
			Additional you can enter this after the url<br><br>
			A city has to be a valid city [cityname,country codes]<br>
			Units have to be enter as followed [metric] or [imperial]<br><br>

			For example:<br>
			<a href="?city=paris,fr&unit=metric">?city=paris,fr&unit=metric</a><br>
			<a href="?city=berlin,de&units=imperial">?city=berlin,de&units=imperial</a>
			</div>
		</td>
	</tr>
</table>

</div>

</body>
</html>
