(function ($) {
	"use strict";
	$(document).ready(function() {
		// Elements Animation
		if ($('.wow').length) {
			var wow = new WOW({
				mobile: false
			});
			wow.init();
		}
	
		//Sortable Masonary with Filters
		function enableMasonry() {
			if ($('.sortable-masonry').length) {
	
				var winDow = $(window);
				// Needed variables
				var $container = $('.sortable-masonry .items-container');
				var $filter = $('.filter-btns');
	
				$container.isotope({
					filter: '*',
					masonry: {
						columnWidth: '.masonry-item.small-column'
					},
					animationOptions: {
						duration: 500,
						easing: 'linear'
					}
				});
	
	
				// Isotope Filter 
				$filter.find('li').on('click', function () {
					var selector = $(this).attr('data-filter');
	
					try {
						$container.isotope({
							filter: selector,
							animationOptions: {
								duration: 500,
								easing: 'linear',
								queue: false
							}
						});
					} catch (err) {
	
					}
					return false;
				});
	
	
				winDow.on('resize', function () {
					var selector = $filter.find('li.active').attr('data-filter');
	
					$container.isotope({
						filter: selector,
						animationOptions: {
							duration: 500,
							easing: 'linear',
							queue: false
						}
					});
				});
	
	
				var filterItemA = $('.filter-btns li');
	
				filterItemA.on('click', function () {
					var $this = $(this);
					if (!$this.hasClass('active')) {
						filterItemA.removeClass('active');
						$this.addClass('active');
					}
				});
			}
		}
	
		enableMasonry();
	
	
		// Two Column Carousel for Portfolio Single page
		if ($('.two-column-carousel').length) {
			$('.two-column-carousel').owlCarousel({
				loop: true,
				margin: 50,
				nav: true,
				smartSpeed: 3000,
				autoplay: 4000,
				navText: ['<span class="fa fa-caret-left"></span>', '<span class="fa fa-caret-right"></span>'],
				responsive: {
					0: {
						items: 1
					},
					480: {
						items: 1
					},
					600: {
						items: 1
					},
					800: {
						items: 2
					},
					1024: {
						items: 2
					}
				}
			});
		}
	
		
		//LightBox / Fancybox
		if ($('.lightbox-image').length) {
			Fancybox.bind('data-fancybox', {
				openEffect: 'fade',
				closeEffect: 'fade',
				helpers: {
					media: {}
				}
			});
		}
	})
})(jQuery);