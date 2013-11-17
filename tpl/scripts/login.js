(function($) {
	function loginBlockState() {
		var blocks = {
			registration: "#registration",
			login: "#login",
			forgot: "#forgot-password"
		};

		if($(blocks.login).hasClass("block-active")) {
			$(blocks.registration).hide() && $(blocks.forgot).hide();

			$('#login .small-link').click(function() {
				$(blocks.registration).show();
				$(blocks.login).hide();
			});

			$('#registration .small-link').click(function() {
				$(blocks.login).show();
				$(blocks.registration).hide();
			});

			$('#login .forgot-password-link').click(function() {
				$(blocks.forgot).show();
				$(blocks.login).hide();
			});

			$('#forgot-password .small-link').click(function() {
				$(blocks.login).show();
				$(blocks.forgot).hide();
			});
		};
	}

	loginBlockState();
})(window.jQuery);