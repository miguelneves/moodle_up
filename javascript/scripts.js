$(document).ready(function() {
	
	//init
	customMenu();
	tableContents();
	textIcons();	
	if($('body').hasClass('editing')) {
		editMode();
	}		
});

function customMenu() {
	var content = '';
	
	//hide default block
	$('.block_navigation').hide();
	$('.block_settings').hide();
	
	//remove images
	$('.block_navigation a img').remove();
	$('.block_settings a img').remove();
	
	//get content
	var home = $('.block_navigation li.depth_2:eq(0) p');
	
	var myProfile = $('.block_navigation li.depth_2:eq(2)');
	var myCourses = $('.block_navigation li.depth_2:eq(3)');
	var sitePages = $('.block_navigation li.depth_2:eq(1)');
	
	var settingsName = $('.block_settings .header .title h2').html()
	var settings = $('#settingsnav > ul');
	settings = $('<li class="contains_branch"></li>').append(settings);
	
	if(myProfile.length){
		content = '<li id="home" class="level-1" role="menuitem">' + home.html() + '</a></li>' 
		+ parseItem(myProfile) 
		+ parseItem(myCourses)
		+ parseItem(sitePages)
		+ parseItem(settings, settingsName);

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
		//	menu.find('li.first-level > ul > li').attr('aria-expanded','true');
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
				target.addClass('menu-parent-collapsed');
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
					menu.find('[tabindex=0]').attr('tabindex','-1').removeClass('active');
					//assign 0 tabindex to focused item
					$(event.target).attr('tabindex','0').addClass('active');
					//if($('li.first-child').hasClass('menu-item-active') && $('li.first-child').not('[aria-expanded=true]'))
					$(event.target).parent().siblings('li.level-1').find('> a').trigger('collapse');
				//	$(event.target).parent().next('li.level-1').find('> a').trigger('collapse');
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
				if(event.keyCode == 32 || event.keyCode == 38 || event.keyCode == 39 || event.keyCode == 40){
					//if key is left arrow 
					if(event.keyCode == 32){ 
						//if list is expanded
						if(target.parent().is('[aria-expanded=true]')){
							target.trigger('collapse');
						}
						//try traversing to parent
						else {
							target.parents('li:eq(1)').find('a').eq(0).focus();
						}	
					}
				}
				//if key is right arrow
				if(event.keyCode == 32){ 
					//if list is collapsed
					if(target.parent().is('[aria-expanded=false]')){
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
				//return any of these keycodes false
				return false;
			}
		});
	
		//remove menu em click outsite menu
		$(document.body).bind('click', function() {
			$('a.menu-parent').trigger('collapse');
		});
		$('#menu .level-1 .sub').bind('click', function(ev) {
			ev.stopPropagation();
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
	level++;
	
	var h4 = $('> p a, > p > span', item);
	var list = $('> ul > li', item);
	
	//define list id
	var id = h4.text().replace(/ /g,'-');
	id = id.toLowerCase();
	
	//convert h4 to html
	h4 = h4.html() || name;
	
	if (level == 1)
		h4 = '<a href="#" tabindex="-1" class="menu-parent menu-parent-collapsed">' + h4 + '</a>';
	else
		h4 = '<a href="#" tabindex="-1"><h4>' + h4 + '</h4></a>';

	//define list content
	var branchContent = new Array();
	var noBranchContent = '';	
	var i = 0;

	$(list).each( function(index){
		if($(this).hasClass('contains_branch') && !$(this).hasClass('type_course')) {
			branchContent[i] = parseItem(this, level)	
			i++;
		} else {
			noBranchContent += '<li role="menuitem">' + $('> p', this).html() + '</li>';		
		}		
	});
	//test if noBranchContent is empty
	if(noBranchContent != ''){
		if(!$(this, list).hasClass('type_course')) {
			if (level == 1)
				noBranchContent = '<li class="general"><ul>' + noBranchContent + '</ul></li>';
		}
	}
	//output only filled elements
	branchTemp = "";
	for (var i=0; i < branchContent.length; i++) {
		if (branchContent[i] != null)
			branchTemp += branchContent[i];
	};

	branchContent = branchTemp
	
	branch = noBranchContent + branchContent;
	
	//set lists
	if (level == 1)
		list = '<ul class="sub menu-group-collapsed" role="group">' + branch + '</ul>';
	else
		list = '<ul>' + branch + '</ul>'

	if (level == 1)
		content = '<li id="' +  id + '" class="level-' + level + '" role="menuitem">' + h4 + list +  '</li>';
	else
		content = '<li class="level-' + level + '" role="menuitem expanded">' + h4 + list +  '</li>';
		
	return content;
}


function tableContents(){
	

	//NEW NAVIGATION BLOCK 
	
	//DEFINE LISTS	
	//table of contents
	var tableContents = $('.block_navigation .type_course li.type_structure');
	var outline = $('.course-content .outline').html();
	$('.course-content .outline').remove();
	var tc = '';
	$('p span', tableContents).each(function(index){
		tc += '<li class="tc"><a href="#section-' + index + '">' + $(this).html() + '</a></li>';
	});

	//course info
	var courseInfo = $('.block_navigation .type_course li.type_unknown.depth_4');

	//remove default navigation block
	$('#region-pre .region-content').empty();
	if($(tc).length || $(courseInfo).length) {
		//add table of content
		if($(tc).length && outline != null)	
			$('#region-pre .region-content').append('<div id="tableContents"><h4>' + outline + '</h4><ul>' + tc + '</ul></div>');
		//add course info
		if($(courseInfo).length)	
			$('#region-pre .region-content').append('<div id="courseInfo"><ul>' + getBranch(courseInfo) + '</ul></div>');
	}
	
	//go to link
	$('#tableContents .tc').bind('click', function() {
		var index = $(this).index();
		var section = "#section-" + index;
		$('body, html').animate({
	  		scrollTop: $(section).offset().top
		}, 500);
		return false;
	});

}

//CHANGE ICONS TO TEXT
function textIcons(){
	//course content edit mode
	$('.course-content .commands a').each(function(){
		iconToText(this, true);
	});
}
//change link icons to text
function iconToText(icon, remove){
	var title = $(icon).attr('title');		
	//return text; if true remove img
	if(!remove) {
		return $(icon).html(title);
	} else {
		return $(icon).append(title);
	}
}

function editMode(){	
	// Edit Summary 
	$('.summary .edit').parent().each(function(){
		iconToText(this);
		$(this).addClass('edit-summary button');
	});
	
	// toggle menu
	$('.section .commands').hide();
	
	var item = $('.section.main .section > li');

	item.bind({
		mouseenter: function() {
			if(!$(this).hasClass('edit-active'))
				$('.mod-indent', this).append($('<span class="edit-toggle">▼</span>'));
		},
		mouseleave: function(){
			if(!$(this).hasClass('edit-active'))
				$('.mod-indent .edit-toggle', this).remove();
		},
		click: function() {
			
			// if($('.section .section > li').hasClass('edit-active')) {
				// $('.mod-indent .edit-toggle', this).html('▲');		
			// } else {
				// $('.mod-indent .edit-toggle', this).html('▼');	
			// }
				
	    	item.removeClass('edit-active');
			$(this).addClass('edit-active');
			
			
			$('.section.main .commands').fadeOut(function(){			
				$('.commands', this);
							
			});
			if($('.commands', this).css('display') == 'none') {
				$('.commands', this).fadeIn().addClass('edit-active');
				$('.mod-indent .edit-toggle').empty();
				$('.mod-indent .edit-toggle', this).html('▲');
			} else {
				$(this).removeClass('edit-active');
				$('.mod-indent .edit-toggle', this).html('▼');
				
			}
		}
	});

/*
	item.click(function(){
		item.removeClass('edit-active');
		$(this).addClass('edit-active');
		$('.commands').fadeOut(function(){			
			$('.commands', this);
			
		});
		if($('.commands', this).css('display') == 'none') {
			$('.commands', this).fadeIn().addClass('edit-active');
		} else {
			$(this).removeClass('edit-active');
		}
	});
	*/
	//remove menu
	$(document.body).bind('click', function() {
		$('.section.main .commands').fadeOut('fast', function(){
			$('.section > li').removeClass('edit-active');
			$('.mod-indent .edit-toggle').remove();
		}); 
	});
	$('.section > li, .section > li .commands').bind('click', function(ev) {		
		ev.stopPropagation();
	});
}

