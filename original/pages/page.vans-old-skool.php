<link rel="stylesheet" href="/css/crshp_vos_20170627.css" type="text/css" media="screen" />

<div class="vos">

</div>


<div class="vos_1">

<img src="/banner_product_page/2017/0627/vans_logo_red.png" alt="Vans logo" />

<h1>VANS OLD SKOOL</h1>
<p>1977<p>
<!-- <span>SINCE 1977</span> -->
</div>

<!--<div class="vos_block">
	<div class="vos_2">
	A VANS céget 1966. március 16-án alapította Paul Van Doren and James Van Doren, Gordon Lee, and Serge D’Elia, első üzletüket pedig The Van Doren Rubber Company néven nyitották meg. A cipőik közül a klasszikus “Old Skool” volt az a cipő, amely meghatározta a brand későbbi imidzsét.
	</div>
</div> -->

<div class="vos_block_3">

<!-- <div class="vos_imgs">
<?
for($i=1; $i<=4; $i++)
	echo '<img src="/banner_product_page/2017/0627/history'.$i.'.jpg" alt="Vans Old Skool history '.$i.'" />';
?>
</div>
-->


	<div class="vos_3">
	
	<p>A VANS céget 1966. március 16-án alapította Paul Van Doren, James Van Doren, Gordon Lee és Serge D’Elia. Első üzletüket The Van Doren Rubber Company néven nyitották meg. A cipőik közül a klasszikus “Old Skool” volt az a cipő, amely meghatározta a brand későbbi arculatát.
	<br />
	<br />
	Az eredeti Vans Old Skool 1977-ben "Style 36” néven látott napvilágot. A legnagyobb különlegessége az volt, hogy ez volt az első olyan cipő, amin rajta volt az eredetileg de Van Doren Rubber Company-nek hívott, de ma már csak VANS-ként ismert kaliforniai cég jellegzetes logója. A jelet egyébként eredetileg "jazz stripe-nak” hívták. A VANS Old Skool abból az egyszerű okból vált az egyik legnépszerűbb gördeszkás cipővé, hogy egyszerű rétegekből, letisztult dizájt szinte bármilyen kombinációban össze tudták rakni, így mindenki igénye szerint vehetett olyat, amilyet akart. A cipő akkora népszerűségnek örvend, hogy időről időre újra feltűnik a kollekciókban, és valahogy soha nem megy ki a divatból.</p>
	</div>
</div>



<div class="vos_block">
	<div class="vos_block_shoes">
	<p>aktuális kínálatunk</p>
	<?
	$q = mysql_query('select id from termekek t
	left join vonalkodok v on v.id_termek = t.id
	where t.termeknev like "%old skool%"
	and t.kategoria in (94,95)
	and v.keszlet_1>0
	and t.aktiv = 1
	group by t.id
	order by t.opcio DESC, t.id DESC');

	while ($one_row = mysql_fetch_array($q))	{
		echo $func->thumb($one_row['id']);
	}
	
	?>
	</div>
</div>

-->
