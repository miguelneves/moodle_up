$(document).ready(function() {
	//init
	customMenu();
	textIcons();
	if($('body').hasClass('editing')) {
		editMode();
	}
	
//	newPostModal();
		
});


function customMenu(){
	
	//remove default tree view
	$('.block_navigation .block_tree').removeClass();
	$('.block_settings .block_tree').removeClass();
	
	//remove images
	$('.block_navigation a img').remove();
	$('.block_settings a img').remove();
	
	
	//MEGAMENU
	/*
	 * Home
	 * My Profile
	 * My Courses
	 * Settings
	 * 
	 * Site Pages?
	 */
	
	//get content
	var home = $('.block_navigation a[title="My home"]');
	var myProfile = $('.block_navigation li.depth_2:eq(2)');
	var myCourses = $('.block_navigation li.depth_2:eq(3)');
	var settings = $('.block_navigation a[title=Home]');
	
	//create megamenu if exist
	if($(home).length) {	
	
		//MY PROFILE
		var h3 = $('> p span', myProfile);
		var ul = $('> ul', myProfile);
		
		//contain branch
		var h4 = $('> li.contains_branch p span', ul);
		var branch = $('> li.contains_branch ul', ul);
	
		//clean up branch
		var branchContent = new Array(3);
		for (var i = branchContent.length - 1; i >= 0; i--) branchContent[i] = '';
	
		$(branch).each( function(index){
			branchTemp = '';
			$('li p', this).each( function(){
				branchTemp += '<li>' + $(this).html() + '</li>';
			})
			branchContent[index] +=  branchTemp;
		});
	
		//create branch
		content = '';
		for (var i = branch.length - 1; i >= 0; i--){
			content += '<li><a href="#"><h4>' + h4[i].innerHTML + '</h4></a>';
			content += '<ul>' + branchContent[i] + '</ul></li>';
		};
		
		//no branch
		var noBranch = $('> li.item_with_icon p', ul);
		noBranchContent = '';	
		$(noBranch).each( function(){
			noBranchContent += '<li>' + this.innerHTML + '</li>';
		});
	
		noBranchContent = '<li class="general"><ul>' + noBranchContent + '</ul></li>';
		
		content = noBranchContent + content;
		
		//create my profile content
		mp = '<a href="#"><h3>' + h3.html() + '</h3></a><ul class="sub">' + content + '</ul>';
		
		//MY COURSES
		
		//get courses
		var courses = $('> ul', myCourses);
		//get my courses title
		var h3 = $('> p span', myCourses);
		var ul = '';
		
		//create list of courses
		$('> li', courses).each( function(){
			li = $('> .tree_item', this);
			ul += '<li>' + li[0].innerHTML + '</li>';
		});
		
		//create my course content
		mc = '<a href="#"><h3>' + h3.html() + '</h3></a><ul class="sub">' + ul + '</ul>';
		
		$('.block_navigation').hide();
		
		//SETTINGS
		//get settings
		var settings = $('.block_settings');
		
		//get settings title
		var h3 = $('.header .title h2', settings);
		var set = $('#settingsnav > ul > li', settings);
		s = getBranch(set);
		
		//create settings content
		set = '<a href="#"><h3>' + h3.html() + '</h3></a><ul class="sub">' + s + '</ul>';
		
		//Create megadropdown menu		
		if($(home).length)
			list = '<li id="home" class="first-level"><h3 id="myHome">' + home.parent().html() + '</h3></li>';
		if($(myProfile).length)
			list += '<li id="myProfile" class="first-level submenu">' + mp + '</li>';
		if($(myCourses).length)
			list += '<li id="myCourses" class="first-level submenu">' + mc + '</li>';
		if($(settings).length)
			list += '<li id="settings" class="first-level submenu">' + set + '</li>';
		
		$('#page-header').append('<div id="megamenu"><ul>' + list + '</ul></div>');
		
		//megadropdown behaviour
		$('#megamenu .sub').hide();
		$('#megamenu li a').click(function(ev){
			$('#megamenu li .sub').slideUp('fast', function(){
				$(this).parent().removeClass('active');
			});
			if($(this).next().css('display') == 'none') {
				$(this).next().slideDown('fast').parent().addClass('active');
			}
			//ev.preventDefault();
		});
		
		//remove menu
		$(document.body).bind('click', function() {
			$('#megamenu li .sub').slideUp('fast', function(){
				$(this).parent().removeClass('active');
			}); 
		});
		$('#megamenu .first-level').bind('click', function(ev) {
			ev.stopPropagation();
		});
	}
	

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
		console.log(this)
		var index = $(this).index();
		var section = "#section-" + index;
		$('body, html').animate({
	  		scrollTop: $(section).offset().top
		}, 500);
		return false;
	});

	// create lists
	function getBranch(el) {
		content = '';
	
		el.each(function(){
			var h4 = $('> p > a, > p > span', this);
			var ul = $('> ul', this);
			var lista = '';
	
			$('> li', ul).each(function(){
				lista += '<li>' + $('p', this).html() + '</li>';
			});
			
			//create branch
			branch = '';
			branch += '<li class="first-level"><a href="#" class="list-header"><h4>' + h4.html() + '</h4></a>';
			branch += '<ul>' + lista + '</ul></li>';
		
			content += branch;
		});
		
		return content;
	}


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

