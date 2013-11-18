<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 snowflake productions gmbh <support@snowflake.ch>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */

/**
 * Describe class here
 *
 * @author        Thomas Petersen <support@snowflake.ch>
 * @package       TYPO3
 * @subpackage    tx_YOUREXT
 */


class JSONParser
{
	private $cities = array(
		"Zurich,ch" => "Zurich",
		"Johannesburg,za" => "Johannesburg",
		"Cape,za" => "Cape Town",
		"London,uk" => "London",
		"Munich,de" => "Munich",
		"Stockholm,se" => "Stockholm",
		"Ottawa,ca" => "Ottawa",
		"ny,us" => "New York",
		"Sydney,au" => "Sydney",
		"Tokyo,jp" => "Tokyo"
	);

	private $units = array(
			"metric" => "Metric",
			"imperial" => "Imperial",
		);

	private $city;

	private $unit;

	private $result;

	private $time;

	public function __construct($city, $unit)
	{
		if (empty($city)) {
			$this->city = 'Zurich,ch';
		} else {
			$this->city = $city;
		}

		if (empty($unit)) {
			$this->unit = 'metric';
		} else {
			$this->unit = $unit;
		}
	}

	private function getUrl($city, $unit)
	{

	if (isset($city) && isset($unit)) {
		$url = 'http://api.openweathermap.org/data/2.5/weather?q=';
		$url .= $city . '&units=';
		$url .= $unit;
	} else {
		$url = 'http://api.openweathermap.org/data/2.5/weather?q=Zurich,ch&units=metric';
		//http://p2511-141-opendata.thpe.rz.snowflake.ch/test.php?city=munich,de&units=metric
	}
		return $url;
	}

	/**
	 * @return    Array
	 */
	public function readJSONFile()
	{
		$content = file_get_contents($this->getUrl($this->city, $this->unit));
		$result = json_decode($content);
		$this->result = $result;

	try {
			if ($content == false) {// hier muss $parameters['controller'] stehen. $contoller macht keinen Sinn
				$error = 'Not a valid URL';
				throw new Exception($error);
			}
	} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), '<br><br>';
	}

		return $result;
	}

	public function getCityOptions()
	{
		return $this->cities;
	}

	public function getSelectedCity()
	{
		//$selectVal = $this->city;
		return $this->city;
	}

	public function getUnitOptions()
	{
		return $this->units;
	}


	public function getSelectedUnit()
	{
		//$selectVal = $this->city;
		return $this->unit;
	}

	public function getTime()
	{
$time_start = microtime(true);
	file_get_contents($this->getUrl($this->city, $this->unit));
$time_end = microtime(true);
$time = $time_end - $time_start;
print_r("Speed: " . number_format($time, 5));
		$this->time = $time;
	}

	/**
	public function selecter()
	{
		$citypicker = '<form action="/index.php" method="POST">';
		$citypicker .= '<label for="city">Select city: </label>';
		$citypicker .= '<select name="city" id="city">';
		$citypicker .= $this->getCityOptions();
		$citypicker .= '</select>';
		$citypicker .= '	<label for="units">Select unit: </label>';
		$citypicker .= '	<select name="units" id="units">';
		$citypicker .= $this->getUnitOptions();
		$citypicker .= '	</select>';
		$citypicker .= '	<input type="submit" value="Submit"><br>';
		$citypicker .= '</form>';
		return $citypicker;
	}*/

	/**
	 * @return    Array
	 */
	/**
	public function getOutput()
	{
		if ($_POST['units'] == 'units=metric') {
			$formatTemp = 'C';
			$formatWind = 'm/s';
		} else {
			$formatTemp = 'F';
			$formatWind = 'mph';
		}

		$unit = '<table><tr><td colspan="2">' . date('d/m/y @ H:m') .  '</td></tr><br>';
		$unit .= '<tr><td>Sunrise:</td><td>' . date('H:m', $this->$result->sys->sunrise) .  '</td></tr><br>';
		$unit .= '<tr><td>Sunset:</td><td>' . date('H:m', $this->$result->sys->sunset) .  '</td></tr>';
		$unit .= '<tr><td class="none"></td></tr>';
		$unit .= '<tr><td>City:</td><td>' . $this->$result->name.', ' . $this->$result->sys->country . '</td></tr>';
		$unit .= '<tr><td>Latitude / Longitude</td><td>' . $this->$result->coord->lat . '&deg, ' . $this->$result->coord->lon . '&deg</td></tr>';
		$unit .= '<tr><td>Description:</td><td>' . $this->$result->weather[0]->description . '</td></tr>';
		$unit .= '<tr><td class="none"></td></tr>';
		$unit .= '<tr><td>Temperature:</td><td>' . $this->$result->main->temp . '&deg' . $formatTemp . '</td></tr>';
		$unit .= '<tr><td>Min Temperature:</td><td>' . $this->$result->main->temp_min . '&deg' . $formatTemp . '</td></tr>';
		$unit .= '<tr><td>Max Temperature:</td><td>' . $this->$result->main->temp_max . '&deg' . $formatTemp . '</td></tr>';
		$unit .= '<tr><td class="none"></td></tr>';
		$unit .= '<tr><td>Humidity:</td><td>' . $this->$result->main->humidity .  '%</td></tr><br>';
		$unit .= '<tr><td>Wind:</td><td>' . number_format($this->$result->wind->speed, 1) . ' ' . $formatWind . '</td></tr></table><br>';

		return $unit;
	}*/

	/**
	 * @return    Array
	 */
	/**public function mappingOutput()
	{
		$mappings = array(
			'coord' => array(
				'lat' => 'Longitude'
			),
			'main' => array(
				'temp' => 'Temperature',
				'temp_min' => 'Min Temperature',
				'temp_max' => 'Max Temperature',
				'humidity' => 'Humidity'
			)
		);

		$html = '<li>City: '. $this->result->name;

		foreach ($mappings as $section => $mapping) {
			foreach ($mappings[$section] as $key => $value) {
				$html .= '<li>'. $value . ': '. $this->result->$section->$key;
			}
		}
		return $html;
	}*/
}
