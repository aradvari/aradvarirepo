<div class="right-container">

	<div class="content-right-blue-headline">Thank you for your order!</div>

	<div style="padding:20px 100px;">
		<?
		
		echo nl2br('We received your order, an automatic confirmation e-mail has been sent to the address provided by you.
		
		
		<b>Delivery with GLS parcel service:</b>

		Expected date of delivery: '.$func->GLSDeliveryDate('EN').'
		
		
		<center>Thank you for shopping at <a href="/">Coreshop</a>!</center>
		
		
		&lsaquo; <a href="/">Back to home</a>');
		?>
	</div>

	</div>
</div>

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
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1010416024/?label=TCuVCJC_0QEQmPPm4QM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>


<? unset($_SESSION["google_fizetendo"]); ?>