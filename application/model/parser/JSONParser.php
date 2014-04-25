<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 snowflake productions gmbh <support@snowflake.ch>
 *  All rights reserved
 *
 *  The project is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 ***************************************************************/

/**
 *
 * @author    Thomas Petersen <tpetersen@snowflake.ch>
 *
 */
class JSONParser
{


	/**
	 * @var array
	 */
	private $cities = array(
		"Zurich,ch"       => "Zurich",
		"Johannesburg,za" => "Johannesburg",
		"Cape,za"         => "Cape Town",
		"Maputo,mz"       => "Maputo",
		"London,uk"       => "London",
		"Stockholm,se"    => "Stockholm",
		"Ottawa,ca"       => "Ottawa",
		"ny,us"           => "New York",
		"Sydney,au"       => "Sydney",
		"Tokyo,jp"        => "Tokyo"
	);


	/**
	 * @var array
	 */
	private $units = array(
		"metric"   => "Metric",
		"imperial" => "Imperial",
	);


	/**
	 * @var string
	 */
	private $city = 'Zurich,ch';


	/**
	 * @var string
	 */
	private $unit = 'metric';


	/**
	 * @var
	 */
	private $result;


	/**
	 * @var
	 */
	public $time;


	/**
	 * @param string $city
	 * @param string $unit
	 */
	public function __construct($city = 'Zurich,ch', $unit = 'metric')
	{
		$this->setValidCity($city);
		$this->setValidUnit($unit);
	}


	/**
	 * @param $city
	 * @return int
	 */
	protected function isValidCity($city)
	{
		$pattern = '/^[A-Z]+[\,]{1}[A-Z]{2}$/i';
		return $validCity = preg_match($pattern, $city);
	}


	/**
	 * @param $unit
	 * @return int
	 */
	protected function isValidUnit($unit)
	{
		$pattern = '/^(imperial|metric)$/i';
		return $validUnits = preg_match($pattern, $unit);
	}


	/**
	 * @param $city
	 */
	public function setValidCity($city)
	{
		if ($this->isValidCity($city) == true) {
			$this->city = $city;
		}
	}


	/**
	 * @param $unit
	 */
	public function setValidUnit($unit)
	{
		if ($this->isValidUnit($unit) == true) {
			$this->unit = $unit;
		}
	}


	/**
	 * @param $city
	 * @param $unit
	 * @return string
	 */
	private function getUrl($city, $unit)
	{
		if (isset($city) && isset($unit)) {
			$url = 'http://api.openweathermap.org/data/2.5/weather?q=';
			$url .= $city . '&units=';
			$url .= $unit;
		} else {
			$url = 'http://api.openweathermap.org/data/2.5/weather?q=Zurich,ch&units=metric';
			//?city=Munich,de&units=imperials
		}

		return $url;
	}


	/**
	 * @return    Array
	 */
	public function readJSONFile()
	{
		$time_start = microtime(true);
		$content = file_get_contents($this->getUrl($this->city, $this->unit));
		$time_end = microtime(true);
		try {
			if ($content == false) { // hier muss $parameters['controller'] stehen. $contoller macht keinen Sinn
				$error = 'Not a valid URL';
				throw new Exception($error);
			}
		} catch (Exception $e) {
			echo 'Caught exception: ', $e->getMessage(), '<br><br>';
		}
		$result = json_decode($content);

		$time = $time_end - $time_start;
		$this->time = $time;

		$this->result = $result;
		return $result;
	}


	public function getImage()
	{
		$iconUrl = "http://openweathermap.org/img/w/";
		$iconUrl .= $this->result->weather[0]->icon . ".png";
		return $iconUrl;
	}


	/**
	 * @return array
	 */
	public function getCityOptions()
	{
		return $this->cities;
	}


	/**
	 * @return string
	 */
	public function getSelectedCity()
	{
		return $this->city;
	}


	/**
	 * @return array
	 */
	public function getUnitOptions()
	{
		return $this->units;
	}


	/**
	 * @return string
	 */
	public function getSelectedUnit()
	{
		return $this->unit;
	}


	/**
	 * @return mixed
	 */
	public function getTime()
	{
		return $this->time;
	}

	/**
	 * public function selecter()
	 * {
	 * $citypicker = '<form action="/index.php" method="POST">';
	 * $citypicker .= '<label for="city">Select city: </label>';
	 * $citypicker .= '<select name="city" id="city">';
	 * $citypicker .= $this->getCityOptions();
	 * $citypicker .= '</select>';
	 * $citypicker .= '    <label for="units">Select unit: </label>';
	 * $citypicker .= '    <select name="units" id="units">';
	 * $citypicker .= $this->getUnitOptions();
	 * $citypicker .= '    </select>';
	 * $citypicker .= '    <input type="submit" value="Submit"><br>';
	 * $citypicker .= '</form>';
	 * return $citypicker;
	 * }*/

	/**
	 * @return    Array
	 */
	/**
	 * public function getOutput()
	 * {
	 * if ($_POST['units'] == 'units=metric') {
	 * $formatTemp = 'C';
	 * $formatWind = 'm/s';
	 * } else {
	 * $formatTemp = 'F';
	 * $formatWind = 'mph';
	 * }
	 *
	 * $unit = '<table><tr><td colspan="2">' . date('d/m/y @ H:m') .  '</td></tr><br>';
	 * $unit .= '<tr><td>Sunrise:</td><td>' . date('H:m', $this->$result->sys->sunrise) .  '</td></tr><br>';
	 * $unit .= '<tr><td>Sunset:</td><td>' . date('H:m', $this->$result->sys->sunset) .  '</td></tr>';
	 * $unit .= '<tr><td class="none"></td></tr>';
	 * $unit .= '<tr><td>City:</td><td>' . $this->$result->name.', ' . $this->$result->sys->country . '</td></tr>';
	 * $unit .= '<tr><td>Latitude / Longitude</td><td>' . $this->$result->coord->lat . '&deg, ' . $this->$result->coord->lon . '&deg</td></tr>';
	 * $unit .= '<tr><td>Description:</td><td>' . $this->$result->weather[0]->description . '</td></tr>';
	 * $unit .= '<tr><td class="none"></td></tr>';
	 * $unit .= '<tr><td>Temperature:</td><td>' . $this->$result->main->temp . '&deg' . $formatTemp . '</td></tr>';
	 * $unit .= '<tr><td>Min Temperature:</td><td>' . $this->$result->main->temp_min . '&deg' . $formatTemp . '</td></tr>';
	 * $unit .= '<tr><td>Max Temperature:</td><td>' . $this->$result->main->temp_max . '&deg' . $formatTemp . '</td></tr>';
	 * $unit .= '<tr><td class="none"></td></tr>';
	 * $unit .= '<tr><td>Humidity:</td><td>' . $this->$result->main->humidity .  '%</td></tr><br>';
	 * $unit .= '<tr><td>Wind:</td><td>' . number_format($this->$result->wind->speed, 1) . ' ' . $formatWind . '</td></tr></table><br>';
	 *
	 * return $unit;
	 * }*/

	/**
	 * @return    Array
	 */
	/**public function mappingOutput()
	 * {
	 * $mappings = array(
	 * 'coord' => array(
	 * 'lat' => 'Longitude'
	 * ),
	 * 'main' => array(
	 * 'temp' => 'Temperature',
	 * 'temp_min' => 'Min Temperature',
	 * 'temp_max' => 'Max Temperature',
	 * 'humidity' => 'Humidity'
	 * )
	 * );
	 *
	 * $html = '<li>City: '. $this->result->name;
	 *
	 * foreach ($mappings as $section => $mapping) {
	 * foreach ($mappings[$section] as $key => $value) {
	 * $html .= '<li>'. $value . ': '. $this->result->$section->$key;
	 * }
	 * }
	 * return $html;
	 * }*/
}
