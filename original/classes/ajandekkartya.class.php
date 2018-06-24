<?

  class ajandekkartya {

    private $actualPage;    
    private $bankLink;
    
    public $getData = array();
                 
    function __construct(){
        
          global $error;
          global $user;

          $this->actualPage = (int)$_POST["giftpage"];
          
          if ($this->getActualPage()==1 && !$user->isLogged()) $this->actualPage = 0;

          if ($this->getActualPage()==2) $this->registerPage(); //Regisztrációs adatok ellenőrzése
        
    }      
    
    function getBankLink(){
        
        return $this->bankLink;
        
    }
    
    function registerPage(){
        
        global $error;
        
        if ((int)$_POST['osszeg']==0) $error->addError("Az ajándék kártya összege nem lehet 0 Ft!");
        elseif ((int)$_POST['osszeg']%1000<>0) $error->addError("Az ajándék kártya összege 1000 Ft-tal osztható kell legyen!");
        elseif ((int)$_POST['osszeg']>300000) $error->addError("Az ajándék kártya összege nem haladhatja meg a 300 000 Ft-ot!");
                     
        if (trim($_POST['felado_nev'])=="") $error->addError("A feladó nevének kitöltése kötelező!");
        if (trim($_POST['felado_email'])=="") $error->addError("A feladó e-mail címének kitöltése kötelező!");
        elseif (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $_POST['felado_email'])) $error->addError('Az feladó e-mail cím formátuma nem megfelelő!');
        elseif (trim($_POST['felado_email']) != trim($_POST['felado_email2'])) $error->addError("A feladó e-mail címei nem egyeznek!");

        if (trim($_POST['cimzett_nev'])=="") $error->addError("A címzett nevének kitöltése kötelező!");
        if (trim($_POST['cimzett_email'])=="") $error->addError("A címzett e-mail címének kitöltése kötelező!");
        elseif (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $_POST['cimzett_email'])) $error->addError('Az címzett e-mail cím formátuma nem megfelelő!');
        elseif (trim($_POST['cimzett_email']) != trim($_POST['cimzett_email2'])) $error->addError("A címzett e-mail címei nem egyeznek!");
                     
        if (count($error->error)==0){
                
            //Banki tranzakció kezdete
            include('cib/cib.class.php');
            
            $trid = mt_rand(1000,9999).date("is",mktime()).mt_rand(1000,9999).date("is",mktime());
            $ts = date('YmdHis');

            $cib = new cibClass();
            
            $this->bankLink = $cib->msg10(0, $trid, 'CSH'.str_pad((int)$_SESSION['felhasznalo']['id'], 8, "0", STR_PAD_LEFT), (int)$_POST['osszeg'], $ts);
            
            if ($this->bankLink==""){
                
                $error->addError("A Bankkártyás fizetés kódolásánál hiba lépett fel. A fizetést próbáld meg újra!");
                $this->actualPage = 1;
                
            }else{
                
                //$hash = $func->passwordGenerator(12, true, true, true, false);
                $hash = date("i").mt_rand(10,99).substr(time()."", 4).date("s");
                $datum_tol = date("Y-m-d H:i:s", strtotime($_POST['kuldes_ev']."-".$_POST['kuldes_honap']."-".$_POST['kuldes_nap']." ".date("H:i:s")));
                $datum_ig = date("Y-m-d H:i:s", strtotime($_POST['kuldes_ev']."-".$_POST['kuldes_honap']."-".$_POST['kuldes_nap']." ".date("H:i:s")." + 5 years"));
                
                //Ajándék kártya adatok letárolása
                $sql = "
                    INSERT INTO
                      giftcard
                    (azonosito_kod, trid, osszeg, ervenyes_tol, ervenyes_ig, felado_nev, felado_email, cimzett_nev, cimzett_email, uzenet, id_kuldo)
                    VALUES
                    ('".$hash."', 
                    '".$trid."', 
                    ".(int)$_POST['osszeg'].", 
                    '".$datum_tol."', 
                    '".$datum_ig."', 
                    '".$_POST['felado_nev']."', 
                    '".$_POST['felado_email']."', 
                    '".$_POST['cimzett_nev']."', 
                    '".$_POST['cimzett_email']."', 
                    '".$_POST['message']."', 
                    ".(int)$_SESSION['felhasznalo']['id'].")
                ";
                
                if (!mysql_query($sql)){
                    
                    $error->addError("Az adatok tárolása nem sikerült, próbáld meg újra!");
                    $this->actualPage = 1;
                    
                }
                
            }
                   
        }else{
        
            $this->actualPage = 1;
            
        }
        
    }
    
    function getActualPage(){
        
        return $this->actualPage;
        
    }
      
  }

?>