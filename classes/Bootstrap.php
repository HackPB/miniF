<?php
class Bootstrap {
	private $controller;
	private $action;
	private $request;

	public function __construct ($request){
		$this->request = $request;
		if($this->request['controller'] ==""){
			$this->controller = 'home';
		}else{
			$this->controller = $this->request['controller'];
		}
		if($this->request['action'] == ""){
			$this->action = 'index';
		}else{
			$this->action = $this->request['action'];
		}

		//echo $this->controller; //test where you are (controler)
		//echo $this->action;//test where you are (action)
	}

	public function createController(){
		//check class
		if(class_exists($this->controller)){
			$parents = class_parents($this->controller);
			//check if is extended
			if(in_array("Controller", $parents)){
				if(method_exists($this->controller, $this->action)){
					return new $this->controller($this->action, $this->request);
				}else{
					//method not exists
					echo "<h1>Method not exists</h1>";
					return;
				}
			}else{
				//base controller not found
				echo "<h1>base controller not found</h1>";
				return;
			}
		}else{
			//controller class not found
			echo "<h1>Controller class not found</h1>";
			return;
		}
	} 
}

?>