<?php

namespace Snowflake\OpenData\Model\Parser;

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
 * @author    Thomas Petersen <tpetersen@snowflake.ch>
 *
 * Class JSONParser
 * @package   Snowflake\OpenData\Model\Parser
 */
class JSONParser
{


	/**
	 * @var array
	 */
	private $cities = array(
		'Zurich,ch'       => 'Zurich',
		'Johannesburg,za' => 'Johannesburg',
		'Cape,za'         => 'Cape Town',
		'Maputo,mz'       => 'Maputo',
		'London,uk'       => 'London',
		'Stockholm,se'    => 'Stockholm',
		'Ottawa,ca'       => 'Ottawa',
		'ny,us'           => 'New York',
		'Sydney,au'       => 'Sydney',
		'Tokyo,jp'        => 'Tokyo'
	);


	/**
	 * @var array
	 */
	private $units = array(
		'metric'   => 'Metric',
		'imperial' => 'Imperial',
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
	 * @param	string	$city
	 * @return	string
	 */
	protected function isValidCity($city)
	{
		$pattern = '/^[A-Z]+[\,]{1}[A-Z]{2}$/i';
		return $validCity = preg_match($pattern, $city);
	}


	/**
	 * @param	string	$unit
	 * @return	string
	 */
	protected function isValidUnit($unit)
	{
		$pattern = '/^(imperial|metric)$/i';
		return $validUnits = preg_match($pattern, $unit);
	}


	/**
	 * @param string $city
	 */
	public function setValidCity($city)
	{
		if ($this->isValidCity($city) == true) {
			$this->city = $city;
		}
	}


	/**
	 * @param string $unit
	 */
	public function setValidUnit($unit)
	{
		if ($this->isValidUnit($unit) == true) {
			$this->unit = $unit;
		}
	}


	/**
	 * @param	string	$city
	 * @param 	string	$unit
	 * @return	string
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
	 * @return array
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


	/**
	 * @return string
	 */
	public function getImage()
	{
		$iconUrl = 'http://openweathermap.org/img/w/';
		$iconUrl .= $this->result->weather[0]->icon . '.png';
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
}
