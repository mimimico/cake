$("ul.options a#reviewsLink").click(function(e) { 
	e.preventDefault(); 
	goToByScroll($(this).attr("id"));
});

function goToByScroll(id){
	id = id.replace("Link", "");
	$('html, body').animate({
	scrollTop: $("." + id).offset().top}, 'slow');
}