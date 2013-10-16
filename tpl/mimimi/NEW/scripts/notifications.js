(function($, f){
	function callNotifications(notificationOptions) {
		var cssClasses = {
			notifications: ".notifications",
			notificationsList: ".notifications-list",
			dropdown: ".notifications-dropdown",
			activeState: "notifications-dropdown-active"
		};

		$('.indicator').click(function() {
			if($(cssClasses.dropdown).hasClass(cssClasses.activeState)){
				// Если уже активное поле, то скрываем его
				$(cssClasses.dropdown).removeClass(cssClasses.activeState);
			} else {
				// Если нет, то делаем видимым, получаем данные и парсим json
				$(cssClasses.dropdown).addClass(cssClasses.activeState);

				// Вот эту строку мы будем обрабатывать. Ты её должен получать будешь из сервера, но для примера я её явно указал
				// Ты её изначально должен получить через ajax-запрос (http://api.jquery.com/jQuery.ajax/)
				// Если будет нужно навалять пример с аякс-запросами — обращайся :)
				var jsonStr = jQuery.parseJSON('[\
					{"pic":"images/temp/userpic-40-2.jpg","name":"Anthony Lagon","text":"comments your item. Check it out.","action":"comment"},\
					{"pic":"images/temp/userpic-40-3.jpg","name":"Colin Devroe","text":"likes your item. Now you have 17 likes.","action":"view"},\
					{"pic":"images/temp/userpic-40-4.jpg","name":"Josh Long","text":"sent you a message!","action":"reply"},\
					{"pic":"images/temp/userpic-40-1.jpg","name":"Andrew Veles","text":"sent you a message!","action":"reply"}]');

				// Обработка каждого элемента json и добавление в блок
				var notificationText = "";
				$(jsonStr).each(function(i, val){
				    notificationText = notificationText + '<li>\
				    		<img src="'+val['pic']+'">\
				    		<div class="notification-content">\
					    		<a href="#" class="name">'+val['name']+'</a>\
					    		<a href="#">'+val['text']+'</a>\
				    		</div>\
				    		<a href="#" class="action '+val['action']+'"></a>\
				    	</li>';
				})
				$(cssClasses.notificationsList).html(notificationText);
				

			};
			$('html').click(function() { $(cssClasses.dropdown).removeClass(cssClasses.activeState); });
			$(cssClasses.notifications).click(function(e){e.stopPropagation();}); // Делаем так, чтобы при клике на любом поле страницы всплывающее окошко закрывалось

		});
	}
	
	callNotifications();

})(window.jQuery, false);