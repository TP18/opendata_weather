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
class Exceptions extends Exception
{
	private $controller;
	private $controllers = array(
		'index',
		'test',
		);

	private $action;
	private $actions = array(
	'index',
	'test',
	);

	public function __construct($controller, $action)
	{
		//controller
		if (empty($controller)) {
			$controller = 'index';
		}

		if (in_array($controller, $this->controllers)) {
			$this->controller = $controller;
		}

		try {
			if (!in_array($controller, $this->controllers)) {// hier muss $parameters['controller'] stehen. $contoller macht keinen Sinn
				$error = 'Not a valid controller';
				throw new Exception($error);
			}
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), '<br><br>';
		}


		//action
		if (empty($action)) {
			$action = 'index';
		}

		if (in_array($action, $this->actions)) {
			$this->action = $action;
		}

		try {
			if (!in_array($action, $this->actions)) {// hier muss $parameters['controller'] stehen. $contoller macht keinen Sinn
				$error = 'Not a valid action';
				throw new Exception($error);
			}
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), '<br><br>';
		}
	}


/**
	public function validAction($action)
	{

		$action = 'index';
		if (empty($parameters['action'])) {
			$parameters['action'] = 'index';
		}

		if (in_array($parameters['action'], $this->actions)) {
			$action = $parameters['action'];
		}

		try {
			if (!in_array($parameters['action'], $this->actions)) {
				$error = 'Not a valid action';
				throw new Exception($error);
			}
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), '<br><br>';
		}
	}**/
}
