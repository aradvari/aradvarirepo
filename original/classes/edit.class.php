<?

 error_reporting(E_ALL);
 ini_set("display_errors", 0);

class edit	{
    
    public $filter = '';
    public $alkategoriak = array();
    public $markak = array();
    public $kURL = '';
    
    function __construct(){

        global $menu;
        global $func;
        global $lang;
    
        //SORREND
        if (empty($_SESSION['termekek_orderby'])) $_SESSION['termekek_orderby'] = 1;
        if (ISSET($_REQUEST['orderby'])) $_SESSION['termekek_orderby'] = $_REQUEST['orderby'];
        $ordeyby_array = array("", "termekek.opcio DESC", "markak.markanev", "vegleges_ar DESC", "vegleges_ar ASC");
        //*********
        
        if ($_POST['oldal']!=""){
            
            parse_str($_SERVER["QUERY_STRING"], $ps);
            $ps["oldal"] = (int)$_POST['oldal'];
            $prefix = $ps["query"];
            unset($ps["query"]);
            $query = http_build_query($ps);
            header("Location: ?$query");
            exit();
            
        }

        if (ISSET($_GET['kategoria'])) {
              
              $menu->parents=array();
              $parents = $menu->getParents($_GET['kategoria']);
              $menu->childrens=array();
              $childrens = $menu->getChildrens($_GET['kategoria']);
              
              while ($t = each($childrens)){
                $sql_in .= $t[1][0].",";
              }
              $sql_in=substr($sql_in, 0, -1);
                    
            //KATEGÓRIÁK
            $kID = (int)$_GET['kategoria'];
            $kSQL = "SELECT szulo FROM kategoriak WHERE id_kategoriak=$kID";
            $pID = (int)mysql_result(mysql_query($kSQL), 0);
            $parentID = ($pID==0?$kID:$pID);
            $cSQL = "SELECT 
                     k.* 
                     FROM kategoriak k 
                     INNER JOIN termekek t ON (t.kategoria=k.id_kategoriak AND aktiv=1 AND torolve IS NULL)
                     INNER JOIN vonalkodok vk ON (vk.id_termek=t.id AND vk.aktiv=1 AND (keszlet_1>0) )
                     WHERE k.szulo=$parentID AND 
                     k.sztorno IS NULL
                     GROUP BY k.id_kategoriak ORDER BY k.sorrend";
                       
            $cQuery = mysql_query($cSQL);
            while ($kat = mysql_fetch_array($cQuery)){
                if ($kID==$kat["id_kategoriak"]) $kat["selected"] = true;
                $this->alkategoriak[] = $kat;   
            }
			
			/*
			
			ha nincs kategoria, akkor markanev alapjan szures
			
			igy csak az alkategoriak jonnek le, de a fokategoria kell fole
			
			SELECT 
			k.* 
			FROM kategoriak k 
			INNER JOIN termekek t ON (t.kategoria=k.id_kategoriak AND aktiv=1 AND torolve IS NULL)
			INNER JOIN vonalkodok vk ON (vk.id_termek=t.id AND vk.aktiv=1 AND (keszlet_1>0) )
			inner join markak m on t.markaid = m.id                     

			WHERE
			t.markaid=118	// JART
			AND 
			k.sztorno IS NULL
			GROUP BY k.id_kategoriak ORDER BY k.sorrend
			*/

            $kName = $func->getMysqlValue("SELECT nyelvi_kulcs FROM kategoriak WHERE id_kategoriak=".$_GET['kategoria']);
            $this->kURL = $func->convertString($lang->$kName)."/".$_GET['kategoria']."/";
            
            //MÁRKÁK
            $mID = (int)$_GET['marka'];
            $mSQL = "SELECT 
                        m.*
                     FROM kategoriak k 
                     INNER JOIN termekek t ON (t.kategoria=k.id_kategoriak AND aktiv=1 AND torolve IS NULL)
                     INNER JOIN vonalkodok vk ON (vk.id_termek=t.id AND vk.aktiv=1 AND (keszlet_1>0) )
                     INNER JOIN markak m ON (m.id = t.markaid)
                     WHERE k.id_kategoriak IN ($sql_in) AND 
                     k.sztorno IS NULL
                     GROUP BY m.id ORDER BY m.markanev";
                       
            $mQuery = mysql_query($mSQL);
            while ($marka = mysql_fetch_array($mQuery)){
                if ($mID==$kat["marka"]) $marka["selected"] = true;
                $this->markak[] = $marka;   
            }

        }
        
        $limit=(ISSET($_GET['kategoria'])?($_GET['kategoria']<>''?' AND kategoria IN ('.$sql_in.')':''):'').
               (ISSET($_GET['marka'])?($_GET['marka']<>''?' AND markaid='.$_GET['marka']:''):'');

		if ($_REQUEST['meretek']=="Minden méret") $_REQUEST['meretek']="";		// minden meret string torles
        
        $meretek_limit=(ISSET($_REQUEST['meretek'])?($_REQUEST['meretek']<>''?' AND vk.megnevezes=\''.$_REQUEST['meretek'].'\'':''):'');
                
        //SZABADSZAVAS KERESÉS
          if (ISSET($_REQUEST['keresendo'])){
              $kulcsszavak = explode(" ", htmlspecialchars($_REQUEST['keresendo'])); 
              $keresendo=' AND ('; 
              while ($k = each($kulcsszavak)){
              
                  $keresendo.= "CONCAT(keresheto, ' ', meretek) LIKE '%".$k[1]."%' AND ";
                  
              }
              $keresendo = substr($keresendo, 0, -4);
              $keresendo.= ")";
          }else{
              $keresendo='';
          }
        
        //opciók
        if (ISSET($_GET['opcio'])){
        
            if ($_GET['opcio']=='coreclub'){
                
                $opt = " AND klub_termek=1";
                
            }else{
                
                $opt = " AND opcio='".$_GET['opcio']."'";
                
            }
            
        }else{
            
            $opt = '';
            
        }
        
        //QUERY
          $this->pages=(int)@mysql_num_rows(mysql_query("SELECT 
                                                  CONCAT(termekek.termeknev, ' ', termekek.szin, ' ', markak.markanev, ' ', k.megnevezes) keresheto,
                                                  ifnull((SELECT GROUP_CONCAT(megnevezes) FROM vonalkodok WHERE id_termek=termekek.id AND aktiv=1 AND keszlet_1>0), ' ') meretek 
                                                  
                                                  FROM termekek 
                                                  INNER JOIN vonalkodok vk ON (vk.id_termek=termekek.id AND vk.aktiv=1 AND (keszlet_1>0 /*OR keszlet_2>0*/) )
                                                  LEFT JOIN markak ON termekek.markaid=markak.id 
                                                  LEFT JOIN kategoriak k ON k.id_kategoriak = termekek.kategoria
                                                  
                                                  WHERE 
                                                  termekek.torolve IS NULL AND 
                                                  termekek.aktiv>=1 ".($_SESSION['resz_query']).
                                                  $modul.
                                                  $opt.
                                                  $limit.$meretek_limit." 
                                                  
                                                  GROUP BY termekek.id
                                                        
                                                  HAVING 1=1 $keresendo"));
                                                  
        //MÉRETEK
          $this->meretek_sql=                                "SELECT 
                                                              vk.megnevezes,
                                                              CONCAT(termekek.termeknev, ' ', termekek.szin, ' ', markak.markanev, ' ', k.megnevezes) keresheto,
                                                              ifnull((SELECT GROUP_CONCAT(megnevezes) FROM vonalkodok WHERE id_termek=termekek.id AND aktiv=1 AND keszlet_1>0), ' ') meretek 
                                                              
                                                              FROM termekek 
                                                              INNER JOIN vonalkodok vk ON (vk.id_termek=termekek.id AND vk.aktiv=1 AND (keszlet_1>0 /*OR keszlet_2>0*/) )
                                                              LEFT JOIN markak ON termekek.markaid=markak.id 
                                                              LEFT JOIN kategoriak k ON k.id_kategoriak = termekek.kategoria
															  LEFT JOIN vonalkod_sorrendek vks ON (vk.megnevezes = vks.vonalkod_megnevezes)
                                                              
                                                              WHERE 
                                                              termekek.torolve IS NULL AND 
                                                              termekek.aktiv>=1 ".($_SESSION['resz_query']).
                                                              $modul.
                                                              $opt.
                                                              $limit." 
                                                              
                                                              GROUP BY vk.megnevezes
                                                                    
                                                              HAVING 1=1 $keresendo
															  
															  ORDER BY vks.sorrend, vk.megnevezes";
                                                  
          //while ($a = mysql_fetch_array($query)) $this->meretek[] = $a['meret'];
		  
		  $product_per_page	= 15;
                                                  
          //if ($this->pages>200) { $l=$this->pages; $this->pages=200; }
          
          if ($this->pages>$product_per_page){$this->pagenum=ceil($this->pages/$product_per_page);}else{$this->pagenum=0;}

          if (ISSET($_GET['list_all'])){$_GET['list_all']=$this->pages;$_REQUEST['oldal']=0;}

          $this->lista_query = mysql_query("SELECT
                
                                            termekek.id,
                                            termekek.termeknev,
                                            termekek.opcio,
                                            termekek.kisker_ar,
                                            termekek.akcios_kisker_ar,
                                            termekek.szin,
                                            termekek.markaid,
                                            markak.markanev,
											termekek.klub_ar,
                                            termekek.klub_termek,
											termekek.dealoftheweek,
                                            (CASE WHEN termekek.akcios_kisker_ar>0 THEN termekek.akcios_kisker_ar ELSE termekek.kisker_ar END) vegleges_ar,
                                            termekek.fokep,
                                            CONCAT(termekek.termeknev, ' ', termekek.szin, ' ', markak.markanev, ' ', k.megnevezes) keresheto,
                                            ifnull((SELECT GROUP_CONCAT(megnevezes) FROM vonalkodok WHERE id_termek=termekek.id AND aktiv=1 AND keszlet_1>0), ' ') meretek 
                                            
                                            FROM termekek 
                                            INNER JOIN vonalkodok vk ON (vk.id_termek=termekek.id AND vk.aktiv=1 AND (keszlet_1>0 /*OR keszlet_2>0*/) )
                                            LEFT JOIN markak ON termekek.markaid=markak.id 
                                            LEFT JOIN kategoriak k ON k.id_kategoriak = termekek.kategoria
                                            
                                            WHERE 
                                            termekek.torolve IS NULL AND 
                                            termekek.aktiv>=1 ".($_SESSION['resz_query']).
                                            $modul.
                                            $opt.
                                            $limit.$meretek_limit." 
                                                    
                                            GROUP BY termekek.id

                                            HAVING 1=1 $keresendo
                                            
                                            ORDER BY 

                                            ".$ordeyby_array[$_SESSION['termekek_orderby']].",
											
                                            termekek.opcio,termekek.id DESC
											
                                            
                                            LIMIT ".($_REQUEST['oldal']*$product_per_page).", ".(ISSET($_GET['list_all'])?$_GET['list_all']:$product_per_page));
                                            
											
											
											
                                            
          //*****************************************************************************
          //*****************************************************************************
          //ÚJ KERESÉSI FEJLÉC
          
          if (ISSET($_POST['navi_type'])){
              
              if ($_POST['navi_type']=='fokat' || $_POST['navi_alkat']==""){
               
                  $m = $func->getMysqlValue("SELECT megnevezes FROM kategoriak WHERE id_kategoriak=".$_POST['navi_fokat']);
                  $url_kat = $func->convertString($m)."/".$_POST['navi_fokat']."/";  
                  
              }

              if ($_POST['navi_type']=='alkat' && $_POST['navi_alkat']!=""){
               
                  $m = $func->getMysqlValue("SELECT megnevezes FROM kategoriak WHERE id_kategoriak=".$_POST['navi_alkat']);
                  $url_kat = $func->convertString($m)."/".$_POST['navi_alkat']."/";
                  
              }
              
              if (ISSET($_POST['navi_marka'])){
                  
                  $m = $func->getMysqlValue("SELECT markanev FROM markak WHERE id=".$_POST['navi_marka']);
                  $url_marka.= $func->convertString($m)."/".$_POST['navi_marka'];
                  
              }
              
              $url = ($url_kat=="//"?'0/0/':$url_kat).($url_marka=="/"?'':$url_marka);
              
              $req = '';
              if ($_REQUEST['meretek']!="") $req.= "?meretek=".urldecode($_REQUEST['meretek']);
              if ($_REQUEST['orderby']!="") $req.= ($req==""?"?":"&")."orderby=".urldecode($_REQUEST['orderby']);
              header("Location: /".$_SESSION["langStr"]."/".$lang->_termekek.($_POST['navi_opt']==""?"":"_".$_POST['navi_opt'])."/".$url.$req);
              exit();
              
          }
          
          
          $this->filter.= '<form method="post" name="naviForm" id="naviForm">';
          $this->filter.= '<input type="hidden" name="navi_type" id="navi_type" value="'.($parents[1]['id_kategoriak']>0?'alkat':'fokat').'" />';
          $this->filter.= '<input type="hidden" name="navi_opt" id="navi_opt" value="'.$_GET['opcio'].'" />';

          //Opciók linkjei
            if (ISSET($_GET['opcio'])){
            
                if ($_GET['opcio']=='coreclub'){
                    
                    $os = " t.klub_termek=1 AND";
                    
                }else{
                    
                    $os = " t.opcio='".$_GET['opcio']."' AND";
                    
                }
                
            }else{
                
                $os = '';
                
            }
          
	  
          //Márkák selectbox
		  $this->filter.= '<div style="float:left;display:inline;">';
          $this->filter.= $func->createSelectBox("SELECT 
                                         m.id, m.markanev 
                                       FROM markak m
                                       INNER JOIN termekek t ON (t.markaid = m.id)
                                       INNER JOIN vonalkodok vk ON (vk.id_termek=t.id)
                                       WHERE 
                                         ".($sql_in==""?"":" t.kategoria IN ($sql_in) AND")."
                                         ".($_REQUEST['meretek']==""?"":" vk.megnevezes = '".$_REQUEST['meretek']."' AND")."
                                         ".$os."
                                         t.torolve IS NULL AND 
                                         t.aktiv>=1 AND
                                         vk.aktiv=1 AND 
                                         keszlet_1>0
                                       GROUP BY m.id
                                       ORDER BY m.markanev", $_GET['marka'], "name=\"navi_marka\" onchange=\"document.naviForm.submit()\"", $lang->osszes_marka);
			$this->filter.= '</div>';
			
			// space
			//$this->filter.= "&nbsp;&nbsp";
        
          //Főkategóriák selectbox
          $this->filter.= $func->createSelectBox("SELECT 
                                         k2.id_kategoriak, 
                                         k2.megnevezes 
                                       FROM termekek t
                                       INNER JOIN kategoriak k ON (k.id_kategoriak = t.kategoria)
                                       LEFT JOIN kategoriak k2 ON (k2.id_kategoriak = k.szulo)
                                       INNER JOIN vonalkodok vk ON (vk.id_termek=t.id)
                                       WHERE 
                                         k.sztorno IS NULL AND 
                                         k.publikus=1 AND 
                                         ".($_GET['marka']==""?"":" t.markaid=".$_GET['marka']." AND")."
                                         ".($_REQUEST['meretek']==""?"":" vk.megnevezes = '".$_REQUEST['meretek']."' AND")."
                                         ".$os."
                                         t.torolve IS NULL AND 
                                         t.aktiv>=1 AND
                                         vk.aktiv=1 AND 
                                         keszlet_1>0
                                       GROUP BY k2.id_kategoriak
                                       ORDER BY k2.sorrend", $parents[0]['id_kategoriak'], "style=\"display:none\" name=\"navi_fokat\" onchange=\"document.getElementById('navi_type').value='fokat'; document.naviForm.submit();\"", $lang->minden_kategoria);
        
          //Alkategóriák selectbox
          if ($parents[0]['id_kategoriak']>0) 
            $this->filter.= $func->createSelectBox("SELECT 
                                           k.id_kategoriak, 
                                           k.megnevezes 
                                         FROM termekek t
                                         INNER JOIN kategoriak k ON (k.id_kategoriak = t.kategoria)
                                         INNER JOIN vonalkodok vk ON (vk.id_termek=t.id)
                                         WHERE 
                                           k.sztorno IS NULL AND 
                                           k.publikus=1 AND 
                                           ".($_GET['marka']==""?"":" t.markaid=".$_GET['marka']." AND")."
                                           ".($_REQUEST['meretek']==""?"":" vk.megnevezes = '".$_REQUEST['meretek']."' AND")."
                                           ".$os."
                                           t.torolve IS NULL AND 
                                           t.aktiv>=1 AND
                                           vk.aktiv=1 AND 
                                           vk.keszlet_1>0 AND
                                           k.szulo=".$parents[0]['id_kategoriak']."
                                         GROUP BY k.id_kategoriak
                                         ORDER BY k.sorrend", $parents[1]['id_kategoriak'], "style=\"display:none\" name=\"navi_alkat\" onchange=\"document.getElementById('navi_type').value='alkat'; document.naviForm.submit();\"", $lang->minden_alkategoria);
		
		
		//Méretek selectbox		
		  $this->filter.= '<div style="display:inline;width:600px;">';
		  $this->filter.= $lang->valassz_meretet." ";          
		  $this->filter.= $func->createButtonSelectBox($this->meretek_sql, $_REQUEST['meretek'], "name=\"meretek\" class=\"sizeButton\" ");
		  $this->filter.= '</div>';		 
          
          
          
          /*$sql_uj= "SELECT 
                   count(t.id) rows 
                 FROM termekek t
                 INNER JOIN kategoriak k ON (k.id_kategoriak = t.kategoria)
                 INNER JOIN vonalkodok vk ON (vk.id_termek=t.id)
                 WHERE 
                   k.sztorno IS NULL AND 
                   k.publikus=1 AND 
                   ".($sql_in==""?"":" t.kategoria IN ($sql_in) AND")."
                   ".($_GET['marka']==""?"":" t.markaid=".$_GET['marka']." AND")."
                   ".($_REQUEST['meretek']==""?"":" vk.megnevezes = '".$_REQUEST['meretek']."' AND")."
                   t.torolve IS NULL AND 
                   t.aktiv>=1 AND
                   t.opcio = 'UJ' AND
                   vk.aktiv=1 AND 
                   vk.keszlet_1>0
                 GROUP BY t.opcio";
          
          $row_uj = (int)mysql_result(mysql_query($sql_uj), 0);

          $sql_akcios= "SELECT 
                   count(t.id) rows 
                 FROM termekek t
                 INNER JOIN kategoriak k ON (k.id_kategoriak = t.kategoria)
                 INNER JOIN vonalkodok vk ON (vk.id_termek=t.id)
                 WHERE 
                   k.sztorno IS NULL AND 
                   k.publikus=1 AND 
                   ".($sql_in==""?"":" t.kategoria IN ($sql_in) AND")."
                   ".($_GET['marka']==""?"":" t.markaid=".$_GET['marka']." AND")."
                   ".($_REQUEST['meretek']==""?"":" vk.megnevezes = '".$_REQUEST['meretek']."' AND")."
                   t.torolve IS NULL AND 
                   t.aktiv>=1 AND
                   t.opcio = 'AKCIOS' AND
                   vk.aktiv=1 AND 
                   vk.keszlet_1>0
                 GROUP BY t.opcio";
          
          $row_akcios = (int)mysql_result(mysql_query($sql_akcios), 0);

          $sql_cc= "SELECT 
                   count(t.id) rows 
                 FROM termekek t
                 INNER JOIN kategoriak k ON (k.id_kategoriak = t.kategoria)
                 INNER JOIN vonalkodok vk ON (vk.id_termek=t.id)
                 WHERE 
                   k.sztorno IS NULL AND 
                   k.publikus=1 AND 
                   ".($sql_in==""?"":" t.kategoria IN ($sql_in) AND")."
                   ".($_GET['marka']==""?"":" t.markaid=".$_GET['marka']." AND")."
                   ".($_REQUEST['meretek']==""?"":" vk.megnevezes = '".$_REQUEST['meretek']."' AND")."
                   t.torolve IS NULL AND 
                   t.aktiv>=1 AND
                   t.klub_termek = 1 AND
                   vk.aktiv=1 AND 
                   vk.keszlet_1>0
                 GROUP BY t.opcio";

          $row_cc = (int)mysql_result(mysql_query($sql_cc), 0);
                                         
          if ($row_uj>0 || $row_cc>0 || $row_akcios>0){

              $this->filter.= '<br />';
              $this->filter.= $lang->valaszthato_opciok.' ';
			  
			  if (($_GET['opcio']=='') || (!isset($_GET['opcio'])))	$class='opcio-active'; else $class='opcio';
			
			$this->filter.= '<span class="'.$class.'"> 
								&nbsp;&nbsp;&nbsp;&nbsp;
								<a href="#" onclick="document.getElementById(\'navi_opt\').value=\'\'; document.naviForm.submit();">'.($_GET['opcio']==''?$lang->minden_termek:$lang->minden_termek).'</a></span>';
			
			$class= ($_GET['opcio']=='uj'?'opcio-active':'opcio');
              if ($row_uj>0) $this->filter.= '<span class="'.$class.'">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<a href="#" onclick="document.getElementById(\'navi_opt\').value=\'uj\'; document.naviForm.submit();">'.($_GET['opcio']=='uj'?$lang->uj_termekek:$lang->uj_termekek).'</a></span>';
			
			$class= ($_GET['opcio']=='coreclub'?'opcio-active':'opcio');
              if ($row_cc>0) $this->filter.= '<span class="'.$class.'">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<a href="#" onclick="document.getElementById(\'navi_opt\').value=\'coreclub\'; document.naviForm.submit();">'.($_GET['opcio']=='coreclub'?$lang->coreclub_termekek:$lang->coreclub_termekek).'</a></span>';
			
			$class= ($_GET['opcio']=='akcios'?'opcio-active':'opcio');
              if ($row_akcios>0) $this->filter.= '<span class="'.$class.'">
													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<a href="#" onclick="document.getElementById(\'navi_opt\').value=\'akcios\'; document.naviForm.submit();">'.($_GET['opcio']=='akcios'?$lang->akcios_termekek:$lang->akcios_termekek).'</a></span>';

          }*/
		  
		  //Rendezés selectbox
          $tomb = array("1"=>$lang->rendezes, "3"=>$lang->legdragabb_elol, "4"=>$lang->legolcsobb_elol);
		  $this->filter.= '<div style="float:right; vertical-align:middle; display:inline;">';
          $this->filter.= $func->createArraySelectBox($tomb, $_SESSION['termekek_orderby'], "style='width:160px;' name=\"orderby\" onchange=\"document.naviForm.submit()\"", "");
		  $this->filter.= '</div>';		  
		  
		  
        //SKULLCANDY
		if ($_GET['kategoria']===141 || $_GET['kategoria']===142)	{

			$SkullcandySQL = "SELECT t.termeknev
							FROM termekek t
							INNER JOIN vonalkodok v ON t.id=v.id_termek
							WHERE t.kategoria=".$_GET['kategoria']."
							AND v.keszlet_1>0
							AND t.aktiv=1
							AND t.torolve IS NULL
							GROUP BY t.termeknev
							ORDER BY t.termeknev";
				   
			$SkullcandyQuery = mysql_query($SkullcandySQL);

			$this->filter.= '<div style="border-top:1px solid #222; margin-top:5px; padding:5px 5px 0 5px; text-align:left;">';
			
			while ($type = mysql_fetch_array($SkullcandyQuery)){
				if ($_GET['keresendo']===$type[0]) $style='color:#FFF;font-weight:bold;'; else $style='';
				
				if(!empty($_GET['orderby']))
					$url='?orderby='.$_GET['orderby'].'&keresendo='.$type[0];
				else
					$url='?keresendo='.$type[0];
				
				$this->filter.= '<a href="'.$url.'" style="margin-right:20px;text-transform:uppercase;'.$style.'">'.$type[0].'</a>';
				
			}						
			$this->filter.= '</div>';
		}
		
		// MARKAK DIREKT LINK
		elseif($_GET['kategoria']<>0)	{
		
			$url = $_GET['query'];
			$exp = explode("/", $url);
			$page = $exp[1];
		
			$kat = $func->convertString($lang->$kName)."/".$_GET['kategoria'];
			
			$MarkakSQL = "SELECT 
							m.id, m.markanev 
							FROM markak m
							INNER JOIN termekek t ON (t.markaid = m.id)
							INNER JOIN vonalkodok vk ON (vk.id_termek=t.id)
							WHERE 
							".($sql_in==""?"":" t.kategoria IN ($sql_in) AND")."
							".($_REQUEST['meretek']==""?"":" vk.megnevezes = '".$_REQUEST['meretek']."' AND")."
							".$os."
							t.torolve IS NULL AND 
							t.aktiv>=1 AND
							vk.aktiv=1 AND 
							keszlet_1>0
							GROUP BY m.id
							ORDER BY m.markanev";
			
			// Belga e-shop kategorianal nem jelennek meg a markak
			$belga_kat = array(150,151,152,153,154,155);
			
			if (!in_array($_GET['kategoria'],$belga_kat) )	{
			
			$this->filter.= '<div style="border-top:1px solid #222; margin-top:5px; padding:5px 5px 0 5px; text-align:left;">';
			
			$this->filter .= '<a href="/'.$_SESSION["langStr"].'/'.$page.'/'.$kat.'">'.$lang->osszes_marka.'</a> &nbsp;&nbsp;&middot; ';			
			
			$MarkakQuery = mysql_query($MarkakSQL);
			
			while ($marka = mysql_fetch_array($MarkakQuery))	{
			
				if ((int)$_GET['marka']==$marka[0]) $style='color:#FFF;font-weight:bold;'; else $style='';
							
				$this->filter.= '<a href="/'.$_SESSION["langStr"].'/'.$page.'/'.$kat.'/'.$marka[1].'/'.$marka[0].'" style="margin: 0 10px;text-transform:uppercase;'.$style.'">'.$marka[1].'</a>';
			}	
			
			$this->filter.= '</div>';
			}
		}
		
		
		  
		  // end of form
          $this->filter.= '</form>';
		  
		  
          
          //ÚJ KERESÉSI FEJLÉC VÉGE
          //*****************************************************************************
          //*****************************************************************************
    }       
    
    function echoRoot(){

      global $menu;
      global $func;
      global $page;
      global $lang;
        
      if (ISSET($_GET['kategoria'])) {
          
          $menu->parents=array();
          $parents = $menu->getParents($_GET['kategoria']);
          $menu->childrens=array();
          $childrens = $menu->getChildrens($_GET['kategoria']);
          
          while ($t = each($childrens)){
            $sql_in .= $t[1][0].",";
          }
          $sql_in=substr($sql_in, 0, -1);
                
      }

      if (ISSET($_GET['marka'])){
          
          $mark=mysql_fetch_array(mysql_query("SELECT markanev FROM markak WHERE id=".$_GET['marka'])); 
          if (!empty($mark[0])) $marka_str=' &raquo '.$mark[0];
      
      }
      
      if (ISSET($_GET['opcio'])){
        switch ($_GET['opcio']){
          case 'uj' : $root .=('<a href="/'.$_SESSION["langStr"].'/'.$lang->_termekek_uj.'">Új termékek</a> &raquo '); break;
          case 'akcios' : $root .=('<a href="/'.$_SESSION["langStr"].'/'.$lang->_termekek_akcios.'">Akciós termékek</a> &raquo '); break;
          case 'web' : $root .=('<a href="/'.$_SESSION["langStr"].'/'.$lang->_termekek_web.'">Web exclusive</a> &raquo '); break;
		  case 'coreclub' : $root .=('<a href="/'.$_SESSION["langStr"].'/'.$lang->_termekek_coreclub.'">Klub termékek</a> &raquo '); break;
        }
      }

      if (ISSET($_GET['kategoria'])){
          
          while ($t = each($parents)){
          
              if (key($parents)=="" && (int)$_GET['marka']<1){
                  
                  $root .= $t[1][1];
                  
              }else{
                  
                  $root .= "<a href=\"/$page/".$func->convertString($t[1][1])."/".$t[1][0]."\">".$t[1][1]."</a>";
                  
              }
              
              $root .= " &raquo; ";
              
              
          }
          $root = substr($root, 0, -8); 
      
      }
      
      if ($_POST['keresendo']!="") echo 'keresendő: <b>'.htmlspecialchars($_POST['keresendo']).'</b>';
      else echo $root.$marka_str;     

    }
    
    function getTitleRoot($separator=", "){

      global $menu;
      global $func;
      global $page;
      global $lang;
        
      if (ISSET($_GET['kategoria'])) {
          
          $menu->parents=array();
          $parents = $menu->getParents($_GET['kategoria']);
          $menu->childrens=array();
          $childrens = $menu->getChildrens($_GET['kategoria']);
          
          while ($t = each($childrens)){
            $sql_in .= $lang->$t[1][0].",";
          }
          $sql_in=substr($sql_in, 0, -1);
                
      }

      if (ISSET($_GET['marka'])){
          
          $mark=mysql_fetch_array(mysql_query("SELECT markanev FROM markak WHERE id=".$_GET['marka'])); 
          if (!empty($mark[0])) $marka_str=$lang->$mark[0].' '.$separator.' ';
      
      }
      
      /*if (ISSET($_GET['opcio'])){
        switch ($_GET['opcio']){
          case 'uj' : $root .= 'Új termékek '.$separator.' '; break;
          case 'akcios' : $root .= 'Akciós termékek '.$separator.' '; break;
          case 'web' : $root .=  'Web exclusive '.$separator.' '; break;
		  case 'klub' : $root .=  'Klub termékek '.$separator.' '; break;
        }
      }*/

      if (ISSET($_GET['kategoria'])){
          
          while ($t = each($parents)){
          
              $root .= ucfirst($lang->$t[1][1]."$separator ");
              
              
          }
          $root = substr($root, 0, -3); 
      
      }
      
      //return $root.$marka_str;     
      return $marka_str.$root;     

    }

    function echoProductTM($arr){
    
         global $func;
         global $lang;
        
         //var_dump($arr);
        
         echo '<div class="product-thumb">';
		 
		 if($arr['dealoftheweek']==1)
			echo '<div class="product-image-container-horizontal-dotw">
				<img src="/images/coreshop_dealoftheweek_small.png" />
			</div>';
		 
		 // opcio icon
			echo '<div class="product-opcio-container">';				
				if ($arr['opcio']=='UJ') echo '<img src="/images/opcio-uj.png" />';
				//if ( ($arr['opcio']=='CORECLUB') || ($arr['klub_ar']>0) ) echo '<div class="icon-coreclub">Club</div>';
				//if ($arr['akcios_kisker_ar'>0]) echo '<img src="/images/opcio-akcios.png" />';
			echo '</div>';
           
         $directory = $func->getHDir($arr['id']);
         
         if (!is_file($directory.'/'.$arr['fokep'].'_small.jpg')){

             echo '<a href="/'.$_SESSION["langStr"].'/'.$lang->_termek.'/'.$func->convertString($arr['termeknev']).'/'.$arr['id'].'"><img src="/images/none.jpg" alt="'.$arr['termeknev'].'" style="width:200px; height:200px;" /></a>';                     

         }else{
         
             echo '<a href="/'.$_SESSION["langStr"].'/'.$lang->_termek.'/'.$func->convertString($arr['termeknev']).'/'.$arr['id'].'"><img src="/'.$directory.'/'.$arr['fokep'].'_small.jpg" alt="'.$arr['termeknev'].'"  style="width:200px; height:200px;" /></a>';
             
         }
		 
         
         echo '<div class="product-info"> 				
                
                <div class="products-thumb-zoom">';

                 if (!is_file($directory.'/'.$arr['fokep'].'_large.jpg')){

                     echo '<a href="#" class="highslide">';

                 }else{
					
					
                     echo '<a href="/'.$directory.'/'.$arr['fokep'].'_large.jpg" class="highslide" onclick="return hs.expand(this)">';
                     
                 }
                  
                  
         echo     '[+] zoom</a>                
                </div>
               
                  <a href="/'.$_SESSION["langStr"].'/'.$lang->_termek.'/'.$func->convertString($arr['termeknev']).'/'.$arr['id'].'"><h1>'.$arr['markanev'].'</h1></a>        
                  <a href="/'.$_SESSION["langStr"].'/'.$lang->_termek.'/'.$func->convertString($arr['termeknev']).'/'.$arr['id'].'">'.$arr['termeknev'].'</a>
				  <br />
                  <a href="/'.$_SESSION["langStr"].'/'.$lang->_termek.'/'.$func->convertString($arr['termeknev']).'/'.$arr['id'].'">'.$arr['szin'].'</a>';

		
			echo '<div class="products-prise-container">';
			
            if ($lang->defaultCurrencyId == 0){ //MAGYARORSZÁG ESETÉN
                
    			if ($arr['akcios_kisker_ar']>0)	{
    					echo	'<span class="products-thumb-originalprise">'.$lang->Eredeti_ar.': <del>'.number_format($arr['kisker_ar'], 0, '', ' ').'</del> Ft</span><br />';
    					echo	'<span class="products-thumb-saleprise">'.$lang->Akcios_ar.': '.number_format($arr['akcios_kisker_ar'], 0, '', ' ').' Ft</span>';
    					}
    			else
    					echo	$lang->Ar.' '.number_format($arr['kisker_ar'], 0, '', ' ').' Ft';
    			
				/*
				// CoreClub ar
                if ($arr['klub_ar']>0) echo '<div class="products-thumb-clubprise">'.$lang->Club_ar.' '.number_format($arr['klub_ar'],0,'',' ').' Ft</div>'; */
    
            }else{

                //ÁTVÁLTÁS

    			if ($arr['akcios_kisker_ar']>0)	{
    					echo	'<span class="products-thumb-originalprise">'.$lang->Eredeti_ar.': € <del>'.$func->toEUR($arr['kisker_ar']).'</del></span><br />';
    					echo	'<span class="products-thumb-saleprise">'.$lang->Akcios_ar.': € '.$func->toEUR($arr['akcios_kisker_ar']).'</span>';
    					}
    			else
    					echo	$lang->Ar.' € '.$func->toEUR($arr['kisker_ar']);
    			
				/*
				// CoreClub ar
                if ($arr['klub_ar']>0) echo '<div class="products-thumb-clubprise">'.$lang->Club_ar.' '.$func->toEUR($arr['klub_ar']).' €</div>'; */
                
            }
            
			
			echo '</div>';

			/*// opcio
			echo '<div class="product-opcio-container">';
				//echo $arr['opcio'];
				
				if ($arr['opcio']=='UJ') echo '<div class="icon-new">ÚJ!</div>';
				if ($arr['opcio']=='CORECLUB') echo '<div class="icon-coreclub">Club</div>';
				if ($arr['opcio']=='AKCIOS') echo '<div class="icon-sale">%</div>';
				
			echo '</div>';*/
			    
            echo '</div>

               </div>';         
        
    }
    
    
    function echoPageStepper()	{
        
        global $lang;

        if ($this->pagenum>0)	{  
          if (!ISSET($_GET['list_all'])){

               if ($_REQUEST['oldal']>0) echo '&lsaquo; <a href="#" onclick="document.getElementById(\'oldal\').value=\''.($_REQUEST['oldal']-1).'\'; document.pageStepForm.submit()">'.$lang->elozo_oldal.'</a>&nbsp;&nbsp;&nbsp;';
              
               for ($go=1; $go<=$this->pagenum; $go++){
                
                   if ($go>1){ echo('&nbsp;&nbsp;'); }
                   if (($_REQUEST['oldal']+1)==$go){
                  
                       echo '<span class="pagenum">'.$go.'</span> ';
                
                   }else{
                       
                       echo('<a href="#" onclick="document.getElementById(\'oldal\').value=\''.($go-1).'\'; document.pageStepForm.submit()" class="pagenum_inactive">'.$go.'</a> ');
                   }
                   
               }
               
               if (($_REQUEST['oldal']+1)<$this->pagenum) echo '&nbsp;&nbsp;&nbsp; <a href="#" onclick="document.getElementById(\'oldal\').value=\''.($_REQUEST['oldal']+1).'\'; document.pageStepForm.submit()">'.$lang->kovetkezo_oldal.'</a> &rsaquo;';
           
          }    
        }        
    }     
}

?>