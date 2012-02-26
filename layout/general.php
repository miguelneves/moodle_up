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
	<!--[if lt IE 9]>
		<link rel="stylesheet" type="text/css" href="<?php echo $CFG->wwwroot . "/theme/up/style/ie.css" ?>" />
	<![endif]-->
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=PT+Sans+Narrow">
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic">
		
		<?php echo $OUTPUT->standard_head_html() ?>
	

</head>
<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>">
<?php echo $OUTPUT->standard_top_of_body_html() ?>
<div id="page">
<?php if ($hasheading || $hasnavbar) { ?>
	<div id="page-header-wrap">
    	<div id="page-header">
    		<?php if ($hasheading) { ?>
		        <h1 class="headermain">
		        	<a href="/?redirect=0"><img src="<?php echo $OUTPUT->pix_url('header', 'theme'); ?>" alt="Moodle" /></a>
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
	<div id="page-footer-wrapper">
	    <div id="page-footer">
			<div class="footer-item site-info">
				<img class="footer-logo" src="<?php echo $OUTPUT->pix_url('logo_up', 'theme'); ?>" alt="U.Porto" />
		     	<p>Gestão e manutenção da plataforma Moodle U.PORTO da responsabilidade do GATIUP - Novas Tecnologias na Educação</p>
			</div>
			<div class="footer-item help">
				<h5>Ajuda</h5>
				<ul>
					<li><a href="">Suporte Moodle UP</a></a></li>
					<li><a href="">Manuais e Tutoriais UP</a></li>
					<li><a href="">Portal e-learning@UP</a></li>
					<li><a href="">MoodlePT</a></li>
					<li><a href="">Moodle.org</a></li>
				</ul>
			</div>
			<div class="footer-item links">
				<h5>Outros Sites</h5>
				<ul>
					<li><a href="">E-learning Café</a></li>
					<li><a href="">Universidade do Porto</a></li>
				</ul>
			</div>
			<div class="footer-item social">
				<ul>
					<li class="facebook"><a href="http://www.facebook.com/pages/Novas-Tecnologias-Na-Educacao/171484579541758" title="Facebook"><img src="<?php echo $OUTPUT->pix_url('facebook', 'theme'); ?>" alt="Facebook" /></a></li>
					<li class="linkedin"><a href="http://www.linkedin.com/in/uportonte" title="Linkedin"><img src="<?php echo $OUTPUT->pix_url('linkedin', 'theme'); ?>" alt="Linkedin" /></a></li>
					<li class="delicious"><a href="http://www.delicious.com/elearning.up.pt" title="Delicious"><img src="<?php echo $OUTPUT->pix_url('delicious', 'theme'); ?>" alt="Delicious" /></a></li>
				</ul>
			</div>
	        <?php        
	       		echo $OUTPUT->login_info();
	        	echo $OUTPUT->standard_footer_html();
	        ?>
	    </div>
    </div>

	<?php } ?>
<!-- END OF FOOTER -->
</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>