<?

    if (ISSET($_POST['modositas'])){
        if (is_array($_POST)) {
            mysql_query("DELETE FROM vonalkod_sorrendek");
            foreach ($_POST as $key => $value) {
                $value = (int)$value;
                $key = urldecode($key);
                if ($key!='modositas') mysql_query("INSERT INTO vonalkod_sorrendek (vonalkod_megnevezes, sorrend) VALUES ('$key', $value)");
            }
        }                                            
    }
    
?>

<form method="post">
<br>
<table width="300" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td width="300">
        <tr>
          <td class="darkCell">Megnevezések sorrendezése</td>
        </tr>
        <table width="300" border="0" cellspacing="1" cellpadding="6">
          <?
            $sql = "SELECT v.megnevezes, vs.sorrend FROM vonalkodok v LEFT JOIN vonalkod_sorrendek vs ON (vs.vonalkod_megnevezes = v.megnevezes) WHERE v.megnevezes!='' GROUP BY v.megnevezes";
            $query = mysql_query($sql);
            
            while ($adatok = mysql_fetch_array($query)){
          ?>
          <tr>
            <td class="darkCell"><?=$adatok['megnevezes']?></td>
            <td colspan="3" class="lightCell"><input type="text" class="form" name="<?=urlencode($adatok['megnevezes'])?>" size="5" value="<?=$adatok['sorrend']?>"></td>
          </tr>
          <?
            }
          ?>
          <tr>
            <td colspan="4" class="lightCell"><input name="modositas" type="submit" class="form" value="Módosítás" /></td>
          </tr>
        </table>
    </td>
  </tr>
</table>

</form>

