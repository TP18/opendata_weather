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


class IndexController
{


	/**
	 * @var
	 */
	private $parameters;


	public $viewData;


	//public $exe;

	public function __construct($parameters)
	{
		$this->parameters = $parameters;
	}


	/**
	 * @return mixed
	 */
	public function indexAction()
	{
		/******************************************************************* muss noch angeschaut werden
		 * foreach ($this->parameters as $parameterValue) {
		 * var_dump($parameterValue);
		 * $search = '.';
		 * $replace = ',';
		 * str_replace($search, $replace, $parameterValue);
		 * }
		 **/
		strip_tags($this->parameters['city']); //strips all tags
		htmlentities($this->parameters['city'], ENT_QUOTES);
		iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $this->parameters['city']);

		$jsonParser = new JSONParser($this->parameters['city'], $this->parameters['units']);
		$jsonData = $jsonParser->readJSONFile();

		new Exceptions($this->parameters['controller'], $this->parameters['action']);

		/**$this->exe = array(
		 * 'validController' => $validPara->validController($this->parameters),
		 * 'validAction' => $validPara->validAction($this->parameters)
		 * );*/

		$this->viewData = array(
			'h1' => 'Top 10 Weather Data',
			'result' => $jsonData,
			'cityOptions' => $jsonParser->getCityOptions(),
			'selectedCity' => $jsonParser->getSelectedCity(),
			'unitOptions' => $jsonParser->getUnitOptions(),
			'selectedUnit' => $jsonParser->getSelectedUnit(),
			'time' => $jsonParser->getTime(),
			'icon' => $jsonParser->getImage()
		);

		return include(PATH_VIEW . 'index.php');
	}
}
