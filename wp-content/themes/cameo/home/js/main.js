var views = ['human', 'life', 'math'];
var bezier = 'cubic-bezier(0.68, 0, 0.265, 1)';
var duration = 1500;
var shorterDuration = 750;
var rotate = 60;
var rotateOther = -60;
var scale = 1.1;

function getViews() {
	var current = window.currentView;
	var i = views.indexOf(current);
	var next = views[i + 1];
	if (!next) {
		next = views[0];
	}
	var prev = views[i - 1];
	if (!prev) {
		prev = views[views.length - 1]
	}
	return {
		current: currentView,
		next: next,
		prev: prev,
	};
}

function jiggleStart() {
	var windowWidth = jQuery(window).innerWidth();
	var windowHeight = jQuery(window).innerHeight();
	jQuery(document).on('mousemove', function (e) {
		var x = e.pageX;
		var y = e.pageY;
		var offsetX = (((windowWidth / 2) - x) / 30) * -1;
		var offsetY = (((windowHeight / 2) - y) / 30) * -1;
		var view = jQuery('.view.' + window.currentView)
		view.find('img.should-move').css({
			transform: 'rotateY(' + offsetX + 'deg) rotateX(' + offsetY + 'deg)',
		});
		view.find('img.should-move-opposite').css({
			transform: 'rotateY(' + (offsetX * -1) + 'deg) rotateX(' + (offsetY * -1) + 'deg)',
		});
	});
}

function jiggleStop() {
	jQuery(document).off('mousemove');
}

function setNavs() {
	var views = getViews();
	jQuery('.nav.prev').find('.' + views.current + ', .' + views.next).addClass('hide').siblings('.' + views.prev).removeClass('hide');
	jQuery('.nav.next').find('.' + views.current + ', .' + views.prev).addClass('hide').siblings('.' + views.next).removeClass('hide');
	jQuery('.bot-section .wrap.' + views.current).addClass('active').siblings().removeClass('active');
	jQuery('.nav-inactive').find('.' + views.prev + ', .' + views.next).addClass('hide').siblings('.' + views.current).removeClass('hide');
	// jQuery('.bot-section .bot-links .link.' + views.current).addClass('active').siblings().removeClass('active');
}

function setViews(direction, edgeDistance, peekDistance, viewWidth) {
	var views = getViews();
	var currentView = jQuery('.view.' + views.current).not('.holder');
	var prevView = jQuery('.view.' + views.prev).not('.holder');
	var nextView = jQuery('.view.' + views.next).not('.holder');
	var currentHolder = jQuery('.view.holder.' + views.current);
	var prevHolder = jQuery('.view.holder.' + views.prev);
	var nextHolder = jQuery('.view.holder.' + views.next);
	var edge = Math.round(edgeDistance + peekDistance);
	var gone = Math.round(edgeDistance + viewWidth) + 200;

	if (!direction) {
		currentView.css({
			transition: 'none',
			opacity: 1,
			willChange: 'transform',
		}).find('img.white').css({
			transition: 'none',
			opacity: 0,
			willChange: 'opacity',
		}).siblings('.should-hide').css({
			transition: 'none',
			opacity: 1,
			willChange: 'opacity',
		});

		currentHolder.hide();

		prevView.css({
			transition: 'none',
			transform: 'translateX(-' + edge + 'px) rotateY(' + rotate + 'deg) scale(' + scale + ')',
			opacity: 1,
			willChange: 'transform',
		}).find('img.white').css({
			transition: 'none',
			opacity: 1,
			willChange: 'opacity',
		}).siblings('.should-hide').css({
			transition: 'none',
			opacity: 0,
			willChange: 'opacity',
		});

		prevHolder.hide();

		nextView.css({
			transition: 'none',
			transform: 'translateX(' + edge + 'px) rotateY(' + rotateOther + 'deg) scale(' + scale + ')',
			opacity: 1,
			willChange: 'transform',
		}).find('img.white').css({
			transition: 'none',
			opacity: 1,
			willChange: 'opacity',
		}).siblings('.should-hide').css({
			transition: 'none',
			opacity: 0,
			willChange: 'opacity',
		});

		nextHolder.hide();
	}

	if (direction === 'next') {
		currentView.css({
			transition: 'all ' + duration + 'ms ' + bezier,
			transform: 'translateX(-' + edge + 'px) rotateY(' + rotate + 'deg) scale(' + scale + ')',
			opacity: 1,
		}).find('img.white').css({
			transition: 'all ' + duration + 'ms ' + bezier,
			opacity: 1,
		}).siblings('.should-hide').css({
			transition: 'all ' + shorterDuration + 'ms ' + bezier,
			opacity: 0,
		});

		prevView.css({
			transition: 'all ' + duration + 'ms ' + bezier,
			transform: 'translateX(-' + gone + 'px) rotateY(' + rotate + 'deg) scale(' + scale + ')',
			opacity: 1,
		});

		prevHolder.css({
			transition: 'none',
			transform: 'translateX(' + gone + 'px) rotateY(' + rotateOther + 'deg) scale(' + scale + ')',
		}).show().css({
			transition: 'all ' + duration + 'ms ' + bezier,
			transform: 'translateX(' + edge + 'px) rotateY(' + rotateOther + 'deg) scale(' + scale + ')',
		});

		setTimeout(function () {
			nextView.find('.should-hide').css({
				transition: 'none',
			});
			prevView.hide().css({
				transition: 'none',
				transform: 'translateX(' + edge + 'px) rotateY(' + rotateOther + 'deg) scale(' + scale + ')',
			}).show();
			prevHolder.hide();
		}, duration + 100);

		nextView.css({
			transition: 'all ' + duration + 'ms ' + bezier,
			transform: 'translateX(0px) rotateY(0deg) scale(1)',
			opacity: 1,
		}).find('img.white').css({
			transition: 'all ' + shorterDuration + 'ms ' + bezier,
			opacity: 0,
		}).siblings('.should-hide').css({
			transition: 'all ' + duration + 'ms ' + bezier,
			opacity: 1,
		});

		window.currentView = views.next;
		setNavs();
		jiggleStart();

	}

	if (direction === 'prev') {
		currentView.css({
			transition: 'all ' + duration + 'ms ' + bezier,
			transform: 'translateX(' + edge + 'px) rotateY(' + rotateOther + 'deg) scale(' + scale + ')',
			opacity: 1,
		}).find('img.white').css({
			transition: 'all ' + duration + 'ms ' + bezier,
			opacity: 1,
		}).siblings('.should-hide').css({
			transition: 'all ' + shorterDuration + 'ms ' + bezier,
			opacity: 0,
		});

		nextView.css({
			transition: 'all ' + duration + 'ms ' + bezier,
			transform: 'translateX(' + gone + 'px) rotateY(' + rotateOther + 'deg) scale(' + scale + ')',
			opacity: 1,
		});

		nextHolder.css({
			transition: 'none',
			transform: 'translateX(-' + gone + 'px) rotateY(' + rotate + 'deg) scale(' + scale + ')',
		}).show().css({
			transition: 'all ' + duration + 'ms ' + bezier,
			transform: 'translateX(-' + edge + 'px) rotateY(' + rotate + 'deg) scale(' + scale + ')',
		});

		setTimeout(function () {
			prevView.find('.should-hide').css({
				transition: 'none',
			});
			nextView.hide().css({
				transition: 'none',
				transform: 'translateX(-' + edge + 'px) rotateY(' + rotate + 'deg) scale(' + scale + ')',
			}).show();
			nextHolder.hide();
		}, duration + 100);

		prevView.css({
			transition: 'all ' + duration + 'ms ' + bezier,
			transform: 'translateX(0px) rotateY(0deg) scale(1)',
			opacity: 1,
		}).find('img.white').css({
			transition: 'all ' + shorterDuration + 'ms ' + bezier,
			opacity: 0,
		}).siblings('.should-hide').css({
			transition: 'all ' + duration + 'ms ' + bezier,
			opacity: 1,
		});

		window.currentView = views.prev;
		setNavs();
		jiggleStart();

	}

	// Added links
	// if (direction === 'human' || direction === 'life' ||direction === 'math') {
	// 	var cView = window.currentView;
	// 	console.log(cView);
	// 	console.log(direction);


	// 	if (direction === 'human' && cView === 'life') setViews('next', edgeDistance, peekDistance, viewWidth);
	// 	if (direction === 'human' && cView === 'math') setViews('prev', edgeDistance, peekDistance, viewWidth);
	// 	if (direction === 'life' && cView === 'math') setViews('next', edgeDistance, peekDistance, viewWidth);
	// 	if (direction === 'life' && cView === 'human') setViews('prev', edgeDistance, peekDistance, viewWidth);
	// 	if (direction === 'math' && cView === 'human') setViews('next', edgeDistance, peekDistance, viewWidth);
	// 	if (direction === 'math' && cView === 'life') setViews('prev', edgeDistance, peekDistance, viewWidth);
	// 	// window.currentView = direction;
	// 	// if (direction === 'human') {
	// 	// 	currentView = jQuery('.view.human').not('.holder');
	// 	// 	prevView = jQuery('.view.math').not('.holder');
	// 	// 	nextView = jQuery('.view.life').not('.holder');
	// 	// 	currentHolder = jQuery('.view.holder.human');
	// 	// 	prevHolder = jQuery('.view.holder.math');
	// 	// 	nextHolder = jQuery('.view.holder.life');
	// 	// }
	// 	// if (direction === 'life') {
	// 	// 	currentView = jQuery('.view.life').not('.holder');
	// 	// 	prevView = jQuery('.view.human').not('.holder');
	// 	// 	nextView = jQuery('.view.math').not('.holder');
	// 	// 	currentHolder = jQuery('.view.holder.life');
	// 	// 	prevHolder = jQuery('.view.holder.human');
	// 	// 	nextHolder = jQuery('.view.holder.math');
	// 	// }
	// 	// if (direction === 'math') {
	// 	// 	currentView = jQuery('.view.math').not('.holder');
	// 	// 	prevView = jQuery('.view.life').not('.holder');
	// 	// 	nextView = jQuery('.view.human').not('.holder');
	// 	// 	currentHolder = jQuery('.view.holder.math');
	// 	// 	prevHolder = jQuery('.view.holder.life');
	// 	// 	nextHolder = jQuery('.view.holder.human');
	// 	// }
	// 	// setNavs();
	// 	// jiggleStart();

	// }

}

function pageTransition(direction) {
	var light = jQuery('.page-transition.light');
	var dark = jQuery('.page-transition.dark');

	var time = 500;
	light.css({
		transformOrigin: direction === 'down' ? 'bottom' : 'top',
		visibility: 'visible',
	});
	setTimeout(function () {
		light.css({
			transition: 'all ' + time + 'ms ' + bezier,
			transform: 'scaleY(1)',
		});
	}, 1);
	setTimeout(function () {
		light.css({
			transition: 'none',
			visibility: 'hidden',
			transform: 'scaleY(0)',
		});
	}, time + 800);
	dark.css({
		transformOrigin: direction === 'down' ? 'bottom' : 'top',
		visibility: 'visible',
	});
	setTimeout(function () {
		dark.css({
			transition: 'all ' + time + 'ms ' + bezier,
			transform: 'scaleY(1)',
		});
	}, 200);
	setTimeout(function () {
		dark.css({
			transformOrigin: direction === 'down' ? 'top' : 'bottom',
			transition: 'none',
		});
	}, time + 200);
	setTimeout(function () {
		dark.css({
			transition: 'all ' + time + 'ms ' + bezier,
		});
	}, time + 201);
	setTimeout(function () {
		dark.css({
			transform: 'scaleY(0)',
			// opacity: 0,
		});
	}, time + 500);
	setTimeout(function () {
		dark.css({
			transition: 'none',
			visibility: 'hidden',
			// transform: 'scaleY(0)',
			opacity: 1,
		});
	}, time + 1001);

	if (direction === 'down') {
		jQuery('.top-section nav').attr('tabindex', '');
	}
	if (direction === 'up') {
		var tabs = jQuery('.bot-section .wrap.active').find('li');
		tabs.attr('tabindex', '');
		jQuery(tabs[0]).attr('tabindex', 100);
		jQuery('.top-section nav.prev').attr('tabindex', 1);
	}
}

function stopPage() {
	jQuery('.top-section .nav.next').off('click');
	jQuery('.top-section .nav.prev').off('click');
}

function initPage() {
	var viewWidth = 600;
	var viewableSpace = 100;

	var windowWidth = jQuery(window).innerWidth();

	var edgeDistance = (windowWidth - viewWidth) / 2;
	var peekDistance = viewWidth - viewableSpace;

	setViews(false, edgeDistance, peekDistance, viewWidth);
	setNavs();
	jiggleStart();

	var next = jQuery('.top-section .nav.next');
	var prev = jQuery('.top-section .nav.prev');

	next.on('click', function () {
		var lastClicked = window.lastClicked;
		var now = new Date();
		var timePassed = now - lastClicked;
		if (!lastClicked || timePassed > duration + 100) {
			window.lastClicked = now;
			jiggleStop();
			setViews('next', edgeDistance, peekDistance, viewWidth);
		}
	});

	prev.on('click', function () {
		var lastClicked = window.lastClicked;
		var now = new Date();
		var timePassed = now - lastClicked;
		if (!lastClicked || timePassed > duration + 100) {
			window.lastClicked = now;
			jiggleStop();
			setViews('prev', edgeDistance, peekDistance, viewWidth);
		}
	});

	// Added links
	// jQuery('.bot-links .link').on('click', function() {
	// 	var tab = jQuery(this).data('tab');
	// 	var cView = window.currentView;

	// 	if (tab === 'human' && cView === 'life') prev.trigger('click');
	// 	if (tab === 'human' && cView === 'math')  next.trigger('click');
	// 	if (tab === 'life' && cView === 'math') prev.trigger('click');
	// 	if (tab === 'life' && cView === 'human')  next.trigger('click');
	// 	if (tab === 'math' && cView === 'human') prev.trigger('click');
	// 	if (tab === 'math' && cView === 'life')  next.trigger('click');

	// 	// if (tab === 'human' && cView === 'life') setViews('prev', edgeDistance, peekDistance, viewWidth);
	// 	// if (tab === 'human' && cView === 'math')  setViews('next', edgeDistance, peekDistance, viewWidth);
	// 	// if (tab === 'life' && cView === 'math') setViews('prev', edgeDistance, peekDistance, viewWidth);
	// 	// if (tab === 'life' && cView === 'human')  setViews('next', edgeDistance, peekDistance, viewWidth);
	// 	// if (tab === 'math' && cView === 'human') setViews('prev', edgeDistance, peekDistance, viewWidth);
	// 	// if (tab === 'math' && cView === 'life')  setViews('next', edgeDistance, peekDistance, viewWidth);
	// });

	startSlider();
}

function startSlider() {
	if (!window.sliderInterval) {
		window.sliderInterval = setInterval(function () {
			var scrollingPage = window.scrollingPage;
			if (scrollingPage.index === 1) {
				jQuery('nav.nav.next').trigger('click');
			}
		}, 3000);
	}
}

function stopSlider() {
	if (window.sliderInterval) {
		clearInterval(window.sliderInterval);
		window.sliderInterval = null;
	}
}

jQuery(document).ready(function () {

	window.currentView = 'human';

	jQuery('.view').hover(function () {
		stopSlider();
	}, function () {
		startSlider();
	});

	jQuery('.nav-down').on('click', function () {
		scrollToPage('down');
	});

	initPage();

	jQuery('.bot-section .nav-panel .item').on('click', function () {

		var self = jQuery(this);
		var tab = self.data('tab');
		var lastTab = window.tabbed;
		var now = new Date();


		var windowWidth = jQuery(window).innerWidth();
		var lastActive = self.parents('.wrap').find('.tab.active');
		if (windowWidth < 768) {
			window.tabActive = true;
			self.addClass('active').siblings('.active').removeClass('active');
			var wrap = self.parents('.wrap');
			wrap.find('.tab-panel').addClass('active');
			wrap.find('.tab.' + tab).addClass('active').siblings('.active').removeClass('active');
			setTimeout(function () {
				jQuery('#header').fadeOut();
			}, 300);

		} else {
			if (!self.hasClass('active')) {
				if (!lastTab || now - lastTab > 500) {
					window.tabbed = now;
					self.addClass('active').siblings('.active').removeClass('active').parents('.wrap').find('.tab.' + tab).addClass('active');
					lastActive.addClass('fadeout');
					setTimeout(function () {
						lastActive.removeClass('fadeout active');
					}, 500);
				}
			}
		}
	});

	jQuery('.tab-panel .back').on('click', function () {
		jQuery(this).parent().removeClass('active');
		setTimeout(function () {
			jQuery('#header').fadeIn();
		}, 300);

		window.tabActive = false;
	});

	jQuery('.bot-section .bot-navs .prev').on('click', function () {
		jQuery('.top-section .nav.prev').trigger('click');
	});

	jQuery('.bot-section .bot-navs .next').on('click', function () {
		jQuery('.top-section .nav.next').trigger('click');
	});

});

jQuery(window).resize(function () {
	stopPage();
	initPage();
});

function scrollToPage(direction) {
	var pageTransitionTime = 600;
	var scrollingPage = window.scrollingPage;
	var index = scrollingPage.index;

	if (!scrollingPage.canScroll) {
		if (scrollingPage.timeout) {
			return false;
		} else {
			pageTransition(direction);

			if (direction === 'up') {
				startSlider();
			} else {
				stopSlider();
				setTimeout(function () {
					stopSlider();
				}, 1500);
			}

			var timeout = setTimeout(function () {
				if (window.scrollingPage.timeout === timeout) {
					window.scrollingPage.canScroll = true;
					if (index === 1) {
						jQuery('.top-section').hide();
						jQuery('.bot-section').show();
					} else {
						jQuery('.top-section').show();
						jQuery('.bot-section').hide();
					}
					window.scrollingPage.canScroll = false;
					setTimeout(function () {
						window.scrollingPage.timeout = '';
					}, 1002);
				}
			}, pageTransitionTime);
			window.scrollingPage.timeout = timeout;
			window.scrollingPage.index = index === 1 ? 2 : 1;
			return false;
		}
	}
}

window.tabActive = false;

window.scrollingPage = {
	index: 1,
	timeout: '',
	canScroll: false,
};

window.botTimeout = '';

jQuery(document).on('mousewheel, wheel', function (e) {
	var direction;
	if (e.originalEvent.wheelDelta > 0 || e.originalEvent.detail < 0 || e.originalEvent.deltaY < 0) {
		direction = 'up';
	} else {
		direction = 'down';
	}
	var index = window.scrollingPage.index;


	if (index === 1 && direction === 'up') {
		// return false;
	} else if (index === 2 && direction === 'down') {
		// return false;
	} else if (index === 2 && direction === 'up') {
		if (!window.tabActive) {
			var time = window.botTimeout;
			var botTop = jQuery('.bot-section').scrollTop();
			if (botTop === 0 && !time) {
				scrollToPage('up');
			} else if (!time) {
				var timeout = setTimeout(function () {
					var time = window.botTimeout;
					if (time === timeout) {
						window.botTimeout = '';
					}
				}, 1500);
				window.botTimeout = timeout;
			}
		}
	} else {
		scrollToPage(direction);
	}

});

jQuery(document).swipedown(function (e) {
	var index = window.scrollingPage.index;

	if (index === 2) {
		if (!window.tabActive) {
			var time = window.botTimeout;
			var botTop = jQuery('.bot-section').scrollTop();
			if (botTop === 0 && !time) {
				scrollToPage('up');
			} else if (!time) {
				var timeout = setTimeout(function () {
					var time = window.botTimeout;
					if (time === timeout) {
						window.botTimeout = '';
					}
				}, 1000);
				window.botTimeout = timeout;
			}
		}
	}
});

jQuery(document).swipeup(function (e) {
	var index = window.scrollingPage.index;
	if (index === 1) {
		scrollToPage('down');
	}
});

jQuery(document).swipeleft(function (e) {
	var index = window.scrollingPage.index;
	if (index === 1) {
		jQuery('.top-section .nav.next').trigger('click');
	}
});

jQuery(document).swiperight(function (e) {
	var index = window.scrollingPage.index;
	if (index === 1) {
		jQuery('.top-section .nav.prev').trigger('click');
	}
	if (index === 2) {
		jQuery('.tab-panel .back').trigger('click');
	}
});

jQuery(document).on('keydown', function (e) {
	var index = window.scrollingPage.index;
	var key = e.which;
	var currentFocus = jQuery(':focus');
	var next = jQuery('.top-section .nav.next');
	var prev = jQuery('.top-section .nav.prev');
	var down = jQuery('.top-section .nav-down');
	var currentTabIndex = currentFocus.attr('tabindex');
	if (key === 39 && index === 1) {
		next.trigger('click');
	}
	if (key === 37 && index === 1) {
		prev.trigger('click');
	}
	if (key === 40 && index === 1) {
		scrollToPage('down');
	}
	if (key === 38 && index === 2) {
		scrollToPage('up');
	}
	if (key === 13) {
		jQuery(':focus').trigger('click');
	}

	if (index === 1) {
		if (currentFocus.is(next)) {
			down.attr('tabindex', Number(currentTabIndex) + 1)
		}
		if (currentFocus.is(down)) {
			prev.attr('tabindex', Number(currentTabIndex) + 1)
		}
		if (currentFocus.is(prev)) {
			next.attr('tabindex', Number(currentTabIndex) + 1)
		}
	}

	if (index === 2) {
		var tabs = currentFocus.parent().find('li.item');
		var currentFocusIndex = currentFocus.index();
		var nextTab = currentFocus.next();
		if (nextTab.length) {
			jQuery(nextTab[0]).attr('tabindex', Number(currentTabIndex) + 1);
		}
		if (currentFocusIndex === tabs.length - 1) {
			jQuery(tabs[0]).attr('tabindex', Number(currentTabIndex) + 1);
		}
	}
});

jQuery(document).ready(function () {
	jQuery('.bot-section').hide();
	var images = jQuery('img');
	var imageCount = images.length;
	var loaded = 0;
	var starttime = new Date();
	images.each(function () {
		var originalSource = this.src;
		this.src = originalSource + '?' + new Date().getTime();
	}).on('load', function () {
		loaded += 1;
		if (loaded === imageCount) {
			jQuery('#loading').fadeOut();
		}
	});
	setTimeout(function () {
		jQuery('#loading').fadeOut();
	}, 10000);

	var FooterHeight = jQuery('.footer  ').height();

	jQuery('#index-page .footer').css({
		minHeight: FooterHeight,
	});
});