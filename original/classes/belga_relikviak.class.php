<?
ini_set("display_errors", 0);

$_GET['kategoria']=151;	//mert ezt nem kapja meg url-bol

class belga_relikviak	{

	public $filter = '';
    public $alkategoriak = array();
    public $markak = array();
    public $kURL = '';
    
	function __construct()	{

	global $menu;
	global $func;
	global $lang;
		
	////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$product_per_page	= 15;
	  
	if ($this->pages>$product_per_page){$this->pagenum=ceil($this->pages/$product_per_page);}else{$this->pagenum=0;}

	/*$this->lista_query = mysql_query("SELECT 
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
									termekek.dealoftheweek
									FROM termekek 
									LEFT JOIN markak ON termekek.markaid=markak.id 
									LIMIT 10"); */

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
									vk.keszlet_1,
									(CASE WHEN termekek.akcios_kisker_ar>0 THEN termekek.akcios_kisker_ar ELSE termekek.kisker_ar END) vegleges_ar,
									termekek.fokep,
									CONCAT(termekek.termeknev, ' ', termekek.szin, ' ', markak.markanev, ' ', k.megnevezes) keresheto,
									ifnull((SELECT GROUP_CONCAT(megnevezes) FROM vonalkodok WHERE id_termek=termekek.id AND aktiv=1 /*AND keszlet_1>0*/ ), ' ') meretek 
									
									FROM termekek 
									INNER JOIN vonalkodok vk ON (vk.id_termek=termekek.id AND vk.aktiv=1 /*AND (keszlet_1>0)*/ )
									LEFT JOIN markak ON termekek.markaid=markak.id 
									LEFT JOIN kategoriak k ON k.id_kategoriak = termekek.kategoria
									
									WHERE 
									termekek.torolve IS NULL AND 
									termekek.aktiv>=1 AND
									termekek.kategoria=".$_GET['kategoria']."
											
									GROUP BY termekek.id

									/* HAVING 1=1 $keresendo */
									
									ORDER BY 

									/*".$ordeyby_array[$_SESSION['termekek_orderby']].",*/
									
									termekek.opcio,termekek.id DESC
									
									
									LIMIT ".($_REQUEST['oldal']*$product_per_page).", ".(ISSET($_GET['list_all'])?$_GET['list_all']:$product_per_page) );
	
	////////////////////////////////////////////////////////////////////////////////////////////////////
	
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
	
	////////////////////////////////////////////////////////////////////////////////////////////////////
	
	    /*function echoProductTM($arr){
				
         global $func;
         global $lang;        
        
         echo '<div class="product-thumb">';
		 
		 if($arr['dealoftheweek']==1)
			echo '<div class="product-image-container-horizontal-dotw">
				<img src="/images/coreshop_dealoftheweek_small.png" />
			</div>';
		 
		 // opcio icon
			echo '<div class="product-opcio-container">';				
				if ($arr['opcio']=='UJ') echo '<img src="/images/opcio-uj.png" />';
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
    			

    
            }else{

                //ÁTVÁLTÁS

    			if ($arr['akcios_kisker_ar']>0)	{
    					echo	'<span class="products-thumb-originalprise">'.$lang->Eredeti_ar.': € <del>'.$func->toEUR($arr['kisker_ar']).'</del></span><br />';
    					echo	'<span class="products-thumb-saleprise">'.$lang->Akcios_ar.': € '.$func->toEUR($arr['akcios_kisker_ar']).'</span>';
    					}
    			else
    					echo	$lang->Ar.' € '.$func->toEUR($arr['kisker_ar']);
    			

                
            }
            
			
			echo '</div>';

			    
            echo '</div>

               </div>';         
        
    }*/
	
	////////////////////////////////////////////////////////////////////////////////////////////////////
		
	}
	
}