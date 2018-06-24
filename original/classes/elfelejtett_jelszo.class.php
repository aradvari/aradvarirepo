<?

class elfelejtett_jelszo{
    
    function __construct(){
    
        global $error;
        global $func;
        global $lang;
        
        
		// AKTIVALAS
        if (ISSET($_GET['azonosito']) && ISSET($_GET['kod'])) {

            if ($_GET['azonosito']=="" && $_GET['kod']=="") $this->message = $lang->Az_elsodeleges_telefonszam_nem_megfelelo;
            
            $ln = mysql_fetch_array(mysql_query("SELECT * FROM felhasznalo_elf_jelszo WHERE sztorno IS NULL AND id_felhasznalo='".$_GET['azonosito']."' AND aktiv_kod='".$_GET['kod']."' ORDER BY id_felhasznalo_elf_jelszo DESC LIMIT 1"));
            //echo "SELECT * FROM felhasznalo_elf_jelszo WHERE sztorno IS NULL AND id_felhasznalo='".$_GET['azonosito']."' AND aktiv_kod='".$_GET['kod']."' ORDER BY id_felhasznalo_elf_jelszo DESC LIMIT 1";
            $id = $ln['id_felhasznalo'];

            if ($id>0){

              $sql = "UPDATE felhasznalo_elf_jelszo SET sztorno=NOW() WHERE id_felhasznalo_elf_jelszo=".(int)$ln['id_felhasznalo_elf_jelszo'];
              $sql2 = "UPDATE felhasznalok SET jelszo = '".$ln['uj_jelszo']."' WHERE id=".(int)$ln['id_felhasznalo'];
                
              if (mysql_query($sql) && mysql_query($sql2)){

                    $error->addError( $lang->Sikeres_jelszo_aktivalas );
					
					/* Sikeres jelszó aktiválás!<br />Új jelszavaddal <a href="/hu/megrendeles">itt</a> jelentkezhetsz be az oldalra. */
					
                
              }else{
                
                    $error->addError( $lang->Sikertelen_jelszo_aktivalas." - ".mysql_error() );
                
              }
                
            }else{
            
                $error->addError( $lang->Nem_vegrehajthato_jelszo_aktivalas );
                
            }
            
        }
		
        
        
		// JELSZO KULDES
        if (ISSET($_POST['elfelejtett_jelszo'])) {

			
              $num = mysql_fetch_array(mysql_query("SELECT * FROM felhasznalok WHERE torolve IS NULL AND email='".trim($_POST['email'])."'"));

              if (trim($_POST['email'])=="") $error->addError( $lang->Az_email_cim_kitoltese_kotelezo.'<br /><br />' );
              elseif (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", trim($_POST['email']))) { 
                    $error->addError( $lang->Az_email_nem_megfelelo.'<br /><br />' );
              }elseif (empty($num)) $error->addError( $lang->email_nem_letezik.'<br /><br />' ); 
              
              if ($_POST['jelszo1']=="" OR $_POST['jelszo2']=="") $error->addError( $lang->A_jelszo_mezo_kitoltese_kotelezo.'<br /><br />' );
              elseif ($_POST['jelszo1']!=$_POST['jelszo2']) $error->addError( $lang->A_jelszo_mezok_nem_egyeznek.'<br /><br />' );
              elseif (strlen($_POST['jelszo1'])<5) $error->addError( $lang->A_megadott_jelszo_rovid.'<br /><br />' );

              if (count($error->error)==0){
              
                  // @desc JELSZÓ KÉRELEM INDÍTÁSA                  

                  mysql_query("START TRANSACTION");

                  $sql = "
                    INSERT INTO felhasznalo_elf_jelszo 
                    (id_felhasznalo, aktiv_kod, uj_jelszo)
                    VALUES
                    ('".(int)$num['id']."', '".sha1(md5(trim($_POST['jelszo1'])))."', '".md5(trim($_POST['jelszo1']))."')
                  ";
                  
                  if (mysql_query($sql)){
                   
                      //EMAIL KIKÜLDÉSE A LICITÁLÓK RÉSZRE
                      //$link = $func->getMainParam("main_url")."/".$_SESSION["langStr"]."/".$lang->_elfelejtett_jelszo."/azonosito/".$num['id']."/kod/".sha1(md5(trim($_POST['jelszo1'])));
                      $link = 'http://'.$_SERVER['SERVER_NAME']."/".$_SESSION["langStr"]."/".$lang->_elfelejtett_jelszo."/azonosito/".$num['id']."/kod/".sha1(md5(trim($_POST['jelszo1'])));
                      
                      require_once ("classes/Mail.class.php");
                      $Mail = new Mail();
                      $send = $Mail->sendMail($_POST['email'], $lang->Jelszomodositasi_kerelem, $Mail->generateMailTemplate("templates_mail/forgot_pwd.".$_SESSION["langStr"], array("link"=>$link)));

                      if ($send){
                      
                          mysql_query("COMMIT");
                          $error->addError( $lang->Sikeres_jelszo_valtoztatas );
                          unset($_POST);
						  
						  /* Jelszóváltoztatási kérelmed rögzítettük, aktiváló levelet küldtünk e-mail címedre.<br />
						  Jelszavad akkor lesz aktív, ha megnyitod az e-mail-ben kapott aktiváló linket. */
						  

                      }else{
                          
                          mysql_query("ROLLBACK");
                          $error->addError( $lang->Sikertelen_jelszo_valtoztatas." - ".$mail->ErrorInfo);
						  
                      }
                      
                  }else{
                      
                      mysql_query("ROLLBACK");
                      $error->addError( $lang->Adatrogzitesi_hiba );

                  }
                  
                  
              }
           
        }
        
        /*
		// KULON AKTIVALAS MAR NINCS HASZNALATBAN
        if (ISSET($_POST['aktivalo_kod'])){
        
              $num = mysql_fetch_array(mysql_query("SELECT * FROM felhasznalok WHERE torolve IS NULL AND aktivacios_kod!='' AND email='".trim($_POST['email'])."'"));

              if (trim($_POST['email'])=="") $error->addError( $lang->Az_email_cim_kitoltese_kotelezo );
              elseif (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", trim($_POST['email']))) { 
                    $error->addError( $lang->Az_email_nem_megfelelo );
              }elseif (empty($num)) $error->addError( $lang->Az_email_mar_letezik ); 

              if (trim($_POST['email'])=="") $error->addError( $lang->Az_email_cim_kitoltese_kotelezo );
              elseif (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", trim($_POST['email']))) { 
                    $error->addError( $lang->Az_email_nem_megfelelo );
              }elseif (empty($num)) $error->addError( $lang->Az_email_nem_letezik_vagy_aktiv ); 
              
              if (count($error->error)==0){
              
                  /**
                  * @desc AKTIVÁLÓ KÓD KIKÜLDÉSE
                  */
					
					/*
                  $link = $func->getMainParam('main_url')."/".$lang->defaultLangStr."/".$lang->_aktivalas."/aktivacioskod/".$num['aktivacios_kod']."/email/".$_POST['email'];
                  
                  require_once ("classes/Mail.class.php");
                  $Mail = new Mail();
                  $send = $Mail->sendMail($_POST['email'], $lang->Aktivacios_link, $Mail->generateMailTemplate("templates_mail/activation.".$_SESSION["langStr"], array("link"=>$link)));
                  
                  if ($send){
                  
                      $error->addError( $lang->Aktivacios_level_kikuldve );
                      unset($_POST);
					 

                  }else{
                      
                      $error->addError($lang->Aktivacios_level_nincs_kikuldve." - ".$mail->ErrorInfo);
					 
                      
                  }
                      
                  
              }
            
        }
		*/
        

        
    }  
      
}

?>