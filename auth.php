<?php

Class Auth{

	static function isLogged(){
		if (isset($_SESSION['auth']) && isset($_SESSION['auth']['login']) && isset($_SESSION['auth']['pass'])){
			return true;
		}
		else{
			return false;
		}
	}

}

?>