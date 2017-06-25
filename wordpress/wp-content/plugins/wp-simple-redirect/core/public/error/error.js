(function ($) {

	window.ArevicoError = {

		errorClass: 'error',
		errors: {},

		/**
		 * Display server based errors
		 */
		display: function (elem, msgs) {
			$(elem).addClass(ArevicoError.errorClass);
			ArevicoError.addToolTip(elem, msgs)
//			ArevicoError.removeOnBlur(elem);
		},
//				<div data-tip="This is the text of the tooltip2">

		addToolTip: function(elem, msgs){
			msgs = msgs.implode('<br />');
			$(elem).wrap('<div data-tip="' + msgs + '"></div>')
		},

		removeOnBlur: function(elem){
			$(elem).bind('blur',function(){
			$(elem).removeClass(ArevicoError.errorClass);
			});
		},

		addError: function (errors) {
			$.extend(ArevicoError.errors, errors);
		},

		init: function(){
			obj = ArevicoError.errors;
			for (var prop in obj) {
				if (!obj.hasOwnProperty(prop))
					continue;

				var name_select = '[name="' + prop + '"]';
				var elem = $('input' + name_select + ', textarea' + name_select);
				ArevicoError.display( elem, obj[prop] );
			}
		}

	};


})(jQuery);



