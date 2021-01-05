// when function is ready
$(document).ready(function() {
	// when this click do the function or perform an action
	$('[data-toggle="offcanvas"]').click(function(){
		//when click toggle the side menu
		$('#side-menu').toggleClass('hidden-xs');
	});
});