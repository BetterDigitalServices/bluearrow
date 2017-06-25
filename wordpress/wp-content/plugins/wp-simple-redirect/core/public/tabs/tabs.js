	(function ($) {
	if (typeof window.ArevicoNS === 'undefined')
		window.ArevicoNS = {};

$.extend( window.ArevicoNS, {

	/**
	 * 
	 * 
	 */
	data: function( node ){
		var attr = $(node);
		
		if (attr.length == 0)
			return {};

		attr = attr.get(0).attributes;

		var oret = {};

		for (var i = 0; i < attr.length; i++) {
			var val = attr[i];

			if (val.name.substr(0,5) !== 'data-' )
				break;

			oret[ val.name.substr(5)] = val.value;
			
		}
	
	return oret;
	},

    /**
	 * Show Tabs on click
	 */
	handleTab: function(event){

		var tabContainer = $(this).closest('.tab-container');

		var tabActive 	= ArevicoNS.getData(event, 'tabActive', 'tab-active nav-tab-active');
		var tabInactive = ArevicoNS.getData(event, 'tabInactive', 'tab-inactive nav-tab-inactive');

		var linkActive 	 = ArevicoNS.getData(event, 'linkActive', 'a-active nav-tab-active');
		var linkInactive = ArevicoNS.getData(event, 'linkInactive', 'a-inactive nav-tab-inactive');


		/* This regular expression */
		var re 	         = /(?:^| )tab-(.*?)(?:$|\s)/;
		var qNR          = '#' + ($(this).attr('class').match(re)[1]);

		/* Get All Navigation Links */
		var navLinks = $('a'   , tabContainer);
		navLinks = navLinks.not(navLinks.find('a') );

		navLinks.removeClass( linkActive).addClass(linkInactive);
		$(this).addClass(linkActive).removeClass(linkInactive);

		var tabs = $('.tab', tabContainer);
		tabs = tabs.not( tabs.find('.tab') );

		tabs.hide().removeClass(tabActive).addClass(tabInactive);
		$(qNR, tabContainer).addClass(tabActive).removeClass(tabInactive).show();

		/* Add active class to the selected tab and header item*/
		//$(this).parent('li').addClass('li-active').removeClass('li-inactive');

		$(qNR, tabContainer).show();
	},

	  /**
	   * Tabs
	   */
	tab: function(){

	},

	newRowIndex: 0,

		/**
		 * @deprecate
		 */
		getData: function(prop, path, def){
			 path = path.split('.');
			 path.unshift('data');

			 for (i = 0; i < path.length; i++) {
			 	if  (prop[path[i] ] !== null )
				 {
					prop = prop[path[i]];
				} else {
					return def;
				}
			}

			return prop;
		},

		areYouSure: function(selector, message){
			if (typeof selector === 'undefined') 	selector = '.confirm';

			if (typeof message === 'undefined') 	message  = 'Are you sure?';
				
			$(selector).on('click', function () {
        		return confirm(message);
		    });
		},

		/**
		 * 
		 * 
		 */
		addRowNew: function(container){

			// These are not the pokemon you're looking for
			if ($(container).length == 0)
				return; 
			var o = $.extend({
				'add-template' 			: '.template',
				'add-button' 			: '.add',
				'add-id-placeholder' 	: '\\{id\\}',
				'add-insert-id'			: 'insert-{i}',
				'add-show-on-empty'		: '.no-items',
				'add-prepend' 			: false,
				/* ClassName to be added or removed to hide items  */
				'add-hidden'			: 'hidden',
				'add-where' 			: '.custom-items',
				'delete-button' 		: '.delete',

				/* The selector to select an item (this way we can determine if a container is empty or not*/
				'single-item' 			: '.single-item',
				'delete-stackname'		: 'delete[]',
				'delete-stack'	 		: 'form',

			}, ArevicoNS.data(container) );
	
			var def_o = {
				'delete-id' 			: null,
				'delete-item' 			: o['single-item']
				/** Where do we want to create an hidden element of deleted elements */
			};

			/** Bind Add Button */
			$(o['add-button'], $(container)).bind('click', function(e){
				var template = $( o['add-template'], $(container) ).clone();

				while ( $('[name*=' + o['add-insert-id'].replace('{i}', ArevicoNS.newRowIndex) + ']') .length)
					ArevicoNS.newRowIndex++;
			
				var insertId 	= o['add-insert-id'].replace('{i}', ArevicoNS.newRowIndex);

				var myRegExp = new RegExp(o['add-id-placeholder'],'gi');
				template 		= template[0].outerHTML.replace(myRegExp, insertId );

				var method = (o[''] == true) ? 'prepend' : 'append';
        	    $( o['add-where'], $(container) )[method]( $(template).clone().removeClass( o['add-template'] + ' ' + o['add-hidden']) );

				$(o['add-show-on-empty'], $(container) ).addClass( o['addhidden']);

				ArevicoNS.newRowIndex++;
			});

			/** Bind Delete Button */
			$(container).on("click", o['delete-button'], function(e){
				var del_o = jQuery.extend({}, def_o, ArevicoNS.data( this ) ); 
				if ( o['delete-id'] !== null)
						$( o['delete-stack'] ).append('<input type="hidden" name="' + o['delete-stack-name']  + '" value="' + del_o['delete-id'] + '" />');
			
		        $( this ).closest( del_o['delete-item'] ).remove();
			});
			
	},


});

$( document ).ready(function() {
/** Auto Bindings */
	  $('.tab-header a').bind('click', ArevicoNS.handleTab);
// Binding to beused for non-header tabs (e.g on metaboxes)
//    $('.tab-header a').bind('click',{'linkActive':'', linkInactive:'',tabActive:'tab-active',tabInactive:''}, ArevicoNS.handleTab);
	ArevicoNS.areYouSure('.confirm');
	ArevicoNS.addRowNew('.var-container');
	$('.fade-out').fadeOut(2500);
});

})(jQuery);


// bind with 	$('.tab-header a').bind('click', ArevicoNS.showTab);

// Initialise a Global Arevico NS



