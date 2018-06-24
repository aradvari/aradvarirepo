<?
if($func->isMobile())
	$mobile='margin:4%; bottom:10px;';
?>


<div class="arrow_box_light" onclick="location.href = '/<?=$_SESSION["langStr"]?>/<?=$lang->_megrendeles?>'" style="top:10px; cursor:pointer; ::after:none; <?=$mobile;?>">
		<span><?=$lang->kosarba_kerult?>.</span>
		<br />
		<span><? include 'inc/top-kosar.php'; ?></span>
		<!-- <span><input type="submit" value="Tovább a megrendeléshez" c_lass="arrow_box" /></span> -->
</div>