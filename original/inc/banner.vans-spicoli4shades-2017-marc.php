<style type="text/css">
<!--

.main-banner	{
	padding:0 0 2% 0; background-color:#FFF; overflow:auto;	letter-spacing:0; font-size:1em; max-width: 1280px; }

.main-banner	span	{
	color:#fff; display:block; background-color:#2a87e4; padding:20px; text-shadow:none; text-align:center;	}

.main-cont	{
	text-align:center; padding-top:20px; }
	
.banner-thumb	{
	margin-top:10px; width:calc(100%/6); float:left; position:relative; }

.banner-thumb a { color:#000; }

.banner-thumb p {
	margin:-30px auto 0 auto; text-transform:uppercase; font-size:12px; }

.banner-thumb img	{
	width:90%; border:none;	margin:0; }

.id_index {
	position:absolute; top:0px;	left:10px;	-webkit-border-radius: 3px;	-moz-border-radius: 3px; border-radius: 3px; background-color:#eee;	padding:4px 10px; }

@media screen and (max-width: 500px) {
	.banner-thumb	{ font-size:0.8em;	} }

@media screen and (max-width: 780px) {
	.banner-thumb	{ margin:10px 0; width:calc(100%/3); }
	.banner-thumb p { font-size:10px; margin:-20px auto 0 auto; }
}
	
-->
</style>


<div class="main-banner">
<span>Minden 20.000 Ft feletti rendeléshez "VANS SPICOLI 4 SHADES" napszemüveget ajándékozunk!</span>
<div class="main-cont">
Írd be a megrendelés oldal MEGJEGYZÉS mezőbe, hogy melyik számú napszemüveget választod az alábbiak közül:
<br />
<br />
<br />

	<?
	$sunglasses =array(4430=>'1_Black', 
						4429=>'2_Black/White', 
						/*6060=>'3_White/Green', */
						5495=>'3_Matte Black/Silver Mirror',
						5742=>'4_Translucent Honey', 
						6061=>'5_Beer Belly',			
						6175=>'6_Los Psychos'
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