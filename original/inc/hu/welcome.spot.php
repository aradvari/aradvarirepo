<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>-->
<script type="text/javascript" src="/js/responsiveslides.min.js"></script>
<link rel="stylesheet" href="/css/responsiveslides_20170112.css">

<script>
	// You can also use "$(window).load(function() {"
	$(function () {

	  $("#slider4").responsiveSlides({
		auto: true,
		pager: false,
		nav: true,
		speed: 500,
		timeout: 7000,
		namespace: "callbacks",
		before: function () {
		  $('.events').append("<li>before event fired.</li>");
		},
		after: function () {
		  $('.events').append("<li>after event fired.</li>");
		}
	  });

	});
</script>
  
  
  
  <div id="wrapper">
  
    <!-- SLIDER DESKTOP -->
    <div class="callbacks_container">
      <ul class="rslides" id="slider4">
		
		<?
		$folder='banner/2018/';									
		// img, caption, url
		$spots=array(																
				$item0=array( '20180124_eos_sale.jpg', 'End of Season SALE!', '/hu/termekek_akcios/ferfi-cipo/94'),
				$item1=array( '20171107-vans-sk8-hi-original.jpg', 'Vans Sk8-Hi', '/hu/termekek/ferfi-cipo/94/Vans/41?keresendo=vans%20sk8-hi'),				
				$item4=array( '20170628_vans_old_skool.jpg', 'Vans Old Skool cipők', '/hu/vans-old-skool'),
				);
								
								
		foreach ($spots as $spot)	{
			echo '<li>
					<a href="'.$spot[2].'"><img src="/'.$folder.$spot[0].'" alt="'.$spot[1].' - Coreshop.hu" title="'.$spot[1].' - Coreshop.hu" /></a>';
			
			if(!empty($spot[1]))
				echo '<p class="caption">'.$spot[1].'</p>';
					
			echo '</li>'; 
		}		
		?>
		
      </ul>
    </div>
	
	
	
</div>