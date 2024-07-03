	function openNav() {
		var element = document.getElementsByClassName('collapse')[0],
		style = window.getComputedStyle(element),
		value = style.getPropertyValue('left');
		var w = window.innerWidth;
		//alert(w);
		if(value == "-295px"){
			document.getElementsByClassName('collapse')[0].style.left = "0px";
		}else if(value == "0px"){
			document.getElementsByClassName('collapse')[0].style.left = "-295px";
		}
		//document.getElementsByClassName('collapse')[0].style.left = "0px";
		
	}
	
	