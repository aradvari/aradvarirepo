<?php

return [
    'adminEmail' => 'admin@example.com',
    'vat' => 27,
    'couponItems' => [
        'slip20' => [
            'name' 		=> 	'Vans Slip-On kedvezmény',				//	kuponkod leiras
            'date_from' => 	'2018-08-08 00:00:00',				//	2018-09-01 10:00
            'date_to' 	=> 	'2018-08-31 23:59:59',				//	2018-09-10 20:00
            'discount'	=>	 20,								//	kedvezmeny ertek
            'discountType' => 1,								//	1: szazalekos, 2: fix osszegu kedvezmeny
            'items' 	=> 	'select id from termekek where markaid=41 and akcios_kisker_ar=0 and termeknev like "%slip-on%" ',		// minden nem akcios vans termek
        ],
    ],
];