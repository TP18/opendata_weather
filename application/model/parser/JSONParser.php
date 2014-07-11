<?php

namespace Snowflake\OpenData\Model\Parser;

use Exception;

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
	 * @var array
	 */
	private $supportedLanguages = array(
		'en', 'ru', 'it', 'es', 'uk', 'de', 'pt', 'ro', 'pl', 'fi', 'nl', 'fr', 'bg', 'sv', 'zh_tw', 'zh', 'tr'
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
	 * @var string
	 */
	private $lang = 'en';


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
	 * @param string $lang
	 */
	public function __construct($city, $unit, $lang)
	{
		$this->setValidCity($city);
		$this->setValidUnit($unit);
		$this->setValidLanguage($lang);
	}


	/**
	 * @param	string	$city
	 * @return	string
	 */
	protected function isValidCity($city)
	{
		$pattern = '/^[A-Z]+[\,]{1}[A-Z]{2}$/i';

		if (preg_match($pattern, $city) === 1) {
			$content = file_get_contents('http://api.openweathermap.org/data/2.5/weather?q='.  $city);
			$content = json_decode($content);
			if ($content->cod === '404') {
				return false;
			}
		} else {
			return false;
		}
		return $city;
	}


	/**
	 * @param	string	$unit
	 * @return	string
	 */
	protected function isValidUnit($unit)
	{
		$pattern = '/^(imperial|metric)$/i';
		return preg_match($pattern, $unit);
	}


	/**
	 * @param	string	$lang
	 * @return	string
	 */
	protected function isValidLanguage($lang)
	{
		$lang = 'de';
		if (!isset($lang)) {
			$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		}

		if (in_array($lang, $this->supportedLanguages)) {
			return $lang;
		}
		return 'en';
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
	 * @param string $lang
	 */
	public function setValidLanguage($lang)
	{
		$this->lang = $this->isValidLanguage($lang);
	}


	/**
	 * @param	string	$city
	 * @param 	string	$unit
	 * @param 	string	$lang
	 * @return	string
	 */
	private function getUrl($city, $unit, $lang)
	{

		if (isset($city) && isset($unit)) {
			$url = 'http://api.openweathermap.org/data/2.5/weather?q=';
			$url .= $city . '&units=';
			$url .= $unit . '&lang=';
			$url .= $lang;
		} else {
			$url = 'http://api.openweathermap.org/data/2.5/weather?q=Zurich,ch&units=metric&lang=en';
		}

		return $url;
	}


	/**
	 * @return array
	 */
	public function readJSONFile()
	{
		$time_start = microtime(true);
		$content = file_get_contents($this->getUrl($this->city, $this->unit, $this->lang));
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


	/**
	 * @return string
	 */
	public function getLanguage()
	{
		return $this->lang;
	}
}
