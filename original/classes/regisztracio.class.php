<?

  class regisztracio {
      
      function __construct(){
      
          //REGISZTRÁCIÓ
          if (ISSET($_POST['regisztracio'])) $this->reg();
          
      }
      
      function reg(){
      
            global $error;
            global $func;
            global $user;
            global $lang;
              
            if (($_POST['jelszo']=='') || ($_POST['jelszo2']=='')){$this->error=$lang->A_jelszo_mezok_kitoltese_kotelezo;}
            if ($_POST['jelszo']<>$_POST['jelszo2']){$this->error=$lang->A_jelszo_mezok_nem_egyeznek;}
            
            //if ($_POST['telefonszam1']==''){$this->error='A telefonszám kitöltése kötelező!';}
            $tel1 = "+36".$_POST['telefonszam1_1'].$_POST['telefonszam1_2'];
            $tel2 = "+36".$_POST['telefonszam2_1'].$_POST['telefonszam2_2'];
            if (!eregi("^([+][0-9]{2,3})([0-9]{1,2})([0-9]{7,8})$", $tel1)) {$this->error=$lang->Az_elsodeleges_telefonszam_nem_megfelelo;}
            if ($_POST['telefonszam2_2']!="" OR $_POST['telefonszam2_1']!="") {
                
                if (!eregi("^([+][0-9]{2,3})([0-9]{1,2})([0-9]{7,8})$", $tel2)) {$this->error=$lang->A_masodlagos_telefonszam_nem_megfelelo;}
                
            }
            $tel1 = $_POST['telefonszam1_0']." ".$_POST['telefonszam1_1']." ".$_POST['telefonszam1_2'];
            $tel2 = $_POST['telefonszam1_0']." ".$_POST['telefonszam2_1']." ".$_POST['telefonszam2_2'];
            
            if ($_POST['email']==''){$this->error=$lang->Az_email_cim_kitoltese_kotelezo;}
            if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $_POST['email'])) {$this->error=$lang->Az_email_cim_formatuma_nem_megfelelo;}
            if ($talalat=mysql_fetch_array(mysql_query("SELECT * FROM felhasznalok WHERE email='".$_POST['email']."'"))){$this->error=$lang->A_megadott_email_cim_mar_foglalt;}

            if ($_POST['emelet']==$lang->Emelet_ajto_egyeb){$_POST['emelet']="";}
            /*if ($_POST['hazszam']=='Házszám'){$_POST['hazszam']="";}*/
            if ($_POST['hazszam']=='' OR $_POST['hazszam']==$lang->Hazszam){$this->error=$lang->A_hazszam_megadasa_kotelezo;}
            if ($_POST['orszag'] == 1){ //MAGYARORSZÁG ESETÉS
                if ($_POST['kozterulet']==''){$this->error=$lang->A_kozterulet_megnevezesenek_kivalasztasa_kotelezo;}
            }
            if ($_POST['utcanev']=='' OR $_POST['utcanev']==$lang->Utcanev){$this->error=$lang->Az_utcanev_kitoltese_kotelezo;}

            if ($_POST['orszag'] == 1){ //MAGYARORSZÁG ESETEN
                if ($_POST['megye']==''){$this->error='A megye kiválasztása kötelező!';}
                if ($_POST['varos']==''){$this->error='A város kiválasztása kötelező!';}
                if (!eregi("^[0-9]{4}$", $_POST['iranyitoszam'])) {$this->error='Az irányítószám nem megfelelő!';}
            }
            //if (!eregi("^[0-9]{3,10}$", $_POST['iranyitoszam'])) {$this->error='Az irányítószám nem megfelelő!';}
            if ($_POST['orszag']==''){$this->error='Az ország kiválasztása kötelező!';}

            if ($_POST['keresztnev']==''){$this->error='A keresztnév kitöltése kötelező!';}
            if ($_POST['vezeteknev']==''){$this->error='A vezetéknév kitöltése kötelező!';}

            //RÖGZÍTÉS
            if ($this->error==''){
                
                if ($_POST['orszag'] == 1){ //MAGYARORSZÁG ESETÉS
                    $orszag_nev = @mysql_result(@mysql_query("SELECT orszag_nev FROM orszag WHERE id_orszag=".(int)$_POST['orszag']), 0);  
                    $megye_nev = @mysql_result(@mysql_query("SELECT megye_nev FROM megyek WHERE id_megye=".(int)$_POST['megye']), 0);  
                    $varos_nev = @mysql_result(@mysql_query("SELECT helyseg_nev FROM helyseg WHERE id_helyseg=".(int)$_POST['varos']), 0);  
                    $kozterulet_nev = @mysql_result(@mysql_query("SELECT megnevezes FROM kozterulet WHERE id_kozterulet=".(int)$_POST['kozterulet']), 0);  
                }else{ //KÜLFÖLD ESETÉN
                    $orszag_nev = @mysql_result(@mysql_query("SELECT orszag_nev FROM orszag WHERE id_orszag=".(int)$_POST['orszag']), 0);  
                    $megye_nev = "";  
                    $varos_nev = $_POST["varos_nev"];  
                    $kozterulet_nev = "";  
                }

                $aktivacios_kod = md5(date("U"));
                
                $query = "
                    INSERT INTO felhasznalok
                    (vezeteknev,
                     keresztnev,
                     cegnev,
                     orszag_nev,
                     id_orszag,
                     irszam,
                     id_megye,
                     megye_nev,
                     id_varos,
                     varos_nev,
                     utcanev,
                     id_kozterulet,
                     kozterulet_nev,
                     hazszam,
                     emelet,
                     email,
                     telefonszam1,
                     telefonszam2,
                     jelszo,
                     hirlevel,
                     aktivacios_kod,
                     regisztralva)
                     VALUES
                     ('".$func->upperFirstChars($_POST['vezeteknev'])."',
                     '".$func->upperFirstChars($_POST['keresztnev'])."',
                     '".trim($_POST['cegnev'])."',
                     '$orszag_nev',
                     ".(int)$_POST['orszag'].",
                     '".trim($_POST['iranyitoszam'])."',
                     ".(int)$_POST['megye'].",
                     '$megye_nev',
                     ".(int)$_POST['varos'].",
                     '$varos_nev',
                     '".$func->upperFirstChars($_POST['utcanev'])."',
                     ".(int)$_POST['kozterulet'].",
                     '$kozterulet_nev',
                     '".trim($_POST['hazszam'])."',
                     '".trim($_POST['emelet'])."',
                     '".trim($_POST['email'])."',
                     '$tel1',
                     '".(strlen($tel2)>10?$tel2:'')."',
                     '".md5($_POST['jelszo'])."',
                     ".(ISSET($_POST['hirlevel'])?1:0).",
                     '$aktivacios_kod',
                     NOW())
                ";
                
                mysql_query("START TRANSACTION");
                
                if (mysql_query($query)){
                
                    require_once ("classes/Mail.class.php");
                    $Mail = new Mail();
                    $send = $Mail->sendMail($_POST['email'], $lang->regisztracios_ertesites, $Mail->generateMailTemplate("templates_mail/registration.".$_SESSION["langStr"], array("nev"=>$_POST['vezeteknev'].' '.$_POST['keresztnev'], "email"=>$_POST['email'])));

                    mysql_query("COMMIT");
                    $user->loginUser($_POST['email'], $_POST['jelszo']);
                    header("Location: /".$_SESSION["langStr"]."/".$lang->_megrendeles);
                    //header("Location: /".$_SESSION["langStr"]."/".$lang->_sikeres_regisztracio);

                }else{
                
                    mysql_query("ROLLBACK");
                    $error->addError("Technikai okokból a regisztrációt nem lehetett befejezni, ismételd meg késöbb!");
                    
                }
              
            }else{
            
                $error->addError($this->error);
                
            }
            
      }
      
  }

?>