<div class="right-container">

<div class="content-right-headline">Delivery</div>

<?=nl2br('<div style="padding:0 105px;"><h4>Shipping via GLS Parcel Service</h4>
Delivery in Hungary will be realized by GLS Hungary kft (parcel service). Seller will send tracking number of the package at 17:00 on the first working day of the depart of the goods to the e-mail address confirmed by the Customer. Using this tracking number the whereabouts of the package may be tracked via the site of GLS Parcel Service<br />(<a href="https://gls-group.eu/EU/en/parcel-tracking" target="_blank">https://gls-group.eu/EU/en/parcel-tracking</a>). 

Customer needs to ensure that an address which is eligible for dispatching the goods in working hours (8-17 weekdays) is specified. Customer or a person residing at the address specified by the Customer is entitled to receiving the goods. Customer may contact the Parcel Service (https://gls-group.eu/) concerning expected delivery date and time. Please refer to the tracking number received in the notification mail.


<h4>Delivery in the EU</h4>
Shipping rate inside the EU: <b>€ '.number_format($func->getMainParam('szallitasi_dij_kulfold'), 0, '', ' ').'</b>.

Free Delivery Limit to abroad (outside Hungary): <b>€ '.number_format($func->getMainParam('ingyenes_szallitas_kulfold'), 0, '', ' ').'</b>.



<h4>Delivery in Hungary</h4>
Shipping rate using GLS for the whole territory of Hungary is <b>'.number_format($func->getMainParam('szallitasi_dij'), 0, '', ' ').' HUF</b>, in case the value of the goods does not exceed the Free Delivery Limit.

Free Delivery Limit in Hungary is <b>'.number_format($func->getMainParam('ingyenes_szallitas'), 0, '', ' ').' HUF</b>.



Estimated shipping time to the members of the European Union is different per country, please refer to the sheet below

');
?>

<center>
	<table class="gls-table">
	<tr><td colspan=2>Delivery time (in weekdays) *</td></tr>
		
	<tr>
		<td style="width:200px;">1 day</td>
		<td><b>HUNGARY</b>, Slovakia</td>
	</tr>
	
	<tr>
		<td>2 days</td>
		<td>Austria, Germany, Czech Republic, Romania, Slovenia, Poland</td>
	</tr>
	
	<tr>
		<td>3 days</td>
		<td>Belgium, Hollandia, Luxembourg, Liechtenstein, Switzerland, Bulgaria, Denmark, France, San Marino, Vatican, Italy, Lithuania</td>
	</tr>
	
	<tr>
		<td>4 days</td>
		<td>United Kingdom, Monaco, Latvia</td>
	</tr>
	
	<tr>
		<td>4-6 days</td>
		<td>Spain</td>
	</tr>
	
	<tr>
		<td>4-7 days</td>
		<td>Sweden</td>
	</tr>
	
	<tr>
		<td>5 days</td>
		<td>Ireland, Estonia, Turkey, Malta</td>
	</tr>
	
	<tr>
		<td>5-7 days</td>
		<td>Norway, Greece, Andorra, Gibraltar, Portugal, Finnland</td>
	</tr>
	
	<tr>
		<td>6-7 days</td>
		<td>Cypress</td>
	</tr>		
	
	</table>
</center>

<?=nl2br('
* Lead times in the tables are indicative and not guaranteed!


</div>');
?>

</div>