<?

  class kapcsolat {
        
	function __construct(){
		//REGISZTRÁCIÓ
        if (ISSET($_POST['msg'])) $this->message_send();
	}
		  
    function message_send(){
      
		global $error;
		global $func;
		global $user;
		global $lang;
		
		if(empty($_POST['msg-name'])) {$error->addError($lang->nev_megadasa_kotelezo);}
		if(empty($_POST['msg-email'])) {$error->addError($lang->email_megadasa_kotelezo);}
		if(empty($_POST['msg-msg'])) {$error->addError($lang->uzenet_megadasa_kotelezo);}
		
		//echo $this->error;
		
		
		//rogzites
		//if ($this->error===''){
		if (empty($error))	{
			echo 'rogzites';			
			/*$query='INSERT INTO uzenetek (nev,email,tel,uzenet,id_statusz) 
					VALUES ('.$_POST['msg_nev'].', '.$_POST['msg_email'].', '.$_POST['msg_tel'].', '.$_POST['msg_uzenet'].', 1)';
			
			if (mysql_query($query))
				$error->addError("Üzenet elküldve");
			
			else echo $query;*/
		}
		else print_r($_POST);
		
		
    }
      
  }

  //$error->addError("Technikai okokból a regisztrációt nem lehetett befejezni, ismételd meg késöbb!");
  //header("Location: /".$_SESSION["langStr"]."/".$lang->_megrendeles);
?>