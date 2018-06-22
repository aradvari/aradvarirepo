<?

    if (ISSET($_POST['modositas'])){
        
        mysql_query("START TRANSACTION");
        
        if (trim($_POST['bevezeto'])=="") $error = "A bevezető megadása kötelező";
        if (trim($_POST['teljes_cikk'])=="") $error = "A teljes hír megadása kötelező";

        if (empty($error)){
        
            /**
            * @desc RÖGZÍTÉS    
            */
            if (!mysql_query("
                UPDATE cikkek 
                SET
                bevezeto = '".trim($_POST['bevezeto'])."',  
                teljes_cikk = '".trim($_POST['teljes_cikk'])."',
                datum = NOW()
                WHERE id_cikk=".$_GET['id']."
            ")) $error = mysql_error();
            
            if (empty($error)){
                
                mysql_query("COMMIT");
                
            }else{
                
                mysql_query("ROLLBACK");
                
            }
            
        }    
        
    }else{
            
        /**
        * @desc ADATOK BEOLVASÁSA
        */
        $_POST = mysql_fetch_array(mysql_query("SELECT * FROM cikkek WHERE id_cikk=".$_GET['id']));
        
    }
        

    if (!empty($error)) echo "<div id=\"error\">$error</div>";
    
?>



<form name="termekfelvitel" method="post" enctype="multipart/form-data">

<table border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td>
        <table border="0" cellspacing="1" cellpadding="6">
          <tr>
            <td class="darkCell" width="150">azonosító:</td>
            <td class="lightCell" width="600"><?=$_GET['id']?>
                <input type="hidden" name="id" value="<?=$_GET['id']?>"></td>
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
            <td colspan="2" class="lightCell"><input name="modositas" type="submit" class="form" id="modositas" value="Hír módosítása" /></td>
          </tr>
        </table>
    </td>
  </tr>
</table>

</form>

