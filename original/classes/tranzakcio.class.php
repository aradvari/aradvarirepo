<?php

class tranzakcio
{

 var $response;
 var $type;

 function __construct()
 {

  global $page;

  if($page == "tranzakcio")
   $this->closeTrans();
 }

 function closeTrans()
 {

  global $user;

  $url=str_replace("query=tranzakcio/&","",$_SERVER["QUERY_STRING"]);

  include('cib/cib.class.php');

  $cib=new cibClass($_SESSION["langStr"],$_SESSION["currencyId"] == 0 ? 'HUF' : 'EUR' );
  $parse=$cib->getData($url);

  //Nyitott e a vizsgálandó tranzakció
  $sql="SELECT * FROM bank_tranzakciok WHERE id_felhasznalo=".$_SESSION['felhasznalo']['id']." AND trid=".$parse["TRID"]." AND lezarva IS NULL";
  $rows=mysql_num_rows(mysql_query($sql));

  if($parse["MSGT"] == "21" && $rows > 0)
  {

   $amo=mysql_result(mysql_query("SELECT amo FROM bank_tranzakciok WHERE id_felhasznalo=".$_SESSION['felhasznalo']['id']." AND trid=".$parse["TRID"]." ORDER BY datum DESC LIMIT 1"),0);

   mysql_query("UPDATE bank_tranzakciok SET history='".$cib->getHistory($parse["TRID"],$amo)."' WHERE trid=".$parse["TRID"]);

   $response=$cib->msg32($parse["TRID"],$amo);
   $this->response=$response;

   if($response["ANUM"] != "" && $response["RT"] != "" && $response["RC"] == "00")
   {

    mysql_query("START TRANSACTION");

    //KIADÁS VÉGLEGESÍTÉSE A MEGRENDELÉS FEJEN
    $idm=mysql_result(mysql_query("SELECT id_megrendeles_fej FROM bank_tranzakciok WHERE id_felhasznalo=".$_SESSION['felhasznalo']['id']." AND trid=".$response["TRID"]." ORDER BY datum DESC LIMIT 1"),0);
    $idg=mysql_result(mysql_query("SELECT id_gift_card FROM bank_tranzakciok WHERE id_felhasznalo=".$_SESSION['felhasznalo']['id']." AND trid=".$response["TRID"]." ORDER BY datum DESC LIMIT 1"),0);

    //Sikeres tranzakció
    $sql="UPDATE bank_tranzakciok SET rc='".$response["RC"]."', rt='".iconv("ISO-8859-2","UTF-8",$response["RT"])."', anum=".$response["ANUM"].", lezarva=NOW() WHERE id_felhasznalo=".$_SESSION['felhasznalo']['id']." AND trid=".$response["TRID"];
    if(!mysql_query($sql))
     $merr=mysql_error();

    //Termék rendelés esetén
    if((int)$idm > 0)
    {

     $this->type=1; // termék típus

     if(!mysql_query("UPDATE megrendeles_fej SET id_statusz=1 WHERE id_megrendeles_fej=".(int)$idm))
      $merr=mysql_error();

     if($merr == "")
     {

      unset($_SESSION['kosar']);
      $this->sendMailMessage($response["TRID"]);
      mysql_query("COMMIT");

      // KLUBKÁRTYA RÖGZÍTÉSE, HA ELÉRTE A HATÁRT
      if($user->isNewClubUser())
      {

       mysql_query("UPDATE felhasznalok SET klubtag_kod='".date("U")."' WHERE id=".$_SESSION['felhasznalo']['id']);
       mysql_query("UPDATE megrendeles_fej SET klubkartya=1 WHERE id_megrendeles_fej = ".(int)$idm);
      }
     }
     else
     {

      mysql_query("ROLLBACK");
     }

     //Ajándékkártya rendelés esetén
    }
    else
    {

     $this->type=2; // giftcard típus

     if(!mysql_query("UPDATE giftcard SET fizetve=NOW() WHERE trid='".$parse["TRID"]."'"))
      $merr=mysql_error();

     if($merr == "")
     {

      $this->sendMailMessage($response["TRID"]);
      mysql_query("COMMIT");
     }
     else
     {

      mysql_query("ROLLBACK");
     }
    }
   }
   else
   {

    //Sikertelen tranzakció
    mysql_query("START TRANSACTION");

    $sql="UPDATE bank_tranzakciok SET rc='".$response["RC"]."', rt='".iconv("ISO-8859-2","UTF-8",$response["RT"])."', lezarva=NOW() WHERE id_felhasznalo=".$_SESSION['felhasznalo']['id']." AND trid=".$response["TRID"]." AND lezarva IS NULL";
    if(!mysql_query($sql))
     $merr=mysql_error();

    if($rows > 0)
    { //mysql_affected_rows()>0
     //KIADÁS SZTORNÓZÁSA, KÉSZLET VISSZAVÉT
     $idm=mysql_result(mysql_query("SELECT id_megrendeles_fej FROM bank_tranzakciok WHERE id_felhasznalo=".$_SESSION['felhasznalo']['id']." AND trid=".$response["TRID"]." ORDER BY datum DESC LIMIT 1"),0);

     //Termék rendelése esetén
     if((int)$idm > 0)
     {

      //KIADÁS SZTORNÓZÁSA, GIFTCARD
      $gc=mysql_fetch_assoc(mysql_query("SELECT * FROM giftcard WHERE id_megrendeles_fej=".(int)$idm));
      $gnum=mysql_num_rows(mysql_query("SELECT id_giftcard FROM giftcard WHERE azonosito_kod='".$gc['azonosito_kod']."'"));
      if($gnum > 1)
      {

       if(!mysql_query("DELETE FROM giftcard WHERE azonosito_kod='".$gc['azonosito_kod']."' ORDER BY id_giftcard DESC LIMIT 1"))
        $merr=mysql_error();
       if(!mysql_query("UPDATE giftcard SET felhasznalva=null, felhasznalt_osszeg=null, id_megrendeles_fej=null WHERE id_megrendeles_fej=".(int)$_GET['id']))
        $merr=mysql_error();
      }else
      {

       if(!mysql_query("UPDATE giftcard SET felhasznalva=null, felhasznalt_osszeg=null, id_megrendeles_fej=null WHERE id_megrendeles_fej=".(int)$_GET['id']))
        $merr=mysql_error();
      }

      //készlet
      if(!mysql_query("UPDATE megrendeles_fej SET id_statusz=99 WHERE id_megrendeles_fej=".(int)$idm))
       $merr=mysql_error();

      $sql="SELECT * FROM megrendeles_tetel WHERE id_megrendeles_fej=".(int)$idm;
      $query=mysql_query($sql);
      while($tetelek=mysql_fetch_assoc($query))
      {

       if(!mysql_query("UPDATE vonalkodok SET keszlet_1 = keszlet_1 + 1 WHERE vonalkod='".$tetelek['vonalkod']."'"))
        $merr=mysql_error();
       if(!mysql_query("UPDATE termekek SET keszleten = keszleten + 1 WHERE id=".$tetelek['id_termek']))
        $merr=mysql_error();
       if(!mysql_query("UPDATE keszlet SET kikerulesi_ar=null, kikerulesi_datum=null, id_felhasznalok=null WHERE id_keszlet=".$tetelek['id_keszlet']))
        $merr=mysql_error();

       if(!mysql_query("INSERT INTO forgalom (id_raktar, id_vonalkod, id_keszlet, lista_ar, fogy_ar, statusz, datum) VALUES (1, '".$tetelek['id_vonalkod']."', ".$tetelek['id_keszlet'].", -".$tetelek['termek_ar'].", -".$tetelek['termek_ar'].", 1, NOW())"))
        $merr=mysql_error();
      }
     }

     if($merr == "")
     {

      mysql_query("COMMIT");
      $this->sendMailMessage($response["TRID"]);
     }
     else
     {

      mysql_query("ROLLBACK");
     }
    }
    else
    {

     mysql_query("ROLLBACK");
    }
   }
  }
  else
  {

   if($parse["TRID"] == "")
   {

    header("Location: /");
    die();
   }
   else
   {

    $amo=mysql_result(mysql_query("SELECT amo FROM bank_tranzakciok WHERE id_felhasznalo=".$_SESSION['felhasznalo']['id']." AND trid=".$parse["TRID"]." ORDER BY datum DESC LIMIT 1"),0);

    mysql_query("UPDATE bank_tranzakciok SET history='".$cib->getHistory($parse["TRID"],$amo)."' WHERE trid=".$parse["TRID"]);

    $cib->msg32($parse["TRID"],$amo); //Lezárás

    $response=$cib->msg33($parse["TRID"],$amo);
    $this->response=$response;
   }
  }
 }

 /**
  * CRONos tranzakciók lezárása
  *
  */
 function cronCloseTrans($id_felhasznalo,$trid,$rc,$rt,$phpMailerUrl)
 {

  global $cib;

  mysql_query("START TRANSACTION");

  $amo=mysql_result(mysql_query("SELECT amo FROM bank_tranzakciok WHERE id_felhasznalo=$id_felhasznalo AND trid=$trid ORDER BY datum DESC LIMIT 1"),0);
  $sql="UPDATE bank_tranzakciok SET history='".$cib->getHistory($trid,$amo)."' WHERE trid=$trid";
  if(!mysql_query($sql))
   $merr=mysql_error();

  $sql="UPDATE bank_tranzakciok SET rc='$rc', rt='$rt', lezarva=NOW() WHERE id_felhasznalo=$id_felhasznalo AND trid=$trid AND lezarva IS NULL";
  if(!mysql_query($sql))
   $merr=mysql_error();

  //id_megrendeles_fej lekérdezése
  $idm=mysql_result(mysql_query("SELECT id_megrendeles_fej FROM bank_tranzakciok WHERE id_felhasznalo=$id_felhasznalo AND trid=$trid ORDER BY datum DESC LIMIT 1"),0);

  //Termék rendelése eseétn
  if((int)$idm > 0)
  {

   //KIADÁS SZTORNÓZÁSA, GIFTCARD
   $gc=mysql_fetch_assoc(mysql_query("SELECT * FROM giftcard WHERE id_megrendeles_fej=".(int)$idm));
   $gnum=mysql_num_rows(mysql_query("SELECT id_giftcard FROM giftcard WHERE azonosito_kod='".$gc['azonosito_kod']."'"));
   if($gnum > 1)
   {

    if(!mysql_query("DELETE FROM giftcard WHERE azonosito_kod='".$gc['azonosito_kod']."' ORDER BY id_giftcard DESC LIMIT 1"))
     $merr=mysql_error();
    if(!mysql_query("UPDATE giftcard SET felhasznalva=null, felhasznalt_osszeg=null, id_megrendeles_fej=null WHERE id_megrendeles_fej=".(int)$_GET['id']))
     $merr=mysql_error();
   }else
   {

    if(!mysql_query("UPDATE giftcard SET felhasznalva=null, felhasznalt_osszeg=null, id_megrendeles_fej=null WHERE id_megrendeles_fej=".(int)$_GET['id']))
     $merr=mysql_error();
   }

   //KIADÁS SZTORNÓZÁSA, KÉSZLET VISSZAVÉT
   if(!mysql_query("UPDATE megrendeles_fej SET id_statusz=99 WHERE id_megrendeles_fej=".(int)$idm))
    $merr=mysql_error();

   $sql="SELECT * FROM megrendeles_tetel WHERE id_megrendeles_fej=".(int)$idm;
   $query=mysql_query($sql);
   while($tetelek=mysql_fetch_assoc($query))
   {

    if(!mysql_query("UPDATE vonalkodok SET keszlet_1 = keszlet_1 + 1 WHERE vonalkod='".$tetelek['vonalkod']."'"))
     $merr=mysql_error();
    if(!mysql_query("UPDATE termekek SET keszleten = keszleten + 1 WHERE id=".$tetelek['id_termek']))
     $merr=mysql_error();
    if(!mysql_query("UPDATE keszlet SET kikerulesi_ar=null, kikerulesi_datum=null, id_felhasznalok=null WHERE id_keszlet=".$tetelek['id_keszlet']))
     $merr=mysql_error();

    if(!mysql_query("INSERT INTO forgalom (id_raktar, id_vonalkod, id_keszlet, lista_ar, fogy_ar, statusz, datum) VALUES (1, '".$tetelek['id_vonalkod']."', ".$tetelek['id_keszlet'].", -".$tetelek['termek_ar'].", -".$tetelek['termek_ar'].", 1, NOW())"))
     $merr=mysql_error();
   }
  }

  if($merr == "")
  {

   mysql_query("COMMIT");
   $this->sendMailMessage($trid,$id_felhasznalo,$phpMailerUrl);
  }
  else
  {

   mysql_query("ROLLBACK");
  }
 }

 function sendMailMessage($trid,$id_felhasznalo=0,$phpMailerUrl='classes/phpmailer/class.phpmailer.php')
 {

  global $error;
  global $func;
  global $user;
  global $lang;

  if(is_file("classes/Mail.class.php"))
   require_once ("classes/Mail.class.php");
  else
   require_once ("../classes/Mail.class.php");

  if($id_felhasznalo > 0)
  {

   $_SESSION['felhasznalo']=mysql_fetch_assoc(mysql_query("SELECT * FROM felhasznalok WHERE id=".$id_felhasznalo));
  }

  //id_megrendeles_fej lekérdezése
  $idm=mysql_fetch_assoc(mysql_query("SELECT * FROM bank_tranzakciok WHERE id_felhasznalo=".$_SESSION['felhasznalo']['id']." AND trid=$trid ORDER BY datum DESC LIMIT 1"));

  //Termék rendelés esetén
  if((int)$idm['id_megrendeles_fej'] > 0)
  {

   $sql="SELECT
                      *
                    FROM megrendeles_fej mf
                    LEFT JOIN bank_tranzakciok bt ON (bt.id_megrendeles_fej = mf.id_megrendeles_fej)
                    WHERE bt.trid=$trid /*AND bt.lezarva IS NULL*/";

   $megrendeles=mysql_fetch_assoc(mysql_query($sql));

   if($megrendeles["trid"] == "")
    return false;

   //Kosár összeállítása
   $mail_kosar="<table>
                            <tr bgcolor=\"#F0F0F0\">
                              <th width=\"200\">".$lang->Vonalkod."</th>
                              <th width=\"200\">".$lang->Termeknev."</th>
                              <th width=\"100\">".$lang->Meret."</th>
                              <th width=\"100\">".$lang->Szin."</th>
                              <th width=\"100\">".$lang->Egysegar."</th>
                              <th width=\"100\">".$lang->Mennyiseg."</th>
                              <th width=\"100\">".$lang->Osszesen."</th>
                            </tr>";

   $kosar_db=0;
   $kosar_fizetendo=0;
   $query=mysql_query("SELECT mt.*, count(vonalkod) db FROM megrendeles_tetel mt WHERE mt.id_megrendeles_fej=".$megrendeles['id_megrendeles_fej']." GROUP BY mt.vonalkod");
   while($tetel_adatok=mysql_fetch_assoc($query))
   {

    if($_SESSION["currencyId"] == 0)
    { //MAGYARORSZÁG
     $mail_kosar.= "<tr>
                                     <td>".$tetel_adatok['vonalkod']."</td>
                                     <td>".$tetel_adatok['termek_nev']."</td>
                                     <td>".$tetel_adatok['tulajdonsag']."</td>
                                     <td>".$tetel_adatok['szin']."</td>
                                     <td align=\"right\">".number_format($tetel_adatok['termek_ar'],0,'',' ')." Ft</td>
                                     <td align=\"right\">".number_format($tetel_adatok['db'],0,'',' ')." ".$lang->db."</td>
                                     <td align=\"right\">".number_format(($tetel_adatok['termek_ar'] * $tetel_adatok['db']),0,'',' ')." Ft</td>
                                   </tr>";

     $kosar_db=$kosar_db + $tetel_adatok['db'];
     $kosar_fizetendo=$kosar_fizetendo + ( $tetel_adatok['termek_ar'] * $tetel_adatok['db'] );
    }
    else
    {

     $mail_kosar.= "<tr>
                                     <td>".$tetel_adatok['vonalkod']."</td>
                                     <td>".$tetel_adatok['termek_nev']."</td>
                                     <td>".$tetel_adatok['tulajdonsag']."</td>
                                     <td>".$tetel_adatok['szin']."</td>
                                     <td align=\"right\">".number_format($tetel_adatok['termek_ar_deviza'],2,'.',' ')." €</td>
                                     <td align=\"right\">".number_format($tetel_adatok['db'],0,'',' ')." ".$lang->db."</td>
                                     <td align=\"right\">".number_format(($tetel_adatok['termek_ar_deviza'] * $tetel_adatok['db']),2,'.',' ')." €</td>
                                   </tr>";

     $kosar_db=$kosar_db + $tetel_adatok['db'];
     $kosar_fizetendo=$kosar_fizetendo + ( $tetel_adatok['termek_ar_deviza'] * $tetel_adatok['db'] );
    }
   }

   /**
    * INGYENES SZÁLLÍTÁSOK VÉGE
    */
   if($megrendeles["id_szallitasi_mod"] == 2) //SZEMÉLYES ÁTVÉTEL
    $ingyenes_szallitas=true;

   if($user->isClubUser()) //TÖRZSVÁSÁRLÓ
    $ingyenes_szallitas=true;

   if($func->getMainParam("ingyenes_szallitas") > 0 && !$user->isForeign()) // INGYENES SZALLITAS MAGYARORSZÁGRA
   {
    if($kosar_fizetendo > $func->getMainParam("ingyenes_szallitas"))
     $ingyenes_szallitas=true;
   }elseif($func->getMainParam("ingyenes_szallitas_kulfold") > 0 && $user->isForeign()) // INGYENES SZALLITAS KÜLFÖLDRE
   {
    if($func->toEUR($kosar_fizetendo,true) > $func->getMainParam("ingyenes_szallitas_kulfold"))
     $ingyenes_szallitas=true;
   }
   /**
    * INGYENES SZÁLLÍTÁSOK VÉGE
    */
   if(!$user->isForeign())
   { //MAGYAR
    $szallitasi_dij=$ingyenes_szallitas ? 0 : (int)$func->getMainParam("szallitasi_dij");
   }
   else
   {
    //$szallitasi_dij = $ingyenes_szallitas?0:$func->toEUR( (int)$func->getMainParam("szallitasi_dij_kulfold"), false );
    $szallitasi_dij=$ingyenes_szallitas ? 0 : (int)$func->getMainParam("szallitasi_dij_kulfold");
   }

   if($_SESSION["currencyId"] == 0)
   { //MAGYARORSZÁG
    $mail_kosar.= "
                             <tr bgcolor=\"#F0F0F0\">
                             <td colspan=\"5\">".$lang->Osszesen_tetel."</td>
                             <td align=\"right\">".number_format($kosar_db,0,'',' ')." ".$lang->db."</td>
                             <td align=\"right\">".number_format($kosar_fizetendo,0,'',' ')." Ft</td>
                             </tr>";
   }
   else
   {

    $mail_kosar.= "
                             <tr bgcolor=\"#F0F0F0\">
                             <td colspan=\"5\">".$lang->Osszesen_tetel."</td>
                             <td align=\"right\">".number_format($kosar_db,0,'',' ')." ".$lang->db."</td>
                             <td align=\"right\">".number_format($kosar_fizetendo,2,'.',' ')." €</td>
                             </tr>";
   }

   //Ajándékkártya felhasználás esetén, a kosárhoz hozzácsapja a dolgokat
   if($megrendeles['giftcard_osszeg'] > 0)
   {

    $giftcard=mysql_fetch_assoc(mysql_query("SELECT * FROM giftcard WHERE id_giftcard=".$megrendeles['id_giftcard']));

    $mail_kosar.= "<tr bgcolor=\"#F0F0F0\">
                                 <td colspan=\"5\"><b>".$lang->Ajandekkartya_egyenlege."</b></td>
                                 <td align=\"right\"></td>
                                 <td align=\"right\"><b>".number_format((int)$giftcard['osszeg'],0,'',' ')." Ft</b></td>
                                 </tr>
                                 <tr bgcolor=\"#F0F0F0\">
                                 <td colspan=\"5\"><b>".$lang->Ajandekkartyarol_felhasznalt_osszeg."</b></td>
                                 <td align=\"right\"></td>
                                 <td align=\"right\"><b>- ".number_format((int)$megrendeles['giftcard_osszeg'],0,'',' ')." Ft</b></td>
                                 </tr>
                                 <tr bgcolor=\"#F0F0F0\">
                                 <td colspan=\"5\"><b>".$lang->Ajandekkartya_aktualis_egyenlege."</b></td>
                                 <td align=\"right\"></td>
                                 <td align=\"right\"><b>".number_format((int)$giftcard['osszeg'] - (int)$megrendeles['giftcard_osszeg'],0,'',' ')." Ft</b></td>
                                 </tr>
                                 ";
   }

   if($_SESSION["currencyId"] == 0)
   { //MAGYARORSZÁG
    $mail_kosar.="
                             <tr bgcolor=\"#F0F0F0\">
                             <td colspan=\"5\">".$lang->Szallitasi_dij."</td>
                             <td align=\"right\">".$lang->egy_utra."</td>
                             <td align=\"right\">".number_format($szallitasi_dij,0,'',' ')." Ft</td>
                             </tr>
                             <tr bgcolor=\"#F0F0F0\">
                             <td colspan=\"5\"><b>".$lang->Osszesen_fizetendo."</b></td>
                             <td align=\"right\"></td>
                             <td align=\"right\"><b>".number_format(($szallitasi_dij + $kosar_fizetendo - (int)$megrendeles['giftcard_osszeg']),0,'',' ')." Ft</b></td>
                             </tr>
                             </table>
                             ";
   }
   else
   {

    $mail_kosar.="
                             <tr bgcolor=\"#F0F0F0\">
                             <td colspan=\"5\">".$lang->Szallitasi_dij."</td>
                             <td align=\"right\">".$lang->egy_utra."</td>
                             <td align=\"right\">".number_format($szallitasi_dij,2,'.',' ')." €</td>
                             </tr>
                             <tr bgcolor=\"#F0F0F0\">
                             <td colspan=\"5\"><b>".$lang->Osszesen_fizetendo."</b></td>
                             <td align=\"right\"></td>
                             <td align=\"right\"><b>".number_format(($szallitasi_dij + $kosar_fizetendo - (int)$megrendeles['giftcard_osszeg_deviza']),2,'.',' ')." €</b></td>
                             </tr>
                             </table>
                             ";
   }

   //Kosár összeállításának vége

   if($megrendeles["anum"] != "")
   { //Jóváhagyott tranzakció esetén
    $megrendeles_szama=date("Y")."/".str_pad($megrendeles['id_megrendeles_fej'],8,"0",STR_PAD_LEFT);

    if($_SESSION["currencyId"] == 0)
    { //MAGYARORSZÁG
     $cib_valasz='
                    <p>'.$lang->sikeres_megrendeles_cib_visszaigazolas.':</p>
                    <ul>
                        <li>'.$lang->Valaszkod.' (RC): <b>'.$megrendeles["rc"].'</b></li>
                        <li>'.$lang->Valaszuzenet.' (RT): <b>'.$megrendeles["rt"].'</b></li>
                        <li>'.$lang->Tranzakcio_azonosito.' (TRID): <b>'.$megrendeles["trid"].'</b></li>
                        <li>'.$lang->Engedelyszam.' (ANUM): <b>'.$megrendeles["anum"].'</b></li>
                        <li>'.$lang->Tranzakcio_osszege.' (AMO): <b>'.number_format($megrendeles["amo"],0,'',' ').' Ft</b></li>
                    </ul>
                    ';
    }
    else
    {

     $cib_valasz='
                    <p>'.$lang->sikeres_megrendeles_cib_visszaigazolas.':</p>
                    <ul>
                        <li>'.$lang->Valaszkod.' (RC): <b>'.$megrendeles["rc"].'</b></li>
                        <li>'.$lang->Valaszuzenet.' (RT): <b>'.$megrendeles["rt"].'</b></li>
                        <li>'.$lang->Tranzakcio_azonosito.' (TRID): <b>'.$megrendeles["trid"].'</b></li>
                        <li>'.$lang->Engedelyszam.' (ANUM): <b>'.$megrendeles["anum"].'</b></li>
                        <li>'.$lang->Tranzakcio_osszege.' (AMO): <b>'.number_format($megrendeles["amo"],0,'',' ').' €</b></li>
                    </ul>
                    ';
    }

    //ÚJ
    $Mail=new Mail();
    $send=$Mail->sendMail($_SESSION['felhasznalo']['email'],$lang->megrendeles_visszaigazolasa." - ".$megrendeles_szama,$Mail->generateMailTemplate("templates_mail/order_cib.".$_SESSION["langStr"],array(
                "nev"=>$_POST['keresztnev'],
                "teljes_nev"=>$_SESSION['felhasznalo']['vezeteknev']." ".$_SESSION['felhasznalo']['keresztnev'],
                "szallitasi_cim"=>$_SESSION['felhasznalo']['irszam']." ".$_SESSION['felhasznalo']['varos_nev'].", ".$_SESSION['felhasznalo']['utcanev']." ".$_SESSION['felhasznalo']['kozterulet_nev']." ".$_SESSION['felhasznalo']['hazszam']." (".$_SESSION['felhasznalo']['emelet'],
                "megjegyzes"=>htmlspecialchars(trim($_POST['megjegyzes'])),
                "kosar"=>$mail_kosar,
                "cib_valasz"=>$cib_valasz
    )));

    if($send)
    {

     $MailAdmin=new Mail();
     $send=$MailAdmin->sendMail($func->getMainParam('order_mail'),$lang->megrendeles_visszaigazolasa." - ".$megrendeles_szama,$Mail->generateMailTemplate("templates_mail/admin_order_cib.".$_SESSION["langStr"],array(
                 "nev"=>$_POST['keresztnev'],
                 "teljes_nev"=>$_SESSION['felhasznalo']['vezeteknev']." ".$_SESSION['felhasznalo']['keresztnev'],
                 "szallitasi_cim"=>$_SESSION['felhasznalo']['irszam']." ".$_SESSION['felhasznalo']['varos_nev'].", ".$_SESSION['felhasznalo']['utcanev']." ".$_SESSION['felhasznalo']['kozterulet_nev']." ".$_SESSION['felhasznalo']['hazszam']." (".$_SESSION['felhasznalo']['emelet'],
                 "megjegyzes"=>htmlspecialchars(trim($_POST['megjegyzes'])),
                 "kosar"=>$mail_kosar,
                 "cib_valasz"=>$cib_valasz
     )));

     return true;
    }
    else
    {

     return false;
    }
   }
   else
   {

    $megrendeles_szama=date("Y")."/".str_pad($megrendeles['id_megrendeles_fej'],8,"0",STR_PAD_LEFT);

    $cib_valasz='
                <p>'.$lang->sikertelen_megrendeles_cib_visszaigazolas.':</p>
                <ul>
                    <li>Válaszkód (RC): <b>'.$megrendeles["rc"].'</b></li>
                    <li>Válaszüzenet (RT): <b>'.$megrendeles["rt"].'</b></li>
                    <li>Tranzakció azonosító (TRID): <b>'.$megrendeles["trid"].'</b></li>
                </ul>
                ';

    $Mail=new Mail();
    $send=$Mail->sendMail($_SESSION['felhasznalo']['email'],$lang->sikertelen_megrendeles_visszaigazolasa." - ".$megrendeles_szama,$Mail->generateMailTemplate("templates_mail/invalid_order_cib.".$_SESSION["langStr"],array(
                "nev"=>$_POST['keresztnev'],
                "teljes_nev"=>$_SESSION['felhasznalo']['vezeteknev']." ".$_SESSION['felhasznalo']['keresztnev'],
                "szallitasi_cim"=>$_SESSION['felhasznalo']['irszam']." ".$_SESSION['felhasznalo']['varos_nev'].", ".$_SESSION['felhasznalo']['utcanev']." ".$_SESSION['felhasznalo']['kozterulet_nev']." ".$_SESSION['felhasznalo']['hazszam']." (".$_SESSION['felhasznalo']['emelet'],
                "megjegyzes"=>htmlspecialchars(trim($_POST['megjegyzes'])),
                "kosar"=>$mail_kosar,
                "cib_valasz"=>$cib_valasz
    )));

    return false;
   }

   //Ajándékkártya rendelése esetén
  }
  else
  {

   //giftkártya adatok lekérdezése
   $gift=mysql_fetch_assoc(mysql_query("SELECT * FROM giftcard WHERE trid=$trid ORDER BY id_giftcard DESC LIMIT 1"));

   if($idm["anum"] != "")
   { //Jóváhagyott tranzakció esetén
    $mail->Subject="Vásárlás visszaigazolása - ajándékkártya";

    $body='
                    <html>
                    <head>

                    <style type="text/css">
                    <!--

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

                                Kedves <b><font size="2" style="color:#9EB91B;" color="#9EB91B">'.$_SESSION['felhasznalo']['keresztnev'].'</font></b>!
                                <br />
                                <br />
                                Rendszerünk az alábbi adatokkal rögzítette ajándékkártya megrendelésed:
                                <br />
                                <br />
                                Címzett neve: <font size="2" style="color:#9EB91B;" color="#9EB91B">'.$gift['cimzett_nev'].'</font>
                                <br />
                                <br />
                                Címzett e-mail címe: <font size="2" style="color:#9EB91B;" color="#9EB91B">'.$gift['cimzett_email'].'</font>
                                <br />
                                <br />
                                A kártya értéke: <font size="2" style="color:#9EB91B;" color="#9EB91B">'.number_format($gift['osszeg'],0,'','.').',- Ft</font>
                                <br />
                                <br />
                                Küldés dátuma: <font size="2" style="color:#9EB91B;" color="#9EB91B">'.date("Y.m.d",strtotime($gift['ervenyes_tol'])).'</font>
                                <br />
                                <br />
                                A CIB Bank a vásárlást a következő adatokkat igazolja vissza:
                                <br>
                                <font size="2" style="color:#9EB91B;" color="#9EB91B">
                                <ul>
                                    <li>Válaszkód (RC): <b>'.$idm["rc"].'</b></li>
                                    <li>Válaszüzenet (RT): <b>'.$idm["rt"].'</b></li>
                                    <li>Tranzakció azonosító (TRID): <b>'.$idm["trid"].'</b></li>
                                    <li>Engedélyszám (ANUM): <b>'.$idm["anum"].'</b></li>
                                    <li>Tranzakció összege (AMO): <b>'.number_format($idm["amo"],0,'',' ').' Ft</b></li>
                                </ul>
                                </font>
                                <br />
                                <br />
                                Köszönjük, hogy igénybevetted a Coreshop ajándékkártya szolgáltatását!

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
                            <font size="1" style="color:#666;" color="#666">&copy; 2010 - <a href="http://coreshop.hu" style="color:#666;" color="#666" target="_blank">coreshop.hu</a> - Minden jog fenntartva - <a href="mailto:info@coreshop.hu" style="color:#666;" color="#666">info@coreshop.hu</a> </font>
                            </td>
                        </tr>

                    </table>

                    </body>
                    </html>
                ';

    $mail->Body=$body;

    if($mail->Send())
    {

     return true;
    }
    else
    {

     return false;
    }
   }
   else
   {

    $mail->Subject="Sikertelen vásárlás visszaigazolása - ajándékkártya";

    $body="
                <p>Kedves ".$_SESSION['felhasznalo']['keresztnev']."!</p>
                <p>A <b>".$func->getMainParam('main_page')."</b> oldalon leadott megrendelésedet nem tudjuk teljesíteni, ennek okáról a levél alján tájékozódhatsz.</p>
                <p>Megrendelő neve: ".$_SESSION['felhasznalo']['vezeteknev']." ".$_SESSION['felhasznalo']['keresztnev']."</p>
                <p>Megrendelt termék: Coreshop ajándékkártya</p>";

    $body.= '
                <p>A fenti megrendelés kifizetése <b>sikertelen</b> volt. A CIB Bank a következő információkat közölte:</p>
                <ul>
                    <li>Válaszkód (RC): <b>'.$idm["rc"].'</b></li>
                    <li>Válaszüzenet (RT): <b>'.$idm["rt"].'</b></li>
                    <li>Tranzakció azonosító (TRID): <b>'.$idm["trid"].'</b></li>
                </ul>
                ';

    $body.= "<p>üdvözlettel: ".$func->getMainParam('main_page')."</p>
                <p>
                Cégnév: Coreshop Kft.<br />
                telephely: 1163 Budapest, Cziráki 26-32. <br />
                telefon: 06 70 208 3000 <br />
                weboldal: <a href=\"".$func->getMainParam('main_url')."\">".$func->getMainParam('main_url')."</a> <br />
                e-mail: <a href=\"mailto:".$func->getMainParam('main_email')."\">".$func->getMainParam('main_email')."</a> <br />
                </p>
                <i>Ezt a levelet a rendszer automatikusan generálta, kérünk ne válaszolj rá!</i>
                ";

    $mail->Body=$body;

    $mail->Send();

    return false;
   }
  }
 }

}
?>