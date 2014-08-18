<?php
namespace TPetersen\OpenData\Model\Validator;

use TPetersen\OpenData\Model\Exception\InvalidControllerOrActionException;

/**
 * @author    Thomas Petersen
 *
 * Class ControllerActionValidator
 * @package   TPetersen\OpenData\Model\Validator
 */
class ControllerActionValidator
{


	/**
	 * @var string
	 */
	private $controller = DEFAULT_CONTROLLER;


	/**
	 * @var array
	 */
	private $validControllers = array(
		'index'
	);


	/**
	 * @var string
	 */
	private $action = DEFAULT_ACTION;


	/**
	 * @var array
	 */
	private $validActions = array(
		'index',
		'forecast'
	);


	/**
	 * @param array $parameters
	 */
	public function __construct(array $parameters)
	{
		try {
			if (isset($parameters['controller'])) {
				$this->setValidController($parameters['controller']);
			}
			if (isset($parameters['action'])) {
				$this->setValidAction($parameters['action']);
			}
		} catch (InvalidControllerOrActionException $e) {
			$this->controller = DEFAULT_CONTROLLER;
			$this->action = DEFAULT_ACTION;
		}
	}


	/**
	 * @param	string	$controller
	 */
	private function setValidController($controller)
	{
		if (in_array($controller, $this->validControllers)) {
			$this->controller = $controller;
		}
	}


	/**
	 * @param	string	$action
	 */
	public function setValidAction($action)
	{
		if (in_array($action, $this->validActions)) {
			$this->action = $action;
		}
	}


	/**
	 * @return string
	 */
	public function getControllerClassName()
	{
		$controllerClassName = 'TPetersen\\OpenData\\Controller\\' . ucfirst($this->controller) . 'Controller'; //IndexController

		return $controllerClassName;
	}


	/**
	 * @return string
	 */
	public function getAction()
	{
		$controllerAction = $this->action . 'Action'; //indexAction
		return $controllerAction;
	}
}
