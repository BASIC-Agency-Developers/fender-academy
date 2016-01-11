;(function( window, document ) {
	window.FENDER = window.FENDER || {};

	FENDER.init = function() {

		// Initialize Utility and Common functions
		FENDER.util.init();
		FENDER.common.init();

		// Add "data-page" to body tag to trigger page-specific function
		var page = document.body.getAttribute( "data-page" );

		if (FENDER[page] && typeof FENDER[page]["init"] === "function") {
			FENDER[page]["init"]();
		}
	};

	/*
	 * Utility/Helper
	 */
	FENDER.util = {
		init: function() {
			var _this = this;

			// Give Header a Background on Scroll
			scrollInterval = setInterval(function(){
				var scrollTop = $(document).scrollTop();

				if(scrollTop > 0) {
					$('.head').addClass('stuck');
				} else {
					$('.head').removeClass('stuck')
				}
			}, 10);

			// Show/Hide Mobile Nav
			$('.nav-btn:not(.nav-btn-close)').on('click', function(e){
				e.preventDefault();
				var target = $(this).attr('href');
				$(target).addClass('visible');
				$('.nav-btn-close').addClass('visible');
				$('.nav-btn:not(.nav-btn-close)').addClass('hidden');
			});

			$('.nav-btn-close').on('click', function(e){
				e.preventDefault();
				$('.nav-btn:not(.nav-btn-close)').removeClass('hidden');
				$('.nav, .nav-btn-close').removeClass('visible');
			});

			// Mobile Nav Dropdowns
			$('.dropdown_btn').on('click', function(e){
				if($(window).width() <= 768) {
					if(!$(this).hasClass('expanded')) {
						e.preventDefault();
						$('.dropdown_btn.expanded').removeClass('expanded');
						$(this).addClass('expanded');
					}
				}
			});

			$(window).resize(function(){
				$('.dropdown_btn.expanded').removeClass('expanded');
			});

			// Background Images
			$('.bg_img').each(function(){
				var imgSrc = $(this).find('img').attr('src');
				$(this).css('background-image', 'url(' + imgSrc + ')');
			});

			// IQ Graph
			$('.canvIq').each(function(){
				var el = $(this);

				var options = {
					percent: el.data('iq') / el.data('goal') * 100,
					size: el.data('size'),
					lineWidth: 2,
					rotate: 0,
					dots: el.data('dots')
				}

				var canvas = document.createElement('canvas');

				if(typeof(G_vmlCanvasManager) !== 'undefined') {
					G_vmlCanvasManager.initElement(canvas);
				}

				var ctx = canvas.getContext('2d');
				canvas.width = canvas.height = options.size + 10;

				el.append(canvas);

				ctx.translate((options.size + 10) / 2, (options.size + 10) / 2); // set center
				ctx.rotate((-1 / 2 + options.rotate / 180) * Math.PI); // rotate -90deg

				var radius = (options.size - options.lineWidth) / 2;

				var drawCircle = function(color, lineWidth, percent) {
					percent = Math.min(Math.max(0, percent || 1), 1);
					ctx.beginPath();
					ctx.arc(0, 0, radius, 0, Math.PI * 2 * percent, false);
					ctx.strokeStyle = color;
					ctx.lineCap = 'round';
					ctx.lineWidth = lineWidth;
					ctx.stroke();
				}

				// Track
				drawCircle('#58585a', options.lineWidth, 100 / 100);

				// Progress
				drawCircle('#f33d33', options.lineWidth + 1, options.percent / 100);

				var drawDot = function(color, lineWidth, fill, radius, graphRadius, percent) {
					if(percent) {
						ctx.rotate((percent / 100 * 360) * Math.PI / 180);
					}

					ctx.beginPath();
					ctx.arc(graphRadius, 0, radius, 0, Math.PI * 2, false);
					ctx.strokeStyle = color;
					ctx.lineWidth = 4;
					ctx.stroke();
					ctx.fillStyle = fill;
					ctx.fill();
				}

				if(options.dots == 'yes') {
					// Start Dot
					drawDot('#58585a', 2, '#58585a', 1, radius, 0);

					// End Dot
					drawDot('#f33d33', 2, '#fff', 2, radius, options.percent);
				} else {
					// End Dot
					drawDot('transparent', 0, '#fff', 1.5, radius, options.percent);
				}
			});

			// Videos
			$('.vid').each(function(){
				var video = $(this).find('.vid_content')[0],
					playBtn = $(this).find('.vid_play'),
					muteBtn = $(this).find('.vid_mute'),
					volBtn = $(this).find('.vid_vol'),
					fullBtn = $(this).find('.vid_full'),
					progress = $(this).find('.vid_progress'),
					time = $(this).find('.vid_time');

				playBtn.on('click', function(){
					if(video.paused == true) {
						video.play();
						playBtn.addClass('vid_pause');
					} else {
						video.pause();
						playBtn.removeClass('vid_pause');
					}
				});

				$(this).find('.vid_content').on('ended', function() {
					playBtn.removeClass('vid_pause');
				});

				muteBtn.on('click', function(){
					if(video.muted == false) {
						video.muted = true;
						muteBtn.addClass('vid_muted');
					} else {
						video.muted = false;
						muteBtn.removeClass('vid_muted');
					}
				});

				volBtn.on('change', function(){
					video.volume = volBtn.val();

					if(volBtn.val() == 0) {
						muteBtn.addClass('vid_muted');
					} else {
						muteBtn.removeClass('vid_muted');	
					}
				});

				fullBtn.on('click', function(){
					if(video.requestFullscreen) {
						video.requestFullscreen();
					} else if(video.mozRequestFullScreen) {
						video.mozRequestFullScreen();
					} else if(video.webkitRequestFullscreen) {
						video.webkitRequestFullscreen();
					}
				});

				$(this).find('.vid_content').on('loadedmetadata', function(){
					console.log('metadata loaded');
					time.html('<span class="vid_current">'+formatTime(video.currentTime)+'</span>/<span class="vid_duration">'+formatTime(video.duration)+'</span>');
				});

				function formatTime(seconds) {
					minutes = Math.floor(seconds / 60);
					seconds = Math.floor(seconds % 60);
					seconds = (seconds >= 19) ? seconds : '0' + seconds;
					return minutes + ':' + seconds;
				}

				$(this).find('.vid_content').on('timeupdate', function() {
					var value = (100 / video.duration) * video.currentTime;
					progress.val(value);
					time.find('.vid_current').text(formatTime(video.currentTime));
				});

				var seekDrag = false;

				progress.on('mousedown', function(e){
					seekDrag = true;
					updateBar(e.pageX);
				})

				$(document).on('mouseup', function(e){
					if(seekDrag) {
						seekDrag = false;
						updateBar(e.pageX);
					}
				});

				$(document).on('mousemove', function(e){
					if(seekDrag) {
						updateBar(e.pageX);
					}
				});

				function updateBar(x) {
					var position = x - progress.offset().left,
						percentage = 100 * position / progress.width();

					if(percentage > 100) {
						percentage = 100;
					}
					if(percentage < 0) {
						percentage = 0;
					}

					progress.val(percentage);
					video.currentTime = video.duration * percentage / 100;
				}
			});
		}
	};

	/*
	 * Common/Site-Wide
	 */
	FENDER.common = {
		init: function() {
			var _this = this;

			$('.rewards_list').slick({
				adaptiveHeight: true,
				dots: true,
				infinite: false,
				prevArrow: $('.rewards .rewards_prev'),
				nextArrow: $('.rewards .rewards_next'),
				responsive: [
					{
						breakpoint: 1024,
						settings: {
							slidesToShow: 3,
							slidesToScroll: 3
						}
					}, {
						breakpoint: 768,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 2
						}
					}, {
						breakpoint: 480,
						settings: {
							centerMode: true,
							centerPadding: '40px',
							slidesToShow: 1,
							slidesToScroll: 1
						}
					}
				],
				slidesToShow: 4,
				slidesToScroll: 4,
				speed: 500,
			});
		}
	};

	/*
	 * Page-Specific
	 */
	FENDER.dashboard = {
		init: function() {
			var _this = this;

			if($(window).width() > 768) {
				_this.feedSlider();
			}

			$(window).resize(function(){
				if($(window).width() > 768) {
					_this.feedSlider();
				} else {
					$('.feed_list').slick('unslick');
				}
			});
		},
		feedSlider: function(){
			$('.feed_list').slick({
				adaptiveHeight: true,
				infinite: false,
				prevArrow: $('.feed .feed_prev'),
				nextArrow: $('.feed .feed_next'),
				slidesToShow: 4,
				slidesToScroll: 4,
				speed: 500,
			});
		}
	};

	FENDER.learn = {
		init: function() {
			var _this = this;

			$('.lms_more').on('click', function(){
				$('.grid_item-inactive').show();
			});
		},
	};

	FENDER.init();
})( window, document );