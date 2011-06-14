<?php
// disable error notice in moodle server
error_reporting(0);

$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
$hassidepre = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-pre', $OUTPUT));
$hassidepost = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-post', $OUTPUT));
$haslogininfo = (empty($PAGE->layout_options['nologininfo']));

$showsidepre = ($hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT));
$showsidepost = ($hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT));

$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));

$bodyclasses = array();
if ($showsidepre && !$showsidepost) {
    $bodyclasses[] = 'side-pre-only';
} else if ($showsidepost && !$showsidepre) {
    $bodyclasses[] = 'side-post-only';
} else if (!$showsidepost && !$showsidepre) {
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
    
    <!-- google fonts -->
    <link href='http://fonts.googleapis.com/css?family=Droid+Serif:regular,italic,bold,bolditalic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:extralight,light,regular,bold' rel='stylesheet' type='text/css'>
    
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
		        	<img src="http://localhost/moodle/theme/up/pix/logo_fcpe.png" alt="logo" />
		        </h1>
		        
		    	<?php if ($haslogininfo) {
		            echo $OUTPUT->login_info();
		        }
		        if (!empty($PAGE->layout_options['langmenu'])) {
		            echo $OUTPUT->lang_menu();
		        } ?>
	        
		        <?php if($hasheadingmenu) { ?>
			        <div class="headermenu">
			        	<?php echo $PAGE->headingmenu; ?>
			        	
			        </div>
		        <?php } ?>
	        <?php } ?>
	        
	        <?php if ($hascustommenu) { ?>
	        <div id="custommenu"><?php echo $custommenu; ?></div>
	        <?php } ?>
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
                   		<?php if ($hassidepre) { ?>
		                <div id="region-pre" class="block-region">
		                    <div class="region-content">
		                        <?php echo $OUTPUT->blocks_for_region('side-pre') ?>
		                    </div>
		                </div>
                </div>

                
                <?php } ?>

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

<!-- START OF FOOTER -->
    <?php if ($hasfooter) { ?>
    <div id="page-footer" class="clearfix">
        <p class="helplink"><?php echo page_doc_link(get_string('moodledocslink')) ?></p>
        <?php
        echo $OUTPUT->login_info();
        echo $OUTPUT->home_link();
        echo $OUTPUT->standard_footer_html();
        ?>
    </div>
    <?php } ?>
</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>