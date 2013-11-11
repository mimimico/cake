function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			$('.image').attr('src', e.target.result);
			$('.image').css('display', 'block');
		}

		reader.readAsDataURL(input.files[0]);
	}
}

$("#inputImage").change(function() {
	readURL(this);
});

$('.tip').click(function() {
	$('.tip').css('opacity', '0');
});