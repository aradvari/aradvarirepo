<h1><?=$termek->termek['termeknev']?></h1>
<h2><?=$termek->termek['markanev']?></h2>
<h3><?=$termek->termek['szin']?></h3>
<h4><?=$termek->termek['markanev']?></h4>

<?
    if (is_array($termek->kepek)){

        while ($pic = each($termek->kepek)){
            
    
            echo '<img src="/'.$pic[1].'" alt="facebook_coreshop_image" />';
            
        }
        
    }
?> 