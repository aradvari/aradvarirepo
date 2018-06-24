<?

// SHOPRENTER ID GENERALO

require_once ("../config/config.php");
require_once ("../classes/connect.class.php");
require_once ("../classes/functions.class.php");

$db = new connect_db();
$func = new functions();

if (!$db->connect(DB_HOST, DB_USER, DB_PW)) die("database connect error: ".$db->error);
if (!$db->select_db(DB_DB)) die("database select error: ".$db->error);

$carryover = array (
			4454,4455,5358,6068,6733,7127,7132,6058,6174,4437,4436,4435,1579,4511,5807,7151,5487,7041,2969,3013,7092,6733,4709,4476
			);
foreach ($carryover as $carryover_id) {
	
		$sql = 'SELECT * FROM vonalkodok WHERE id_termek='.$carryover_id.' ORDER BY megnevezes';

		$query = mysql_query($sql);

		$i=0;
		while ($row = mysql_fetch_assoc($query))	{
			$i++;
			
			// ZEROFILL
			$i_zerofill = str_pad($i, 2, "0", STR_PAD_LEFT);
			$id_shoprenter = $row['id_termek'].'_'.$i_zerofill;	
			//$id_shoprenter = $row['id_termek'].'_'.$i;
			
			$query2 = 'UPDATE vonalkodok 
					   SET id_shoprenter="'.$id_shoprenter.'"
					   WHERE id_vonalkod='.$row['id_vonalkod'];
					   
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
	}