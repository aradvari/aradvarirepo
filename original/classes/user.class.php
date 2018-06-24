<?
class user extends functions{
    
    var $errors = array();
    var $message = '';
    var $registration = false;
    var $modify = false;
    var $lapok = array();
    var $forward = '';
    
    function __construct(){

        //COOKIE BELÉPTETÉS ESETÉN
        if ($_COOKIE["coreShopLoginID"]>0)	{

            $f = mysql_fetch_array(mysql_query("SELECT 
                                                * 
                                                FROM felhasznalok f
                                                LEFT JOIN orszag o ON (o.id_orszag = f.id_orszag)
                                                WHERE f.id=".(int)$_COOKIE["coreShopLoginID"]));
            $this->loginUser($f["email"], $f["jelszo"], false);
            
        }
		
		
        //BELÉPTETÉS
        if (ISSET($_SESSION['felhasznalo'])){
        
            if (ISSET($_REQUEST['logout'])){
            
                $this->logoutUser();
                
            }else{
                
                $this->checkUserLogin($_SESSION['felhasznalo']['email'], $_SESSION['felhasznalo']['jelszo']);
                
            }
            
        }else{

            if (ISSET($_POST['login_email']) && ISSET($_POST['login_password'])){

                $this->loginUser($_POST['login_email'], $_POST['login_password']);
            
            }elseif (ISSET($_POST['login_email_admin']) && ISSET($_POST['login_password_admin'])){

                $this->loginUser($_POST['login_email_admin'], $_POST['login_password_admin'], false);
            
            }else{
             
                $this->logoutUser();
                
            }
        
        }
        
    }
    
    function isLogged(){
    
        if ($this->checkUserLogin($_SESSION['felhasznalo']['email'], $_SESSION['felhasznalo']['jelszo'])){
            
            return true;
        
        }else{
            
            return false;
            
        }
        
    }
    
    function isForeign(){
        
        //Ha még nincs bejelentkezve, és a nyelv ANGOL, akkor külföldinek tekintjük
        if (!$this->isLogged() && $_SESSION["currencyId"]==1) return true;
        
        //Leellenőrizzük milyen országgal regisztrált, e szerint állapítjuk meg hogy külföldi, vagy sem
        if ($_SESSION['felhasznalo']["id_orszag"]>1) return true;
        return false; 
        
    }
    
    function checkUserLogin($username, $pass){
		
        $num = mysql_num_rows(mysql_query("SELECT 
                                                * 
                                                FROM felhasznalok f
                                                LEFT JOIN orszag o ON (o.id_orszag = f.id_orszag) 												
												WHERE torolve IS NULL AND email='".$username."' AND jelszo='".$pass."' ORDER BY id DESC LIMIT 1") );

        if ($num>0) {

            $_SESSION['felhasznalo'] = mysql_fetch_array(mysql_query("SELECT 
                                                * 
                                                FROM felhasznalok f
                                                LEFT JOIN orszag o ON (o.id_orszag = f.id_orszag) 
												WHERE torolve IS NULL AND email='".$username."' AND jelszo='".$pass."' ORDER BY id DESC LIMIT 1") );

            //Adatok megjegyzése
            if (ISSET($_POST["rememberLogin"])) setcookie("coreShopLoginID", $_SESSION["felhasznalo"]["id"], time() + 86400 * 365 );
    
            return true; 

        }else{
        
            $this->logoutUser();
            return false;
        
        }
        
    }  

    function loginUser($email, $pass, $md5=true){

        global $error;
        
        if ($this->checkUserLogin($email, ($md5?md5($pass):$pass))){

            if ($md5) mysql_query("INSERT INTO log_login (felhasznalonev, jelszo, ipcim, datum, megjegyzes) VALUES ('".strtolower($email)."', '".md5($pass)."', '".$this->getIpAddress()."', NOW(), 'SIKERES')");
                  
            if ($md5) $_SESSION['felhasznalo'] = mysql_fetch_array(mysql_query("SELECT 
                                                * 
                                                FROM felhasznalok f
                                                LEFT JOIN orszag o ON (o.id_orszag = f.id_orszag) 
												WHERE torolve IS NULL AND email='".$email."' AND jelszo='".md5($pass)."' ORDER BY id DESC LIMIT 1") );
												
            else $_SESSION['felhasznalo'] = mysql_fetch_array(mysql_query("SELECT 
                                                * 
                                                FROM felhasznalok f
                                                LEFT JOIN orszag o ON (o.id_orszag = f.id_orszag) 
												WHERE torolve IS NULL AND email='".$email."' AND jelszo='".$pass."' ORDER BY id DESC LIMIT 1") );

            mysql_query("UPDATE felhasznalok SET session_id='".session_id()."', utolso_belepes=NOW() WHERE id=".(int)$_SESSION['felhasznalo']['id']);    

            //Header("Location: /"); die();

            
        }else{
            
            mysql_query("INSERT INTO log_login (felhasznalonev, jelszo, ipcim, datum, megjegyzes) VALUES ('".strtolower($email)."', '".md5($pass)."', '".$this->getIpAddress()."', NOW(), 'SIKERTELEN')");
            
            $this->logoutUser();
            $error->addError("Sikertelen bejelentkezés!");
            
        }
        
    }	
	
    
    function logoutUser(){
        
        @mysql_query("UPDATE felhasznalok SET session_id=NULL WHERE id=".(int)$_SESSION['felhasznalo']['id']);    
        unset($_SESSION['felhasznalo']);
        setcookie("coreShopLoginID", $_SESSION["felhasznalo"]["id"], time());
        //unset($_SESSION['kosar']);
        
    }

		
    function cartManager(){

        global $error;
        global $lang;
        
        //TERMÉK TÖRLÉS A KOSÁRBÓL
        if (ISSET($_POST['delid_kosar'])){
            
            $_SESSION['kosar'][$_POST['delid_kosar']][2]--;
            
            if ($_SESSION['kosar'][$_POST['delid_kosar']][2]<1){
            
                $vagottTomb = array_merge(array_slice($_SESSION['kosar'], 0, $_POST['delid_kosar']), array_slice($_SESSION['kosar'], $_POST['delid_kosar']+1));
          
                $_SESSION['kosar']=$vagottTomb;
                
            }
            
        }
                
        //KOSÁRKEZELÉS
        $mehet=true; 
        $mehet2=true;
      
        if (ISSET($_POST['mennyiseg'])) if ($_POST['mennyiseg']=='') { $error->addError($lang->Valaszd_ki_a_mennyiseget); $mehet=false; }
        if (ISSET($_POST['meret'])) if ($_POST['meret']=='') { $error->addError($lang->Valaszd_ki_a_meretet); $mehet2=false; }
      
        if (ISSET($_POST['mennyiseg']) && ISSET($_POST['termekid']) && ISSET($_POST['ar']) && ISSET($_POST['marka']) && $mehet && $mehet2){
        
            $duplikacio=0;
            
            if (is_array($_SESSION['kosar'])){
              
                while($reszletek=each($_SESSION['kosar'])){
                
                    $meret = @mysql_result(@mysql_query("SELECT megnevezes FROM vonalkodok WHERE aktiv=1 AND id_termek=".$_POST['termekid']." AND vonalkod='".$_POST['meret']."'"), 0);
                      
                    if (($reszletek[1][0]==$_POST['termekid']) && ($reszletek[1][1]==$meret)){
                  
                        $_SESSION['kosar'][$reszletek[0]][2] = $_SESSION['kosar'][$reszletek[0]][2] + (int)($_POST['mennyiseg']);
                        $duplikacio=1;
                        
                    }
                      
                }     
              
            }
              
            if ($duplikacio==0){
                  
                $meret = @mysql_result(@mysql_query("SELECT megnevezes FROM vonalkodok WHERE aktiv=1 AND id_termek=".$_POST['termekid']." AND vonalkod='".$_POST['meret']."'"), 0);
                $szin = @mysql_result(@mysql_query("SELECT szin FROM termekek WHERE id=".$_POST['termekid']), 0);
                  
                $_SESSION['kosar'][] = array ($_POST['termekid'], $meret, $_POST['mennyiseg'], $_POST['ar'], $_POST['marka'], $_POST['termeknev'], $_POST['cikkszam'], $_POST['opciostr'], $_POST['meret'], $szin);
              
                //echo "***<br><br><br><br>";
                //var_dump($_SESSION['kosar']);
                
            }
            
            $error->addCart("*");
              
        }

    }
	
    function isClubUser($userid=0){
        
        //Egyenlőre nincs klubbtagság, így minden esetben false a visszatérés
        return false;
        
        if ((int)$userid<1) $userid=$_SESSION['felhasznalo']['id'];
    
        if ($this->getUserClubPrices($userid) >= (int)$this->getMainParam("klub_hatar")) return true;

        
        //Kártyakód vagy klubtagkód esetén
        $sql = "SELECT klubtag_kod FROM felhasznalok WHERE id=$userid";
        $klubtag_kod = (int)mysql_result(mysql_query($sql), 0);
        $sql = "SELECT kartya_kod FROM felhasznalok WHERE id=$userid";
        $kartya_kod = (int)mysql_result(mysql_query($sql), 0);
        if ($klubtag_kod>0 || $kartya_kod>0) return true;
        
        //Nem klubtag
        return false;
        
    }

    function getUserClubPrices($userid=0){
    
        if ((int)$userid<1) $userid=$_SESSION['felhasznalo']['id'];
        
        $sql = "SELECT sum(kikerulesi_ar) FROM keszlet WHERE id_felhasznalok=$userid";
        $price = (int)mysql_result(mysql_query($sql), 0);

        return $price;
        
    } 

    function isNewClubUser($userid=0){
        
        if ((int)$userid<1) $userid=$_SESSION['felhasznalo']['id'];
    
        if ($this->getUserClubPrices($userid) >= (int)$this->getMainParam("klub_hatar")){
        
            //Kártyakód vagy klubtagkód esetén
            $sql = "SELECT klubtag_kod FROM felhasznalok WHERE id=$userid";
            $klubtag_kod = (int)mysql_result(mysql_query($sql), 0);
            $sql = "SELECT kartya_kod FROM felhasznalok WHERE id=$userid";
            $kartya_kod = (int)mysql_result(mysql_query($sql), 0);
            
            if ($klubtag_kod==0 && $kartya_kod==0) return true;
            
        }
        
        return false;
        
    }
  
}
?>