<?php

namespace Snowflake\OpenData\Model;

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
 * Class Exceptions
 * @package   Snowflake\OpenData\Model
 */
class Exceptions extends \Exception
{


	/**
	 * @var string
	 */
	private $controller = 'index';


	/**
	 * @var array
	 */
	private $controllers = array(
		'index',
		'test',
	);


	/**
	 * @var string
	 */
	private $action = 'index';


	/**
	 * @var array
	 */
	private $actions = array(
		'index',
		'test',
	);


	/**
	 * @param string $controller
	 * @param string $action
	 */
	public function __construct($controller = 'index', $action = 'index')
	{
		$this->validController($controller);
		$this->validAction($action);
	}


	/**
	 * @param string $controller
	 */
	public function validController($controller)
	{
		//controller
		if (empty($controller)) {
			$controller = 'index';
		}

		if (in_array($controller, $this->controllers)) {
			$this->controller = $controller;
		}

		try {
			if (!in_array(
							$controller,
							$this->controllers
			)
			) { // hier muss $parameters['controller'] stehen. $contoller macht keinen Sinn
				$error = 'Not a valid controller';
				throw new Exception($error);
			}
		} catch (Exception $e) {
			echo 'Caught exception: ', $e->getMessage(), '<br><br>';
		}
	}


	/**
	 * @param string $action
	 */
	public function validAction($action)
	{
		//action
		if (empty($action)) {
			$action = 'index';
		}

		if (in_array($action, $this->actions)) {
			$this->action = $action;
		}

		try {
			if (!in_array(
							$action,
							$this->actions
			)
			) { // hier muss $parameters['controller'] stehen. $contoller macht keinen Sinn
				$error = 'Not a valid action';
				throw new Exception($error);
			}
		} catch (Exception $e) {
			echo 'Caught exception: ', $e->getMessage(), '<br><br>';
		}
	}
}
