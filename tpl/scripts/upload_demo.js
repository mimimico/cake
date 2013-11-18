function readURL(input, index) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$("#image" + index).attr("src", e.target.result);
			$("#image" + index).css("opacity", "1");
		}

		reader.readAsDataURL(input.files[0]);
	}
}

$(".upload input:file").each(function(index, element) {
	$("#upload" + index).change(function() {
		readURL(this, index);
	});
})
