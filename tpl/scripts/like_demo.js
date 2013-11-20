$(function () {
	$('.like').click(function() {
		if($('.like').hasClass('liked')) {
			$('.like').removeClass('liked');
		} else {
			$('.like').addClass('liked');
		}
	});

	var highlights = '.item .browse .highlights';
	$(highlights).click(function() {
		if($(highlights).hasClass('highlighted')) {
			$(highlights).html('Highlight item').removeClass('highlighted');
		} else {
			$(highlights).html('Item will be highlighted after adding').addClass('highlighted');
		}
	});
});
