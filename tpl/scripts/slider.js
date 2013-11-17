/*
*	FuckinSlider v1.1
*	by Andrew Veles
*	mrveles@icloud.com
*	http://twitter.com/mrveles
*/

$(function() {
	$('.slider').fuckinSlider({
		speed: 1000,
		delay: 7000,
		dots: true,
		complete: false
	});
});

(function($, f) {
	// If jQuery isn't enabled, this fucking slider don't work. 
	if(!$) return f;

	var fuckinSlider = function() {
		// Setting up elements
		this.elmts = f;
		this.items = f;

		// Dimentions
		this.sizes = [];
		this.maxim = [0,0];

		// Interval
		this.intvl = f;

		// Current
		this.current = 0;

		this.optns = {
			speed: 1000,
			delay: 3000,
			complete: f,
			dots: f,
			easing: "easeOut"
		};


		var clone = this;
		this.init = function(elmts, optns) {
			this.elmts = elmts;
			this.ul = elmts.children("ul");
			this.maxim = [elmts.outerWidth(), elmts.outerHeight()];
			this.items = this.ul.children("li").each(this.calculate);

			this.optns = $.extend(this.optns, optns);

			this.setup(); 

			return this;
		};

		// index: fuckinSlider.calculate.call($("li:first"), 0)
		this.calculate = function(index) {
			var fuckinElement = $(this),
				width = fuckinElement.outerWidth(), 
				height = fuckinElement.outerHeight();

			// Sizes array
			clone.sizes[index] = [width, height];
			if(width > clone.maxim[0]) clone.maxim[0] = width;
			if(height > clone.maxim[1]) clone.maxim[1] = height;
		};

		this.setup = function() {
			// Set main element
			this.elmts.css({
				overflow: 'hidden',
				width: clone.maxim[0],
				height: this.items.first().outerHeight()
			});

			// Set relative widths
			this.ul.css({width: (this.items.length * 100) + '%', position: 'relative'});
			this.items.css('width', (100 / this.items.length) + '%');

			if(this.optns.delay !== f) {
				this.start();
				this.elmts.hover(this.stop, this.start);
			}

			this.optns.dots && this.dots();
		};

		this.move = function(index, cb) {
			if(!this.items.eq(index).length) index = 0;
			if(index < 0) index = (this.items.length - 1);

			var targt = this.items.eq(index);
			var objct = {height: targt.outerHeight()};
			var easng = this.optns.easing;
			// TODO: Add easing support.
			var speed = cb ? 5 : this.optns.speed;
			if(!this.ul.is(':animated')) {
				clone.elmts.find('.dot:eq(' + index + ')').addClass('active').siblings().removeClass('active');
				this.elmts.animate(objct, speed) && this.ul.animate($.extend({left: '-' + index + '00%'}, objct), speed, function(data) {
					clone.current = index;
					$.isFunction(clone.optns.complete) && !cb && clone.optns.complete(this.elmts);
				});
			}
		};

		this.start = function() {
			clone.intvl = setInterval(function() {
				clone.move(clone.current + 1);
			},
			clone.optns.delay);
		};

		this.stop = function() {
			clone.intvl = clearInterval(clone.intvl);
			return clone;
		};

		this.next = function() {
			return clone.stop().move(clone.current + 1);
		}

		this.prev = function() {
			return clone.stop().move(clone.current - 1);
		}

		this.dots = function() {
			var html = '<ol class="dots">';
				$.each(this.items, function(index) {
					// TODO: Check null as ""
					html += '<li class="dot' + (index < 1 ? ' active' : "") + '"></li>';	
				});

				this.elmts.addClass("has-dots").append(html).find('.dot').click(function() {
					clone.move($(this).index());
				});
		};
	};

	$.fn.fuckinSlider = function(options) {
		var lengt = this.length;

		return this.each(function(index) {
			// Cache
			var fuckinElement = $(this);
			var insts = (new fuckinSlider).init(fuckinElement, options);

			// Invoke an instance
			fuckinElement.data('fuckinSlider' + (lengt > 1 ? '-' + (index + 1) : null), insts);
		});
	};
})(window.jQuery, false);