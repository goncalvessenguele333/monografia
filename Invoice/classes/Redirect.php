<?php
class Redirect{
	public static function to($location=null){
		if($location){
			if(is_numeric($location)){
				switch ($location) {
					case 404:
						header('HTTP/1.0 4040 Not Found');
						include'../includes/error/404.php';
						exit();
						break;					
					}
			}
			header('location:'.$location);
			exit();
		}
	}
	}
