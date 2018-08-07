<?

// SHOPRENTER ID GENERALO

require_once ("../config/config.php");
require_once ("../classes/connect.class.php");
require_once ("../classes/functions.class.php");

$db = new connect_db();
$func = new functions();

if (!$db->connect(DB_HOST, DB_USER, DB_PW)) die("database connect error: ".$db->error);
if (!$db->select_db(DB_DB)) die("database select error: ".$db->error);

$j=0;
for ($j=1; $j<=8000; $j++)	{
	
		
		$sql = 'SELECT id_termek, SUM(keszlet_1) as kkk FROM vonalkodok WHERE id_termek='.$j.' AND aktiv=1';

		$query = mysql_query($sql);

		
		while ($row = mysql_fetch_assoc($query))	{
			
			if (($row['kkk']<1) && (!empty($row['id_termek'])))	{
				$query2 = 'UPDATE termekek SET aktiv=0 WHERE id='.$row['id_termek'];
				//echo $j.' : '.$row['keszlet'].'<br />';
				
				echo $query2.'<br />';
			}
					
			/*$query2 = 'UPDATE vonalkodok 
					   SET id_shoprenter="'.$id_shoprenter.'"
					   WHERE id_vonalkod='.$row['id_vonalkod'];*/
					   
			
			
			/*mysql_query("SET AUTOCOMMIT=0");
			mysql_query("START TRANSACTION");
			
			if (mysql_query($query2))	{
				mysql_query("COMMIT");
				echo '<div class="green_box">OK: : '.$id_shoprenter.' &#x2714;</div>';
			}

			else	{
			mysql_query("ROLLBACK");
			echo '<div class="red_box">HIBA: '.$id_shoprenter.' X</div>';
			}*/
		}
	}