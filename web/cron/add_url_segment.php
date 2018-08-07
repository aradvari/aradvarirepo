<?
///// AUTOFILL URL_SEGMENT
 
require_once ("../config/config.php");
require_once ("../classes/connect.class.php");
require_once ("../classes/functions.class.php");

$db = new connect_db();
$func = new functions();

if (!$db->connect(DB_HOST, DB_USER, DB_PW)) die("database connect error: ".$db->error);
if (!$db->select_db(DB_DB)) die("database select error: ".$db->error);


mysql_query("UPDATE kategoriak set url_segment = toSlug2(megnevezes) WHERE url_segment IS NULL");

mysql_query("UPDATE markak set url_segment = toSlug2(markanev) WHERE url_segment IS NULL");

mysql_query("UPDATE termekek set url_segment = toSlug2(concat(IFNULL(termeknev, ''), '-', IFNULL(szin, ''), '-', id)) WHERE url_segment IS NULL");

mysql_query("UPDATE vonalkodok set url_segment = toSlug2(megnevezes) WHERE url_segment IS NULL");