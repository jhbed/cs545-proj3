/*
$(document).ready(function(){
	
	function sendEmail(){
		var url = "send_email.php";
		var data = "email=" + $('input[name="email"]').val();
		//$.post(url, data, handleData);
		$.ajax({
			type: "POST",
			url: url,
			data: data,
			datatype: 'html',
			success: handleData,
			error: ajaxError,
								
		});
	}
	
	function handleData(s) {
		var handle = document.getElementById("error");
		if(s == "dup"){
			alert('dup');
			handle.innerHTML = s;
			return false;
		}
		if(s == "OK"){
			return true;
		}
	}
	
	function ajaxError(){
		alert('Error doing ajax with jquery');
	}
});
*/
