<script src="js/prototype.js" type="text/javascript"></script>
<script src="js/ajax.js" type="text/javascript"></script>
<?

    if (ISSET($_POST['login'])){
    
            $_SESSION['felhasznalo'] = mysql_fetch_array(mysql_query("SELECT * FROM felhasznalok WHERE id=".(int)$_GET['id']));
            $_SESSION['welcome'] = true;
            echo '<script>document.location.href=\'https://coreshop.hu/index.php\'</script>';
            //echo '<script>document.location.href=\'http://test.coreshop.hu/index.php\'</script>';
            die();
        
    }

    if (ISSET($_POST['modositas'])){
        
            
            //Születési dátum ellenőrzése, ha valami ki van töltve
            if ($_POST['szuletesi_ev']!="" OR $_POST['szuletesi_honap']!="" OR $_POST['szuletesi_nap']!="" ) {
                
                $date = $_POST["szuletesi_ev"]."-".$_POST["szuletesi_honap"]."-".$_POST["szuletesi_nap"];
                if(!strtotime($date)) $error = "A megadott születési dátum nem megfelelő!";
                
            }

            //RÖGZÍTÉS
            if ($error==''){
                
                if ($_POST["orszag"]==1){
                    
                    $megye_nev = @mysql_result(@mysql_query("SELECT megye_nev FROM megyek WHERE id_megye=".(int)$_POST['megye']), 0);  
                    $varos_nev = @mysql_result(@mysql_query("SELECT helyseg_nev FROM helyseg WHERE id_helyseg=".(int)$_POST['varos']), 0);  
                    $kozterulet_nev = @mysql_result(@mysql_query("SELECT megnevezes FROM kozterulet WHERE id_kozterulet=".(int)$_POST['kozterulet']), 0);  
    
                }else{

                    $megye_nev = "";  
                    $varos_nev = $_POST['varos_nev'];  
                    $kozterulet_nev = "";  
    
                }
                
                $query="
                     UPDATE felhasznalok SET
					 email = '".$_POST['email']."',
                     vezeteknev = '".trim($_POST['vezeteknev'])."',
                     keresztnev = '".trim($_POST['keresztnev'])."',
                     cegnev = '".trim($_POST['cegnev'])."',
                     id_orszag = ".(int)$_POST['orszag'].",
                     irszam = '".$_POST['iranyitoszam']."',
                     id_megye = ".(int)$_POST['megye'].",
                     megye_nev = '$megye_nev',
                     id_varos = ".(int)$_POST['varos'].",
                     varos_nev = '$varos_nev',
                     utcanev = '".trim($_POST['utcanev'])."',
                     hazszam = '".trim($_POST['hazszam'])."',
                     id_kozterulet = ".(int)$_POST['kozterulet'].",
                     kozterulet_nev = '$kozterulet_nev',
                     emelet = '".trim($_POST['emelet'])."',
                     telefonszam1 = '".trim($_POST['telefonszam1'])."',
                     telefonszam2 = '".trim($_POST['telefonszam2'])."',
                     szuletesi_ev = ".($_POST['szuletesi_ev']<1?'NULL':$_POST['szuletesi_ev']).",
                     szuletesi_honap = ".($_POST['szuletesi_honap']<1?'NULL':$_POST['szuletesi_honap']).",
                     szuletesi_nap = ".($_POST['szuletesi_nap']<1?'NULL':$_POST['szuletesi_nap']).",
                     ".(empty($_POST['jelszo'])?'':'jelszo=\''.md5($_POST['jelszo']).'\',')."
                     klubtag_kod = '".trim($_POST['klubtag_kod'])."',
                     kartya_kod = '".trim($_POST['kartya_kod'])."',
                     hirlevel = ".(int)$_POST['hirlevel'].",
                     aktivacios_kod = '".$_POST['aktivacios_kod']."',
                     modositva=1,
                     modositva2=1,
                     modositva3=1
                     WHERE
                     id=".(int)$_GET['id'];
					 
                     
                mysql_query("START TRANSACTION");
			
                
                if (mysql_query($query)){
                
                    if (!empty($_POST['jelszo'])) $_SESSION['felhasznalo']['jelszo'] = md5($_POST['jelszo']);
                    
                    mysql_query("COMMIT");
                    

                }else{
                
                    $error = mysql_error();
                    mysql_query("ROLLBACK");
                    
                }
              
            }
                    
    }else{
            
        /**
        * @desc ADATOK BEOLVASÁSA
        */
        $adatok = mysql_fetch_array(mysql_query("SELECT * FROM felhasznalok WHERE id=".$_GET['id']));
        
        $_POST['vezeteknev'] = $adatok['vezeteknev'];
        $_POST['keresztnev'] = $adatok['keresztnev'];
        $_POST['cegnev'] = $adatok['cegnev'];
        $_POST['orszag'] = $adatok['id_orszag'];
        $_POST['iranyitoszam'] = $adatok['irszam'];
        $_POST['megye'] = $adatok['id_megye'];
        $_POST['varos'] = $adatok['id_varos'];
        $_POST['varos_nev'] = $adatok['varos_nev'];
        $_POST['utcanev'] = $adatok['utcanev'];
        $_POST['kozterulet'] = $adatok['id_kozterulet'];
        $_POST['hazszam'] = $adatok['hazszam'];
        $_POST['emelet'] = $adatok['emelet'];
        $_POST['email'] = $adatok['email'];
        $_POST['telefonszam1'] = $adatok['telefonszam1'];
        $_POST['telefonszam2'] = $adatok['telefonszam2'];
        $_POST['szuletesi_ev'] = $adatok['szuletesi_ev'];
        $_POST['szuletesi_honap'] = $adatok['szuletesi_honap'];
        $_POST['szuletesi_nap'] = $adatok['szuletesi_nap'];
        $_POST['klubtag_kod'] = $adatok['klubtag_kod'];
        $_POST['kartya_kod'] = $adatok['kartya_kod'];
        $_POST['hirlevel'] = $adatok['hirlevel'];
        $_POST['aktivacios_kod'] = $adatok['aktivacios_kod'];
        $_POST['regisztralva'] = $adatok['regisztralva'];
        $_POST['utolso_belepes'] = $adatok['utolso_belepes'];
        $_POST['auth_type'] = $adatok['auth_type'];

    }
        

    if (!empty($error)) echo "<div id=\"error\">$error</div>";
    
?>

<form name="felhLoginForm" id="felhLoginForm" method="post" action="https://coreshop.hu">
	<input type="hidden" name="login_email_admin" value="<?=$adatok['email']?>" />
	<input type="hidden" name="login_password_admin" value="<?=$adatok['jelszo']?>" />
</form>

<form name="felhForm" method="post" autocomplete="off">
<input type="hidden" name="spec_num" id="spec_num" value="-1" />

<table width="700" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td width="700">
        <table width="700" border="0" cellspacing="1" cellpadding="6">
          <tr>
            <td class="darkCell">azonosító:</td>
            <td colspan="3" class="lightCell"><?=$_GET['id']?>
                <input type="hidden" name="id" value="<?=$_GET['id']?>"></td>
          </tr>
          <tr>
            <td class="darkCell">Regisztrálva:</td>
            <td class="lightCell"><?=$_POST['regisztralva']?><input type="hidden" name="regisztralva" value="<?=$_POST['regisztralva']?>" /></td>
            <td class="darkCell">Utoljára belépett:</td>
            <td class="lightCell"><?=$_POST['utolso_belepes']?><input type="hidden" name="utolso_belepes" value="<?=$_POST['utolso_belepes']?>" /></td>
          </tr>
          <tr>
            <td class="darkCell">e-mail:</td>
            <td colspan="3" class="lightCell"><input name="email" type="text" class="form" id="email" size="50" maxlength="255" <?php echo(ISSET($_POST['email'])?'VALUE="'.$_POST['email'].'"':'');?>></td>
          </tr>
          <tr>
            <td class="darkCell">vezetéknév:</td>
            <td colspan="3" class="lightCell"><input name="vezeteknev" type="text" class="form" id="vezeteknev" size="30" maxlength="255" <?php echo(ISSET($_POST['vezeteknev'])?'VALUE="'.$_POST['vezeteknev'].'"':'');?>></td>
          </tr>
          <tr>
            <td class="darkCell">keresztnév:</td>
            <td colspan="3" class="lightCell"><input name="keresztnev" type="text" class="form" id="keresztnev" size="30" maxlength="255" <?php echo(ISSET($_POST['keresztnev'])?'VALUE="'.$_POST['keresztnev'].'"':'');?>></td>
          </tr>
          <!-- <tr>
            <td class="darkCell">születési dátum:</td>
            <td colspan="3" class="lightCell">
            <?
                for ($i=date("Y"); $i>=1900; $i--) $evek[$i]=$i;
                echo $func->createArraySelectBox($evek, $_POST['szuletesi_ev'],  "name=\"szuletesi_ev\"", "Év");
                
                $h = array("", "Január", "Február", "Március", "Április", "Május", "Június", "Július", "Augusztus", "Szeptember", "Október", "November", "December");
                for ($i=1; $i<=12; $i++) $honapok[$i]=$h[$i];
                echo $func->createArraySelectBox($honapok, $_POST['szuletesi_honap'],  "name=\"szuletesi_honap\"", "Hónap");
                
                for ($i=1; $i<=31; $i++) $napok[$i]=$i;
                echo $func->createArraySelectBox($napok, $_POST['szuletesi_nap'],  "name=\"szuletesi_nap\"", "Nap");
            ?>
            </td>
          </tr> -->
          <tr>
            <td class="darkCell">cégnév:</td>
            <td colspan="3" class="lightCell"><input name="cegnev" type="text" class="form" id="cegnev" size="30" maxlength="255" <?php echo(ISSET($_POST['cegnev'])?'VALUE="'.$_POST['cegnev'].'"':'');?>></td>
          </tr>
          <tr>
            <td class="darkCell">Ország</td>
            <td colspan="3" class="lightCell">
                <?
                    echo $func->createSelectBox("SELECT * FROM orszag ORDER BY id_orszag", $_POST['orszag'], "name=\"orszag\" id=\"orszag\" onchange=\"divOrszagSelect(this.options[this.selectedIndex].value)\"", "- Válassz -");
                ?>
            </td>            
          </tr>          
          <tr id="hun1">
            <td class="darkCell">Irszám / Megye / Város:</td>
            <td colspan="3" class="lightCell">
              <div>    
                <div style="float:left">
                <input type="text" name="iranyitoszam" id="iranyitoszam" onchange="getWhitePostCode(this.value, $('megye'), 'varos', 'helysegekdiv')" value="<?=$_POST['iranyitoszam']?>" maxlength="4" size="4">
                <?
                    echo $func->createSelectBox("SELECT * FROM megyek ORDER BY megye_nev", $_POST['megye'], "name=\"megye\" id=\"megye\" onchange=\"divHelysegek('helysegekdiv', this.options[this.selectedIndex].value, 'varos')\"", "- Válassz -");
                ?>
                </div>
                <div id="helysegekdiv"></div>
              </div>
            </td>
          </tr>
          <!--<tr id="eng1">
            <td class="darkCell">Irszám / Város:</td>
            <td colspan="3" class="lightCell">
              <div>    
                <div style="float:left">
                <input type="text" name="iranyitoszam" id="iranyitoszam" value="<?=$_POST['iranyitoszam']?>" maxlength="8" size="4">
                <input type="text" name="varos_nev" value="<?=$_POST['varos_nev']?>" maxlength="50" size="20">
              </div>
            </td>
          </tr> -->
          <tr id="hun2">
            <td class="darkCell">Lakcím:</td>
            <td colspan="3" class="lightCell">
              <input type="text" id="utcanev" name="utcanev" value="<?=$_POST['utcanev']?>" maxlength="100" size="30">
              <?
                echo $func->createSelectBox("SELECT * FROM kozterulet ORDER BY megnevezes", $_POST['kozterulet'], "name=\"kozterulet\"");
              ?>
              <input type="text" id="hazszam" name="hazszam" value="<?=$_POST['hazszam']?>" maxlength="10" size="5">
              <input type="text" id="emelet" name="emelet" value="<?=$_POST['emelet']?>" maxlength="20" size="5">
            </td>
          </tr>
          <!--<tr id="eng2">
            <td class="darkCell">Lakcím:</td>
            <td colspan="3" class="lightCell">
              <input type="text" id="utcanev" name="utcanev" value="<?=$_POST['utcanev']?>" maxlength="100" size="30">
              <input type="text" id="hazszam" name="hazszam" value="<?=$_POST['hazszam']?>" maxlength="10" size="5">
              <input type="text" id="emelet" name="emelet" value="<?=$_POST['emelet']?>" maxlength="20" size="5">
            </td>
          </tr>-->
          <tr>
            <td class="darkCell">1. telefonszám:</td>
            <td colspan="3" class="lightCell">
                <input type="text" name="telefonszam1" id="telefonszam1" value="<?=$_POST['telefonszam1']?>" size="20" maxlength="20">
            </td>
          </tr>
          <tr>
            <td class="darkCell">2. telefonszám:</td>
            <td colspan="3" class="lightCell">
                <input type="text" name="telefonszam2" id="telefonszam2" value="<?=$_POST['telefonszam2']?>" size="20" maxlength="20">
            </td>
          </tr>
          <tr>
            <td class="darkCell">új jelszó:</td>
            <td colspan="3" class="lightCell">
                <input type="password" name="jelszo" id="jelszo" size="30">
            </td>
          </tr>
          <tr>
            <td class="darkCell">klubtag kód:</td>
            <td class="lightCell"><input name="klubtag_kod" type="text" class="form" id="klubtag_kod" size="30" maxlength="255" <?php echo(ISSET($_POST['klubtag_kod'])?'VALUE="'.$_POST['klubtag_kod'].'"':'');?>></td>
            <td class="darkCell">kártya kód:</td>
            <td class="lightCell"><input name="kartya_kod" type="text" class="form" id="kartya_kod" size="30" maxlength="255" <?php echo(ISSET($_POST['kartya_kod'])?'VALUE="'.$_POST['kartya_kod'].'"':'');?>></td>
          </tr>
          <tr>
            <td valign="top" class="darkCell">hírlevél:</td>
            <td colspan="3" class="lightCell"><select name="hirlevel" id="hirlevel" class="form">
                <option value="1" <?php echo ((ISSET($_POST['hirlevel'])?($_POST['hirlevel']==1?'SELECTED':''):''));?>>Igen</option>
                <option value="0" <?php echo ((ISSET($_POST['hirlevel'])?($_POST['hirlevel']==0?'SELECTED':''):''));?>>Nem</option>
            </select></td>
          </tr>
          <tr>
              <td valign="top" class="darkCell">felhasználó státusza:</td>
              <td class="lightCell">
                  <select name="aktivacios_kod" id="aktivacios_kod" class="form">
                      <option value="" <?php echo ((ISSET($_POST['aktivacios_kod'])?($_POST['aktivacios_kod']==""?'SELECTED':''):''));?>>Aktiválva</option>
                      <option value="<?=md5(sha1(date("U")))?>" <?php echo ((ISSET($_POST['aktivacios_kod'])?($_POST['aktivacios_kod']==""?'':'SELECTED'):''));?>>Nincs aktiválva</option>
                  </select>
              </td>
              <td valign="top" class="darkCell">regisztráció típusa:</td>
              <td class="lightCell"><?=$_POST['auth_type']?><input type="hidden" name="auth_type" value="<?=$_POST['auth_type']?>" /></td>
          </tr>
          <tr>
            <td colspan="4" class="lightCell">
                <input name="modositas" type="submit" class="form" id="modositas" value="Felhasználó módosítása" />
                <input name="login" type="button" class="form" id="login" value="Bejelentkezés a felhasználóval" onclick="document.felhLoginForm.submit()" />
                <input type="button" class="form" value="Vissza a listához" onclick="document.location.href='index.php?lap=felhasznalok'" />
            </td>
          </tr>
        </table>
    </td>
  </tr>
</table>

</form>

<table width="700" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td width="700">
    <table width="700" border="0" cellspacing="1" cellpadding="6">
        <tr class="darkCell" height="25">
            <td align="center" class="table-row-unpair"><b>Dátum/Idő</b></td>
            <td align="center" class="table-row-unpair"><b>Termék</b></td>
            <td align="center" class="table-row-unpair"><b>Kép</b></td>
            <td align="center" class="table-row-unpair"><b>Menny.</b></td>
            <td align="center" class="table-row-unpair"><b>Ár</b></td>
        </tr>
        
        <!-- 1 vasarlas blokk eleje -->
        <?
        
            //Eddigi vásárlások
            $sql = "
                SELECT
                t.id, k.kikerulesi_datum, m.markanev, t.termeknev, t.szin, v.megnevezes, count(k.id_vonalkod) db, k.kikerulesi_ar, DATE_FORMAT(k.kikerulesi_datum, '%Y.%m.%d') datum, DATE_FORMAT(k.kikerulesi_datum, '%H:%i:%s') idopont
                FROM keszlet k
                LEFT JOIN vonalkodok v ON (v.id_vonalkod=k.id_vonalkod)
                LEFT JOIN termekek t ON (t.id=v.id_termek)
                LEFT JOIN markak m ON (m.id=t.markaid)
                WHERE k.id_felhasznalok=".(int)$_GET['id']."
                GROUP BY k.id_vonalkod, k.kikerulesi_datum, k.kikerulesi_ar
                ORDER BY k.kikerulesi_datum
            ";

            $query = mysql_query($sql);
            
            $num=0; $reszosszeg=0; $ossz=0;
            
            while ($adatok = mysql_fetch_assoc($query)){
                
                $ossz = $ossz + ($adatok['kikerulesi_ar']*$adatok['db']);
                
                if ($datum != $adatok['kikerulesi_datum']){
                    
                    $datum = $adatok['kikerulesi_datum'];
                    $pd = $adatok['datum'].'<br>'.$adatok['idopont'];
                    
                    $reszosszeg=($adatok['kikerulesi_ar']*$adatok['db']);
                    
                }else{
                 
                    $datum = $adatok['kikerulesi_datum'];
                    $pd = $adatok['datum'].'<br>'.$adatok['idopont'];
                    $reszosszeg = $reszosszeg + ($adatok['kikerulesi_ar']*$adatok['db']);
                    
                }
                
                $num++;
                
        ?>
        

        <tr class="lightCell">
            <td align="center"><?=$pd?></td>
            <td class="vasarlasaim_data">
                
                <?
                    $directory = $func->getHDir($adatok['id']);
                ?>
                
                <!--<a href="/<?=$directory;?>/1_large.jpg" class="highslide" onclick="return hs.expand(this)" />-->
                <b><?=!empty($adatok['markanev'])?$adatok['markanev'].' - ':''?></b> <?=!empty($adatok['termeknev'])?$adatok['termeknev']:''?><br />
                <?=!empty($adatok['szin'])?$adatok['szin'].' - ':''?> <?=!empty($adatok['megnevezes'])?$adatok['megnevezes']:''?>
                <!--</a>-->
            </td>
            <td align="center" class="vasarlasaim_data">
        <?        
             
             if (is_file("../coreshop.hu/".$directory.'/1_small.jpg')){

                 echo '<a href="'.$func->getMainParam("main_url").'/'.$directory.'1_large.jpg" class="highslide" onclick="return hs.expand(this)" /><img src="'.$func->getMainParam("main_url").'/'.$directory.'1_small.jpg" alt="" title="" width="25" height="25" /></a>';  
                 }
        ?>
            </td>
            <td align="center" class="vasarlasaim_data"><?=$adatok['db']?></td>
            <td align="right" class="vasarlasaim_data"><?=number_format(($adatok['kikerulesi_ar']*$adatok['db']), 0, '', ' ')?>,-</td>
        </tr>
        
        <?
        
            }
            
        ?>
        
        <!-- 1 vasarlas blokk vege -->
        
        <!-- //////////////////////////////////////////////////////////////// -->    
        
        <!-- vasarlasok osszesen eleje -->
        
        <tr class="darkCell">
            <td colspan="4" align="right"><b>Vásárlások összesen:</b></td>
            <td align="right"><b><?=number_format($ossz, 0, '', ' ')?>,-</b></td>
        </tr>
        
        <!-- vasarlasok osszesen vege -->    
        
    </table>
    
    </td>
  </tr>
</table>

<script>
    divHelysegek('helysegekdiv', '<?=$_POST['megye']?>', 'varos', '<?=$_POST['varos']?>');
    divOrszagSelect('<?=$_POST['orszag']?>');
</script>
