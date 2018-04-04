//Jake Bedard
//jadrn007
//Red ID 818121974


var empty = '';
var dupMsg = 'You entered an email that has been entered by another runner! Please choose a new email.';
var msg = ['Please enter your first name',
		   'Please enter your last name',
		   'Please enter your address',
		   'Please enter your city',
		   'Please enter your state',
		   'Please enter your zip',
		   'Please enter your email',
		   'Please enter your date of birth',
		   'Please enter your full phone number',
		   'Please enter your full phone number',
		   'Please enter your full phone number',];

function isValidState(state) {                                
    var stateList = new Array("AK","AL","AR","AZ","CA","CO","CT","DC",
    "DE","FL","GA","GU","HI","IA","ID","IL","IN","KS","KY","LA","MA",
    "MD","ME","MH","MI","MN","MO","MS","MT","NC","ND","NE","NH","NJ",
    "NM","NV","NY","OH","OK","OR","PA","PR","RI","SC","SD","TN","TX",
    "UT","VA","VT","WA","WI","WV","WY");
    for(var i=0; i < stateList.length; i++)
        if(stateList[i] == $.trim(state))
            return true;
    
    return false;
} 

function isValidEmail(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
} 

$(document).ready(function(){

	//ajax check dup code
	function sendEmail(){
		var url = "send_email.php";
		var data = "email=" + $('input[name="email"]').val();
		$.post(url, data, handleData);
		/*
		$.ajax({
			type: "POST",
			url: url,
			data: data,
			datatype: 'text',
			success: handleData,
			error: ajaxError,
								
		});
		*/
	}
	
	function handleData(response) {
    		if(jQuery.trim(response) == "dup")
        		$('#error').text(dupMsg);
    		else if(jQuery.trim(response) == "OK") {
			if(validate())
        			$('form').submit();
       		}
    		else
        		$('#error').text("Error");
	}
	
	function ajaxError(){
		alert('Error doing ajax with jquery');
	}
	
	//end ajax check dup code

	var handle = new Array(6);
	handle[0] = $('input[name="fname"]');	   
	handle[1] = $('input[name="lname"]');
	handle[2] = $('input[name="address1"]');
	handle[3] = $('input[name="city"]');			   
	handle[4] = $('input[name="state"]');
	handle[5] = $('input[name="zip"]');
	handle[6] = $('input[name="email"]');
	handle[7] = $('input[name="dob"]');
	handle[8] = $('input[name="phone1"]');
	handle[9] = $('input[name="phone2"]');
	handle[10] = $('input[name="phone3"]');


	var size = 0;

	$('input[name="user_pic"]').on('change', function(){
		size = this.files[0].size;
	});


	//validate and check dups	
	$(':submit').on('click', function(e){
		e.preventDefault();
		sendEmail();
	});

	handle[4].on('keyup', function(){
		handle[4].val(handle[4].val().toUpperCase());
	});

	function validate(){

		//check all text categories
		for(var i=0; i<11; i++) {
			if($.trim(handle[i].val()) == ""){
			    $('#error').text(msg[i]);
			    handle[i].focus();
			    return false;
			}
		}
		
		//check states
		if(isValidState(handle[4].val()) == "") { 
            $('#error').text("Please make sure you are using the correct 2 letter state abreviation");
            handle[4].focus();           
            return false;
        }

        //check numbers
        if(!$.isNumeric(handle[5].val()) || handle[5].val().length != 5){
        	$('#error').text("Zip code must be a 5 digit number");
        	handle[5].focus();
        	return false;
        }

        if(!$.isNumeric(handle[8].val())){
        	$('#error').text("Phone number must only use digits 0-9");
        	handle[8].focus();
        	return false;
        }

        if(!$.isNumeric(handle[9].val())){
        	$('#error').text("Phone number must only use digits 0-9");
        	handle[9].focus();
        	return false;
        }

        if(!$.isNumeric(handle[10].val())){
        	$('#error').text("Phone number must only use digits 0-9");
        	handle[10].focus();
        	return false;
        }
        //end check numbers numbers

        //check date
        var month = Number(handle[7].val().substring(0,2)) - 1;
        var day = Number(handle[7].val().substring(3,5));
        var year = Number(handle[7].val().substring(6));

        var userDob = new Date(year, month, day);

        if(userDob.getFullYear() != year){
        	
        	$('#error').text("Please enter your date in the correct format: MM/DD/YYYY");
        	handle[7].focus();
        	return false;
        }

        if(userDob.getMonth() != month){
        	
        	$('#error').text("Please enter your date in the correct format: MM/DD/YYYY");
        	handle[7].focus();
        	return false;
        }

        if(userDob.getDate() != day){
        	
        	$('#error').text("Please enter your date in the correct format: MM/DD/YYYY");
        	handle[7].focus();
        	return false;
        }
        //end check date


        //check email
        if(!isValidEmail(handle[6].val())) {
        	$('#error').text("The email address appears to be invalid");
            handle[6].focus();            
            return false;
        }  
        //end check email
        

		//check exp level
		var choiceExp = $('input[name="experience"]');
		var selectedExp;
		$.each(choiceExp, function(k,v){
			if(this.checked)
				selectedExp = v.value;
		});
		if(!selectedExp){
			$('#error').text("Please check a box for your experience level");
			return false;
		}
		//end check exp level

		//check gender
		var choiceGen = $('input[name="gender"]');
		var selectedGen;
		$.each(choiceGen, function(k,v){
			if(this.checked)
				selectedGen = v.value;
		});
		if(!selectedGen){
			$('#error').text("Please check a box for your gender");
			return false;
		}
		//end check gender

		//check picture
		if(size == 0) {
			$('#error').text("Please add a picture");
			return false;
		}
		if(size/2000 > 2000) {
			$('#error').text("File too big, 1MB Max.");
			return false;
		}
		//end check picture

		//check age
		var choiceAge = $('input[name="age-category"]');
		var selectedAge;
		$.each(choiceAge, function(k,v){
			if(this.checked)
				selectedAge = v.value;
		});
		if(!selectedAge){
			$('#error').text("Please check a box for your age category");
			return false;
		}
		//end check age

		$('#error').text("");
		return true;
	}
	handle[0].focus();


	//on blur, remove error message if it pertains to a fixed thing
	//tried to make this into one clean function and I can't figure it out!!!
	handle[0].on('blur', function(){
		if($('#error').text() == msg[0] && handle[0].val() != "" ){
			$('#error').text('');
			$('#error').html('&nbsp;');

		}
	});

	handle[1].on('blur', function(){
		if($('#error').text() == msg[1] && handle[1].val() != "" ){
			$('#error').text('');
			$('#error').html('&nbsp;');

		}
	});

	handle[2].on('blur', function(){
		if($('#error').text() == msg[2] && handle[2].val() != "" ){
			$('#error').text('');
			$('#error').html('&nbsp;');

		}
	});

	handle[3].on('blur', function(){
		if($('#error').text() == msg[3] && handle[3].val() != "" ){
			$('#error').text('');
			$('#error').html('&nbsp;');

		}
	});

	handle[4].on('blur', function(){
		if($('#error').text() == msg[4] && handle[4].val() != "" ){
			$('#error').text('');
			$('#error').html('&nbsp;');

		}
	});

	handle[5].on('blur', function(){
		if($('#error').text() == msg[5] && handle[5].val() != "" ){
			$('#error').text('');
			$('#error').html('&nbsp;');

		}
	});

	handle[6].on('blur', function(){
		if($('#error').text() == msg[6] && handle[6].val() != "" ){
			$('#error').text('');
			$('#error').html('&nbsp;');

		}
	});

	handle[6].on('blur', function(){
		if($('#error').text() == dupMsg && handle[6].val() != "" ){
			$('#error').text('');
			$('#error').html('&nbsp;');
		}
	});

	handle[7].on('blur', function(){
		if($('#error').text() == msg[7] && handle[7].val() != "" ){
			$('#error').text('');
			$('#error').html('&nbsp;');

		}
	});

	handle[8].on('blur', function(){
		if($('#error').text() == msg[8] && handle[8].val() != "" ){
			$('#error').text('');
			$('#error').html('&nbsp;');

		}
	});

	handle[9].on('blur', function(){
		if($('#error').text() == msg[9] && handle[9].val() != "" ){
			$('#error').text('');
			$('#error').html('&nbsp;');

		}
	});

	handle[10].on('blur', function(){
		if($('#error').text() == msg[10] && handle[10].val() != "" ){
			$('#error').text('');
			$('#error').html('&nbsp;');

		}
	});

	handle[8].on('keyup', function() {
		if(handle[8].val().length == 3)
			handle[9].focus();
	});

	handle[9].on('keyup', function() {
		if(handle[9].val().length == 3)
			handle[10].focus();
	});

	handle[7].on('keyup', function(e){
		if(e.keyCode != 8){
			if(handle[7].val().length == 2 || handle[7].val().length == 5){
				handle[7].val(handle[7].val() + "/");
			}
		}
		
	});


});






