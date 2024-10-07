<?php

define('HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PWD', '');
define('DB_NAME', 'meals_and_tips');
define('DIR_PATH', __DIR__);
define('FILE_PATH', __FILE__);
define('TITLE', 'Meals and Tips');
define('FOLDER', 'meals_and_tips');
define('CURRENCY', 'SAR ');
define('MINUTES_DIFF', 60);

date_default_timezone_set('Asia/Karachi');

$host = $_SERVER['HTTP_HOST'];
define('SITE_URL', ($host == 'localhost') ? 'http://' . $host . '/' . FOLDER : 'https://' . $host . '/' . FOLDER);
