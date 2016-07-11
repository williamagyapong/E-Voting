
function ignore(){
	var myForm = document.forms[0];
	var mybutton = myForm.ignore;
	
	var response;
	if(mybutton.checked){
		 response = confirm("You have chosen to ignore some data. Click OK if those fields you are ignoring contain no data.");
	} else{
         response = confirm("You have chosen to include additional fields. Click OK if those fields have been fully filled.");
	}

	if(response) {
		return true;
	} else {
		return false;
	}
}