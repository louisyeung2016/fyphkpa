<?php

$expected_logout_time_milliseconds = $_SESSION["expected_logout_time_milliseconds"];

$common_js_str = <<<EOD

window.addEventListener("resize", function() {
  const width = $(window).width();
  var height = window.innerHeight;
  //console.log("width: "+width);
  if(width>751){
	//console.log("width_HAHA: "+width);
	document.getElementsByClassName('collapse')[0].style.left = "0px";
  }else{
	document.getElementsByClassName('collapse')[0].style.left = "-295px";
  }
});

showTime();

$(document).ready(function(){
	$.post(
		"./controller/controller_item_return_alarm.php", 
		{index: 0}, 
		function(result){
			//console.log(result);
			if(result==0){
				
				var txt = "<i class=\"fa-regular fa-bell\"></i>"+" 0";
				$(".return-alarm").empty();
				$(".return-alarm").html(txt);
				$(".return-alarm").css("background-color", "green");
			}else{
				var txt = "<i class=\"fa-solid fa-bell fa-shake\"></i>"+result;
				$(".return-alarm").empty();
				$(".return-alarm").html(txt);
			}

		}
	);
	
	  $("#flip").click(function(){
		$("#panel").slideDown("slow");
	  });
});


	// Set the date we're counting down to
	var countDownDate = new Date($expected_logout_time_milliseconds).getTime();

	// Update the count down every 1 second
	var x = setInterval(function() {

	  // Get today's date and time
	  var now = new Date().getTime();
		
	  // Find the distance between now and the count down date
	  var distance = countDownDate - now;
		
	  // Time calculations for days, hours, minutes and seconds
	  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
	  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
	  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
	  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
		
	  // Output the result in an element with id="demo"
	  document.getElementById("logoutCounter").innerHTML =  hours + "h "
	  + minutes + "m " + seconds + "s ";
		
	  // If the count down is over, write some text 
	  if (distance < 0) {
		clearInterval(x);
		document.getElementById("logoutCounter").innerHTML = "EXPIRED";
	  }
	}, 1000);

EOD;




?>