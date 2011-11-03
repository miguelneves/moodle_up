<?php
// disable error notice in moodle server
error_reporting(0);

$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));

$hassidepost = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-post', $OUTPUT));
$haslogininfo = (empty($PAGE->layout_options['nologininfo']));

$showsidepost = ($hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT));

$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));

$bodyclasses = array();
if ($showsidepost) {
    $bodyclasses[] = 'side-post-only';
} else if (!$showsidepost) {
    $bodyclasses[] = 'content-only';
}

if ($hascustommenu) {
    $bodyclasses[] = 'has_custom_menu';
}

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $PAGE->title ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />  
    <?php echo $OUTPUT->standard_head_html() ?>
    
      <!--[if lt IE 9]>
        <link rel="stylesheet" type="text/css" href="http://localhost/moodle/theme/up/style/ie.css" />
	<![endif]-->
    
    <!-- google fonts -->
	<script type="text/javascript">
		WebFontConfig = {
    	google: { families: [ 'PT+Sans+Narrow:400,700:latin', 'Droid+Serif:400,700,400italic,700italic:latin' ] }
  	};
  	(function() {
    	var wf = document.createElement('script');
    	wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
      		'://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    	wf.type = 'text/javascript';
    	wf.async = 'true';
    	var s = document.getElementsByTagName('script')[0];
    	s.parentNode.insertBefore(wf, s);
  	})(); </script>


</head>
<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>">
<?php echo $OUTPUT->standard_top_of_body_html() ?>
<div id="page">
<?php if ($hasheading || $hasnavbar) { ?>
	<div id="page-header-wrap">
    	<div id="page-header">
    		<?php if ($hasheading) { ?>
		        <h1 class="headermain">
		        	<!-- <a href="/" title="Moodle U.Porto" >Moodle U.Porto</a> -->
		        	<a href="/"><img src="<?php echo $OUTPUT->pix_url('header', 'theme'); ?>" alt="logo_fcpe" /></a>
		        </h1>
		                
		        <?php if($hasheadingmenu) { ?>
			        <div class="headermenu">
			        	<?php echo $PAGE->headingmenu; ?>
			        	
			        </div>
		        <?php } ?>
	        <?php } ?>
	        
	        <?php if ($hascustommenu) { ?>
	        <div id="custommenu"><?php echo $custommenu; ?></div>
	        <?php } ?>
	        
	        <div id="login-info-wrap">
		    	<?php 
		    		 if (!empty($PAGE->layout_options['langmenu'])) {
		            	echo $OUTPUT->lang_menu();
		       		}
		  			if ($haslogininfo) {
		            	echo $OUTPUT->login_info();
		       		}
	        	?>
		    </div>
	    </div>
    </div>
<?php } ?>
<!-- END OF HEADER -->
		
    <div id="page-content">
    	<?php if ($hasnavbar) { ?>
            <div class="navbar clearfix">
                <div class="breadcrumb"><?php echo $OUTPUT->navbar(); ?></div>
            </div>
        <?php } ?>
        <div id="region-main-box">
            <div id="region-post-box">

                <div id="region-main-wrap">
                	<div id="course-title">
	                	<?php if ($hasheading) { ?>
                    		<h2><?php echo $PAGE->heading ?></h2>
                    	<?php } ?>
                    	<?php if ($hasnavbar) { ?>					             
				        	<div class="navbutton"> <?php echo $PAGE->button; ?></div>
				        <?php } ?>
					</div>
                    <div id="region-main">                    	
            	        <div class="region-content">                        	
                            <?php echo core_renderer::MAIN_CONTENT_TOKEN ?>                           
                        </div>
                    </div>
				</div>
                <!-- sidebar -->
  				<?php if ($hassidepost) { ?>               
	                <div id="region-post" class="block-region">
	                    <div class="region-content">	                    
	                        <?php echo $OUTPUT->blocks_for_region('side-post') ?>
	                    </div>
	                </div>
                <?php } ?>	
				</div>
			</div>
		</div>
	</div>



<!-- START OF FOOTER -->
    <?php if ($hasfooter) { ?>
    <div id="page-footer" class="clearfix">
     <!--   <p class="helplink"><?php echo page_doc_link(get_string('moodledocslink')) ?></p> -->
     <img src="<?php echo $OUTPUT->pix_url('logo_up', 'theme'); ?>" alt="logo_up" />
        <?php
        echo $OUTPUT->login_info();
      //  echo $OUTPUT->home_link();
        echo $OUTPUT->standard_footer_html();
        ?>
    </div>
    <?php } ?>
</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>