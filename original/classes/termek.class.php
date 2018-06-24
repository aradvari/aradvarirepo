<?
class termek
{

 function __construct()
 {

  global $error;
  global $func;
  global $user;
  global $lang;
  global $topnav;
  global $page;


  $_GET['opcio']=$_SESSION['opcio'];

  $user->cartManager();

  $id=(int)$_GET['id_termek'];

  $this->termek=mysql_fetch_array(mysql_query("SELECT
                                                       t.id,
                                                       t.termeknev,
                                                       t.szin,
                                                       t.leiras,
                                                       t.kisker_ar,
                                                       t.akcios_kisker_ar,
		                                               t.klub_ar,
													   t.dealoftheweek,
                                                       t.fokep,
                                                       t.cikkszam,
                                                       t.opcio,
													   sum(v.keszlet_1) as webshop_keszlet,
                                                       (CASE WHEN t.akcios_kisker_ar>0 THEN t.akcios_kisker_ar ELSE t.kisker_ar END) vegleges_ar,
                                                       m.markanev,
                                                       t.kategoria,
                                                       t.markaid,
                                                       t.keszleten,
													   t.video,
													   k.megnevezes as kategorianev
                                                       FROM termekek t
                                                       LEFT JOIN markak m ON (m.id = t.markaid)
													   LEFT JOIN vonalkodok v ON v.id_termek=t.id
													   LEFT JOIN kategoriak k ON k.id_kategoriak = t.kategoria
                                                       WHERE t.id=$id
                                                       GROUP BY id"));

  //Klubtag ellenőrzés
  if($user->isClubUser())
   $this->termek['kosar_ar']=$this->termek['klub_ar'] > 0 ? $this->termek['klub_ar'] : $this->termek['vegleges_ar'];
  else
   $this->termek['kosar_ar']=$this->termek['vegleges_ar'];

  /*if($this->termek["keszleten"] < 1)
  {
   header("Location: /");
   die("REDIRECT");
  }*/
  
  /* kikapcsolva, mert nem orult neki a google search console
  if($this->termek["webshop_keszlet"] < 1)
  {
   //header("Location: /");
   //die("REDIRECT");
   header("HTTP/1.0 404 Not Found");
   $page='kifutott_termek';
  } */


  if(count($this->termek) > 1)
  {

   $_GET['kategoria']=$this->termek['kategoria'];
   $_GET['marka']=$this->termek['markaid'];

   if($_GET['kep'] == "")
   {

    $this->kep['small']=$func->getHDir($this->termek['id']).$this->termek['fokep']."_small.jpg";
    $this->kep['medium']=$func->getHDir($this->termek['id']).$this->termek['fokep']."_medium.jpg";
    $this->kep['large']=$func->getHDir($this->termek['id']).$this->termek['fokep']."_large.jpg";
   }
   else
   {

    $this->kep['small']=$func->getHDir($this->termek['id']).$_GET['kep']."_small.jpg";
    $this->kep['medium']=$func->getHDir($this->termek['id']).$_GET['kep']."_medium.jpg";
    $this->kep['large']=$func->getHDir($this->termek['id']).$_GET['kep']."_large.jpg";
   }

   $this->sizes=@getimagesize($this->kep['large']);

   //TOVÁBBI KÉPEK
   $this->kepek=array();
   if(is_dir($func->getHDir($this->termek['id'])))
   {

    foreach(@glob($func->getHDir($this->termek['id'])."*_large.jpg") as $filename)
    {
		//$this->kepek[]=$filename;
		$e = explode("_", basename($filename));
		$this->kepek[ (int)$e[0] ] = $filename;
    }

	ksort($this->kepek, SORT_NUMERIC);
   }
  }
  else
  {

   //$error->addError('A TERMÉK NEM TALÁLHATÓ!');
   header("HTTP/1.0 404 Not Found");
   $page='error404';
//   header("Location: /".$lang->defaultLangId."/".$lang->_nem_talalhato);
//   die();
  }

  // top navigation

  $alkategoria=mysql_fetch_array(mysql_query('
											SELECT k.megnevezes, k.nyelvi_kulcs, k.szulo, t.kategoria
											FROM termekek t											
											LEFT JOIN termek_kategoria_kapcs tkk ON tkk.id_termekek = t.id
											LEFT JOIN kategoriak k ON k.id_kategoriak = tkk.id_kategoriak
											WHERE tkk.id_termekek ='.$this->termek['id']));
  $kategoria=mysql_fetch_array(mysql_query('SELECT k.megnevezes,k.nyelvi_kulcs,k.id_kategoriak FROM kategoriak k where id_kategoriak='.$alkategoria['szulo']));
  $kName=$func->getMysqlValue("SELECT nyelvi_kulcs FROM kategoriak WHERE id_kategoriak=".$kategoria['id_kategoriak']);
  $kURL=$func->convertString($lang->$kName)."/".$alkategoria['kategoria']."/";
  
  $_SESSION['kategoria'] = $alkategoria['szulo'];	// headerben  igy latszik az alkategoria menu is
  
  $_SESSION['alkategoria'] =  $alkategoria['kategoria'];

  if (!$func->isMobile())
				$this->topnav='<a href="/">'.$lang->Kezdolap.'</a>&rsaquo;';
  
  
	$this->topnav.='<a href="/'.$_SESSION["langStr"].'/'.$lang->_termekek.'/'.$kURL.'">'.$lang->$kategoria['nyelvi_kulcs'].'</a>&rsaquo;
				<a href="/'.$_SESSION["langStr"].'/'.$lang->_termekek.'/'.$kURL.'">'.$lang->$alkategoria['nyelvi_kulcs'].'</a>&rsaquo;
				<a href="/'.$_SESSION["langStr"].'/'.$lang->_termekek.'/'.$kURL.$func->convertString($this->termek['markanev']).'/'.$this->termek['markaid'].'/">'.$this->termek['markanev'].'</a>&rsaquo;';
	
	if (!$func->isMobile())	{	
				$this->topnav.='<span style="margin-left:2%">'.$this->termek['termeknev'].' '.$this->termek['szin'].' </span>';
				//if(!empty($this->termek['cikkszam']))
				//$this->topnav.= ' - '.$this->termek['cikkszam'];
				}
	else
			$this->topnav.='<span style="margin-left:2%">'.$this->termek['termeknev'].'</span>';
			
 }		

 /*function getSizes($id,$storage,$start="",$end="",$separator=" ")
 {

  $query=mysql_query("SELECT
                              v.megnevezes
                              FROM termekek t
                              LEFT JOIN vonalkodok v ON (v.id_termek = t.id AND v.aktiv=1 AND v.keszlet_$storage>0)
                              LEFT JOIN vonalkod_sorrendek vs ON (vs.vonalkod_megnevezes=v.megnevezes)
                              WHERE t.id=$id AND v.megnevezes!='-'
                              ORDER BY vs.sorrend, v.megnevezes
                              ");

  $res="";

  while($a=mysql_fetch_array($query))
  {

   $res[]=$start.$a[0].$end;
  }

  return implode($res,$separator);
 } */
 
  function getSizes($id,$storage,$separator=" ")
 {

  $query=mysql_query("SELECT
                              v.megnevezes,
							  v.vonalkod
                              FROM termekek t
                              LEFT JOIN vonalkodok v ON (v.id_termek = t.id AND v.aktiv=1 AND v.keszlet_$storage>0)
                              LEFT JOIN vonalkod_sorrendek vs ON (vs.vonalkod_megnevezes=v.megnevezes)
                              WHERE t.id=$id AND v.megnevezes!='-'
                              ORDER BY vs.sorrend, v.megnevezes
                              ");

  $res="";

  while($a=mysql_fetch_array($query))
  {
   
   $onclick = 'selectSize(\''.$a[1].'\')';
   $item = '<input type="radio" name="meret_radio" style="display:none;" id="v_'.$a[1].'" onclick="'.$onclick.'"/><label for="v_'.$a[1].'" class="product-size">'.$a[0].'</label>';
   $res .= $item;
  }

  return $res;
 }

 function getStorage($id,$storage)
 {

  $query=mysql_query("SELECT sum(keszlet_$storage) FROM vonalkodok WHERE id_termek=$id");

  return @mysql_result($query,0);
 }

}
?>