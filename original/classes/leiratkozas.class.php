<?

class leiratkozas	{
    
    function __construct()	{
    
        global $error;
        global $func;
        global $lang;
        

        if (isset($_POST['email'])) {
		
			if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", trim($_POST['email'])))
                    $error->addError( $lang->Az_email_nem_megfelelo );
			
			else	{
		
				$num = mysql_fetch_array(mysql_query("SELECT * FROM felhasznalok WHERE torolve IS NULL AND email='".trim($_POST['email'])."'"));

				if(!empty($num)) {
					
					if (mysql_query('UPDATE felhasznalok SET hirlevel=0 WHERE email="'.$_POST['email'].'"'))	{
					
						$error->addError( $lang->Sikeres_leiratkozas );
					
						unset($_POST);
						unset($_GET);
						
						}
					
				}
				
				else
					$error->addError( $lang->email_nem_letezik );
					
				}			

			}

	}  
      
}

?>