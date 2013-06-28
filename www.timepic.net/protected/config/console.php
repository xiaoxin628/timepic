<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'TimePicConsole',
	// application components
	'components'=>array(
		
		'db'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=localhost;dbname=timepic',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'lishuzu511',
			'charset' => 'utf8',
			'tablePrefix' => 'tp_'
		),
	),
);