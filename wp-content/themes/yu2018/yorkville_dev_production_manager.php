<?php

	$dev_mode = false;
	$YORKVILLE = "NOT_SET";
	
	if (strpos($_SERVER['SERVER_NAME'], 'yorkvilleu.dev') !== false) {
		$dev_mode = true;
	}

	if($dev_mode){
		$YORKVILLE=[
			'home'=>'yorkvilleu.dev',
			'my'=>'my.yorkvilleu.dev',
			'courses'=>'courses.yorkvilleu.dev',
			'myprogram'=>'myprogram.yorkvilleu.dev',
			'library'=>'library.yorkvilleu.dev',
			'ontariolibrary'=>'ontariolibrary.yorkvilleu.dev',
			'askyu'=>'askyu.yorkvilleu.dev',
			'technology'=>'technology.yorkvilleu.dev',
		];
	}else{
		$YORKVILLE=[
			'home'=>'azure.yorkvilleu.ca',
			'my'=>'my.yorkvilleu.ca',
			'courses'=>'courses.yorkvilleu.ca',
			'myprogram'=>'myprogram.yorkvilleu.ca',
			'library'=>'library.yorkvilleu.ca',
			'ontariolibrary'=>'ontariolibrary.yorkvilleu.ca',
			'askyu'=>'askyu.azure.yorkvilleu.ca',
			'technology'=>'technology.yorkvilleu.ca',
		];
	}

?>