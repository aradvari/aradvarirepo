<div class="arrow_box" style="margin:4%; text-transform:uppercase; font-size:1.4em; font-weight:bold; vertical-align:middle;">Sikeres vásárlás!</div>

<div class="textbox">

	<div style="padding:0 4%;">
		<?
		
		echo nl2br('Megrendelésed sikeres volt, a regisztrált e-mail címedre visszaigazoló levelet küldött rendszerünk.
		
		
		<b>A TERMÉK ÁTVÉTELE:</b>
		
		<ul><li><b>Kiszállítás GLS csomagküldő szolgálattal:</b>
		
		A kézbesítés várható időpontja: <a href="/'.$_SESSION["langStr"].'/'.$func->convertString('szallitas').'"><b>'.$func->dateToHU($func->GLSDeliveryDate('HU')).'</b></a> 
		</li>
				
			<li><b>Személyes átvétel esetén:</b>
			
			Ha megrendelésed leadásakor a "személyes átvételt" választottad, akkor a <a href="/uzletunk">Coreshop irodájában</a> munkanapokon 9:30 - 17:00 között veheted át a terméket.
			
			Fizetési módok irodánkban, személyes átvétel esetén:
			
			- Készpénz 
			- Bankkártya (Visa, Visa Electron, MasterCard, Cirrus)
				
						
		<center>Köszönjük, hogy a <a href="/">Coreshop</a>-ot választottad!</center>		
		
		
		<a href="/"><div class="arrow_box_light">&lsaquo; Vissza a kezdőlapra</div></a>');
		?>
	</div>

	
</div>

<div class="textbox">

	<div class="radioSelect" style="padding:0; margin:0; text-align:left;">
	<style>
	.radioSelect {
	  margin: 0 0 0.75em 0;
	}

	.radioSelect div{
		display: inline-block;
		margin: 0px 10px;
		width: 40%;
	}

	
	input[type="radio"] + label {
	  color: #666;
	  font-family: Arial, sans-serif;
	  font-size: 14px;
	  cursor: pointer;
	}

	input[type="radio"] + label span {
	  display: inline-block;
	  width: 19px;
	  height: 19px;
	  margin: -1px 4px 0 0;
	  vertical-align: middle;
	  cursor: pointer;
	  -moz-border-radius: 50%;
	  border-radius: 50%;
	}

	input[type="radio"] + label span {
	  background-color: #444;
	}

	input[type="radio"]:checked + label span {
	  background-color: #78CDD1;
	}

	input[type="radio"] + label span,
	input[type="radio"]:checked + label span {
	  -webkit-transition: background-color 0.4s linear;
	  -o-transition: background-color 0.4s linear;
	  -moz-transition: background-color 0.4s linear;
	  transition: background-color 0.4s linear;
	}


	input[type="radio"]:checked+label{
		background: transparent !important;
	}

		@media screen and (max-width: 720px) {
	input[type="radio"] + label {
	  color: #666;
	  font-family: Arial, sans-serif;
	  font-size: 14px !important;
	  text-align: center !important;
	  cursor: pointer;
	  line-height: 20px;
	  } 
	  
	input[type="radio"] + label span {
	  display: inline-block;
	  width: 10px !important;
	  height: 10px !important;
	  margin: -1px 4px 0 0;
	  vertical-align: middle;
	  cursor: pointer;
	  -moz-border-radius: 50%;
	  border-radius: 50%;
	}
	
	.radioSelect div{
		display: inline-block;
		margin: 0px 10px;
		width: 100%;
	}
	} 
	
</style>
	<? 
	// szavazas
	include 'inc/inc.szavazas.php'; ?>
	</div>
	
</div>


<?

// disabled coreshop user
if($_SESSION['felhasznalo']['id']!=11039)	{
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
<?php if(isset($_SESSION["google_fizetendo"])): ?>
var google_conversion_value = <? echo $_SESSION["google_fizetendo"]?>;
<?php endif; ?>
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


<? unset($_SESSION["google_fizetendo"]); 
}
?>