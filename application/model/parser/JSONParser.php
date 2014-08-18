<?php

namespace TPetersen\OpenData\Model\Parser;

use Exception;

/**
 * @author    Thomas Petersen
 *
 * Class JSONParser
 * @package   TPetersen\OpenData\Model\Parser
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
	private function getUrl($url, $city, $unit, $lang)
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
	public function getCurrentWeather()
	{
		if (isset($this->city) && isset($this->unit)) {
			$url = 'http://api.openweathermap.org/data/2.5/weather?q=';
			$url .= $this->city . '&units=';
			$url .= $this->unit . '&lang=';
			$url .= $this->lang;
		} else {
			$url = 'http://api.openweathermap.org/data/2.5/weather?q=Zurich,ch&units=metric&lang=en';
		}

		$this->result = $this->decodeJSONData($this->readJSONFile($url));
		return $this->result;
	}


	/**
	 * @return array
	 */
	public function getForecastWeather()
	{
		if (isset($this->city) && isset($this->unit)) {
			$url = 'http://api.openweathermap.org/data/2.5/forecast/daily?q=';
			$url .= $this->city . '&units=';
			$url .= $this->unit . '&lang=';
			$url .= $this->lang . '&cnt=15';
		} else {
			$url = 'http://api.openweathermap.org/data/2.5/forecast/daily?q=Zurich,ch&units=metric&lang=en&cnt=15';
		}

		$response = $this->decodeJSONData($this->readJSONFile($url), true);

		foreach ($response['list'] as $singleDay) {
			$weatherData['date'][] = date("d.m.y", $singleDay['dt']);
			$weatherData['temp'][] = $singleDay['temp']['day'];
			if ($singleDay['rain'] != null) {
				$weatherData['rain'][] = $singleDay['rain'];
			} else {
				$weatherData['rain'][] = 0;
			}
		}

		$weatherData['cityName'] = $response['city']['name'];
		$weatherData['date'] = json_encode($weatherData['date'], JSON_HEX_TAG);
		$weatherData['temp'] = json_encode($weatherData['temp'], JSON_HEX_TAG);
		$weatherData['rain'] = json_encode($weatherData['rain'], JSON_HEX_TAG);
		return $weatherData;
//		return $this->result;
	}


	/**
	 * @param      $data
	 * @param bool $returnArray
	 * @return mixed
	 */
	public function decodeJSONData($data, $returnArray = false)
	{
		if ($returnArray) {
			return json_decode($data, true);
		}
		return json_decode($data);
	}


	/**
	 * @param $url
	 * @return mixed
	 */
	public function readJSONFile($url)
	{
		$time_start = microtime(true);
		$content = file_get_contents($url);
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

		return $content;
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
