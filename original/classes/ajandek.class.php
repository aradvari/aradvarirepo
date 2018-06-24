<?

  class ajandek {
      
      var $uzenet;
      
      function __construct(){

  	if ((int)$_SESSION['felhasznalo']['id']>0){          

	  $sql = "SELECT date_format(igenyelt, '%Y.%m.%d') FROM felhasznalok_karkoto WHERE id_felhasznalo = ".(int)$_SESSION['felhasznalo']['id'];
          
          $datum = @mysql_result(@mysql_query($sql), 0);
          
          if ($datum!=''){ // Ha már igényelt
              
              $this->uzenet = '<b>'.$_SESSION['felhasznalo']['email'].'</b> felhasználói fiókoddal, <b>'.$datum.'</b> dátummal már igényeltél Coreshop karkötőt.';
              
          }elseif (ISSET($_POST['ajandek_igenyles'])){ // Ha még nem igényelt
              
              $exec = "INSERT INTO felhasznalok_karkoto (id_felhasznalo, igenyelt) VALUES (".(int)$_SESSION['felhasznalo']['id'].", NOW())";
              
              if (mysql_query($exec)) $this->uzenet = 'Gratulálunk, ajándék karkötődet hamarosan postázzuk!';
              else $this->uzenet = 'Sajnáljuk, de technikai okok miatt az igénylésedet nem tudtuk rögzíteni. Kérjük, próbáld meg késöbb!';
              
          }

	}
      
      }
     
  }

?>