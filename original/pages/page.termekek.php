<?

//ini_set("display_errors", 1); 

//LAPLÉPTETÕ FORM
echo '<form method="post" name="pageStepForm" id="pageStepForm" action="">';
echo '<input type="hidden" name="oldal" id="oldal" />';
//echo '<input type="hidden" name="keresendo" value="' . htmlspecialchars($_POST['keresendo']) . '" />';
echo '</form>';


// markatortenet egyelore csak magyar nyelvnel

if ($_SESSION["langStr"] == "hu")
{
    $exp = explode("/", $_GET['query']); // az url-t kell vizsgalni pl: /hu/termekek/0/0/Vans/41
    if (!(int) $exp[3] && (int) $_GET["marka"])
	{

        $aboutbrand = (int) $_GET['marka'];

        $file = 'inc/hu/about/' . $aboutbrand . '.php';

        if (file_exists($file))
            include $file;
    }
}


// alkategoriak csak a mobil nezetnel
if ($_GET['kategoria'] <> 0)
{
    echo '<div class="subcat-container-mobile">';	
	
	$is_fokat = mysql_fetch_array(mysql_query('SELECT id_kategoriak, szulo FROM kategoriak WHERE id_kategoriak='.$_SESSION['kategoria']));
	
	$subcat	= mysql_query('SELECT k.id_kategoriak, k.nyelvi_kulcs, k.megnevezes, k.szulo
					FROM kategoriak k
					LEFT JOIN termek_kategoria_kapcs tkk ON tkk.id_kategoriak = k.id_kategoriak
					LEFT JOIN termekek t ON t.id = tkk.id_termekek
					LEFT JOIN vonalkodok v ON v.id_termek = t.id
					WHERE k.sztorno IS NULL AND t.aktiv =1 AND v.keszlet_1 >0 AND t.torolve IS NULL AND k.szulo ='.$is_fokat['szulo'].' 
					GROUP BY k.id_kategoriak
					ORDER BY k.sorrend');	
	$szulo= mysql_fetch_array(mysql_query('SELECT nyelvi_kulcs FROM kategoriak WHERE id_kategoriak='.$is_fokat['szulo']));

	//echo '<span class="filter-name" s_tyle="clear:both;">'.$lang->kategoria.'</span>';
	echo '<span class="filter-name" s_tyle="clear:both;">'.$lang->$szulo[0].'</span>';
					
	while($row = mysql_fetch_array($subcat))
	{
		if ($row['id_kategoriak']==$_GET['kategoria'])
            $style = 'class="sizeButtonSelected" ';
        else
            $style = 'class="sizeButton" ';
		
		if($_SESSION['kategoria']==$row['id_kategoriak'])
			$selected='class="selected"'; else $selected='';
		
		echo '<a href="/'.$_SESSION["langStr"].'/'.$lang->_termekek.'/'.$func->convertString($row['megnevezes']).'/'.$row['id_kategoriak'].'" '.$style.'>'.$lang->$row['nyelvi_kulcs'].'</a> ' ;
	}
	
    echo '</div>';
}


// filter
echo $termekek->filter;

// ures kategoria tajekoztato szoveg, url igy megmarad a google-ban
echo $termekek->ures_kategoria;


// listanezet
echo '<div class="thumbnail-container">';
	// termek thumbnail
	while ($lista = mysql_fetch_array($termekek->lista_query))
	{
		//$termekek->echoProductTM($lista);
		echo $func->thumb($lista['id']);
		//print_r($lista);
		//echo $lista['id'];
	}
echo '</div>';

// lapozas lent
echo $termekek->echoPageStepper();


// Belga tortenet
$belga_kategoriak = array(155, 154, 150, 151, 152, 153);
$exp = explode("/", $_GET['query']);
$kat = $exp[3];
if (in_array($kat, $belga_kategoriak)) 
	include 'inc/' . $_SESSION["langStr"] . '/about/121.php'; // belga tortenet
	
// ferfi cipo szoveg

/* if ($_GET['query']=='hu/termekek/ferfi-cipo/94')
	include 'inc/hu/about/ferfi_cipo.php'; */
	