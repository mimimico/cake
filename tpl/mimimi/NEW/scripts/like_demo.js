$(function () {
	$('.like').click(function() {
		if($('.like').hasClass('liked')) {
			$('.like').removeClass('liked');
		} else {
			$('.like').addClass('liked');
		}
	});
});