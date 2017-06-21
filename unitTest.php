<?php
require_once "apiTest.php";

$apiTest = new ApiTest();

$dataArray = [
	'flag' => 'true',
	'msg' => 'post success!',
	'data' => [
		'name' => 'chenrongrong',
		'pw' => '123456',
	],
];

$apiTest->setData($dataArray);

$apiTest->outputData();