<div class="fixed-header-container">

<table border=0 width=980>
	
	<tr>
		<!-- orszag / valuta valtol -->
		<td colspan=3 valign="middle"><? /*=$lang->valassz_nyelvet*/?>
            
			<form method="post" id="changeLanguageForm" action="/" style="display: inline-block;"> 
			
                <input type="hidden" name="selectedLang" id="selectedLang" />
				<img src="/images/flags/0.jpg" alt="" class="flags" style="cursor: pointer;" onclick="jQuery('#selectedLang').val('0'); jQuery('#changeLanguageForm').submit()" /> <!-- hu -->
				<img src="/images/flags/1.jpg" alt="" class="flags" style="cursor: pointer;" onclick="jQuery('#selectedLang').val('1'); jQuery('#changeLanguageForm').submit()" /> <!-- en -->
			
    			<!--
				<select name="selectedLang" onchange="jQuery('#changeLanguageForm').submit()">
    				<option value="1" <?=$lang->defaultLangId==1?'selected="selected"':''?> >English</option>
    				<option value="0" <?=$lang->defaultLangId==0?'selected="selected"':''?> >Magyar</option>
    			</select>
				-->
    		
            </form>
			
			
 		    &nbsp;&nbsp; &middot; &nbsp;&nbsp;<?=$lang->penznem?> &rsaquo;   
            <form method="post" id="changeCurrencyForm" style="display: inline-block;">
    			
                <select name="selectedCurrency" onchange="jQuery('#changeCurrencyForm').submit()">
    				<option value="1" <?=$lang->defaultCurrencyId==1?'selected="selected"':''?> >EUR ( &euro; )</option>
    				<option value="0" <?=$lang->defaultCurrencyId==0?'selected="selected"':''?> >HUF ( Ft )</option>
    			</select>
		
            </form>
			
			<!--&nbsp;&nbsp; &middot; &nbsp;&nbsp;<a href="#" style="color:#CCC;">EU shipping <img src="/images/flags/eu.jpg" class="flags" style="vertical-align:middle;"/></a> -->
		
		
		<!-- aloldalak -->		
		<? include 'inc/subpages.php'; ?>
		
		</td>
	</tr>
	
	<tr>
		<!-- logo -->
		<td align="center" style="height:60px;width:290px;">			
			<a href="/"><img src="/images/coreshop-logo.png" alt="<?=$lang->cslogo_title?>" /></a>
		</td>
		
		<!-- kosar -->
		<td align="center" style="width:400px;">
			<!-- <div class="top-kosar-content"> -->
			<div>
			<? include 'inc/top-kosar.php'; ?>
			</div>
			<!-- </div> -->
		</td>
		
		<!-- kereses -->
		<td align="center" style="width:290px;">
			<div id="searchwrapper">
					<form action="/<?=$_SESSION["langStr"]?>/<?=$lang->_termekek?>" method="post">
						<input type="text" class="searchbox" name="keresendo" id="search-top" value="<?=$lang->termek_kereses?>" onClick="input_clear('search-top');" />
						<input type="image" src="/images/lupe.jpg" class="searchbox_submit" value="" />
					</form>
			</div>
		</td>
	</tr>
	
	<tr>
		<!-- topmenu -->
		<td colspan=3 valign="top">
			<? include 'inc/topmenu.php'; ?>		
		</td>
	</tr>
	
</table>

</div>