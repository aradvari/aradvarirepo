<?

  class aktivalas {

    function __construct(){

          global $error;
        
          //AKTIVÁCIÓ
          if (ISSET($_GET['aktivacioskod']) && ISSET($_GET['email'])){
              
            if ($ellenorzes=mysql_fetch_array(mysql_query("SELECT * FROM felhasznalok WHERE email='".$_GET['email']."' AND aktivacios_kod='".$_GET['aktivacioskod']."'"))){
            
                mysql_query("UPDATE felhasznalok SET aktivacios_kod=NULL WHERE id=".$ellenorzes[0]);
                $error->addMessage("Az aktiváció sikeres volt, most már bejelentkezhetsz a rendszerbe!");
            
            }else{
            
                $error->addError("A megadott adatokkal az aktiváció nem hajtható végre, vagy már aktivált a felhasználó!");
            
            }
            
          }
        
    }      
      
  }

?>