$(document).ready(function() {

	if(!userIsLoggedIn){
		$("#SubmitComment").attr("disabled", true);
	}

	$(".loginRequired").click(function(event){
		event.preventDefault();
	});
}