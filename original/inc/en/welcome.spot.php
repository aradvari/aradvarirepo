<script src="/js/jquery.bxSlider.min.js" type="text/javascript"></script>

<script type="text/javascript">
  $(function(){
  $('#slider1').bxSlider({
	auto: true,
	autoControls: true,
    autoControlsSelector: '#my-start-stop',
    mode: 'fade',
    pager: true,
	pause: 5000,
	autoHover: false /* onmouseover-re megall */
  });
});
</script>

<div id="my-start-stop"></div>

<div class="slider1-container">
	<div id="slider1">	
	<?
	$spots = array (				
				'/en/products/shoes/94/Vans/41/'			=>	'/banner/2015/20150519_en_Vans_ISO_1_5.jpg',
				/*'/en/products/shoes/94/Vans/41/#1'			=>	'/banner/2015/20150115_en_vans_tnt_sg_tony_trujillo_scarlett_white.jpg',*/
				/*'/en/products/shoes/94/#2'					=>	'/banner/2014/20141203_xmas_sale.jpg',
				'/en/products/shoes/94/#3'					=>	'/banner/2014/20141128_en_etnies_marana_ryan_sheckler.jpg',
				'/en/products/shoes/94/Vans/41/#2'			=>	'/banner/2014/20141017_en_vans_starwars_holiday.jpg'				*/
			);
	
	foreach ($spots as $url=>$img)	{
		echo '<div>
				<a href="'.$url.'">
				<img src="'.$img.'" alt="Coreshop.hu" />
				</a>
			</div>';
	}
	?>	
	</div>
</div>



<?

// mobile spot only 1st item

reset($spots);
$first_key = key($spots);


echo '<div class="spot-mobile">
		<a href="'.$first_key.'"><img src="'.$spots[$first_key].'" alt="Coreshop.hu" /></a>
</div>';