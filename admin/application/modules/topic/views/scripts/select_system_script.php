<script type="text/javascript">
$(document).ready(function() {

	$(".sys_topic_option").click(function(){
		var handler = $(this).attr('id');
		if (handler == "checkall"){
			allselections();
		} else if (handler == "disableall"){
			disableselections();
		} else if (handler == "enableall"){
			enableselections();
		}
	});
	
	function allselections() { 
	    var e = document.getElementById('selections'); 
	    //e.disabled = true; 
	    var i = 0; 
	    var n = e.options.length; 
	    for (i = 0; i < n; i++) { 
	        //e.options[i].disabled = true; 
	        e.options[i].selected = true; 
	    } 
	}
	 
	function disableselections() { 
	   var e = document.getElementById('selections'); 
	   //e.disabled = true; 
	   var i = 0; 
	   var n = e.options.length; 
	   for (i = 0; i < n; i++) { 
	       //e.options[i].disabled = true; 
	       e.options[i].selected = false; 
	   } 
	}
	 
	function enableselections() { 
	  var e = document.getElementById('selections'); 
	  e.disabled = false; 
	  var i = 0; 
	  var n = e.options.length; 
	  for (i = 0; i < n; i++) { 
	       e.options[i].disabled = false; 
	   } 
	}
});
</script>