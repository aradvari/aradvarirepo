<?
			
$brands = array (
				41=>'Vans',
				40=>'DC',
				42=>'etnies',
				44=>'Emerica',
				68=>'Fallen',
				58=>'Volcom',
				108=>'Skullcandy',
				118=>'Jart',
				);
?>

<center>

<div class="footer-table">
	<table>
		<tr>
			
			<!-- kapcsolat -->
			<td>
					&copy; <?=date('Y')?> - <a href="<?=$func->getMainParam('main_url')?>"><?=$func->getMainParam('main_page')?>.hu</a><br />
					All rights reserved.
					<br />
					<br />
					<b>Contact</b>
					<br />
					<br />
					Call center:
					<br />
					Weekdays: between 9am and 5pm
					<br />
					<br />
					Phone numbers:
					<br />
					&nbsp;+36 70 676 CORE<br />
					(+36 70 676 2673)
					<br />
					<br />
					E-Mail:
					<br />
					<a href="mailto:<?=$func->getMainParam('main_email')?>"><?=$func->getMainParam('main_email')?></a>				
			</td>
			
			<!-- markaink -->
			<td>
				<b>Brands:</b>
				<br />
				<br />
					<?
					foreach	($brands as $markaid => $markanev)	{
						echo '<a href="/'.$lang->defaultLangStr.'/products/0/0/'.$markanev.'/'.$markaid.'">'.$markanev.'</a>  &middot; ';
						}
						
					echo '<a href="/hu/products/belga/150">Bëlga</a>';

					?>
				<br />	
				<br />	
				<br />	
				<br />	
				<b>Product search</b>
				<br />
				<br />				

				<div id="searchwrapper">
					<form action="/products" method="post">
						<input type="text" class="searchbox" name="keresendo" id="search-bottom" value="Product search" onclick="input_clear('search-bottom');" />
						<input type="image" src="/images/lupe.jpg" class="searchbox_submit" value="" />
					</form>
				</div>
				
				<br />
				<br />
				
				<?
				echo '<a href="/'.$_SESSION["langStr"].'/'.$func->convertString($lang->_aszf).'">'.$lang->aszf.'</a> &middot; ';
				echo '<a href="/'.$_SESSION["langStr"].'/'.$func->convertString($lang->_aszf).'#1">'.$lang->vasarlas.'</a> &middot; ';
				echo '<a href="/'.$_SESSION["langStr"].'/'.$func->convertString($lang->_szallitas).'">'.$lang->szallitas.'</a> &middot; ';
				echo '<a href="/'.$_SESSION["langStr"].'/'.$func->convertString($lang->_aszf).'#7">'.$lang->szavatossag.'</a> &middot; ';
				echo '<a href="/'.$_SESSION["langStr"].'/'.$func->convertString($lang->termekcsere).'">'.$lang->termekcsere.'</a> &middot; ';
				echo '<a href="/'.$_SESSION["langStr"].'/'.$func->convertString($lang->kapcsolat).'">'.$lang->kapcsolat.'</a> &middot; ';
				echo '<a href="/'.$_SESSION["langStr"].'/'.$func->convertString($lang->_uzletunk).'">'.$lang->uzletunk.'</a> &middot; ';
				?>
				
			</td>
			
			<!-- CIB -->
			<td>				
				<? include 'inc/'.$lang->defaultLangStr.'/left.kartyas_fizetes.php';?>	  
			</td>
			
			<td style="border:none;">
			
			<?
			echo '<b>Free shipping over € '.$func->getMainParam('ingyenes_szallitas_kulfold').'</b><br /><br /><div class="arrow_box">';
			// ingyenes szallitas ertekhatar
			while($reszletek=each($_SESSION['kosar']))	{              
				$kosar_fizetendo = $kosar_fizetendo + ( $reszletek[1][3] * $reszletek[1][2] );
			}
			
			$ingyenes_szallitas_ertekhatar = $func->getMainParam('ingyenes_szallitas_kulfold') - $func->toEUR($kosar_fizetendo, true);
			
			if ( ($ingyenes_szallitas_ertekhatar) >0 )	{
				echo 'You still need to purchase for<br /> <b>€ '.number_format($ingyenes_szallitas_ertekhatar, 2, '.', ' ').'</b> to reach the Free Delivery Limit';
				}
			else
				echo 'Elérted a '.number_format($func->getMainParam('ingyenes_szallitas_kulfold'), 0, '', ' ').' Ft <b>ingyenes szállítás</b> értékhatárát!';
			
			echo '</div>';
			
			echo nl2br('			
			<div style="border-bottom:1px solid #222;"></div>			
			<b>Shipping via GLS Parcel Service</b>			
			<a href="/'.$_SESSION["langStr"].'/'.$lang->_szallitas.'"><img src="/images/gls-logo.png" alt="Coreshop shipping via GLS Parcel Service" style="margin:5px 0; width:244px; height:80px;" /></a>
			<a href="/'.$_SESSION["langStr"].'/'.$lang->_szallitas.'">Learn more about delivery</a> &rsaquo;');
			
			?>
	
			</td>
			
		</tr>
	</table>
</div>

</center>