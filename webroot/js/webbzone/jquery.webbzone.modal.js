$(function(){
	(function( $ ) {
		$.fn.wzmodal = function(options) {
			var wzselector = this.selector;
			var behaviourTypes = ['inline', 'fullPage', 'left', 'right', 'top', 'bottom'];
			var behaviourClass = {
				inline: 'wz-inline-modal',
				fullPage: 'wz-full-page-modal',
				left: 'wz-inleft-modal',
				right: 'wz-inright-modal',
				top: 'wz-intop-modal',
				bottom: 'wz-inbottom-modal'
			};
			
			var settings = $.extend({
				action: 'show',
				dafaultBehaviour: 'fullPage',
				behaviour: 'fullPage',
				effect: false,
				init: function() {
					if ($.inArray(settings.behaviour, behaviourTypes) !== -1) {
						$(wzselector).addClass(behaviourClass[settings.behaviour]);
						triggerModal($(wzselector), settings.behaviour, settings.effect);
					} else {
						$(wzselector).addClass(behaviourClass[settings.dafaultBehaviour]);
						triggerModal($(wzselector), settings.behaviour, settings.effect);
					}
				},
				close: function() {
					triggerModal($(wzselector), settings.behaviour, settings.effect);
				}
			}, options);
			
			if (settings.action == 'show') {
				settings.init();
			}
			if (settings.action == 'hide') {
				settings.close();
			}
			
			return this;
		};
		
		function setModalTop(object, behaviour) {
			if (behaviour == 'inline' && object.height() < $(window).height()) {
				var difference = $(window).height() - object.height();
				var topMargin = difference / 2;
				object.css('top', topMargin + 'px');
			}
		}
			
		function triggerModal(object, behaviour, effect) {
			if (object.hasClass('open')) {
				object.removeClass('open');
				if (effect) {
					object.slideUp(function(){
						$('.wzoverlay').remove();
					});
				} else {
					object.hide();
					$('.wzoverlay').remove();
				}
			} else {
				object.addClass('open');
				if (effect) {
					object.slideDown(function(){
						setModalTop(object, behaviour);
					});
				} else {
					object.show();
					setModalTop(object, behaviour);
				}
				$('body').append('<div class="wzoverlay"></div>');
			}
		}
		
		$(document).on('click', '[data-toggle=wzmodal]', function(){
			var arrData = {action: 'show'};
			var modalId = $(this).attr('data-wzmodal');
			if (typeof $(this).attr('data-behaviour') != 'undefined') {
				arrData.behaviour = $(this).attr('data-behaviour');
			}
			if (typeof $(this).attr('data-effect') != 'undefined' && $(this).attr('data-effect') == 'true') {
				arrData.effect = true;
			}
			$( "#"+modalId ).wzmodal(arrData);
			return false;
		});
		
		$(document).on('click', '[data-dismiss=wzmodal]', function(){
			var modalId = $(this).closest('.custom-s-modal').attr('id');
			triggerModal($('#'+modalId));
		});
	})(jQuery);
	
	/* $( "#leftModal" ).wzmodal({
		action: 'show',
		behaviour: 'left'
	});
	$( "#leftModal" ).wzmodal({
		action: 'hide'
	}); */

});