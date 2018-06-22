<?
    
    if (ISSET($_POST['felvitel'])){
        
        mysql_query("START TRANSACTION");
        
        if (trim($_POST['bevezeto'])=="") $error = "A bevezető megadása kötelező";
        if (trim($_POST['teljes_cikk'])=="") $error = "A teljes hír megadása kötelező";

        if (empty($error)){
        
            /**
            * @desc RÖGZÍTÉS    
            */
            if (!mysql_query("
                INSERT INTO cikkek
                (bevezeto, teljes_cikk, datum)
                VALUES
                (
                 '".trim($_POST['bevezeto'])."',
                 '".trim($_POST['teljes_cikk'])."',
                 NOW()
                )
                ")) $error = mysql_error();
                                                                                                               
            if (empty($error)){
                
                mysql_query("COMMIT");
                unset($_POST);

            }else{
                
                mysql_query("ROLLBACK");
                
            }
            
        }    
        
    }

    if (!empty($error)) echo "<div id=\"error\">$error</div>";
    
    $newid = (int)@mysql_result(@mysql_query("SELECT max(id_cikk) FROM cikkek"), 0);
    
?>



<form name="termekfelvitel" method="post" enctype="multipart/form-data">
<input type="hidden" name="spec_num" id="spec_num" value="-1" />

<table border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td>
        <table border="0" cellspacing="1" cellpadding="6">
          <tr>
            <td class="darkCell" width="150">azonosító:</td>
            <td class="lightCell" width="600"><?=$newid+1?>
                <input type="hidden" name="id" value="<?=$newid+1?>"></td>
          </tr>
          <tr>
            <td class="darkCell">bevezető:</td>
            <td class="lightCell"><input name="bevezeto" type="text" class="form" id="bevezeto" style="width:100%" maxlength="255" <?php echo(ISSET($_POST['bevezeto'])?'VALUE="'.$_POST['bevezeto'].'"':'');?>></td>
          </tr>
          <tr>
            <td class="darkCell">teljes hír:</td>
            <td class="lightCell">
                <textarea name="teljes_cikk" style="width:100%; height:200px"><?php echo(ISSET($_POST['teljes_cikk'])?$_POST['teljes_cikk']:'');?></textarea>
            </td>
          </tr>
          <tr>
            <td colspan="2" class="lightCell"><input name="felvitel" type="submit" class="form" id="felvitel" value="Hír rögzítése" /></td>
          </tr>
        </table>
    </td>
  </tr>
</table>

</form>

