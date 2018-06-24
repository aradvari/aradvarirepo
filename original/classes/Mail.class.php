<?

/**
* Lev�l kezel� oszt�ly
*/
class Mail{
    
    /**
    * Oszt�ly bevezet�se, lev�lk�ld� PHPMailer oszt�ly be�gyaz�sa
    * 
    */
    function __construct(){
        
        require_once ("classes/phpmailer/class.phpmailer.php");
        
    }
    
    /**
    * Levelez�s be�ll�t�sa, p�ld�nyos�t�sa
    * 
    * @return object
    */
    function initMail(){
        
        global $func;
        
        $mail = new PHPMailer();
        
        $mail->IsSMTP($func->getMainParam('mail_smtp')=='true'?true:false);
        if ($func->getMainParam('mail_host')!="") $mail->Host = $func->getMainParam('mail_host');
        if ((int)$func->getMainParam('mail_port')>0) $mail->Port = (int)$func->getMainParam('mail_port');

        $mail->SMTPAuth = $func->getMainParam('mail_auth')=='true'?true:false;
        $mail->Username = $func->getMainParam('mail_user');
        $mail->Password = $func->getMainParam('mail_pwd');
        
        $mail->From     = $func->getMainParam('mail_from');
        $mail->FromName = $func->getMainParam('mail_fromname');;
        $mail->SetLanguage(LANG_STR, "classes/phpmailer/language/"); 
        $mail->CharSet = "UTF-8";
        
        return $mail;
        
    }
    
    /**
    * Fizikai sablon file beolvas�sa �s az abban tal�lhat� >>PARAM><<< param�terek cser�je
    * 
    * @param string $file - file root-ja
    * @param Array $params - A lecser�lend� param�terek, ahol a tomb kulcsa a sablonban tal�lhat� param�ter, a t�mb �rt�ke meg sablon param�ter helyre ker�l
    * @return mixed
    */
    function generateMailTemplate($file, $params){
        
        $gt = file_get_contents($file);

        if (!$gt) return false;
        
        $gt = iconv("ISO-8859-2", "UTF-8", $gt);
        
        if (is_array($params)){
            
            foreach ($params as $key=>$value){
                
                $gt = str_replace ("#".$key."#", $value, $gt);
                
            }
            
        }
        
        return $gt;
        
    }
    
    /**
    * Elk�ldi a levelet
    * 
    * @param string $mails - email c�mek vessz�vel elv�lasztva
    * @param string $subject - lev�l t�rgya
    * @param string $body - lev�l sz�vege
    * @param string $ccs - cc-k, vessz�vel elv�lasztva
    */
    function sendMail($mails, $subject, $body, $ccs=''){  
        
        global $error;
        
        $Mail = $this->initMail();
        
        if (is_array($mails)){
             
            foreach($mails as $mail) $Mail->AddAddress($mail,"");  
        
        }else{
        
            $Mail->AddAddress($mails,"");  
            
        }
        
        if ($ccs!=""){
            
            if (is_array($ccs)){
                 
                foreach($ccs as $cc) $Mail->addCC($cc,"");  
            
            }else{
            
                $Mail->AddAddress($ccs,"");  
                
            }
            
        }
        
        $Mail->IsHTML(true);                               
        
        $Mail->Subject = $subject;
        
        $Mail->Body    = $body;

        if (!$Mail->Send()){
        
            $error->addError( $Mail->ErrorInfo );
            return true;
            
        }else{

            return true;

        }        
        
    }

}
?>