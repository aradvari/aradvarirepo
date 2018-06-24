<?

  class adataim {
      
      function __construct(){
      
          //REGISZTRÁCIÓ
          if (ISSET($_POST['modositas'])){
              
              $this->modify();
              
          }else{
          
              $this->readData();
              
          }
          
      }
      
      function readData(){
      
          //ADATBEOLVASÁS
          $adatok = mysql_fetch_array(mysql_query("SELECT * FROM felhasznalok WHERE id=".(int)$_SESSION['felhasznalo']['id']));
          
          $_POST['vezeteknev'] = $adatok['vezeteknev'];
          $_POST['keresztnev'] = $adatok['keresztnev'];
          $_POST['szuletesi_ev'] = $adatok['szuletesi_ev'];
          $_POST['szuletesi_honap'] = $adatok['szuletesi_honap'];
          $_POST['szuletesi_nap'] = $adatok['szuletesi_nap'];
          $_POST['cegnev'] = $adatok['cegnev'];
          $_POST['orszag'] = $adatok['id_orszag'];
          $_POST['iranyitoszam'] = $adatok['irszam'];
          $_POST['megye'] = $adatok['id_megye'];
          $_POST['varos'] = $adatok['id_varos'];
          $_POST['varos_nev'] = $adatok['varos_nev'];
          $_POST['utcanev'] = $adatok['utcanev'];
          $_POST['kozterulet'] = $adatok['id_kozterulet'];
          $_POST['hazszam'] = $adatok['hazszam'];
          $_POST['emelet'] = $adatok['emelet'];
          $_POST['email'] = $adatok['email'];
          $telefon1 = explode(" ", $adatok['telefonszam1']);
          $telefon2 = explode(" ", $adatok['telefonszam2']);
          $_POST['telefonszam1_0'] = $telefon1[0];
          $_POST['telefonszam1_1'] = $telefon1[1];
          $_POST['telefonszam1_2'] = $telefon1[2];
          $_POST['telefonszam2_0'] = $telefon2[0];
          $_POST['telefonszam2_1'] = $telefon2[1];
          $_POST['telefonszam2_2'] = $telefon2[2];

      }
      
      function modify(){
      
            global $error;
            global $func;
            global $lang;
              
            if ($_POST['jelszo']<>$_POST['jelszo2']){$this->error=$lang->A_jelszo_mezok_nem_egyeznek;}
            
            $tel1 = "+36".$_POST['telefonszam1_1'].$_POST['telefonszam1_2'];
            $tel2 = "+36".$_POST['telefonszam2_1'].$_POST['telefonszam2_2'];
            if (!eregi("^([+][0-9]{2,3})([0-9]{1,2})([0-9]{7,8})$", $tel1)) {$this->error=$lang->Az_elsodeleges_telefonszam_nem_megfelelo;}
            if ($_POST['telefonszam2_2']!="" OR $_POST['telefonszam2_1']!="") {
                
                if (!eregi("^([+][0-9]{2,3})([0-9]{1,2})([0-9]{7,8})$", $tel2)) {$this->error=$lang->A_masodlagos_telefonszam_nem_megfelelo;}
                
            }
            $tel1 = $_POST['telefonszam1_0']." ".$_POST['telefonszam1_1']." ".$_POST['telefonszam1_2'];
            $tel2 = $_POST['telefonszam1_0']." ".$_POST['telefonszam2_1']." ".$_POST['telefonszam2_2'];
            
            //Születési dátum ellenőrzése, ha valami ki van töltve
            if ($_POST['szuletesi_ev']!="" AND $_POST['szuletesi_honap']!="" AND $_POST['szuletesi_nap']!="" ) {
                
                $date = $_POST["szuletesi_ev"]."-".$_POST["szuletesi_honap"]."-".$_POST["szuletesi_nap"];
                if(!strtotime($date)) $this->error = $lang->A_megadott_szuletesi_datum_nem_megfelelo;

                $szul_sql.="
                 szuletesi_ev = ".((int)$_POST['szuletesi_ev']<1?'NULL':$_POST['szuletesi_ev']).",
                 szuletesi_honap = ".((int)$_POST['szuletesi_honap']<1?'NULL':$_POST['szuletesi_honap']).",
                 szuletesi_nap = ".((int)$_POST['szuletesi_nap']<1?'NULL':$_POST['szuletesi_nap']).",";
                
            }

            if ($_POST['emelet']==$lang->Emelet_ajto_egyeb){$_POST['emelet']="";}
            /*if ($_POST['hazszam']=='Házszám'){$_POST['hazszam']="";}*/
            if ($_POST['hazszam']=='' OR $_POST['hazszam']==$lang->Hazszam){$this->error=$lang->A_hazszam_megadasa_kotelezo;}
            if ($_POST['orszag'] == 1){ //MAGYARORSZÁG ESETÉS
                if ($_POST['kozterulet']==''){$this->error=$lang->A_kozterulet_megnevezesenek_kivalasztasa_kotelezo;}
            }
            if ($_POST['utcanev']=='' OR $_POST['utcanev']==$lang->Utcanev){$this->error=$lang->Az_utcanev_kitoltese_kotelezo;}

            if ($_POST['orszag'] == 1){ //MAGYARORSZÁG ESETÉS
                if ($_POST['megye']==''){$this->error='A megye kiválasztása kötelező!';}
                if ($_POST['varos']==''){$this->error='A város kiválasztása kötelező!';}
                if (!eregi("^[0-9]{4}$", $_POST['iranyitoszam'])) {$this->error='Az irányítószám nem megfelelő!';}
            }
            if (!eregi("^[0-9]{3,10}$", $_POST['iranyitoszam'])) {$this->error='Az irányítószám nem megfelelő!';}
            if ($_POST['orszag']==''){$this->error='Az ország kiválasztása kötelező!';}

            if ($_POST['keresztnev']==''){$this->error=$lang->A_keresztnev_kitoltese_kotelezo;}
            if ($_POST['vezeteknev']==''){$this->error=$lang->A_vezeteknev_kitoltese_kotelezo;}

            //RÖGZÍTÉS
            if ($this->error==''){
                
                $orszag_nev = @mysql_result(@mysql_query("SELECT orszag_nev FROM orszag WHERE id_orszag=".(int)$_POST['orszag']), 0);
                $megye_nev = @mysql_result(@mysql_query("SELECT megye_nev FROM megyek WHERE id_megye=".(int)$_POST['megye']), 0);  
                $varos_nev = @mysql_result(@mysql_query("SELECT helyseg_nev FROM helyseg WHERE id_helyseg=".(int)$_POST['varos']), 0);  
                $kozterulet_nev = @mysql_result(@mysql_query("SELECT megnevezes FROM kozterulet WHERE id_kozterulet=".(int)$_POST['kozterulet']), 0);  
                
                $query="
                     UPDATE felhasznalok SET
                     vezeteknev = '".$func->upperFirstChars($_POST['vezeteknev'])."',
                     keresztnev = '".$func->upperFirstChars($_POST['keresztnev'])."',
                     ".$szul_sql."
                     cegnev = '".trim($_POST['cegnev'])."',
                     id_orszag = ".(int)$_POST['orszag'].",
                     orszag_nev = '$orszag_nev',
                     irszam = '".trim($_POST['iranyitoszam'])."',
                     id_megye = ".(int)$_POST['megye'].",
                     megye_nev = '$megye_nev',
                     id_varos = ".(int)$_POST['varos'].",
                     varos_nev = '$varos_nev',
                     utcanev = '".$func->upperFirstChars($_POST['utcanev'])."',
                     id_kozterulet = ".(int)$_POST['kozterulet'].",
                     kozterulet_nev = '$kozterulet_nev',
                     emelet = '".trim($_POST['emelet'])."',
                     hazszam = '".trim($_POST['hazszam'])."',
                     telefonszam1 = '$tel1',
                     telefonszam2 = '".(strlen($tel2)>10?$tel2:'')."',
                     ".(empty($_POST['jelszo'])?'':'jelszo=\''.md5($_POST['jelszo']).'\',')."
                     hirlevel = ".(ISSET($_POST['hirlevel'])?1:0).",
                     modositva = 1,
                     modositva2 = 1,
                     modositva3 = 1
                     WHERE
                     id=".(int)$_SESSION['felhasznalo']['id'];
				                     
                mysql_query("START TRANSACTION");
                
                if (mysql_query($query)){
				
                    if (!empty($_POST['jelszo'])) $_SESSION['felhasznalo']['jelszo'] = md5($_POST['jelszo']);
                    
                    $this->readData();
                    mysql_query("COMMIT");
                    //$error->addMEssage($lang->Az_adatok_mentese_sikeres_volt);
					header("Location: /".$lang->defaultLangStr."/".$lang->_megrendeles);

                }else{
                
                    mysql_query("ROLLBACK");
                    $error->addError($lang->Technikai_problema);
                    
                }
              
            }else{
            
                $error->addError($this->error);
                
            }
            
      }
      
  }

?>