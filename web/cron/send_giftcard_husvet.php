<?
require_once ("../config/config.php");
require_once ("../classes/connect.class.php");
require_once ("../classes/functions.class.php");
require_once ("../classes/phpmailer/class.phpmailer.php");

$db = new connect_db();
$mail = new PHPMailer();
$func = new functions();

if (!$db->connect(DB_HOST, DB_USER, DB_PW)) die("database connect error: ".$db->error);
if (!$db->select_db(DB_DB)) die("database select error: ".$db->error);

$sql = "SELECT * FROM giftcard WHERE kikuldve IS NULL AND ervenyes_tol<=NOW() AND fizetve IS NOT NULL AND id_kuldo=0";
$query = mysql_query($sql);

while ($adatok = mysql_fetch_assoc($query)){

    $mail->IsSMTP($func->getMainParam('mail_smtp')=='true'?true:false);
    if ($func->getMainParam('mail_host')!="") $mail->Host = $func->getMainParam('mail_host');
    if ((int)$func->getMainParam('mail_port')>0) $mail->Port = (int)$func->getMainParam('mail_port');

    $mail->SMTPAuth = $func->getMainParam('mail_auth')=='true'?true:false;
    $mail->Username = $func->getMainParam('mail_user');
    $mail->Password = $func->getMainParam('mail_pwd');

    $mail->From     = $func->getMainParam('mail_from');
    $mail->FromName = $func->getMainParam('mail_fromname');;
    $mail->SetLanguage("hu", "classes/phpmailer/language/"); 
    $mail->CharSet = "UTF-8";

    $mail->to[0][0] = $adatok['cimzett_email'];
    $mail->to[0][1] = "";    

    $mail->IsHTML(true);                               

    $mail->Subject = "Ajándékkártyád érkezett a Coreshop.hu oldalról";         

    $mail->Body = '
        <html>
        <head>

        <style type="text/css">
        <!--
		
		body	{	background-color:#000;	}
		
        .main  {    width:400px;    padding:0px 0px;    background-color:#000;    font-family: Verdana, Arial, Helvetica, sans-serif;    font-size: 13px;    font-weight: normal;    color: #EEE;    text-decoration: none;    text-align:center;    }

        img {  border:none;    }

        a {  color: #9EB91B;  border:none;  outline:none;  text-decoration:none;  font-weight: normal;    }

        a:hover {  text-decoration:underline;    }

        b {  color: #9EB91B;  font-weight:normal;    }

        h1  {    color: #00AEEF;    font-size: 11px;    font-weight: bold;    text-decoration:normal;    }

        h2  {    color: #9EB91B;    font-size: 16px;    font-weight: bold;    text-decoration:normal;    margin: 2px;}

        .footer {  text-align:center;  color:#999;  font-size: 10px;    }

        .content  {  width:620px;  padding:10px; color: #FFF;  text-align:left;    background-image: url(http://www.coreshop.hu/images/egiftcard/mail-bg.jpg); background-position:top center; background-repeat: no-repeat; }

        .btn  {  text-align:center;    }

        .unsubscribe  {  padding: 10px 20px;  font-size: 9px;  color:#999;  }
          
        .separator  {  margin:20px 0;    }

        .image    {    text-align:center; }

        .button    {    text-align:center; color: #FFF;    font-size: 16px;    font-weight: bold;    text-decoration:normal; border:1px solid #333; margin:0 10px; padding:5px;    }
        -->
        </style>

        </head>
        <body>

        <table width="100%" align="center" bgcolor="#000" border="0" class="main" cellpadding="0">
            <tr>
                <td align="center"><a href="http://coreshop.hu"><img src="http://coreshop.hu/egiftcard/mail/egiftcard-mail-top.jpg" border="0" /></a></td>
            </tr>
            
            <tr>
                <td align="center" valign="top">
                <!-- content table -->
                <table class="main" border="0" width="400">
                    <tr><td align="left">
                    
                    <font size="2" style="color:#EEE;" color="#EEE">
                    
                    Kedves <b><font size="2" style="color:#9EB91B;" color="#9EB91B">'.$adatok['cimzett_nev'].'</font></b>!
                    <br />					
                    <br />
					Köszönjük húsvéti megrendelésed! Ehhez kapcsolódóan online ajándékkártyát küldünk neked, melynek vásárlási értéke:
                    <br />
                    <br />
                    <div class="button"><font size="2" style="color:#9EB91B;" color="#9EB91B">'.number_format($adatok['osszeg'], 0, '', ' ').',- Ft</font></div>
                    <br />
                    Felhasználható '.substr($adatok['ervenyes_ig'], 0,10).'-ig.
                    <br />
                    <br />
                    Egyedi azonosítód:
                    <br />
                    <br />
                    <div class="button"><font size="2" style="color:#9EB91B;" color="#9EB91B">'.$adatok['azonosito_kod'].'</font></div>
                    <br />
                    A kártya felhasználásának részleteiről <a href="http://www.coreshop.hu/ajandekkartya"><font size="2" style="color:#9EB91B;" color="#9EB91B">bővebben itt olvashatsz</font></a>.
                    <br />
                    <br />
                    Coreshop
                    
                    </font>
                    
                    </td></tr>
                </table>
                <!-- end of content -->
                
                <br />
                <br />
                <br />
                </td>
            </tr>
            
            <tr>
                <td align="center">
                <a href="http://coreshop.hu"><img src="http://coreshop.hu/egiftcard/mail/egiftcard-mail-bottom.jpg" border="0" /></a>
                <br />
                <br />
                <br />
                <font size="1" style="color:#666;" color="#666">&copy; 2011 - <a href="http://coreshop.hu" style="color:#666;" color="#666" target="_blank">coreshop.hu</a> - Minden jog fenntartva - <a href="mailto:info@coreshop.hu" style="color:#666;" color="#666">info@coreshop.hu</a> </font>
                </td>
            </tr>
            
        </table>

        </body>
        </html>
    ';
                                            
    if ($mail->Send()){
        
        $sql = "UPDATE giftcard SET kikuldve=NOW() WHERE id_giftcard=".$adatok['id_giftcard'];
        mysql_query($sql);
        echo 'OK: '.(int)$adatok['id_giftcard']."<br>";
        
    }else{
        
        echo 'HIBÁS: '.(int)$adatok['id_giftcard']."<br>";
        
    }    
    
}

?>