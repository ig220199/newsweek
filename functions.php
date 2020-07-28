<?php

	function redirect($dest){
		header("Location: ".$dest);
		exit;
	}

	function checkSaver($name, $type,  $value = 'NaN'){
		if(isset($_SESSION["fill"][$name])){
			switch ($type) {
				case 'input':
					echo 'value="'.$_SESSION["fill"][$name].'"';
					break;
				case 'textarea':
					echo $_SESSION["fill"][$name];
					break;
				case 'checkbox':
					if($_SESSION["fill"][$name] == 1){
						echo "checked";
					}
					break;
				case 'select':
					if($_SESSION["fill"][$name] == $value){
						echo 'selected';
					}
					break;		
			}
		}
	}

	function sanitize($data){
		$data = htmlspecialchars(strip_tags($data), ENT_QUOTES, 'UTF-8');
		return $data;
	}

	function format_datum($datetime){
		$date = str_replace("-", "/", explode(" ", $datetime)[0]);
		$time = explode(":", explode(" ", $datetime)[1]);
		unset($time[2]);
		$time = implode(":", $time);

		return $date." ".$time;
	}

?>