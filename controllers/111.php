<?

//error_reporting(E_ALL);

//ini_set("display_errors", 1);

class megrendeles
{

    function __construct()
    {

        global $error;
        global $func;
        global $user;
        global $lang;

        $user->cartManager();

        //die(var_dump($_POST));

        if(ISSET($_POST['megjegyzes']))
        {

            if($_SESSION['felhasznalo']["id_orszag"] == 1)
            { //MAGYARORSZÁG ESETÉS
                if($_POST['hazszam'] == '')
                {
                    $this->error=$lang->A_hazszam_kitoltese_kotelezo;
                }
                if($_POST['kozterulet'] == '')
                {
                    $this->error=$lang->A_kozterulet_megnevezesenek_kivalasztasa_kotelezo;
                }
                if($_POST['utcanev'] == '')
                {
                    $this->error=$lang->Az_utcanev_kitoltese_kotelezo;
                }

                if($_POST['megye'] == '')
                {
                    $this->error=$lang->A_megye_kivalasztasa_kotelezo;
                }
                if($_POST['varos'] == '')
                {
                    $this->error=$lang->A_varos_kivalasztasa_kotelezo;
                }
                if(!eregi("^[0-9]{4}$",$_POST['iranyitoszam']))
                {
                    $this->error=$lang->Az_iranyitoszam_nem_megfelelo;
                }
            }
            else
            { //KÜLFÖLD ESETÉN
                if($_POST['hazszam'] == '')
                {
                    $this->error=$lang->A_hazszam_kitoltese_kotelezo;
                }
                if($_POST['utcanev'] == '')
                {
                    $this->error=$lang->Az_utcanev_kitoltese_kotelezo;
                }
                if($_POST['varos_nev'] == '')
                {
                    $this->error=$lang->A_varos_kitoltese_kotelezo;
                }
                /*if(!eregi("^[0-9]{2,10}$",$_POST['iranyitoszam']))
                {
                 $this->error=$lang->Az_iranyitoszam_nem_megfelelo;
                }*/
            }


            if(strlen($_POST['szamlazasi_nev']) < 3)
            {
                $this->error=$lang->A_szamlazasi_nev_kitoltese_kotelezo;
            }

            if(strlen($_POST['fizetesi_mod']) == "")
            {
                $this->error=$lang->A_fizetesi_mod_kivalasztasa_kotelezo;
            }
            if(strlen($_POST['szallitasi_mod']) == "")
            {
                $this->error=$lang->A_szallitasi_mod_kivalasztasa_kotelezo;
            }

            if(trim($_POST['ajandek_kod']) != "")
            {

                if ( (trim(strtolower($_POST['ajandek_kod'])) == "xmas") && (date('Y-m-d')>='2017-12-12') && (date('Y-m-d')<='2017-12-17') )

                    /* glamour / joy + 263. sorban is at kell irni */
                {
                    $kosar_fizetendo=0;
                    if(ISSET($_SESSION['kosar']))
                    {

                        reset($_SESSION['kosar']);

                        while($reszletek=current($_SESSION['kosar']))
                        {
                            // Vans 20%
                            //if (($reszletek[4]==='Vans') && ($reszletek[7]!="AKCIOS"))

                            if ($reszletek[7]!="AKCIOS") // akcios termeket nem akcioz tovabb

                                $osszeg= $osszeg + (($reszletek[3] * $reszletek[2]) * 0.2);		// 20%-os akcio minden vans termekre

                            //$osszeg= $osszeg + (($reszletek[3] * $reszletek[2]) * 0.1);

                            next($_SESSION['kosar']);
                        }
                    }

                    $_POST['kedvezmeny']=round($osszeg, -1);
                }

                /*if ((trim($_POST['ajandek_kod']) == "xmas") && (date('Y-m-d')<'2013-12-31') )
                {
                 $kosar_fizetendo=0;
                 if(ISSET($_SESSION['kosar']))
                 {

                  reset($_SESSION['kosar']);

                  while($reszletek=current($_SESSION['kosar']))
                  {
                   $kosar_fizetendo=$kosar_fizetendo + ( $reszletek[3] * $reszletek[2] );
                   next($_SESSION['kosar']);
                  }
                 }

                if($kosar_fizetendo > 10000 && $kosar_fizetendo <= 15000)
                  $osszeg=2000;
                 elseif($kosar_fizetendo > 15000 && $kosar_fizetendo <= 25000)
                  $osszeg=3000;
                 elseif($kosar_fizetendo > 25000)
                  $osszeg=5000;
                 else
                  $osszeg=0;

                 $_POST['kedvezmeny']=$osszeg;
                }*/
                else
                {

                    $sql="SELECT osszeg FROM giftcard WHERE azonosito_kod='".trim($_POST['ajandek_kod'])."' AND ervenyes_tol<=NOW() AND ervenyes_ig>NOW() AND fizetve IS NOT NULL AND felhasznalva IS NULL";
                    $osszeg=@mysql_result(@mysql_query($sql),0);
                    $_POST['kedvezmeny']=$osszeg;

                    /*if((int)$osszeg < 1)
                     $this->error=$lang->Az_ajandekkartya_kodja_nem_megfelelo; */
                }
            }

            //RÖGZÍTÉS
            if($this->error == '')
            {

                $this->veglegesites();
            }
            else
            {

                $error->addError($this->error);
            }
        }
        else
        {

            if(strlen($_SESSION['felhasznalo']['cegnev']) > 3)
                $szamlazasi_nev=$_SESSION['felhasznalo']['cegnev'];
            else
                $nev=$_SESSION['felhasznalo']['vezeteknev']." ".$_SESSION['felhasznalo']['keresztnev'];

            if (isset($_SESSION['felhasznalo'])){
                $_POST['szamlazasi_nev']=$szamlazasi_nev;
                $_POST['iranyitoszam']=$_SESSION['felhasznalo']['irszam'];
                $_POST['megye']=$_SESSION['felhasznalo']['id_megye'];
                $_POST['varos']=$_SESSION['felhasznalo']['id_varos'];
                $_POST['varos_nev']=$_SESSION['felhasznalo']['varos_nev'];
                $_POST['utcanev']=$_SESSION['felhasznalo']['utcanev'];
                $_POST['kozterulet']=$_SESSION['felhasznalo']['id_kozterulet'];
                $_POST['hazszam']=$_SESSION['felhasznalo']['hazszam'];
            }
        }
    }

    function vonalkodok()
    {

        $kodok=array();

        if(ISSET($_SESSION['kosar']))
        {

            reset($_SESSION['kosar']);

            while($reszletek=current($_SESSION['kosar']))
            {

                $kodok[]=array($reszletek[8],$reszletek[2],$reszletek[5]." ".$reszletek[1]);

                next($_SESSION['kosar']);
            }
        }

        return $kodok;
    }

    function veglegesites()
    {

        global $error;
        global $func;
        global $user;
        global $lang;

        if(count($_SESSION['kosar']) < 1)
            $this->error=$lang->Ures_kosarral_a_megrendeles_nem_veglegesitheto;

        //KÉSZLET ELLENŐRZÉS
        $kodok=$this->vonalkodok();
        while($k=each($kodok))
        {

            $num=(int)@mysql_result(@mysql_query("SELECT keszlet_1 FROM vonalkodok WHERE vonalkod='".$k[1][0]."'"),0);

            if($num < 1)
            {

                $this->error=$lang->Az_alabbi_termek_keszlete_elfogyott.': ['.$k[1][2].']';
            }
            elseif($num < $k[1][1])
            {

                $this->error=$lang->Az_alabbi_termek_keszlete_nem_elegendo_a_rendeleshez.': ['.$k[1][2].'], '.$lang->maximum_rendelheto.' '.$num.' db';
            }
        }

        //RÖGZÍTÉS
        if($this->error == '')
        {

            /*if(trim($_POST['ajandek_kod']) == "xmas")
            {
             $kosar_fizetendo=0;
             if(ISSET($_SESSION['kosar']))
             {

              reset($_SESSION['kosar']);

              while($reszletek=current($_SESSION['kosar']))
              {
               $kosar_fizetendo=$kosar_fizetendo + ( $reszletek[3] * $reszletek[2] );
               next($_SESSION['kosar']);
              }
             }

             if($kosar_fizetendo > 10000 && $kosar_fizetendo <= 15000)
              $osszeg=2000;
             elseif($kosar_fizetendo > 15000 && $kosar_fizetendo <= 25000)
              $osszeg=3000;
             elseif($kosar_fizetendo > 25000)
              $osszeg=5000;
             else
              $osszeg=0;

             $giftcard["id_giftcard"]=null;
             $giftcard["osszeg"]=$osszeg;
             $giftcard["min_vasarlas_osszeg"]=0;
            }*/

            if ( (trim(strtolower($_POST['ajandek_kod'])) == "xmas") && (date('Y-m-d')>='2017-12-12') && (date('Y-m-d')<='2017-12-17') )

            {
                $kosar_fizetendo=0;
                if(ISSET($_SESSION['kosar']))
                {

                    reset($_SESSION['kosar']);

                    while($reszletek=current($_SESSION['kosar']))
                    {
                        // Vans 20%
                        //if (($reszletek[4]==='Vans') && ($reszletek[7]!="AKCIOS"))

                        if ($reszletek[7]!="AKCIOS") // akcios termeket nem akcioz tovabb

                            $osszeg= $osszeg + (($reszletek[3] * $reszletek[2]) * 0.2);		// 20%-os akcio minden vans termekre

                        //$osszeg= $osszeg + (($reszletek[3] * $reszletek[2]) * 0.1);

                        next($_SESSION['kosar']);
                    }
                }

                $giftcard["id_giftcard"]=null;
                $giftcard["osszeg"]=round($osszeg, -1);
                $giftcard["min_vasarlas_osszeg"]=0;
            }

            else
            {
                $giftcard=mysql_fetch_assoc(mysql_query("SELECT * FROM giftcard WHERE azonosito_kod='".trim($_POST['ajandek_kod'])."' AND ervenyes_tol<=NOW() AND ervenyes_ig>NOW() AND fizetve IS NOT NULL AND felhasznalva IS NULL"));
            }

            $megrendelo_neve=$_SESSION['felhasznalo']['vezeteknev']." ".$_SESSION['felhasznalo']['keresztnev']." (".$_SESSION['felhasznalo']['cegnev'].")";
            $megrendelo_neve=str_replace("()","",$megrendelo_neve);

            if($_SESSION['felhasznalo']["id_orszag"] == 1)
                $varos_nev=@mysql_result(@mysql_query("SELECT helyseg_nev FROM helyseg WHERE id_helyseg=".(int)$_POST['varos']),0);
            else
                $varos_nev=$_POST['varos'];

            $kozterulet_nev=@mysql_result(@mysql_query("SELECT megnevezes FROM kozterulet WHERE id_kozterulet=".(int)$_POST['kozterulet']),0);

            mysql_query("START TRANSACTION");

            // MEGRENDELÉS FEJ RÖGZÍTÉSE
            $sql="
                INSERT INTO megrendeles_fej
                (id_felhasznalo,

                id_orszag,

                szallitasi_nev,
                szallitasi_irszam,
                szallitasi_varos,
                szallitasi_utcanev,
                szallitasi_kozterulet,
                szallitasi_hazszam,
                szallitasi_emelet,

                szamlazasi_nev,
                szamlazasi_irszam,
                szamlazasi_varos,
                szamlazasi_utcanev,
                szamlazasi_kozterulet,
                szamlazasi_hazszam,

                id_szallitasi_mod,
                id_fizetesi_mod,
                id_penznem,

                megjegyzes,
                datum)
                VALUES
                (
                ".$_SESSION['felhasznalo']['id'].",

                ".$_SESSION['felhasznalo']['id_orszag'].",

                '".$megrendelo_neve."',
                '".$_SESSION['felhasznalo']['irszam']."',
                '".$_SESSION['felhasznalo']['varos_nev']."',
                '".$_SESSION['felhasznalo']['utcanev']."',
                '".$_SESSION['felhasznalo']['kozterulet_nev']."',
                '".$_SESSION['felhasznalo']['hazszam']."',
                '".$_SESSION['felhasznalo']['emelet']."',

                '".$_POST['szamlazasi_nev']."',
                '".$_POST['iranyitoszam']."',
                '".$varos_nev."',
                '".$_POST['utcanev']."',
                '".$kozterulet_nev."',
                '".$_POST['hazszam']."',

                '".$_POST['szallitasi_mod']."',
                '".$_POST['fizetesi_mod']."',
                '".(int)$_SESSION["currencyId"]."',

                '".trim($_POST['megjegyzes'])."',
                NOW()
                )
            ";

            if(!mysql_query($sql))
                $this->error=mysql_error();

            $lastId=mysql_insert_id();

            $megrendeles_szama=date("Y")."/".str_pad($lastId,8,"0",STR_PAD_LEFT);

            //klubtagság ellenőrzése
            if($user->isClubUser())
                $club=true;
            else
                $club=false;

            // KOSÁR VÉGLEGES ÖSSZESÍTÉSE TÉTELEK RÖGZÍTÉSE
            if(ISSET($_SESSION['kosar']))
            {

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

                reset($_SESSION['kosar']);

                $ingyenes_szallitas=false;

                $anaconvitems = array();
                $itemsi = 0;

                $kosar_fizetendo=0;
                while($reszletek=current($_SESSION['kosar']))
                {

                    $termek_adatok=mysql_fetch_array(mysql_query("SELECT
                                                                  t.id,
                                                                  t.kategoria,
                                                                  t.markaid,
                                                                  t.termeknev,
                                                                  (CASE WHEN t.akcios_kisker_ar<1 THEN t.kisker_ar ELSE t.akcios_kisker_ar END) ar,
                                                                  t.klub_ar,
                                                                  v.id_vonalkod,
                                                                  v.vonalkod,
                                                                  v.megnevezes,
                                                                  t.szin,
                                                                  t.opcio,
                                                                  t.cikkszam
                                                                  FROM termekek t
                                                                  LEFT JOIN markak m ON (m.id = t.markaid)
                                                                  LEFT JOIN vonalkodok v ON (v.id_termek = t.id AND v.vonalkod='".$reszletek[8]."')
                                                                  WHERE t.id=".(int)$reszletek[0]."
                                                                  "));

                    //KLUB ÁR ELLENŐRZÉS
                    if($club && (int)$termek_adatok['klub_ar'] > 0)
                        $termek_adatok['ar']=$termek_adatok['klub_ar'];

                    //KLUB ESETÉN NINCS SZÁLLÍTÁSI KÖLTSÉGE
                    if($club)
                        $ingyenes_szallitas=true;

                    //KÉSZLET SOROK KIVÁLASZTÁSA
                    $k_sorok_sql="SELECT id_keszlet FROM keszlet WHERE id_vonalkod=".$termek_adatok['id_vonalkod']." AND kikerulesi_datum IS NULL AND kikerulesi_ar IS NULL AND id_raktar=1 LIMIT ".(int)$reszletek[2];
                    $k_sorok_query=mysql_query($k_sorok_sql);
                    $k_sorok_array=array();
                    while($a=mysql_fetch_row($k_sorok_query))
                        $k_sorok_array[]=$a[0];
                    $k_sorok=implode(",",$k_sorok_array);
                    $update="UPDATE keszlet SET fogy_ar=".$termek_adatok['ar'].", kikerulesi_ar=".$termek_adatok['ar'].", kikerulesi_datum=NOW(), id_felhasznalok=".$_SESSION['felhasznalo']['id']." WHERE id_keszlet IN (".$k_sorok.")";
                    if(!mysql_query($update))
                        $this->error=mysql_error();

                    /**
                     * IDEIGLENES POSTAKÖLTSÉG KEZELŐ
                     * Ha a felhasználó 2010.10.15-2010.10.24 között vásárol, bármilyen hardware-t, akkor a postakültség 0 Ft.
                     */
                    if(!$ingyenes_szallitas)
                    {

                        $datumok=array("2011-06-17","2011-06-18","2011-06-19","2011-06-20","2011-06-21","2011-06-22","2011-06-23","2011-06-24","2011-06-25","2011-06-26","2011-06-27","2011-06-28","2011-06-29","2011-06-30");
                        //echo $termek_adatok['kategoria']."***";
                        if(in_array(date("Y-m-d"),$datumok) && ($termek_adatok['kategoria'] == 114 || $termek_adatok['kategoria'] == 115 || $termek_adatok['kategoria'] == 113 || $termek_adatok['kategoria'] == 120))
                            $ingyenes_szallitas=true;
                    }
                    /**
                     * ***********************
                     * IDEIGLENES POSTAKÖLTSÉG KEZELÉS VÉGE
                     */
                    //ANNYISZOR BESZÚRJA MINT TÉTEL, AHÁNY DARAB RENDELÉS VAN BELŐLE
                    for($go=1; $go <= $reszletek[2]; $go++)
                    {

                        $sql="
                        INSERT INTO megrendeles_tetel
                        (id_megrendeles_fej,
                         id_termek,
                         id_marka,
                         id_vonalkod,
                         termek_nev,
                         termek_ar,

                         termek_ar_deviza,
                         afa_kulcs,
                         afa_ertek,
                         afa_ertek_deviza,

                         vonalkod,
                         id_keszlet,
                         tulajdonsag,
                         szin,
                         termek_opcio)
                        VALUES
                        (
                        ".$lastId.",
                        ".$termek_adatok['id'].",
                        ".$termek_adatok['markaid'].",
                        ".$termek_adatok['id_vonalkod'].",
                        '".$termek_adatok['termeknev']."',
                        '".$termek_adatok['ar']."',

                        '".$func->toEUR($termek_adatok['ar'],false)."',
                        '".$func->getMainParam("afa_kulcs")."',
                        '".$func->getBruttoToNetto($termek_adatok['ar'])."',
                        '".$func->getBruttoToNetto($func->toEUR($termek_adatok['ar'],false))."',

                        '".$termek_adatok['vonalkod']."',
                        '".(int)$k_sorok_array[$go - 1]."',
                        '".$termek_adatok['megnevezes']."',
                        '".$termek_adatok['szin']."',
                        '".$termek_adatok['opcio']."')
                      ";

                        if(!mysql_query($sql))
                            $this->error=mysql_error();

                        //FORGALOM MENTÉSE

                        $sql="
                        INSERT INTO forgalom
                          (id_raktar, id_vonalkod, id_keszlet, lista_ar, fogy_ar, statusz, datum)
                        VALUES
                        (
                         1,
                        ".$termek_adatok['id_vonalkod'].",
                        ".(int)$k_sorok_array[$go - 1].",
                        ".$termek_adatok['ar'].",
                        ".$termek_adatok['ar'].",
                         0,
                         NOW()
                        )
                      ";

                        if(!mysql_query($sql))
                            $this->error=mysql_error();
                    }

                    //KÉSZLET CSÖKKENTÉSE
                    $sql="UPDATE vonalkodok SET keszlet_1 = keszlet_1 - ".$reszletek[2]." WHERE vonalkod='".$reszletek[8]."'";
                    if(!mysql_query($sql))
                        $this->error=mysql_error();
                    $sql="UPDATE termekek SET keszleten = keszleten - ".$reszletek[2]." WHERE id=".$reszletek[0];
                    if(!mysql_query($sql))
                        $this->error=mysql_error();

                    if($_SESSION["currencyId"] == 0)
                    { //MAGYARORSZÁG
                        $mail_kosar.= "<tr>
                                     <td>".$termek_adatok['vonalkod']."</td>
                                     <td>".$termek_adatok['termeknev']."</td>
                                     <td>".$termek_adatok['megnevezes']."</td>
                                     <td>".$termek_adatok['szin']."</td>
                                     <td align=\"right\">".number_format($termek_adatok['ar'],0,'',' ')." Ft</td>
                                     <td align=\"right\">".number_format($reszletek[2],0,'',' ')." ".$lang->db."</td>
                                     <td align=\"right\">".number_format(($reszletek[3] * $reszletek[2]),0,'',' ')." Ft</td>
                                     </tr>";
                    }
                    else
                    {

                        $mail_kosar.= "<tr>
                                     <td>".$termek_adatok['vonalkod']."</td>
                                     <td>".$termek_adatok['termeknev']."</td>
                                     <td>".$termek_adatok['megnevezes']."</td>
                                     <td>".$termek_adatok['szin']."</td>
                                     <td align=\"right\">".$func->toEUR($termek_adatok['ar'])." ?</td>
                                     <td align=\"right\">".number_format($reszletek[2],0,'',' ')." ".$lang->db."</td>
                                     <td align=\"right\">".$func->toEUR(($reszletek[3] * $reszletek[2]))." ?</td>
                                     </tr>";
                    }

                    $anaconvitems[$itemsi]['SKU'] = $reszletek[8];
                    $anaconvitems[$itemsi]['productname'] = $reszletek[4].' '.$reszletek[5].' '.$reszletek[9];
                    $anaconvitems[$itemsi]['itemprice'] = $reszletek[3];
                    $anaconvitems[$itemsi]['itemqty'] = $reszletek[2];

                    $itemsi++;

                    $kosar_db=$kosar_db + $reszletek[2];

                    $kosar_fizetendo=$kosar_fizetendo + ( $reszletek[3] * $reszletek[2] );

                    next($_SESSION['kosar']);
                }

                //GOOGLE ADWORDS-NEK

                unset($itemsi);

                $anaconvgeneral = array();
                $anaconvgeneral['invoice'] = $megrendeles_szama;
                $anaconvgeneral['totalnovat'] = (int)$kosar_fizetendo;
                $anaconvgeneral['shipping'] = 0;
                $anaconvgeneral['totalvat'] = 0;
                $_SESSION["anaconvgeneral"] = $anaconvgeneral;
                $_SESSION["anaconvitems"] = $anaconvitems;


                $_SESSION["google_fizetendo"]=(int)$kosar_fizetendo;

                //INGYENES SZÁLLÍTÁS, SZEMÉLYES ÁTVÉT ESETÉN
                if($_POST["szallitasi_mod"] == 2)
                    $ingyenes_szallitas=true;

                // INGYENES SZALLITAS MAGYARORSZÁGRA
                if($func->getMainParam("ingyenes_szallitas") > 0 && !$user->isForeign())
                {
                    if($kosar_fizetendo - $_POST['kedvezmeny'] > $func->getMainParam("ingyenes_szallitas")) //modositva: 2013.06.06.
                        $ingyenes_szallitas=true;

                    // INGYENES SZALLITAS KÜLFÖLDRE
                }elseif($func->getMainParam("ingyenes_szallitas_kulfold") > 0 && $user->isForeign())
                {
                    if($func->toEUR($kosar_fizetendo,true) > $func->getMainParam("ingyenes_szallitas_kulfold"))
                        $ingyenes_szallitas=true;
                }

                if(!$user->isForeign())
                { //MAGYAR
                    $szallitasi_dij=$ingyenes_szallitas ? 0 : (int)$func->getMainParam("szallitasi_dij");
                }
                else
                {
                    $szallitasi_dij=$ingyenes_szallitas ? 0 : $func->toHUF((int)$func->getMainParam("szallitasi_dij_kulfold"),false);
                }

                if($_SESSION["currencyId"] == 0)
                { //MAGYARORSZÁG
                    $mail_kosar.= "<tr bgcolor=\"#F0F0F0\">
                                 <td colspan=\"5\">".$lang->Osszesen_tetel."</td>
                                 <td align=\"right\">".number_format($kosar_db,0,'',' ')." ".$lang->db."</td>
                                 <td align=\"right\">".number_format($kosar_fizetendo,0,'',' ')." Ft</td>
                                 </tr>";
                }
                else
                {

                    $mail_kosar.= "<tr bgcolor=\"#F0F0F0\">
                                     <td colspan=\"5\">".$lang->Osszes_tetel."</td>
                                     <td align=\"right\">".number_format($kosar_db,0,'',' ')." ".$lang->db."</td>
                                     <td align=\"right\">".$func->toEUR($kosar_fizetendo)." ?</td>
                                     </tr>";
                }

                //Ajándékkártya kalkuláció, hogy minuszba ne mehessen a megrendelés
                if(($kosar_fizetendo + $szallitasi_dij) >= (int)$giftcard['osszeg'])
                {

                    $kedvezmeny=(int)$giftcard['osszeg'];
                }
                else
                {

                    $kedvezmeny=$kosar_fizetendo + $szallitasi_dij;
                }

                //5000-ezres limit
                if($kedvezmeny > 0 AND $kosar_fizetendo < (int)$giftcard['min_vasarlas_osszeg'])
                {

                    if($_SESSION["currencyId"] == 0)
                    { //MAGYARORSZÁG
                        $this->error='Az ajándékkártya minimum '.number_format($giftcard['min_vasarlas_osszeg'],0,'',' ').' Ft-os termék(ek) vásárlásánál használható fel!';
                    }
                    else
                    {

                        $this->error=$lang->ajadekkartya_minimum_vegosszeg_limit.': '.$func->toEUR($giftcard['min_vasarlas_osszeg']).' ?';
                    }
                }

                //Ajándékkártya felhasználás esetén, a kosárhoz hozzácsapja a dolgokat
                if($giftcard['osszeg'] > 0)
                {

                    if($_SESSION["currencyId"] == 0)
                    { //MAGYARORSZÁG
                        $mail_kosar.= "<tr bgcolor=\"#F0F0F0\">
                                     <td colspan=\"5\"><b>".$lang->Ajandekkartya_egyenlege."</b></td>
                                     <td align=\"right\"></td>
                                     <td align=\"right\"><b>".number_format((int)$giftcard['osszeg'],0,'',' ')." Ft</b></td>
                                     </tr>
                                     <tr bgcolor=\"#F0F0F0\">
                                     <td colspan=\"5\"><b>".$lang->Ajandekkartyarol_felhasznalot_osszeg."</b></td>
                                     <td align=\"right\"></td>
                                     <td align=\"right\"><b>- ".number_format($kedvezmeny,0,'',' ')." Ft</b></td>
                                     </tr>
                                     <tr bgcolor=\"#F0F0F0\">
                                     <td colspan=\"5\"><b>".$lang->Ajandekkartya_aktualis_egyenlege."</b></td>
                                     <td align=\"right\"></td>
                                     <td align=\"right\"><b>".number_format((int)$giftcard['osszeg'] - $kedvezmeny,0,'',' ')." Ft</b></td>
                                     </tr>
                                     ";
                    }
                    else
                    {

                        $mail_kosar.= "<tr bgcolor=\"#F0F0F0\">
                                     <td colspan=\"5\"><b>".$lang->Ajandekkartya_egyenlege."</b></td>
                                     <td align=\"right\"></td>
                                     <td align=\"right\"><b>".$func->toEUR((int)$giftcard['osszeg'])." ?</b></td>
                                     </tr>
                                     <tr bgcolor=\"#F0F0F0\">
                                     <td colspan=\"5\"><b>".$lang->Ajandekkartyarol_felhasznalot_osszeg."</b></td>
                                     <td align=\"right\"></td>
                                     <td align=\"right\"><b>- ".$func->toEUR($kedvezmeny)." ?</b></td>
                                     </tr>
                                     <tr bgcolor=\"#F0F0F0\">
                                     <td colspan=\"5\"><b>".$lang->Ajandekkartya_aktualis_egyenlege."</b></td>
                                     <td align=\"right\"></td>
                                     <td align=\"right\"><b>".$func->toEUR((int)$giftcard['osszeg'] - $kedvezmeny)." ?</b></td>
                                     </tr>
                                     ";
                    }
                }

                if($_SESSION["currencyId"] == 0)
                { //MAGYARORSZÁG
                    $mail_kosar.= "<tr bgcolor=\"#F0F0F0\">
                                 <td colspan=\"5\">".$lang->Szallitasi_dij."</td>
                                 <td align=\"right\">".$lang->egy_utra."</td>
                                 <td align=\"right\">".number_format($szallitasi_dij,0,'',' ')." Ft</td>
                                 </tr>
                                 <tr bgcolor=\"#F0F0F0\">
                                 <td colspan=\"5\"><b>".$lang->Osszesen_fizetendo."</b></td>
                                 <td align=\"right\"></td>
                                 <td align=\"right\"><b>".number_format(($szallitasi_dij + $kosar_fizetendo - $kedvezmeny),0,'',' ')." Ft</b></td>
                                 </tr>
                                 </table>
                                 ";
                }
                else
                {

                    $mail_kosar.= "<tr bgcolor=\"#F0F0F0\">
                                 <td colspan=\"5\">".$lang->Szallitasi_dij."</td>
                                 <td align=\"right\">".$lang->egy_utra."</td>
                                 <td align=\"right\">".$func->toEUR($szallitasi_dij)." ?</td>
                                 </tr>
                                 <tr bgcolor=\"#F0F0F0\">
                                 <td colspan=\"5\"><b>".$lang->Osszesen_fizetendo."</b></td>
                                 <td align=\"right\"></td>
                                 <td align=\"right\"><b>".$func->toEUR(($szallitasi_dij + $kosar_fizetendo - $kedvezmeny))." ?</b></td>
                                 </tr>
                                 </table>
                                 ";
                }
            }

            //BANKÁRTYÁS FIZETÉS VIZSGÁLAT
            if($_POST['fizetesi_mod'] == 2)
                $bankFizetes=true;
            else
                $bankFizetes=false;
            if($bankFizetes)
            {

                //0 Ft-os bankártyás fizetés nincs!!!
                if(($szallitasi_dij + $kosar_fizetendo - $kedvezmeny) < 1)
                {

                    $this->error=$func->dijmentes_rendeles_figyelmeztetes;
                }
                else
                {

                    include('cib/cib.class.php');

                    $trid=mt_rand(1000,9999).date("is",mktime()).mt_rand(1000,9999).date("is",mktime());
                    $ts=date('YmdHis');

                    //if ($_SESSION['felhasznalo']["id_orszag"]==1){ //MAGYARORSZÁG
                    if($_SESSION["currencyId"] == 0)
                    { //Forint esetén
                        $cib=new cibClass($_SESSION["langStr"],'HUF');

                        //$bankLink = $cib->msg10($lastId, $trid, 'CSH'.str_pad($_SESSION['felhasznalo']['id'], 8, "0", STR_PAD_LEFT), ($szallitasi_dij + ($kosar_fizetendo - $kedvezmeny)), $ts);
                        $bankLink=$cib->msg10($lastId,$trid,'CSH'.str_pad($_SESSION['felhasznalo']['id'],8,"0",STR_PAD_LEFT),($szallitasi_dij + $kosar_fizetendo - $kedvezmeny),$ts);
                    }
                    else
                    {

                        $cib=new cibClass($_SESSION["langStr"],'EUR');

                        $bankLink=$cib->msg10($lastId,$trid,'CSH'.str_pad($_SESSION['felhasznalo']['id'],8,"0",STR_PAD_LEFT),$func->toEUR($szallitasi_dij + $kosar_fizetendo - $kedvezmeny,false),$ts);
                    }

                    if($bankLink == "")
                    {

                        $this->error="A Bankkártyás fizetés kódolásánál hiba lépett fel. A fizetést próbáld meg újra!";
                    }

                    $updateStatusz=", id_statusz=50 ";
                }
            }
            //BANKÁRTYÁS FIZETÉS VÉGE
            //Giftcard könyvelés, ha van
            if((int)$giftcard['id_giftcard'] > 0)
            {

                //Ha még marad egyenleg, akkor ismét létrehozunk ugyan olyan kóddal egy új giftcardot
                if((int)$giftcard['osszeg'] > (int)$kedvezmeny)
                {

                    $sql="INSERT INTO
                            giftcard
                            (azonosito_kod, trid, osszeg, min_vasarlas_osszeg, ervenyes_tol, ervenyes_ig, kikuldve, felado_nev, felado_email, cimzett_nev, cimzett_email, uzenet, id_felhasznalo, id_kuldo, fizetve)
                            VALUES
                            ('".$giftcard['azonosito_kod']."',
                            ".$giftcard['trid'].",
                            ".((int)$giftcard['osszeg'] - (int)$kedvezmeny).",
                            ".$giftcard['min_vasarlas_osszeg'].",
                            '".$giftcard['ervenyes_tol']."',
                            '".$giftcard['ervenyes_ig']."',
                            '".$giftcard['kikuldve']."',
                            '".$giftcard['felado_nev']."',
                            '".$giftcard['felado_email']."',
                            '".$giftcard['cimzett_nev']."',
                            '".$giftcard['cimzett_email']."',
                            '".$giftcard['uzenet']."',
                            0,
                            ".$giftcard['id_kuldo'].",
                            '".$giftcard['fizetve']."')";

                    if(!mysql_query($sql))
                        $this->error=mysql_error();
                }

                $sql="UPDATE
                          giftcard
                        SET
                          id_felhasznalo = ".(int)$_SESSION['felhasznalo']['id'].",
                          felhasznalva=NOW(),
                          felhasznalt_osszeg = ".(int)$kedvezmeny.",
                          id_megrendeles_fej = ".$lastId."
                        WHERE
                          id_giftcard=".(int)$giftcard['id_giftcard'];

                if(!mysql_query($sql))
                    $this->error=mysql_error();

                $updateGiftcard=", id_giftcard=".(int)$giftcard['id_giftcard'].", giftcard_osszeg=".(int)$kedvezmeny.", giftcard_osszeg_deviza=".$func->toEUR((int)$kedvezmeny,true);
            }

            if((int)$giftcard['id_giftcard'] == 0 && (int)$giftcard['osszeg'] > 0)
                $updateGiftcard=", id_giftcard=0, giftcard_osszeg=".(int)$kedvezmeny.", giftcard_osszeg_deviza=".$func->toEUR((int)$kedvezmeny,true);

            $sql="
                UPDATE megrendeles_fej SET
                megrendeles_szama='".$megrendeles_szama."',
                fizetendo=".(int)$kosar_fizetendo.",
                fizetendo_deviza=".$func->toEUR((int)$kosar_fizetendo,true).",
                tetel_szam=".(int)$kosar_db.",
                szallitasi_dij=".(int)$szallitasi_dij.",
                szallitasi_dij_deviza=".$func->toEUR((int)$szallitasi_dij,true).",
                deviza_arfolyam=".$func->getMainParam("eur_arfolyam")
                .$updateStatusz
                .$updateGiftcard
                ." WHERE id_megrendeles_fej = ".$lastId."
            ";

            if(!mysql_query($sql))
                $this->error=mysql_error();

            if($this->error == '')
            {

                //Utánvétes vásárlás esetén
                if($bankLink == "" && !$bankFizetes)
                {

                    require_once ("classes/Mail.class.php");
                    $Mail=new Mail();
                    $send=$Mail->sendMail($_SESSION['felhasznalo']['email'],$lang->megrendeles_visszaigazolasa." - ".$megrendeles_szama,$Mail->generateMailTemplate("templates_mail/order.".$_SESSION["langStr"],array(
                        "nev"=>$_POST['keresztnev'],
                        "teljes_nev"=>$_SESSION['felhasznalo']['vezeteknev']." ".$_SESSION['felhasznalo']['keresztnev'],
                        "szallitasi_cim"=>$_SESSION['felhasznalo']['irszam']." ".$_SESSION['felhasznalo']['varos_nev'].", ".$_SESSION['felhasznalo']['utcanev']." ".$_SESSION['felhasznalo']['kozterulet_nev']." ".$_SESSION['felhasznalo']['hazszam']." (".$_SESSION['felhasznalo']['emelet'],
                        "megjegyzes"=>htmlspecialchars(trim($_POST['megjegyzes'])),
                        "kosar"=>$mail_kosar
                    )));

                    if(!$send)
                    {

                        $error->addError("A megadott e-mail címre a rendszer nem tudta kiküldeni a visszaigazoló levelet! Ismételd meg újra!");
                        mysql_query("ROLLBACK");
                    }
                    else
                    {

                        $AdminMail=new Mail();
                        $AdminMail->sendMail($func->getMainParam('order_mail'),$lang->megrendeles_erkezett." - ".$megrendeles_szama,$Mail->generateMailTemplate("templates_mail/admin_order.".$_SESSION["langStr"],array(
                            "nev"=>$_POST['keresztnev'],
                            "teljes_nev"=>$_SESSION['felhasznalo']['vezeteknev']." ".$_SESSION['felhasznalo']['keresztnev'],
                            "szallitasi_cim"=>$_SESSION['felhasznalo']['irszam']." ".$_SESSION['felhasznalo']['varos_nev'].", ".$_SESSION['felhasznalo']['utcanev']." ".$_SESSION['felhasznalo']['kozterulet_nev']." ".$_SESSION['felhasznalo']['hazszam']." (".$_SESSION['felhasznalo']['emelet'],
                            "megjegyzes"=>htmlspecialchars(trim($_POST['megjegyzes'])),
                            "kosar"=>$mail_kosar
                        )));

                        unset($_SESSION['kosar']);

                        mysql_query("COMMIT");

                        // KLUBKÁRTYA RÖGZÍTÉSE, HA ELÉRTE A HATÁRT
                        if($user->isNewClubUser())
                        {

                            mysql_query("UPDATE felhasznalok SET klubtag_kod='".date("U")."' WHERE id=".$_SESSION['felhasznalo']['id']);
                            mysql_query("UPDATE megrendeles_fej SET klubkartya=1 WHERE id_megrendeles_fej = ".$lastId);
                        }

                        if(count($_SESSION['kosar']) > 0)
                            header("Location: /".$lang->defaultLangStr."/".$lang->_megrendeles);
                        else
                            header("Location: /".$lang->defaultLangStr."/".$lang->_sikeres_vasarlas);
                        die();
                    }

                    //Bakkártyás vásárlás esetén
                }else
                {

                    // MEGRENDELÉS FEJ RÉSZLETEZÉSE
                    mysql_query("COMMIT");

                    //die("LINK:".$bankLink);
                    header("Location: ".$bankLink);
                }
            }
            else
            {

                mysql_query("ROLLBACK");
                $error->addError($this->error);
            }
        }
        else
        {

            $error->addError($this->error);
        }
    }

}
?>