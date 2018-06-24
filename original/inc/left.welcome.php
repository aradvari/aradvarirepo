<?
  $rss=mysql_fetch_array(mysql_query("SELECT id_cikk, bevezeto, teljes_cikk, datum FROM cikkek ORDER BY id_cikk DESC LIMIT 1"));
?>

<table border="0" align="center" class="leftpanel">

  <tr>
	<th style="color:#9EB91B;"><?=$rss['bevezeto'];?></th>
  </tr>
  
  <tr>
    <td>
      <div style="text-align:left; padding:0 10px;">
      <div style="font-size:9px"><?=$rss['datum'];?></div>
      
      <br />
      
      <?=nl2br($rss['teljes_cikk']);?>
     
      </div>
      
      <br />
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://blog.coreshop.hu" target="_blank"><img src="/images/blog-coreshop.png" alt="Coreshop Blog" title="Coreshop Blog" /></a>
    </td>
  </tr>
  
</table>
