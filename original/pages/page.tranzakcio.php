<?
echo '<div style="padding:40px 80px;">';

if ($tranzakcio->response["RC"]=="00"){ //SIKERES VÁSÁRLÁS
	
	echo '<div class="alert_green">';
	
    echo '<p>'.$lang->cib_sikeres.'</p>';
    echo '<p>'.$lang->cib_sikeres_vissza.'</p>';
    echo '<ul>';
    echo '<li>'.$lang->Valaszkod.' (RC): <b>'.$tranzakcio->response["RC"].'</b></li>';
    echo '<li>'.$lang->Valaszuzenet.' (RT): <b>'.iconv("ISO-8859-2", "UTF-8", $tranzakcio->response["RT"]).'</b></li>';
    echo '<li>'.$lang->Tranzakcio_azonosito.' (TRID): <b>'.$tranzakcio->response["TRID"].'</b></li>';
    echo '<li>'.$lang->Engedelyszam.' (ANUM): <b>'.$tranzakcio->response["ANUM"].'</b></li>';
    echo '<li>'.$lang->Tranzakcio_osszege.': <b>'.number_format($tranzakcio->response["AMO"], 2, '.', ' ').' '.($_SESSION["currencyId"]==0?'Ft':'EUR').'</b></li>';
    echo '</ul>';
	
	echo '</div>';
	
	/////////////////////////////////////////////////////////
	
	if($_SESSION['langStr']=='hu')	{
		//// SIKERES VASARLAS ///////////////////////////////
		echo '<div class="content-right-blue-headline">Sikeres vásárlás!</div>';

		echo '<div style="padding:20px 0 0 60px;">';
		
		echo nl2br('A megrendelésed sikeres volt, a regisztrált e-mail címedre visszaigazoló levelet küldött rendszerünk.
			
			
			<b>A TERMÉK ÁTVÉTELE:</b>
			
			<ul><li><b>Kiszállítás GLS csomagküldő szolgálattal:</b>
			
			A kézbesítés várható időpontja: <a href="/'.$_SESSION["langStr"].'/'.$func->convertString('szallitas').'"><b>'.$func->dateToHU($func->GLSDeliveryDate('HU')).'</b></a> (Tájékoztató jellegű adat.)		
			</li>
					
			<center>Köszönjük, hogy a <a href="/">Coreshop</a>-ot választottad!</center>
			
			
			&lsaquo; <a href="/">vissza a kezdőlapra</a>');
			
			echo '</div>';			
		
		// GOOGLE CONV
		$anaconvgeneral = $_SESSION["anaconvgeneral"];
		$anaconvitems = $_SESSION["anaconvitems"];
		?>

		<script type="text/javascript">
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-17488049-1', 'auto');
			ga('require', 'displayfeatures');
			ga('require', 'linkid', 'linkid.js');	
			ga('send', 'pageview');

			ga('require', 'ecommerce', 'ecommerce.js');  

			// Initialize the transaction
			ga('ecommerce:addTransaction', {
						 id: '<?php echo ($anaconvgeneral['invoice']); ?>',     // Transaction ID*
				affiliation: '', // Store Name
					revenue: '<?php echo ($anaconvgeneral['totalnovat']); ?>',       // Total
				   shipping: '<?php echo ($anaconvgeneral['shipping']); ?>',          // Shipping
						tax: '<?php echo ($anaconvgeneral['totalvat']); ?>'         // Tax
			});  
		  

		  <?php 
		foreach($anaconvitems as $item) :
		?>  

			ga('ecommerce:addItem', {
					  id: '<?php echo ($anaconvgeneral['invoice']); ?>',            // Transaction ID*
					 sku: '<?php echo $item['SKU']; ?>',         // Product SKU
					name: '<?php echo $item['productname']; ?>',   // Product Name*
				category: '',      // Product Category
				   price: '<?php echo $item['itemprice']; ?>',              // Price
				quantity: '<?php echo $item['itemqty']; ?>'                   // Quantity
			});

		<?php
		endforeach;
		?>
		  
		ga('ecommerce:send');

		</script> 
		
		


		<!-- Google Code for sikeres vasarlas Conversion Page -->
		<script type="text/javascript">
		/* <![CDATA[ */
		var google_conversion_id = 1010416024;
		var google_conversion_language = "en";
		var google_conversion_format = "1";
		var google_conversion_color = "000000";
		var google_conversion_label = "TCuVCJC_0QEQmPPm4QM";
		if (<? echo $_SESSION["google_fizetendo"] ?>) {
		var google_conversion_value = <? echo $_SESSION["google_fizetendo"] ?>;
		}
		var google_conversion_currency = "HUF";
		var google_remarketing_only = false;

		/* ]]> */
		</script>
		<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
		</script>
		<noscript>
		<div style="display:inline;">
		<img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/1010416024/?value=<?php echo $_SESSION["google_fizetendo"] ;?>?&amp;currency_code=HUF&amp;label=TCuVCJC_0QEQmPPm4QM&amp;guid=ON&amp;script=0"/>
		</div>
		</noscript>
		<!-- -->


		
		
		<!-- Facebook Conversion Code for Sikeres vásárlás -->
		<script>(function() {
		var _fbq = window._fbq || (window._fbq = []);
		if (!_fbq.loaded) {
		var fbds = document.createElement('script');
		fbds.async = true;
		fbds.src = '//connect.facebook.net/en_US/fbds.js';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(fbds, s);
		_fbq.loaded = true;
		}
		})();
		window._fbq = window._fbq || [];
		window._fbq.push(['track', '6018444862384', {'value':'<? echo $_SESSION["google_fizetendo"] ?>.00','currency':'HUF'}]);
		</script>
		<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6018444862384&amp;cd[value]=<? echo $_SESSION["google_fizetendo"] ?>&amp;cd[currency]=HUF&amp;noscript=1" /></noscript>
		
		<!-- facebook konverzio_2017 -->
		<script>
		fbq('track', 'Purchase', {value: '<?=$_SESSION["google_fizetendo"];?>.00', currency: 'HUF'});
		</script>


		<? unset($_SESSION["google_fizetendo"]); ?>
		
		<?
		}
	else	{	//mas nyelvnel sikeres kartyas fizetes uzenet
		//// PAYMENT SUCCESSFUL ///////////////////////////////
		echo '<div class="content-right-blue-headline">SUCCESSFUL ORDER!</div>';

		echo '<div style="padding:20px 0 0 60px;">';
		
		echo nl2br('The order has been successful, the registered e-mail address sent a letter of confirmation system.
			
			
			<b>DELIVERY:</b>
			
			<ul><li><b>GLS parcel service:</b>
			
			Expected shipping date: between '.date('Y. F d. D', strtotime("+2 day")).' - '.date('Y. F d. D', strtotime("+4 day")).'</li>
			
			<a href="/'.$_SESSION["langStr"].'/'.$func->convertString('szallitas').'">More information about the international shipping</a>
			
					
			<center><text size=4>Thank you for your order!</text></center>
			
			
			&lsaquo; <a href="/">Back to home</a>');
			
			echo '</div>';
		}
	/////////////////////////////////////////////////////////
	
   
}elseif ($tranzakcio->response["RC"]!="00"){ //SIKERTELEN VÁSÁRLÁS

    echo '<div class="alert_red">';
	
    echo '<p>'.$lang->cib_sikertelen.'</p><br />';
    echo '<p>'.$lang->cib_sikertelen_vissza.'</p>';
    echo '<ul>';
    echo '<li>'.$lang->Valaszkod.' (RC): <b>'.$tranzakcio->response["RC"].'</b></li>';
    echo '<li>'.$lang->Valaszuzenet.' (RT): <b>'.iconv("ISO-8859-2", "UTF-8", $tranzakcio->response["RT"]).'</b></li>';
    echo '<li>'.$lang->Tranzakcio_azonosito.' (TRID): <b>'.$tranzakcio->response["TRID"].'</b></li>';
    echo '</ul>';
	
	echo '</div>';
    
    if ($tranzakcio->type==1) echo $lang->rendeles_ujra;	
	
	
    
}else{ //TIME-OUT
    
    echo '<p>'.$lang->cib_tomeout.'</p>';
    
}

echo '</div>';
?>