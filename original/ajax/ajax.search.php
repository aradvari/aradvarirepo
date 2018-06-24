<?
require_once ("../config/config.php");
require_once ("../classes/connect.class.php");
require_once ("../classes/functions.class.php");

$func = new functions();
$conn = new connect_db();
$conn->connect(DB_HOST, DB_USER, DB_PW);
$conn->select_db(DB_DB);

$theCode = $_POST["code"];
$slicedCode = explode(" ", $theCode);

$sliceDB = count($slicedCode);
$sqlCode = "";
for($i = 0; $i < $sliceDB; $i++)
{
	if($slicedCode[$i] != "")
		$sqlCode .= " CONCAT(m.markanev, ' ', k.megnevezes, ' ', t.termeknev, ' ', t.cikkszam, ' ', t.szin) LIKE '%" . $slicedCode[$i] . "%' AND";
}

$sqlCode = substr($sqlCode, 0, -3);

$msql = mysql_query("SELECT t.id, m.markanev, t.termeknev, t.szin, t.kisker_ar, t.akcios_kisker_ar, k.megnevezes
		FROM termekek t
		LEFT JOIN vonalkodok v ON t.id=v.id_termek
		LEFT JOIN markak m ON t.markaid=m.id
		LEFT JOIN termek_kategoria_kapcs tkk ON (tkk.id_termekek = t.id) 
		LEFT JOIN kategoriak k ON tkk.id_kategoriak=k.id_kategoriak
		WHERE t.aktiv=1 AND v.keszlet_1>0 AND " . $sqlCode . " GROUP BY t.id");

$msq_cipos = mysql_query("SELECT t.id, t.fokep, m.markanev, t.termeknev, t.szin, t.kisker_ar, t.akcios_kisker_ar
		FROM termekek t
		LEFT JOIN vonalkodok v ON t.id=v.id_termek
		LEFT JOIN markak m ON t.markaid=m.id
		LEFT JOIN termek_kategoria_kapcs tkk ON (tkk.id_termekek = t.id) 
		LEFT JOIN kategoriak k ON tkk.id_kategoriak=k.id_kategoriak		
		WHERE t.aktiv=1 AND v.keszlet_1>0 AND " . $sqlCode . " AND tkk.id_kategoriak IN ('94', '95') GROUP BY t.id ORDER BY t.id DESC LIMIT 6");

$cipo_talalat = mysql_num_rows($msq_cipos);
$maradek = 6 - $cipo_talalat;

$msq_tobbi = mysql_query("SELECT t.id, t.fokep, m.markanev, t.termeknev, t.szin, t.kisker_ar, t.akcios_kisker_ar
		FROM termekek t
		LEFT JOIN vonalkodok v ON t.id=v.id_termek
		LEFT JOIN markak m ON t.markaid=m.id
		LEFT JOIN termek_kategoria_kapcs tkk ON (tkk.id_termekek = t.id) 
		LEFT JOIN kategoriak k ON tkk.id_kategoriak=k.id_kategoriak
		WHERE t.aktiv=1 AND v.keszlet_1>0 AND " . $sqlCode . " AND tkk.id_kategoriak NOT IN ('94', '95') GROUP BY t.id ORDER BY t.id DESC LIMIT " . $maradek);


$resHTML = "";
while($result = mysql_fetch_array($msq_cipos))
{
	if(isset($result["akcios_kisker_ar"]) && $result["akcios_kisker_ar"] != 0)
		$ar = $result["akcios_kisker_ar"];
	else
		$ar = $result["kisker_ar"];
	
	$kep = "/" . $func->getHDir($result["id"]) . $result["fokep"] . "_small.jpg";
	
	$resHTML .= '<div id="search-item">
		<a href="/hu/termek/' . $result["markanev"] . '/' . $result["id"] . '">
			<img src="' . $kep . '" alt="' . $result["markanev"] . '" title="' . $result["termeknev"] . '" />
			<h1>'.$result["markanev"].' '.$result["termeknev"].'<br />'.$result["szin"].'</h1>
			<h4>'.number_format($ar, 0, '', ' ' ).' Ft</h4>
		</a>
	</div>';
}

while($result = mysql_fetch_array($msq_tobbi))
{
	if(isset($result["akcios_kisker_ar"]) && $result["akcios_kisker_ar"] != 0)
		$ar = $result["akcios_kisker_ar"];
	else
		$ar = $result["kisker_ar"];
	
	$kep = "/" . $func->getHDir($result["id"]) . $result["fokep"] . "_small.jpg";
	
	/* $resHTML .= '<div id="search-item">
		<a href="/hu/termek/' . $result["markanev"] . '/' . $result["id"] . '">
			<img src="' . $kep . '" alt="' . $result["markanev"] . '" title="' . $result["termeknev"] . '" />
			<h1>' . substr($result["markanev"], 0, 10) . '</h1>
			<h2>' . substr($result["termeknev"], 0, 15) . '.. </h2>
			<h3>' . substr($result["szin"], 0, 15) . '.. </h3>
			<h4>' . number_format($ar, 0, '', ' ' ) . ' Ft</h4>
		</a>
	</div>'; */
	
	$resHTML .= '<div id="search-item">
		<a href="/hu/termek/' . $result["markanev"] . '/' . $result["id"] . '">
			<img src="' . $kep . '" alt="' . $result["markanev"] . '" title="' . $result["termeknev"] . '" />
			<h1>'.$result["markanev"].' '.$result["termeknev"].' '.$result["szin"].'</h1>
			<h4>'.number_format($ar, 0, '', ' ' ).' Ft</h4>
		</a>
	</div>';
}

$talalat = mysql_num_rows($msql);
if($talalat > 0)
{
	$resHTML .= '<div id="search-all-item">
		<a href="/hu/termekek?keresendo=' . $_POST["code"] . '">Összes találat (' . mysql_num_rows($msql) . ' db)</a>
	</div>';
}
else
{
	$resHTML .= '<div id="search-all-item" style="text-align: center;">
		Nincs találat!
	</div>';
}

$res["responseHTML"]	= $resHTML;

echo json_encode($res);

?>