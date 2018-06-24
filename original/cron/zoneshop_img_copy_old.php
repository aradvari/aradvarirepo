<?
ini_set('display_errors', '1');

// ZONESHOP IMAGE COPY -> ALLINONE
require_once ("../config/config.php");
require_once ("../classes/connect.class.php");
require_once ("../classes/functions.class.php");

$db = new connect_db();
$func = new functions();

//if (!$db->connect(DB_HOST, DB_USER, DB_PW)) die("database connect error: ".$db->error);
//if (!$db->select_db(DB_DB)) die("database select error: ".$db->error);

for ($i=7074; $i<=7074; $i++)	{
	
	$images_directory = '../'.$func->getHDir($i);
	$scanned_directory = scandir($images_directory);	
	
	foreach($scanned_directory as $index=>$image)	{
		if (strpos($image,'_large'))
			echo 'kép: '.$image.'<br />';
		}
	}



?>