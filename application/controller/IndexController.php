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
 * @author	Thomas Petersen <support@snowflake.ch>
 * @package	TYPO3
 * @subpackage	tx_YOUREXT
 */
class IndexController
{
	private $parameters;

	public $viewData;

	public $Exe;

	public function __construct($paramters)
	{
		$this->parameters = $paramters;
	}

	public function indexAction()
	{
		$jsonParser = new JSONParser($this->parameters['city'], $this->parameters['units']);
		$jsonData = $jsonParser->readJSONFile();

		/**$valid = new Exceptions($this->parameters['controller'], $this->parameters['action']);*/

		$this->Exe = array(
					/**'validController' => $valid->validController(),
					'validAction' => $valid->validAction()*/
				);

		$this->viewData = array(
			'h1' => 'Top 10 Weather Data',
			'result' => $jsonData,
			'cityOptions' => $jsonParser->getCityOptions(),
			'selectedCity' => $jsonParser->getSelectedCity(),
			'unitOptions' => $jsonParser->getUnitOptions(),
			'selectedUnit' => $jsonParser->getSelectedUnit(),
			'time' => $jsonParser->getTime()
		);

		return include(PATH_VIEW . 'index.php');
	}
}
