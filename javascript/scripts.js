$(document).ready(function() {
	//init
	customMenu();
	//textIcons();
	//editMode();
//	newPostModal();
		
});


function customMenu(){
	
	//remove default tree view
	$('.block_navigation .block_tree').removeClass();
	
	//create megadropdownmenu
	/*
	 * Home
	 * My Profile
	 * My Courses
	 * Settings
	 * 
	 * Site Pages?
	 */
	
	//remove images
	$('.block_navigation a img').remove();
	
	//get content
	var home = $('.block_navigation a[title="My home"]');
	var myProfile = $('.block_navigation li.depth_2:eq(2)');
	var myCourses = $('.block_navigation li.depth_2:eq(3)');
	var settings = $('.block_navigation a[title=Home]');
	
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
		content += '<li><h4>' + h4[i].innerHTML + '</h4>';
		content += '<ul>' + branchContent[i] + '</ul></li>';
	};
	
	//no branch
	var noBranch = $('> li.item_with_icon p', ul);
	noBranchContent = '';	
	$(noBranch).each( function(){
		noBranchContent += '<li>' + this.innerHTML + '</li>';
	});

	noBranchContent = '<li id="general"><ul>' + noBranchContent + '</ul></li>';
	
	content = noBranchContent + content;
	
	//create my profile content
	mp = '<h3>' + h3.html() + '</h3><ul class="sub">' + content + '</ul>';

	//mp = getBranch(ul);
	
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
	
	//create my course contetn
	mc = '<h3>' + h3.html() + '</h3><ul class="sub">' + ul + '</ul>';
	
	$('.block_navigation').hide();
	//SETTINGS
	
	//get settings
	var settings = $('.block_settings');
	
	//get settings title
	var h3 = $('.header .title h2', settings);
	var set = $('#settingsnav > ul', settings);
	
	//console.log(set)
	//c = getBranch(set)
	//contain branch
	
	//create settings content
	set = '<h3>' + h3.html() + '</h3><ul class="sub">' + 'c' + '</ul>';
	
	var mp, mc, set = '';
	
	//mp = getMenu(myProfile);
	//create megadropdown menu
	list = '<li id="home"><h3 id="myHome">' + home.parent().html() + '</h3></li>';
	list += '<li id="myProfile">' + mp + '</li>';
	list += '<li id="myCourses">' + mc + '</li>';
	list += '<li id="settings">' + set + '</li>';
	
	
	$('#page-header').append('<div id="megamenu"><ul>' + list + '</ul></div>');
	
	
	//style megadropdown
	
	$('#megamenu .sub').css({
		display: 'none'
	})
	
	$('#megamenu li h3').click(function(){
		//$('#megamenu .sub').not(this).slideToggle();
		$(this).next().slideToggle();
		$(this).parent().toggleClass('active')
	})
	
	

	//NEW NAVIGATION BLOCK 
	
	
	//table of contents
	var tableContents = $('.block_navigation .type_course li.type_structure');
	var tc = '';	
	
	//go to link
	$('#tc li').click(function(e) {	
		var index = $(this).index();
		var section = "#section-" + index;
		$('body, html').animate({
	  		scrollTop: $(section).offset().top
		}, 1000);
		return false;
		e.preventDefault();
	});
	
	
	//DEFINE LISTS	
	//course info
	var courseInfo = $('.block_navigation .type_course li.type_unknown.depth_4');
	var info = '';
	$(courseInfo).each(function(){
		info += $(this).html();		
	});
	
	$('p span', tableContents).each(function(index){
		tc += '<li class="tc"><a href="#section-' + index + '">' + $(this).html() + '</a></li>';
	});
	
	//remove default navigation block
	$('#region-pre .region-content').empty();
	//add table of content	
	$('#region-pre .region-content').append('<div id="tableContents"><h4>Table of Contents</h4><ul id="tc">' + tc + '</ul></div>');
	//add course info
	$('#region-pre .region-content').append('<div id="courseInfo"><h4>Course</h4><ul id="tc">' + getBranch(courseInfo) + '</ul></div>');
		
}


// create lists
function getBranch(el) {
	content = '';

	el.each(function(){
		var h4 = $('> p > a', this);
		var ul = $('> ul', this);
		var lista = '';
		
		$('> li', ul).each(function(){
			lista += '<li>' + $('p', this).html() + '</li>';
		});
		
		//create branch
		branch = '';
		branch += '<li><a href="#"><h4>' + h4.html() + '</h4></a>';
		branch += '<ul>' + lista + '</ul></li>';
	
		content += branch;
	});
	
	return content;
}




// TODO
function newPostModal(){
	$('#newdiscussionform').click(function(){
		$.ajax({
			url: "http://localhost/moodle/mod/forum/post.php",
			type: 'get',
			data: {
				forum: "1"
			},
			success: function(data){
				var form = $(data).find('form');
								
				//overlay
				$('body').append('<div id="overlay"></div>');
	 
	  				$('#overlay').css({
				    position: "fixed",
				    top: "0",
				    left: "0",
				    height: "100%",
				    width: "100%",
				    background: "#000",
				    opacity: '0.5'
				});
				
				//form
	  
				var imageWidth = form.width / 2 ;
				var imageHeight = form.height / 2;
			    form.css({
			        "margin-left": -imageWidth,
		       		"margin-top": -imageHeight,
		       		"z-index": "80000"
			    });
			  
			    $("body").append(form);
			}
			
		
		});
		return false; 
	});
}

function editMode(){
	$('.singlebutton input').click(function(e){
		$.ajax({
  		url: "http://localhost/moodle/course/view.php",
  			type: 'POST',
  			data: {
  				id: '3',
  				sesskey: '8La3UtEcRI',
  				edit: 'on'
  			},
  			success: function(){
  				$(this).addClass("done");		
			}
		});
		e.preventDefault();
	});
}
function textIcons(){
	$('.commands a').each(function(){
		var title = $(this).attr('title');
		
		$('img',this).remove();
		$(this).html(title);
		
		//debug
		//console.log(title);
	});
}

