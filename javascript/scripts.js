$(document).ready(function() {
	//init
	customMenu();
	//textIcons();
	//editMode();
	//settings();
	
	/*$('.topics .section .right a').click(function(e){
		
		$(this).parent().parent().find('.content').slideToggle();
		
		e.preventDefault();
	});
	
	//edit dropdown menu
	$('.commands').hide();
	$('h2').click(function(e){
		
		$(this).next().slideToggle(function(){
			$('.commands a').css('display', 'block');
			$(this).css({
				background: '#ccc',
				padding: '10px',
				position: 'absolute'
			})
		});
	});
	
	*/
	
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
	 */
	
	//get content
	var home = $('.block_navigation a[title=Home]');
	var myProfile = $('.block_navigation li.depth_2:eq(2)');
	var myCourses = $('.block_navigation li.depth_2:eq(3)');
	var settings = $('.block_navigation a[title=Home]');
	

	
	
	//MY PROFILE
	
	var h3 = $('> p span', myProfile);
	var ul = $('> ul', myProfile);
	
	mp = '<h3>' + h3.html() + '</h3><ul class="sub">' + ul.html() + '</ul>';
	
	
	//MY COURSES
	
	//get courses
	var courses = $('> ul', myCourses);
	//get my courses title
	var h3 = $('> p span', myCourses);
	var ul = '';
	
	//create list of courses
	$('> li', courses).each( function(){
		li = $('> .tree_item a', this);
		console.log(li);
		ul += '<li>' + li[0].outerHTML + '</li>';
	});

	mc = '<h3>' + h3.html() + '</h3><ul class="sub">' + ul + '</ul>';
	
	
	
	//create megadropdown menu
	list = '<li id="home">' + home[0].outerHTML + '</li>';
	list += '<li id="myProfile">' + mp + '</li>';
	list += '<li id="myCourses">' + mc + '</li>';
	list += '<li id="settings">' + settings.html() + '</li>';
	
	
	$('#page-header').append('<div id="megamenu"><ul>' + list + '</ul></div>');
	
	
	//style megadropdown
	
	$('#megamenu .sub').css({
		display: 'none'
	})
	
	$('#megamenu li h3').hover(function(){
		//$('#megamenu #myProfile .sub').hide();
		$(this).next().slideToggle();
	})
	
	
	
	
	//table of contents
	/*var tableContents = $('.block_navigation .type_course li.type_structure');
	var list = '';
	//console.log($('p span', tableContents));
	
	$('p span', tableContents).each(function(index){
		list += '<li class="tc"><a href="#section-' + index + '">' + $(this).html() + '</a></li>';
	});

	$('.block_navigation').append('<h4>Table of Contents</h4><ul id="tc">' + list + '</ul>');
	
	$('#tc li').click(function(e) {	
		var index = $(this).index();
		var section = "#section-" + index;
		$('body, html').animate({
	  		scrollTop: $(section).offset().top
		}, 1000);
		e.preventDefault();
	});
	*/
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

function settings(){
	var set = $('.block_settings').remove();
	set = set.appendTo('#page-header');
	
	set.find('.content').hide();
	
	$('.block_settings h2').click(function(){
		set.find('.content').slideToggle();
		set.find('.content').css('backgroundColor', '#ccc');
		
	});
	$('.block_tree').css('overflow', 'hidden');
	$('.block_tree > li').removeClass('collapsed').css({
		'width': '250px',
		'float': 'left'
	});
	$('.commands').hide();
	
	
}














