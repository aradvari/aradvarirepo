<?

    if (ISSET($_POST['modositas'])){
        if (is_array($_POST)) {
            foreach ($_POST as $key => $value) {
                mysql_query("UPDATE globalis_adatok SET ertek='$value' WHERE kulcs='$key'");
            }
        }                                            
    }
    
?>

<form method="post">

<table width="700" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td width="500">
        <table width="500" border="0" cellspacing="1" cellpadding="6">
          <?
            $sql = "SELECT * FROM globalis_adatok ORDER BY sorrend";
            $query = mysql_query($sql);
            
            while ($adatok = mysql_fetch_array($query)){
          ?>
          <tr>
            <td class="darkCell"><?=$adatok['megnevezes']?>:</td>
            <td colspan="3" class="lightCell"><input type="text" class="form" name="<?=$adatok['kulcs']?>" size="60" value="<?=$adatok['ertek']?>"></td>
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

