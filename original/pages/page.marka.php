<? ini_set('display_errors', 0); ?>

<div class="right-container">

<? 

//LAPLÉPTETŐ FORM
echo '<form method="post" name="pageStepForm" id="pageStepForm">';
echo '<input type="hidden" name="oldal" id="oldal" />';
echo '</form>';

// hibak be
//ini_set("display_errors", 1);

// markainfo
if ($_SESSION["langStr"]=="hu")	
	include 'inc/'.$_SESSION["langStr"].'/about/'.$markaid.'.php';
	
//echo $marka->filter;

// kategoriak / alkategoriak DIV	
echo $marka->kategoriak;

// filter helye
//echo '<div class="grey-container"> </div>';

// lapozas fent
//echo '<div class="pagestepper">'.$marka->echoPageStepper().'</div>';

// termekek listazasa ////////////////////////////////////////////////////////////////

///
echo "SELECT t.id,
		t.termeknev,
		t.opcio,
		t.kisker_ar,
		t.akcios_kisker_ar,
		t.szin,
		t.markaid,
		t.klub_ar,
		t.klub_termek,
		t.dealoftheweek,
		(CASE WHEN t.akcios_kisker_ar>0 THEN t.akcios_kisker_ar ELSE t.kisker_ar END) vegleges_ar,
		t.fokep
		FROM termekek t
		LEFT JOIN vonalkodok v ON v.id_termek = t.id
		LEFT JOIN kategoriak k ON k.id_kategoriak = t.kategoria
		WHERE v.keszlet_1 >0
		AND t.aktiv =1
		AND t.kategoria =	".$_SESSION['kategoria']."
		AND t.markaid =	".$_SESSION['markaid']."
		GROUP BY t.id
		ORDER BY t.id DESC";
///


//echo '<center>';
echo '<table align="center" class="products_table">';

$num=0;
$row=0;
while ($lista=mysql_fetch_array($marka->lista_query)) { 

	if (++$num==1) {
				echo '<tr>';
				$row++;
				}
	
	$notopborder='';
	if ($row==1)	$notopborder='border-top:none;';
	
	$noleftborder='';
	if ($num%5==1)	$noleftborder='border-left:none;';
 
	echo '<td align="center" valign="top" style="'.$noleftborder.$notopborder.'">';
	
	$marka->echoProductTM($lista);
	
	echo '</td>';
	
	if ($num==5){
	
		echo '</tr>';
		$num=0;
		
	}
	
}

if ($num<>0) echo '</tr>';
  
echo '</table>';

//////////////////////////////////////////////////////////////////////////////////////	

?>

</div>

<? ini_set('display_errors', 0); ?>