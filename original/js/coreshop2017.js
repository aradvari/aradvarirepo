function input_clear(name){document.getElementById(name).value="";}

function changeImage(){var list=document.getElementById('optionlist');

document.mainimage.src=list.options[list.selectedIndex].value+'?17';		// kep uj verzio



}

function prevImage(){var list=document.getElementById('optionlist');if(list.selectedIndex==0){list.selectedIndex=list.options.length-1;}else{list.selectedIndex--;}changeImage();}

function nextImage(thumb){var list=document.getElementById('optionlist');if(list.selectedIndex==list.options.length-1){list.selectedIndex=0;}else{list.selectedIndex++;}if(thumb>0)list.selectedIndex=thumb;changeImage();}

function roll(img_name,img_src){document[img_name].src=img_src;}

function changeSpot(image,url){document.getElementById("mainimage").src=image;

document.getElementById("mainurl").href=url;}function selectSize(vonalkod){document.getElementById('meret').value=vonalkod;divKeszletMobile('keszlet',vonalkod);}function show_table_row(itemID){if((document.getElementById(itemID).style.display=='none')){document.getElementById(itemID).style.display=''
event.preventDefault()}else{document.getElementById(itemID).style.display='none';event.preventDefault()}}

jQuery(function(){
    window.selectedIndex = 0;

    window.resetCounter = function(){
        if(selectedIndex >= jQuery(".product-thumbs img").length){
            selectedIndex = 0;
        }

        if(selectedIndex < 0){
            selectedIndex = jQuery(".product-thumbs img").length;
        }
    }

    window.nextImage = function(index){
        if(index){
            selectedIndex = parseInt(index);
        } else {
            selectedIndex = ++selectedIndex;    
        }
        resetCounter();
        changeImage();
		changeZoomImage();
    }

    window.prevImage = function(){
        if(index){
            selectedIndex = parseInt(index);
        } else {
            selectedIndex = --selectedIndex;    
        }
        resetCounter();
        changeImage();        
    }

    window.changeImage = function(){
		//window.setTimeout(window.nextImage, 6000);	// autoplay
        jQuery("#mainimage").data('selectedIndex',selectedIndex);
        var selectedImage = jQuery("#thumb"+selectedIndex);
        if(jQuery("#mainimage")[0]){
            jQuery("#mainimage")[0].src = selectedImage[0].src.replace('/image_resize.php?w=110&img=','');
            jQuery(".product-thumbs img").each(function(key,obj){
                jQuery(obj).css('border-color','#eff2f3');
            });
            selectedImage.css('border-color','#2a87e4');    
        }
        
    }
	
	window.changeZoomImage = function(){
        jQuery("#mainzoomimage").data('selectedIndex',selectedIndex);
        var selectedImage = jQuery("#thumbzoom"+selectedIndex);
        if(jQuery("#mainzoomimage")[0]){
            jQuery("#mainzoomimage")[0].src = selectedImage[0].src.replace('/image_resize.php?w=110&img=','');
            jQuery(".product-thumbs-zoom img").each(function(key,obj){
                jQuery(obj).css('border-color','#eff2f3');
            });
            selectedImage.css('border-color','#2a87e4');    
        }
        
    }

    changeImage();
    changeZoomImage();
});