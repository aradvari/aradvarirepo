<?
error_reporting(1);

// SHOPRENTER ID GENERALO

require_once ("../config/config.php");
require_once ("../classes/connect.class.php");
require_once ("../classes/functions.class.php");

$db = new connect_db();
$func = new functions();

if (!$db->connect(DB_HOST, DB_USER, DB_PW)) die("database connect error: ".$db->error);
if (!$db->select_db(DB_DB)) die("database select error: ".$db->error);

// default id_shoprenter
$next_id = 1;

// query keszlet > 0 w/o id_shoprenter
$sql_id_shoprenter_check = 'SELECT * FROM vonalkodok WHERE keszlet_1>0 AND id_shoprenter IS NULL ORDER BY id_termek,megnevezes';	//igy fasza a megnevezes, meret szerinti sorrendben

$query_id_shoprenter_check = mysql_query($sql_id_shoprenter_check);		


while ($row = mysql_fetch_assoc($query_id_shoprenter_check))	{
	
	// query last/max id_shoprenter
	$query_max_id_shoprenter = mysql_fetch_array(mysql_query('SELECT MAX(id_shoprenter) FROM vonalkodok WHERE id_termek='.$row['id_termek']));
				
	$max_id_shoprenter = explode('_', $query_max_id_shoprenter[0]);
	
	// next id_shoprenter
	$next_id = $max_id_shoprenter[1]+1;
	
	// zerofill pl.: 01 02 03 04
	$i_zerofill = str_pad($next_id, 2, "0", STR_PAD_LEFT);			
	$id_shoprenter = $row['id_termek'].'_'.$i_zerofill;		
	
	// add id_shoprenter
	$query2 = 'UPDATE vonalkodok SET id_shoprenter="'.$id_shoprenter.'" WHERE id_vonalkod='.$row['id_vonalkod'];
	
	echo $query2.'<br />';
	
	mysql_query("SET AUTOCOMMIT=0");
	mysql_query("START TRANSACTION");
	
	if (mysql_query($query2))	{
		mysql_query("COMMIT");
		echo '<div class="green_box">OK: : '.$id_shoprenter.' &#x2714;</div>';
	}

	else	{
	mysql_query("ROLLBACK");
	echo '<div class="red_box">HIBA: '.$id_shoprenter.' X</div>';
	}
	
}