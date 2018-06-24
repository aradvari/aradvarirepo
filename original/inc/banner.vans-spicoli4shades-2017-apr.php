<style type="text/css">
<!--

.main-banner	{
	padding:0 0 10px 0; margin-top:-10px; margin-bottom:0; background-color:#FFF; overflow:auto;	letter-spacing:0; font-size:1em; max-width: 1280px; }

.main-banner	span	{
	color:#222; display:block; background-color:#ffb400; padding:20px; text-shadow:none; text-align:center;	}

.main-cont	{
	text-align:center; padding-top:0px; }
	
.banner-thumb	{
	/*margin-top:10px; width:calc(100%/4); */
	
	top:-40px; 
	z-index:1;
	width:-webkit-calc(25% - 40px);width:-moz-calc(25% - 40px);width:calc(25% - 40px);margin:0px 20px;
	
	float:left; position:relative; 
	
	margin-bottom:-20px; 
	}

.banner-thumb a { color:#000; }

.banner-thumb p {
	margin:-40px auto 0 auto; text-transform:uppercase; font-size:12px; }

.banner-thumb img	{
	width:90%; border:none;	margin:0; }

.id_index {
	position:absolute; top:20px;	left:10px;	-webkit-border-radius: 3px;	-moz-border-radius: 3px; border-radius: 3px; background-color:#eee;	padding:4px 10px; }

@media screen and (max-width: 500px) {
	.banner-thumb	{ font-size:0.8em;	} }

@media screen and (max-width: 780px) {
	.banner-thumb	{ margin:10px 0; width:calc(100%/2); }
	.banner-thumb p { font-size:10px; margin:-20px auto 0 auto; }
}
	
-->
</style>


<div class="main-banner">
<span>Minden 20.000 Ft feletti rendeléshez "VANS SPICOLI 4 SHADES" napszemüveget ajándékozunk!</span>
<div class="main-cont">
<p style="z-index:2;">Írd be a megrendelés oldal MEGJEGYZÉS mezőbe, hogy melyik számú napszemüveget választod az alábbiak közül:</p>
<br />

	<?
	$sunglasses =array(						
						5495=>'1_Matte Black/Silver Mirror',
						4429=>'2_Black/White',
						5742=>'3_Translucent Honey', 
						6061=>'4_Beer Belly',			
					);
		
		foreach($sunglasses as $sunglass=>$color)	{
		
			$sg_id=explode('_', $color);
		
			echo '<div class="banner-thumb">
			<a href="/'.$func->getHDir($sunglass).'1_large.jpg" class="highslide" onclick="return hs.expand(this)">			
			<img src="/'.$func->getHDir($sunglass).'1_small.jpg" /></a>
			<div class="id_index">'.$sg_id[0].'</div>
			<br /><p>'.$sg_id[1].'</p>
			</div>';
			
			}
	?>
</div>
</div>