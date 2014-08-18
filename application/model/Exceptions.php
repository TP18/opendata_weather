<?php

namespace TPetersen\OpenData\Model;

use Exception;

/**
 * @author    Thomas Petersen
 *
 * Class Exceptions
 * @package   TPetersen\OpenData\Model
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
		'forecast',
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
