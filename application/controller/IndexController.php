<?php
namespace Snowflake\OpenData\Controller;

use Snowflake\OpenData\Model\Parser\JSONParser;
use Snowflake\OpenData\Model\Exceptions;

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
 * Class IndexController
 * @package   Snowflake\OpenData\Controller
 */
class IndexController
{


	/**
	 * @var
	 */
	private $parameters;


	/**
	 * @var
	 */
	public $viewData;


	/**
	 * @param $parameters
	 */
	public function __construct($parameters)
	{
		$this->parameters = $parameters;
	}


	/**
	 * @return mixed
	 */
	public function indexAction()
	{
		strip_tags($this->parameters['city']); //strips all tags
		htmlentities($this->parameters['city'], ENT_QUOTES);
		iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $this->parameters['city']);

		$jsonParser = new JSONParser($this->parameters['city'], $this->parameters['units'], $this->parameters['lang']);
		$jsonData = $jsonParser->readJSONFile();
		$lang = $jsonParser->getLanguage();

		switch ($lang) {
			case 'de':
				$language = file_get_contents('./local/de.json');
				break;
			case 'fr':
				$language = file_get_contents('./local/fr.json');
				break;
			default:
				$language = file_get_contents('./local/en.json');
		}

		$language = json_decode($language, true);
		new Exceptions($this->parameters['controller'], $this->parameters['action']);

		$this->viewData = array(
			'h1' => 'Top 10 Weather Data',
			'result' => $jsonData,
			'language' => $language,
			'cityOptions' => $jsonParser->getCityOptions(),
			'selectedCity' => $jsonParser->getSelectedCity(),
			'unitOptions' => $jsonParser->getUnitOptions(),
			'selectedUnit' => $jsonParser->getSelectedUnit(),
			'time' => $jsonParser->getTime(),
			'icon' => $jsonParser->getImage()
		);

		return include(PATH_VIEW . 'index.phtml');
	}
}
