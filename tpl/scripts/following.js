(function($) {
	var strings = {
			button: ".follow-button",
			follow: "follow",
			unfollow: "unfollow",
			followed: "followed",
			noAction: "follow-no-action"
	};

	function followStates() {
		if($(strings.button).hasClass(strings.unfollow)) {
			$(strings.button).click(function() {
				$(strings.button).removeClass(strings.unfollow).removeClass(strings.followed).html("Follow"); 
			});
		}
		

		if($(strings.button).hasClass(strings.noAction)) {
			$(strings.button).click(function() {
				$(strings.button).html("Followed").removeClass(strings.noAction).addClass(strings.followed); 
			});
		}

		if($(strings.button).hasClass(strings.followed)) {
			$(strings.button).click(function() {
				$(strings.button).html("Unfollow?").removeClass(strings.followed).addClass(strings.unfollow); 
			});
		}
	}
	
	followStates();
})(window.jQuery);