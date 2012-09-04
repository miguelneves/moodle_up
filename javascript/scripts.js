// se true o menu de settings vai ficar no topo, caso contrário fica na coluna lateral
var settingsHeader = false;

$(document).ready(function() {

	//INIT

	// Menu de navegação no cabeçalho
	customMenu();

	// Menu de settings na lateral (provavelmente já não deve ser preciso)
	settingsMenu();

	// Dropdowns no modo de edição
	if($('body').hasClass('editing')) {
		editMode();
	}


	// change width of the content column if sidebar is empty
	if ($('body').hasClass('notloggedin')) {
		if ($('#region-post .region-content > .block').length == 0) {
			$('body').addClass('no-sidebar');
		}
	} else {
		if ($('#region-post .region-content > .block').not('.block_navigation').length == 0) {
			$('body').addClass('no-sidebar');
		}
	}

	/* ===== HOMEPAGE ===== */

	// Banner Slider bxslider.com
	$('#page-site-index #slider1').bxSlider({
		mode: 'fade',
		auto: true,
		page: true,
		pause: 4000,
		controls: false,
		randomStart: false
	});

});

function customMenu() {
	var content = '';

	//hide default block
	$('.block_navigation').hide();
	if (settingsHeader)
	 	$('.block_settings').hide();

	//remove images
	$('.block_navigation a img').remove();
	if (settingsHeader)
		$('.block_settings a img').remove();

	//get content
	var myHome = $('.block_navigation li.depth_1:eq(0) p');

	var myProfile = $('.block_navigation li.depth_2:eq(2)');
	var myCourses = $('.block_navigation li.depth_2:eq(3)');
	var sitePages = $('.block_navigation li.depth_2:eq(1)');

	// remove .contains_branch for blocking YUI from loading subtopics and remove subtopics
	myCourses.find('.type_course').removeClass('contains_branch');
	myCourses.find('.type_course ul').remove();

	if (settingsHeader) {
		var settingsName = $('.block_settings .header .title h2').html()
		var settings = $('#settingsnav > ul');
		settings = $('<li class="contains_branch"></li>').append(settings);
	}

	if(myProfile.length){
		content = '<li id="home" class="level-1" role="menuitem">' + myHome.html() + '</a></li>'
		+ parseItem(myProfile, 'profile')
		+ parseItem(myCourses, 'courses')
		+ parseItem(sitePages, 'pages');
		if (settingsHeader)
			content += parseItem(settings, 'settings');


		$('#page-header').append('<div id="megamenu"><ul id="menu" class="menu" role="menu">' + content + '</ul></div>');

		/* ==== Menu behaviour===== */
		var menu = $('ul#menu');

		//add the role and default state attributes (some were already added)
			if( !$('body').is('[role]') ){ $('body').attr('role','application'); }
			//add role and class of menu
			menu.attr({'role': 'menu'}).addClass('menu');
			//set first node's tabindex to 0
			menu.find('a:eq(0)').attr('tabindex','0');
			//set all others to -1
			menu.find('a:gt(0)').attr('tabindex','-1');
			//add group role and menu-group-collapsed class to all ul children
			menu.find('li.level-1 > ul').attr('role','group').addClass('menu-group-collapsed');
			//add menuitem role to all li children
			menu.find('li').attr('role','menuitem');
			//find menu group parents
			menu.find('li.level-1:has(ul)')
					.attr('aria-expanded', 'false')
					.find('>a')
					.addClass('menu-parent menu-parent-collapsed');
			menu.find('li.level-1 > ul > li').has('ul').addClass('expanded');

		//bind custom events
		$('#menu .sub').hide();

		menu.bind({
			//expand a sublist
			expand: function(event){
				var target = $(event.target) || menu.find('a[tabindex=0]');
				target.removeClass('menu-parent-collapsed');
				target.siblings().hide().removeClass('menu-group-collapsed').slideDown(150, function(){
					target.parent().attr('aria-expanded', 'true');
				});
			},
			//collapse a menu node
			collapse: function(event){
				var target = $(event.target) || menu.find('a[tabindex=0]');
				target.addClass('menu-parent-collapsed')
				// default to down arrow
				target.siblings().slideUp(150, function(){
					target.parent().attr('aria-expanded', 'false');
					$(this).addClass('menu-group-collapsed');
				});
			},
			toggle: function(event){
				var target = $(event.target) || menu.find('a[tabindex=0]');
				//check if target parent LI is collapsed
				if( target.parent().is('[aria-expanded=false]') ){
					//call expand function on the target
					target.trigger('expand');
				}
				//otherwise, parent must be expanded
				else{
					//collapse the target
					target.trigger('collapse');
				}
			},
			//shift focus down one item
			traverseDown: function(event){
				var target = $(event.target) || menu.find('a[tabindex=0]');
				var targetLi = target.parent();
				if(targetLi.is('[aria-expanded=true]') || targetLi.hasClass('expanded')){
					target.next().find('a').eq(0).focus();
				}
				else if(targetLi.next().length) {
					targetLi.next().find('a').eq(0).focus();
				}
				else {
					targetLi.parents('li').next().find('a').eq(0).focus();
				}
			},
			//shift focus up one item
			traverseUp: function(event){
				var target = $(event.target) || menu.find('a[tabindex=0]');
				var targetLi = target.parent();
					if(targetLi.prev().hasClass('expanded')){
					targetLi.addClass('test');
						targetLi.prev().find('li:last-child a').eq(0).focus();
					}
					else if(targetLi.prev().length){
						targetLi.prev().find('a').eq(0).focus();
					}

				else {
					targetLi.parents('li:eq(0)').find('a').eq(0).focus();
				}
			},
			//clicks and presses
			focus: function(event){
					//deactivate previously active menu node, if one exists
					menu.find('[tabindex=0]').attr('tabindex','-1');
					//assign 0 tabindex to focused item
					$(event.target).attr('tabindex','0');
					$(event.target).parent().siblings('li.level-1').find('> a').trigger('collapse');
			},
			click: function(event){
				//save reference to event target
				var target = $(event.target);
				//check if target is a menu node
				if( target.is('a.menu-parent') ){
					target.trigger('toggle');
					target.eq(0).focus();
					//return click event false because it's a menu node (folder)
					return false;
				}
			},
			keydown: function(event){
				var target = menu.find('a[tabindex=0]');
				//check for arrow keys
				if(event.keyCode == 37 || event.keyCode == 38 || event.keyCode == 39 || event.keyCode == 40 || event.keyCode == 49 || event.keyCode == 32 || event.keyCode == 9){
					//if key is left arrow
					if(event.keyCode == 37 || event.keyCode == 32){
						//if list is expanded
						if(target.parents().is('[aria-expanded=true]')){
							target.trigger('collapse');
							$('li[aria-expanded=true] > a').focus();
							$('a.menu-parent').trigger('collapse');
						}
						//try traversing to parent
						else {
							target.parents('li:eq(1)').find('a').eq(0).focus();
						}
					}
				}
				//if key is right arrow
				if(event.keyCode == 39 || event.keyCode == 32){
					//if list is collapsed
					if(target.parents().is('[aria-expanded=false]')){
						target.trigger('expand');
					}
				}
				//if key is up arrow
				if(event.keyCode == 38){
					target.trigger('traverseUp');
				}
				//if key is down arrow
				if(event.keyCode == 40){
					target.trigger('traverseDown');
				}
				if(event.keyCode == 37 || event.keyCode == 38 || event.keyCode == 39 || event.keyCode == 40 || event.keyCode == 49 || event.keyCode == 32) {
				//return any of these keycodes false
				return false;
				}
			}
		});

		//remove menu on click outsite menu
		$(document.body).bind('click', function() {
			$('a.menu-parent').trigger('collapse');
		});
		$('#menu .level-1 .sub').bind('click', function(ev) {
			ev.stopPropagation();
		});

		// submenu
		$('#menu .sub .contains_branch ul').hide();
		$('#menu .sub .contains_branch .branch').click(function () {
			$(this).next().toggle().parent().toggleClass('active-submenu');
		});
	}
}


//create menu branch (use 'li' as argument)
//can use a custom name as argument
function parseItem(item, name){
	//test if received a name as input
	if(isNaN(name)){
		var level = 0;
	} else {
		var level = (name || 0);
	}

	var h4 = $('> p a, > p > span', item);

	if (h4.length === 0) {
		h4 = $('.block_settings .header .title h2');

	}

	var list = $('> ul', item);

/* 	var content = '<li class="level-1 ' + name + '"><a href="#" tabindex="-1" class="menu-parent menu-parent-collapsed">' + h4.html() + '</a><ul class="sub menu-group-collapsed">' + list.html() + '</ul></li>'; */
	var content = '<li class="level-1 ' + name + '"><a href="#" tabindex="-1" class="menu-parent menu-parent-collapsed">' + h4.html() + '</a><ul class="sub menu-group-collapsed">' + list.html() + '</ul></li>';

	// return empty if item is null
	if ( item.length == 0 ) {
		return '';
	}

	return content;
}


function settingsMenu(){

	var settingsName = $('.block_settings .header .title h2').html()
	var settings = $('.block_settings');

	//remove skip-blocks
	settings.next().remove();
	settings.prev().remove();

	$('.header', settings).remove();
	$('.footer', settings).remove();

	$('#region-main-wrap').append(settings);

}


function editMode(){

	// add class to body
	$('body').addClass('edit-mode');

//	 Edit Summary
	$('.summary .edit').parent().each(function(){
		iconToText(this);
		$(this).addClass('edit-summary button');
	});
	// Change text to icon in sidebar
	$('.block .editbutton a').each(function(){
		iconToText(this, false);
		$(this).addClass('edit-summary button');
	});
	//change move button location
	$('.course-content .commands').each(function(){
		var m = $('a:first', this);
		if (m.css('cursor') === 'move') {
			m.addClass('move');
	 		$(this).parent().prepend(m);
		}
	});
	// redraw menu if item is added or removed
	$('.course-content .commands a').click(function(){
		$('.course-content .commands a').each(function(){
			iconToText(this, true);
		});
	});
	createDropdown($('.block .commands'));
	createDropdown($('.course-content .commands'));

	// if block has no h2 create a edit button
	$('.block .commands').each(function () {
		var p = $(this).parent();
		if (p.find('h2').length == 0) {
			p.prepend('<h2 class="empty-title"></h2>');
		}
	});
}

function createDropdown(commands){

	$('block .commands a').click(function(){
		$('.block .commands a').each(function(){
			iconToText(this, true);
		});
	});
	// change icons to text
	$('a', commands).each(function(){
		iconToText(this, true);
	});

	// redraw dropdown if item changes
	$('a', commands).click(function(){
		$(this).each(function(){
			iconToText(this, true);
		});
	});
	// toggle menu
	commands.hide();

	var item = commands.parent();

	item.bind({
		mouseenter: function() {
			if(!$(this).hasClass('edit-active'))
				$(this).append($('<span class="edit-toggle">▼</span>'));
		},
		mouseleave: function(){
			if(!$(this).hasClass('edit-active'))
				$('.edit-toggle', this).remove();
		},
		click: function() {
	    	$('.commands').parent().removeClass('edit-active');
			$(this).addClass('edit-active');

			$(commands).fadeOut(function(){
				$('.commands', this);
			});
			if($('.commands', this).css('display') == 'none') {
				$('.commands').fadeOut().removeClass('edit-active');
				$('.commands', this).fadeIn().addClass('edit-active');
				$('.edit-toggle').empty();
				$('.edit-toggle', this).html('▲');
			} else {
				$(this).removeClass('edit-active');
				$('.edit-toggle', this).html('▼');
			}
		}
	});

	//remove menu
	$(document.body).bind('click', function() {
		$(commands).fadeOut('fast', function(){
			$('.edit-active').removeClass('edit-active');
			$('.edit-toggle').remove();
		});
	});
	$(commands).parent().bind('click', function(ev) {
		 ev.stopPropagation();
	});
	$(commands).bind('click', function(ev) {
		ev.stopPropagation();
	});
}


// ==============================

//change link icons to text
function iconToText(icon, remove){
	var title = $(icon).attr('title') || $(icon).children().attr('alt');
	//return text; if true remove img
	if(!remove) {
		return $(icon).html(title);
	} else {
		var img = $('img', icon);
		return $(icon).empty().append(img, title);
	}
}
