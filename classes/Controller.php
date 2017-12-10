<?php

abstract class Controller{

	protected $resquest;
	protected $action;

	public function __construct ($action, $resquest){
		$this->action = $action;
		$this->resquest = $resquest;
	}

	public function executeAction(){
		return $this->{$this->action}();
	}

	protected function returnView($viewModel, $fullView){
		$view = 'views/' . get_class($this). '/'. $this->action. '.php';

		if ($fullView) {
			require('views/main.php');
		}else{
			require($view);
		}
	}
}