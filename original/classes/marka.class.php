<?

class marka
{

 public $filter=''; 
 public $kategoriak=''; 

	function __construct()
	{	
	
	global $markaid;
	global $lang;
	global $func;	

	// markanev, markaid
	$exp = explode("/", $_GET['query']);
	$markanev=$exp[2];	
		
	$markaSQL = mysql_fetch_array(mysql_query("SELECT id,markanev FROM markak WHERE markanev='".$markanev."'"));		// markaid-t lekerdezzuk az url-ben megadott markanev alapjan
	
	$markaid = $markaSQL[0];					// markaID global
	$_SESSION['markaid'] = $markaid;			// markaid sessionbe
	$_SESSION['markanev'] = $markaSQL[1];		// markaid sessionbe
	$_SESSION['kategoria'] = $exp[4];			// kategoria sessionbe
	
	
	
	
	// alkategoriak
	$fokatSQL = mysql_query("SELECT k.*
							FROM kategoriak k
							INNER JOIN termekek t ON (t.kategoria=k.id_kategoriak AND aktiv=1 AND torolve IS NULL)
							INNER JOIN vonalkodok vk ON (vk.id_termek=t.id AND vk.aktiv=1 AND (keszlet_1>0) )
							LEFT JOIN kategoriak fk ON (fk.id_kategoriak = k.szulo)
							WHERE
							t.markaid=".(int)$markaid." AND
							k.sztorno IS NULL
							GROUP BY
							/*k.id_kategoriak*/
							k.szulo
							ORDER BY
							fk.sorrend, k.sorrend");
							
	
	while($fokatrow=mysql_fetch_array($fokatSQL))	{
	
		$alkatSQL = mysql_query("
								SELECT k.*
								FROM kategoriak k
								INNER JOIN termekek t ON (t.kategoria=k.id_kategoriak AND aktiv=1 AND torolve IS NULL)
								INNER JOIN vonalkodok vk ON (vk.id_termek=t.id AND vk.aktiv=1 AND (keszlet_1>0) )
								LEFT JOIN kategoriak fk ON (fk.id_kategoriak = k.szulo)
								WHERE
								t.markaid=".(int)$markaid." AND
								k.sztorno IS NULL AND
								k.szulo=".$fokatrow['szulo']."

								GROUP BY k.id_kategoriak

								ORDER BY
								/*fk.sorrend,*/ k.sorrend
		");
		
		// fokategoria neve
		$fokat_nev=mysql_fetch_array(mysql_query('SELECT id_kategoriak,megnevezes FROM kategoriak WHERE id_kategoriak='.$fokatrow['szulo']));
		
		
		$this->kategoriak.= '<div class="marka_kat" style="width:'.((100/(mysql_num_rows($fokatSQL)))-2).'%;"><h4>'.$markanev.' &middot; '.$fokat_nev['megnevezes'].'</h4>';
		
		while($alkatrow=mysql_fetch_array($alkatSQL))	{
		
				if(!$_SESSION['kategoria']) $_SESSION['kategoria']=$alkatrow['id_kategoriak'];		// default alkategoria
				
				if ($_SESSION['kategoria']==$alkatrow['id_kategoriak']) 
					$color="style='color:#fff;background-color:#333;'";
				else
					$color='';
				
				$this->kategoriak.= '<a href="/'.$_SESSION["langStr"].'/marka/'.$markanev.'/'.$func->convertstring($lang->$alkatrow['nyelvi_kulcs']).'/'.$alkatrow['id_kategoriak'].'" 
				alt="'.ucfirst($markanev).' '.strtolower($alkatrow['nyelvi_kulcs']).' - Coreshop.hu" '.$color.'>
				'.$alkatrow['nyelvi_kulcs'].'</a><br />';
		}
		
		$this->kategoriak.='</div>';
		
	}

	
	
	// termekek SQL
									
	$this->lista_query=mysql_query("SELECT 
									t.id,
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
									ORDER BY t.id DESC");
									
	// talalatok szama lapozashoz									
	$this->pages=mysql_num_rows($this->lista_query);

	}
	
 function echoProductTM($arr)
 { 
 
  global $func;
  global $lang;

  
  //var_dump($arr);

  echo '<div class="product-thumb">';

  if($arr['dealoftheweek'] == 1)
   echo '<div class="product-image-container-horizontal-dotw">
				<img src="/images/coreshop_dealoftheweek_small.png" />
			</div>';

  // opcio icon
  echo '<div class="product-opcio-container">';
  if($arr['opcio'] == 'UJ')
   echo '<img src="/images/opcio-uj.png" />';
 
  echo '</div>';

  $directory=$func->getHDir($arr['id']);

  if(!is_file($directory.'/'.$arr['fokep'].'_small.jpg'))
  {

   echo '<a href="/'.$_SESSION["langStr"].'/'.$lang->_termek.'/'.$func->convertString($arr['termeknev']).'/'.$arr['id'].'"><img src="/images/none.jpg" alt="'.$_SESSION['markanev'].' - '.$arr['termeknev'].'" style="width:200px; height:200px;" /></a>';
  }
  else
  {

   echo '<a href="/'.$_SESSION["langStr"].'/'.$lang->_termek.'/'.$func->convertString($arr['termeknev']).'/'.$arr['id'].'"><img src="/'.$directory.'/'.$arr['fokep'].'_small.jpg" alt="'.$_SESSION['markanev'].' - '.$arr['termeknev'].'"  style="width:200px; height:200px;" /></a>';
  }


  echo '<div class="product-info">

                <div class="products-thumb-zoom">';

  if(!is_file($directory.'/'.$arr['fokep'].'_large.jpg'))
  {

   echo '<a href="#" class="highslide">';
  }
  else
  {


   echo '<a href="/'.$directory.'/'.$arr['fokep'].'_large.jpg" class="highslide" onclick="return hs.expand(this)">';
  }


  echo '[+] zoom</a>
                </div>

                  <a href="/'.$_SESSION["langStr"].'/'.$lang->_termek.'/'.$func->convertString($arr['termeknev']).'/'.$arr['id'].'"><h1>'.$_SESSION['markanev'].'</h1></a>
                  <a href="/'.$_SESSION["langStr"].'/'.$lang->_termek.'/'.$func->convertString($arr['termeknev']).'/'.$arr['id'].'">'.$arr['termeknev'].'</a>
				  <br />
                  <a href="/'.$_SESSION["langStr"].'/'.$lang->_termek.'/'.$func->convertString($arr['termeknev']).'/'.$arr['id'].'">'.$arr['szin'].'</a>';


  echo '<div class="products-prise-container">';

  if($lang->defaultCurrencyId == 0)
  { //MAGYARORSZÁG ESETÉN
   if($arr['akcios_kisker_ar'] > 0)
   {
    echo '<span class="products-thumb-originalprise">'.$lang->Eredeti_ar.': <del>'.number_format($arr['kisker_ar'],0,'',' ').'</del> Ft</span><br />';
    echo '<span class="products-thumb-saleprise">'.$lang->Akcios_ar.': '.number_format($arr['akcios_kisker_ar'],0,'',' ').' Ft</span>';
   }
   else
    echo $lang->Ar.' '.number_format($arr['kisker_ar'],0,'',' ').' Ft';

  }else
  {

   //ÁTVÁLTÁS

   if($arr['akcios_kisker_ar'] > 0)
   {
    echo '<span class="products-thumb-originalprise">'.$lang->Eredeti_ar.': € <del>'.$func->toEUR($arr['kisker_ar']).'</del></span><br />';
    echo '<span class="products-thumb-saleprise">'.$lang->Akcios_ar.': € '.$func->toEUR($arr['akcios_kisker_ar']).'</span>';
   }
   else
    echo $lang->Ar.' € '.$func->toEUR($arr['kisker_ar']);

  }


  echo '</div>';

  echo '</div>

               </div>';
	
 }
 
 ///////////////////////////////////////////////////////////
 
 function echoPageStepper()
 {
	
	global $lang;

	$product_per_page=15;	

	if($this->pages > $product_per_page)
	{
	$this->pagenum=ceil($this->pages / $product_per_page);
	}
	else
	{
	$this->pagenum=0;
	}


	if($this->pagenum > 0)
	{

	if($_REQUEST['oldal'] > 0)
	 echo '&lsaquo; <a href="#" onclick="document.getElementById(\'oldal\').value=\''.($_REQUEST['oldal'] - 1).'\'; document.pageStepForm.submit()">'.$lang->elozo_oldal.'</a>&nbsp;&nbsp;&nbsp;';

	for($go=1; $go <= $this->pagenum; $go++)
	{

	 if($go > 1)
	 {
	  echo('&nbsp;&nbsp;');
	 }
	 if(($_REQUEST['oldal'] + 1) == $go)
	 {

	  echo '<span class="pagenum">'.$go.'</span> ';
	 }
	 else
	 {

	  echo('<a href="#" onclick="document.getElementById(\'oldal\').value=\''.($go - 1).'\'; document.pageStepForm.submit()" class="pagenum_inactive">'.$go.'</a> ');
	 }
	}

	if(($_REQUEST['oldal'] + 1) < $this->pagenum)
	 echo '&nbsp;&nbsp;&nbsp; <a href="#" onclick="document.getElementById(\'oldal\').value=\''.($_REQUEST['oldal'] + 1).'\'; document.pageStepForm.submit()">'.$lang->kovetkezo_oldal.'</a> &rsaquo;';

	}
	}
	
	
	
}
?>