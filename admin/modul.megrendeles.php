<?

if (ISSET($_REQUEST['id_statusz'])) {

    $isok = true;

    mysql_query("START TRANSACTION");

    if (!mysql_query("UPDATE megrendeles_fej SET id_statusz=" . (int)$_REQUEST['id_statusz'] . " WHERE id_megrendeles_fej=" . (int)$_GET['id'])) $isok = false;

    if ((int)$_REQUEST['id_statusz'] == 99 && mysql_affected_rows() > 0) {

        $sql = "SELECT * FROM megrendeles_tetel WHERE id_megrendeles_fej=" . (int)$_GET['id'];
        $query = mysql_query($sql);
        while ($tetelek = mysql_fetch_assoc($query)) {

            if (!mysql_query("UPDATE vonalkodok SET keszlet_1 = keszlet_1 + 1 WHERE vonalkod='" . $tetelek['vonalkod'] . "'")) $is_ok = false;
            if (!mysql_query("UPDATE termekek SET keszleten = keszleten + 1 WHERE id=" . $tetelek['id_termek'])) $is_ok = false;
            if (!mysql_query("UPDATE keszlet SET kikerulesi_ar=null, kikerulesi_datum=null, id_felhasznalok=null WHERE id_keszlet=" . $tetelek['id_keszlet'])) $is_ok = false;

            //FORGALOM INSERT
            if (!mysql_query("INSERT INTO forgalom (id_raktar, id_vonalkod, id_keszlet, lista_ar, fogy_ar, statusz, datum) VALUES (1, '" . $tetelek['id_vonalkod'] . "', " . $tetelek['id_keszlet'] . ", -" . $tetelek['termek_ar'] . ", -" . $tetelek['termek_ar'] . ", 1, NOW())")) $is_ok = false;
        }

        //Klubkártya recheck
        $sql = "SELECT sum(kikerulesi_ar) FROM keszlet WHERE id_felhasznalok=" . (int)$_GET['id_felh'];
        $price = (int)mysql_result(mysql_query($sql), 0);
        if ($price < (int)$func->getMainParam("klub_hatar")) {

            //klubkártya törlése
            if (!mysql_query("UPDATE felhasznalok SET klubtag_kod=null WHERE id=" . $_SESSION['felhasznalo']['id'])) $is_ok = false;
            if (!mysql_query("UPDATE megrendeles_fej SET klubkartya=0 WHERE id_megrendeles_fej = " . (int)$_GET['id'])) $is_ok = false;


        }

        //Giftcard felhasználásának törlése
        $gc = mysql_fetch_assoc(mysql_query("SELECT * FROM giftcard WHERE id_megrendeles_fej=" . (int)$_GET['id']));
        $gnum = mysql_num_rows(mysql_query("SELECT id_giftcard FROM giftcard WHERE azonosito_kod='" . $gc['azonosito_kod'] . "'"));
        if ($gnum > 1) {

            if (!mysql_query("DELETE FROM giftcard WHERE azonosito_kod='" . $gc['azonosito_kod'] . "' ORDER BY id_giftcard DESC LIMIT 1")) $is_ok = false;
            if (!mysql_query("UPDATE giftcard SET felhasznalva=null, felhasznalt_osszeg=null, id_megrendeles_fej=null WHERE id_megrendeles_fej=" . (int)$_GET['id'])) $is_ok = false;

        } else {

            if (!mysql_query("UPDATE giftcard SET felhasznalva=null, felhasznalt_osszeg=null, id_megrendeles_fej=null WHERE id_megrendeles_fej=" . (int)$_GET['id'])) $is_ok = false;

        }


    }

    if ($isok) {

        mysql_query("COMMIT");

        $sql = "
            SELECT 
            f.email,
            mf.megrendeles_szama,
            CONCAT(f.vezeteknev,' ',f.keresztnev) nev
            FROM megrendeles_fej mf
            LEFT JOIN felhasznalok f ON (f.id = mf.id_felhasznalo)
            WHERE mf.id_megrendeles_fej=" . (int)$_GET['id'] . "
            GROUP BY f.id
            ";

        $f = mysql_fetch_array(mysql_query($sql));

        require_once("classes/phpmailer/class.phpmailer.php");

        $mail = new PHPMailer();

        $mail->IsSMTP($func->getMainParam('mail_smtp') == 'true' ? true : false);
        if ($func->getMainParam('mail_host') != "") $mail->Host = $func->getMainParam('mail_host');
        if ((int)$func->getMainParam('mail_port') > 0) $mail->Port = (int)$func->getMainParam('mail_port');

        $mail->SMTPAuth = $func->getMainParam('mail_auth') == 'true' ? true : false;
        $mail->Username = $func->getMainParam('mail_user');
        $mail->Password = $func->getMainParam('mail_pwd');

        $mail->From = $func->getMainParam('mail_from');
        $mail->FromName = $func->getMainParam('mail_fromname');;
        $mail->SetLanguage("hu", "classes/phpmailer/language/");
        $mail->CharSet = "UTF-8";

        $mail->AddAddress($f['email'], "");
        // $mail->AddAddress('gabor@eyecandy.hu',"");  // masolat a rendszerlevelekrol

        $mail->IsHTML(true);

        $mail->Subject = "Megrendelés állapotváltozás - " . $f['megrendeles_szama'];

        if ($_REQUEST['id_statusz'] == 3) {

            $mail->Body = "
            <p>Kedves " . $f['nev'] . "!</p>
            <p>Ezúton tájékoztatunk hogy a " . $f['megrendeles_szama'] . " számú megrendelésed átadásra került a GLS csomagküldő szolgálatnak.</p>
            <br />
            <p>Üdvözlettel: " . $func->getMainParam('main_page') . "<br>
            <a href=\"" . $func->getMainParam('main_url') . "\">" . $func->getMainParam('main_url') . "</a><br><a href=\"mailto:" . $func->getMainParam('main_email') . "\">" . $func->getMainParam('main_email') . "</a></p>
            <i>Ezt a levelet a rendszer automatikusan generálta, kérünk ne válaszolj rá!</i>
            ";

        }
        if ($_REQUEST['id_statusz'] == 99) {

            $mail->Body = "
            <p>Kedves " . $f['nev'] . "!</p>
            <p>Ezúton tájékoztatunk hogy a " . $f['megrendeles_szama'] . " számú megrendelésedet rendszerünkből töröltük!</p>
            <br />
            <p>Üdvözlettel: " . $func->getMainParam('main_page') . "<br>
            <a href=\"" . $func->getMainParam('main_url') . "\">" . $func->getMainParam('main_url') . "</a><br><a href=\"mailto:" . $func->getMainParam('main_email') . "\">" . $func->getMainParam('main_email') . "</a></p>
            <i>Ezt a levelet a rendszer automatikusan generálta, kérünk ne válaszolj rá!</i>
            ";

        }

        if ($mail->Body != "") $mail->Send();

    } else {

        mysql_query("ROLLBACK");

    }

    header("Location: index.php?lap=megrendeles&id=" . $_GET[id]);

}

$sql = "
    SELECT 
        mf.*, 
        mf.szallitasi_nev megrendelo_neve,
        CONCAT_WS('', o.orszag_nev,', ',mf.szallitasi_irszam,' ',mf.szallitasi_varos,', ',mf.szallitasi_utcanev,' ',mf.szallitasi_kozterulet,' ',mf.szallitasi_hazszam,' (',mf.szallitasi_emelet,')') megrendelo_cime,
        CONCAT_WS('', o.orszag_nev,', ',mf.szamlazasi_irszam,' ',mf.szamlazasi_varos,', ',mf.szamlazasi_utcanev,' ',mf.szamlazasi_kozterulet,' ',mf.szamlazasi_hazszam) szamlazasi_cim,
        CONCAT_WS('', f.email,' | ',f.telefonszam1,' | ',f.telefonszam2) megrendelo_elerhetosegei,
        ms.*,
        f.klubtag_kod, f.kartya_kod, f.id id_felhasznalo, f.aktivacios_kod,
        bt.trid,
        bt.id_bank_tranzakcio,
		bt.anum,
        o.orszag_nev
    FROM megrendeles_fej mf
        LEFT JOIN felhasznalok f ON (f.id = mf.id_felhasznalo)
        LEFT JOIN megrendeles_statuszok ms ON (ms.id_megrendeles_statusz = mf.id_statusz)
        LEFT JOIN bank_tranzakciok bt ON (bt.id_megrendeles_fej = mf.id_megrendeles_fej)
        LEFT JOIN orszag o ON (o.id_orszag = mf.id_orszag)
    WHERE mf.id_megrendeles_fej=" . (int)$_GET['id'] . "
    GROUP BY mf.id_megrendeles_fej
    ";

$m = mysql_fetch_array(mysql_query($sql));

/*
if ($m["trid"]=="") $keyCell="darkCell"; else $keyCell="greenCell";

if ($m["giftcard_osszeg"]=="") $keyCell="darkCell"; else $keyCell="orangeCell";
*/
$keyCell = "darkCell";

if ($m["trid"] != "") $keyCell = "greenCell";                                                //kartyas
if ($m["giftcard_osszeg"] != "") $keyCell = "orangeCell";                                    //kedvezmeny
if (($m["trid"] != "") && ($m["giftcard_osszeg"] != "")) $keyCell = "blueCell";                    //kartyas + kedvezmeny
if ($m['id_szallitasi_mod'] == 2) $keyCell = 'redCell';                                        // szemelyes atvetel
if (($m['id_szallitasi_mod'] == 2) && ($m['trid'] != "")) $keyCell = 'purpleCell';            // kartyas + szemelyes atvetel
if (($m['id_szallitasi_mod'] == 2) && ($m['giftcard_osszeg'] != "")) $keyCell = 'oliveCell';    // szemelyes atvetel + giftcard

?>

<form method="post" name="statuszFrom" id="statuszFrom">

    <table width="700" border="0" cellspacing="0" cellpadding="10">
        <tr>
            <td width="700">
                <table width="700">

                    <?
                    //nav csak az uj rendelesekre
                    if ($m['id_statusz'] == 1) {

                        $rendelesek = mysql_query('SELECT id_megrendeles_fej FROM `megrendeles_fej` WHERE id_statusz=1 AND sztorno IS NULL ORDER BY megrendeles_szama');
                        while ($row = mysql_fetch_array($rendelesek)) {
                            $rend_szamok[] = $row[0];
                        }

                        $current = array_search($_GET['id'], $rend_szamok);

                        $prev = $rend_szamok[$current - 1];

                        $next = $rend_szamok[$current + 1];

                        /* echo 'aktuális: '.$current.'<br /><br />';
                        echo 'előző: '.$prev.'<br /><br />';
                        echo 'következő: '.$next.'<br /><br />'; */

                        $min = mysql_fetch_array(mysql_query('SELECT MIN(id_megrendeles_fej) FROM `megrendeles_fej` WHERE id_statusz=1 AND sztorno IS NULL'));

                        $max = mysql_fetch_array(mysql_query('SELECT MAX(id_megrendeles_fej) FROM `megrendeles_fej` WHERE id_statusz=1 AND sztorno IS NULL'));
                        ?>
                        <tr>
                            <td colspan="10" align="center" style="padding:0 5px 8px 5px; margin:0;">

                                <?

                                echo '<b>' . ($current + 1) . '</b> / ' . sizeof($rend_szamok);

                                if (isset($prev)) { ?>
                                    <div style="float:left;"><input type="button" class="form" value="&lsaquo; Előző"
                                                                    onclick="document.location.href='index.php?lap=megrendeles&id=<?= $prev ?>'"/>
                                    </div>
                                <? }

                                if (isset($next)){ ?>
                                <div style="float:right"><input type="button" class="form" value="Következő &rsaquo;"
                                                                onclick="document.location.href='index.php?lap=megrendeles&id=<?= $next ?>'"/>
                                </div>
                            </td>
                            <? } ?>
                        </tr>
                    <? } ?>

                    <tr>
                        <td colspan=4 align="right"><a href="index.php?lap=megrendeles_szerk&id=<?= $_GET['id'] ?>"
                                                       style="padding:4px;font-size:14px;"><img src="/images/edit.png"
                                                                                                style="width:14px;height:14px;vertical-align:middle;padding:0 10px 2px 0;opacity:0.8;"/>Szerkesztés</a>
                        </td>
                    </tr>

                    <tr>
                        <td class="<?= $keyCell ?>" width=170>Megrendelés száma:</td>
                        <td colspan="3" class="lightCell">
                            <b><?= $m['megrendeles_szama'] ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td class="<?= $keyCell ?>">Megrendelés dátuma:</td>
                        <td colspan="3" class="lightCell">
                            <b><?= $m['datum'] ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td class="<?= $keyCell ?>">Megrendelő neve:</td>
                        <td colspan="3" class="lightCell">
                            <a href="index.php?lap=felhasznalo&id=<?= $m['id_felhasznalo'] ?>"><b><?= $m['megrendelo_neve'] ?></b></a> <? if ($m['aktivacios_kod'] == 'login_once') echo '(Regisztráció nélküli vásárlás)'; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="<?= $keyCell ?>">Szállítási cím:</td>
                        <td colspan="3" class="lightCell">
                            <b><?= str_replace("()", "", $m['megrendelo_cime']) ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td class="<?= $keyCell ?>">Számlázási név:</td>
                        <td colspan="3" class="lightCell">
                            <b><?= $m['szamlazasi_nev'] ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td class="<?= $keyCell ?>">Számlázási cím:</td>
                        <td colspan="3" class="lightCell">
                            <b><?= str_replace("()", "", $m['szamlazasi_cim']) ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td class="<?= $keyCell ?>">Megrendelő elérhetőségei:</td>
                        <td colspan="3" class="lightCell">
                            <b><?= $m['megrendelo_elerhetosegei'] ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td class="<?= $keyCell ?>">Megrendelő megjegyzése:</td>
                        <td colspan="3" class="lightCell">
                            <?
                            if ($m['megjegyzes'])
                                echo '<span class="bubble-yellow">' . nl2br($m['megjegyzes']) . '</span>';
                            else
                                echo '&nbsp;';
                            ?>
                        </td>
                    </tr>
                    <?
                    //if ($func->isClubUser($m['id_felhasznalo']) && $m['kartya_kod']==''){
                    if ($m['klubkartya'] == 1) {
                        ?>
                        <tr>
                            <td class="<?= $keyCell ?>">Rendszer üzenet:</td>
                            <td colspan="3" class="lightCell">
                                <a href="index.php?lap=felhasznalo&id=<?= $m['id_felhasznalo'] ?>"><b>A felhasználó
                                        klubtag lett!</b></a>
                            </td>
                        </tr>
                        <?
                    } elseif ($m['klubtag_kod'] != '' && $m['kartya_kod'] == '') {
                        ?>
                        <tr>
                            <td class="<?= $keyCell ?>">Rendszer üzenet:</td>
                            <td colspan="3" class="lightCell">
                                <a href="index.php?lap=felhasznalo&id=<?= $m['id_felhasznalo'] ?>"><b>A felhasználó már
                                        klubtag, de még nem kapott kártyát!</b></a>
                            </td>
                        </tr>
                        <?
                    }
                    ?>
                    <tr>
                        <td class="<?= $keyCell ?>">Szállítási és fizetési mód:</td>
                        <td colspan="" class="lightCell">
                            <?
                            $fizetesi_modok = array(1 => "Utánvét", 2 => "Bankkártyás fizetés");
                            $szallitasi_modok = array(1 => "GLS", 2 => "Személyes", 3 => "GLS pont");
                            ?>
                            <b><?= $fizetesi_modok[$m['id_fizetesi_mod']] ?></b> /
                            <b><?= $szallitasi_modok[$m['id_szallitasi_mod']] . ' (' . $m['gls_kod'] . ')' ?></b>
                        </td>

                        <td class="<?= $keyCell ?>" align="center">Számla generálás</td>
                        <td class="lightCell" align="center">
                            <a href="/szamlaatadas_szamlazz_hu.php?id_megrendeles_fej=<?= $_GET['id'] ?>&fizetesi_mod=1">UTÁNVÉT</a>
                            &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;
                            <a href="/szamlaatadas_szamlazz_hu.php?id_megrendeles_fej=<?= $_GET['id'] ?>&fizetesi_mod=3">KÉSZPÉNZ</a>
                            &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;
                            <a href="/szamlaatadas_szamlazz_hu.php?id_megrendeles_fej=<?= $_GET['id'] ?>&fizetesi_mod=2">BANKKÁRTYA</a>
                        </td>

                    </tr>
                    <tr>
                        <td class="<?= $keyCell ?>">Fizetési pénznem:</td>
                        <td colspan="3" class="lightCell">
                            <b><?= $m['id_penznem'] == 0 ? "HUF" : "EUR" ?></b>
                        </td>
                    </tr>

                    <tr>
                        <td class="<?= $keyCell ?>" colspan="4">Megrendelt tételek:</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="lightCell" style="padding: 0;">
                            <table style="min-width:910px;width:100%;" cellpadding="3">
                                <tr align="center">
                                    <td class="<?= $keyCell ?>" align="left">Kép</td>
                                    <td class="<?= $keyCell ?>" align="left">Vonalkód</td>
                                    <td class="<?= $keyCell ?>" align="left">Márka</td>
                                    <td class="<?= $keyCell ?>" align="left">Megnevezés</td>
                                    <td class="<?= $keyCell ?>" align="left">Szín</td>
                                    <td class="<?= $keyCell ?>">Méret</td>
                                    <td class="<?= $keyCell ?>" align="right">Bruttó ár</td>
                                    <td class="<?= $keyCell ?>" align="right">Mennyiség</td>
                                    <td class="<?= $keyCell ?>" align="right">Összesen</td>
                                </tr>
                                <?

                                // kikommenteltem a termek_ar_deviza mezot, mert nem talalhato a tablaban - gabor
                                $sql = "SELECT 
                                mt.*,
								m.markanev,
                                count(mt.id_megrendeles_tetel) mennyiseg,
                                sum(mt.termek_ar) osszesen,
                                sum(mt.termek_ar_deviza) osszesen_deviza
                                FROM megrendeles_tetel mt 
								LEFT JOIN markak m ON mt.id_marka=m.id
                                WHERE mt.id_megrendeles_fej=" . $m['id_megrendeles_fej'] . " AND 
                                mt.sztorno IS NULL
                                GROUP BY mt.id_megrendeles_fej, mt.vonalkod
                                ";

                                $query = mysql_query($sql);

                                $osszes_ft = 0;
                                $osszes_db = 0;

                                while ($t = mysql_fetch_array($query)) {

                                    $osszes_ft = $osszes_ft + $t['osszesen'];
                                    $osszes_eur = $osszes_eur + $t['osszesen_deviza'];
                                    $osszes_db = $osszes_db + $t['mennyiseg'];

                                    // fizikai tarolo helyseg
                                    $tarolo = array(0 => 'Zöld', 1 => 'Showroom', 2 => 'Iroda', 3 => 'Kék');

                                    $tarolva = mysql_fetch_array(mysql_query('SELECT tarolva FROM termekek WHERE id=' . $t['id_termek']));
                                    ?>
                                    <tr>
                                        <td class="mediumCell" align="center"><a
                                                    href="http://www.coreshop.hu/<?= $func->getHDir($t['id_termek']); ?>1_large.jpg"
                                                    class="highslide" onclick="return hs.expand(this)"><img
                                                        src="http://coreshop.hu/<?= $func->getHDir($t['id_termek']); ?>1_small.jpg"
                                                        style="width:60px;height:60px;outline:2px solid #eee;"/></a>
                                        </td>

                                        <td class="mediumCell"><?= $t['vonalkod'] ?><br/><br/><span style="color:blue;"><b><?= $tarolo[$tarolva[0]]; ?></b> raktár</span>
                                        </td>
                                        <td class="mediumCell"><a href="index.php?lap=termek&id=<?= $t['id_termek'] ?>"
                                                                  target="_blank"><?= $t['markanev'] ?></a></td>
                                        <td class="mediumCell"><a href="index.php?lap=termek&id=<?= $t['id_termek'] ?>"
                                                                  target="_blank"><?= $t['termek_nev'] ?></a></td>
                                        <td class="mediumCell"><a href="index.php?lap=termek&id=<?= $t['id_termek'] ?>"
                                                                  target="_blank"><?= $t['szin'] ?></a></td>
                                        <td class="mediumCell" align="center"><a
                                                    href="index.php?lap=termek&id=<?= $t['id_termek'] ?>"
                                                    target="_blank" class="meret"><?= $t['tulajdonsag'] ?></a></td>
                                        <td class="mediumCell" align="right">
                                            <?= number_format($t['termek_ar'], 0, '', ' ') ?> Ft
                                            <?
                                            if ($m["id_penznem"] != 0) {
                                                ?>
                                                <br/><b><?= number_format($t['termek_ar_deviza'], 2, '.', ' ') ?>
                                                    &euro;</b>
                                                <?
                                            } ?>
                                        </td>
                                        <td class="mediumCell"
                                            align="right"><?= number_format($t['mennyiseg'], 0, '', ' ') ?> db
                                        </td>
                                        <td class="mediumCell" align="right">
                                            <?= number_format($t['osszesen'], 0, '', ' ') ?> Ft
                                            <?
                                            if ($m["id_penznem"] != 0) {
                                                ?>
                                                <br/><b><?= number_format($t['osszesen_deviza'], 2, '.', ' ') ?>
                                                    &euro;</b>
                                                <?
                                            } ?>
                                        </td>
                                    </tr>
                                    <?
                                }

                                ?>
                                <tr>
                                    <td class="lightCell" colspan=5>&nbsp;</td>
                                    <td class="mediumCell">Szállítási díj</td>
                                    <td class="mediumCell" align="right">
                                        <? if ($m['id_szallitasi_mod'] == 2) $m['szallitasi_dij'] = 0; ?>
                                        <?= number_format($m['szallitasi_dij'], 0, '', ' ') ?> Ft
                                        <? if ($m["id_orszag"] != 1) { ?>
                                            <br/><b><?= $func->toEUR($m['szallitasi_dij'], $m["deviza_arfolyam"]) ?>
                                                &euro;</b>
                                        <? } ?>
                                    </td>
                                    <td class="mediumCell" align="right">1 útra</td>
                                    <td class="mediumCell" align="right">
                                        <?= number_format($m['szallitasi_dij'], 0, '', ' ') ?> Ft
                                        <? if ($m["id_penznem"] != 0) { ?>
                                            <br/><b><?= $func->toEUR($m['szallitasi_dij'], $m["deviza_arfolyam"]) ?>
                                                &euro;</b>
                                        <? } ?>
                                    </td>
                                </tr>
                                <?
                                if ($m['giftcard_osszeg'] > 0) {
                                    ?>
                                    <tr>
                                        <td class="lightCell" colspan=5>&nbsp;</td>
                                        <td class="lightCell" colspan="2" align="right"><b>Ajándékkártya összege</b>
                                        </td>
                                        <td class="<?= $keyCell ?>" align="right"><b>1 db</b></td>
                                        <td class="<?= $keyCell ?>" align="right">
                                            <b><?= number_format($m['giftcard_osszeg'], 0, '', ' ') ?> Ft</b>
                                            <?
                                            if ($m["id_penznem"] != 0) {
                                                ?>
                                                <br/><b><?= number_format($m['giftcard_osszeg_deviza'], 2, '.', ' ') ?>
                                                    &euro;</b>
                                                <?
                                            } ?>
                                        </td>
                                    </tr>
                                    <?
                                }
                                ?>
                                <tr>
                                    <td class="lightCell" colspan=5>&nbsp;</td>
                                    <td class="lightCell" colspan="2" align="right"><b>Összesen fizetendő</b></td>
                                    <td class="<?= $keyCell ?>" align="right">
                                        <b><?= number_format($osszes_db, 0, '', ' ') ?> db</b></td>
                                    <td class="<?= $keyCell ?>" align="right">
                                        <b><?= number_format($osszes_ft + $m['szallitasi_dij'] - $m['giftcard_osszeg'], 0, '', ' ') ?>
                                            Ft</b>
                                        <? if ($m["id_penznem"] != 0){ ?>
                                        <br/><b><b><?= number_format($osszes_eur + $func->toEUR($m['szallitasi_dij'], $m["deviza_arfolyam"], false) - $m['giftcard_osszeg_deviza'], 2, '.', ' ') ?>
                                                &euro;</b>
                                            <? } ?>
                                    </td>
                                </tr>
                                <?
                                if ($m['kedvezmeny_erteke'] > 0) {
                                    ?>
                                    <tr>
                                        <td class="lightCell" colspan=4>&nbsp;</td>
                                        <td class="lightCell" colspan="2" align="right"><b>Kedvezmény</b></td>
                                        <td class="<?= $keyCell ?>" align="right">1 db</b></td>
                                        <td class="<?= $keyCell ?>" align="right">
                                            <b><?= number_format($m['kedvezmeny_erteke'], 0, '', ' ') ?> Ft</b>
                                            <?
                                            if ($m["id_orszag"] != 1) {
                                                ?>
                                                <br/>
                                                <b><?= number_format($m['kedvezmeny_erteke_deviza'], 2, '.', ' ') ?>
                                                    &euro;</b>
                                                <?
                                            } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="lightCell" colspan=4>&nbsp;</td>
                                        <td class="lightCell" colspan="2" align="right"><b>Kedvezménnyel számítva</b>
                                        </td>
                                        <td class="<?= $keyCell ?>"
                                            align="right"><?= number_format($osszes_db, 0, '', ' ') ?> db</b></td>
                                        <td class="<?= $keyCell ?>" align="right">
                                            <b><?= number_format(($osszes_ft - $m['kedvezmeny_erteke']) + $m['szallitasi_dij'], 0, '', ' ') ?>
                                                Ft</b>
                                            <?
                                            if ($m["id_orszag"] != 1){
                                            ?>
                                            <br/><b><b><?= number_format($osszes_eur + $func->toEUR($m['szallitasi_dij'], $m["deviza_arfolyam"], false) - $m['kedvezmeny_erteke_deviza'], 2, '.', ' ') ?>
                                                    &euro;</b>
                                                <?
                                                } ?>
                                        </td>
                                    </tr>
                                    <?
                                }
                                ?>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" align="right" class="<?= $keyCell ?>">CIB tranzakció azonosító:</td>
                        <td colspan="3" class="<?= $keyCell ?>"><a
                                    href="index.php?lap=tranzakcio&id=<?= $m['id_bank_tranzakcio'] ?>"><b><?= $m['trid']; ?></b></a>
                            &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;ANUM (számlára
                            ráírni):&nbsp;&nbsp;&nbsp;<b><?= $m['anum'] ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" align="right" class="<?= $keyCell ?>">Státusz:</td>
                        <td colspan="3" class="<?= $keyCell ?>">
                            <b><?= $m['statusz_nev']; ?></b>
                            <span id="keszlet_div" style="display:none"><input type="checkbox" name="tetelek_vissza"
                                                                               style="vertical-align:middle"> tételek visszarakása a készletbe </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="<?= $keyCell ?>">
                            <?
                            if ($m['id_statusz'] == 1) {
                                ?>
                                <input type="button" class="form" value=" Lezárás "
                                       onclick="document.location.href='index.php?lap=megrendeles&id=<?= $m['id_megrendeles_fej'] ?>&id_statusz=3'"/>
                                &nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;

                                <div class="storno_button"><input type="button" value="Sztornózás" class="form"
                                                                  onclick="if (confirm('Biztosan sztornózza a megrendelést?')){ document.statuszFrom.submit(); }"/>
                                </div>
                                <input type="hidden" name="id_statusz" value="99"/>
                                <input type="hidden" name="id_felh" value="<?= $m['id_felhasznalo'] ?>"/>

                                <?
                            } elseif ($m['id_statusz'] == 2) {
                                ?>
                                <input type="submit" value="lezárás" class="form">
                                <input type="hidden" name="id_statusz" value="3"/>
                                <?
                            }
                            ?>

                            <input type="button" class="form" value="&lsaquo; Vissza a listához"
                                   onclick="document.location.href='index.php?lap=megrendelesek'"/>

                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</form>


<span class="greenCell"
      style="padding:0 2px; margin-right:0px; border:0px solid green">&nbsp;&nbsp;</span> Bankkártya &nbsp;&nbsp;&nbsp;&nbsp;
<span class="redCell"
      style="padding:0 2px; margin-right:0px; border:0px solid red">&nbsp;&nbsp;</span> Személyes átvétel &nbsp;&nbsp;&nbsp;&nbsp;
<span class="orangeCell"
      style="padding:0 2px; margin-right:0px; border:0px solid orange">&nbsp;&nbsp;</span> Giftcard &nbsp;&nbsp;&nbsp;&nbsp;
<span class="purpleCell"
      style="padding:0 2px; margin-right:0px; border:0px solid orange">&nbsp;&nbsp;</span> Bankkártya + Személyes &nbsp;&nbsp;&nbsp;&nbsp;
<span class="blueCell"
      style="padding:0 2px; margin-right:0px; border:0px solid orange">&nbsp;&nbsp;</span> Bankkártya + Giftcard &nbsp;&nbsp;&nbsp;&nbsp;
<span class="oliveCell"
      style="padding:0 2px; margin-right:0px; border:0px solid orange">&nbsp;&nbsp;</span> Személyes + Giftcard &nbsp;&nbsp;&nbsp;&nbsp;