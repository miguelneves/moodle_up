<?php
// disable error notice in moodle server
error_reporting(0);

$hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
$showsidepre = $hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT);
$showsidepost = $hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT);

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
    <meta name="description" content="<?php p(strip_tags(format_text($SITE->summary, FORMAT_HTML))) ?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
    
    <!--[if lt IE 9]>
        <link rel="stylesheet" type="text/css" href="http://localhost/moodle/theme/up/style/ie.css" />
	<![endif]-->
	
     <!-- google fonts -->
    <link href='http://fonts.googleapis.com/css?family=Droid+Serif:regular,italic,bold,bolditalic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:200,300,400,700&v2' rel='stylesheet' type='text/css'>
</head>
<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>">
<?php echo $OUTPUT->standard_top_of_body_html() ?>

<div id="page">
	<div id="page-header-wrap">
    	<div id="page-header">
    		
		        <h1 class="headermain">
		        	<!-- <a href="/" title="Moodle U.Porto" >Moodle U.Porto</a> -->
		        	<a href="/"><img src="<?php echo $OUTPUT->pix_url('header_up', 'theme'); ?>" alt="logo_fcpe" /></a>
		        </h1>
		        
		    <?php 
	    		echo $OUTPUT->login_info();
				echo $OUTPUT->lang_menu();
		    ?>
		     
			<?php if ($hasheading) { ?>  
		        <?php if($hasheadingmenu) { ?>
			        <div class="headermenu">
			        	<?php echo $PAGE->headingmenu; ?>
			        	
			        </div>
		        <?php } ?>
	        <?php } ?>
	        
	        <?php if ($hascustommenu) { ?>
	        <div id="custommenu"><?php echo $custommenu; ?></div>
	        <?php } ?>
	        
	        <!-- header login -->
	        <div id="header-login">
	        	<?php  
	        	error_reporting(1);
	        	$sidebar = $OUTPUT->blocks_for_region('side-post');
      	      
				$doc = new DOMDocument();
				$doc->loadHTML($sidebar);
				
				$elems = $doc->getElementsByTagName('div');
				
				foreach($elems as $elem){
					$attr = $elem->getAttribute('class');
					// check if has block_login class
					$pattern = '/block_login/';
					$match = preg_match($pattern, $attr);
					if ($match) {
						$children = $elem->childNodes; 
						foreach ($children as $child) { 
				    		$tmp_doc = new DOMDocument(); 
				  			$tmp_doc->appendChild($tmp_doc->importNode($child,true));        
				    		$innerHTML .= $tmp_doc->saveHTML(); 
						}
						echo $innerHTML;
					}					
				}
				
				?>
	        </div>
	    </div>
    </div>
    
<!-- END OF HEADER -->

    <div id="page-content">
        <div id="region-main-box">
            <div id="region-post-box">

                <div id="region-main-wrap">
                    <div id="region-main">
                        <div class="region-content">
                          <!-- <?php echo core_renderer::MAIN_CONTENT_TOKEN ?> -->
                           
							<!-- frontpage static content 
								
								REMOVER OU ALTERAR PELO CORRECTO
								
								-->
							<div id="frontpage-content">
								<div class="frontblock">
	  								<h2 class="frontblock fronthead p1">Welcome to Moodle U.PORTO!</h2>
									<p class="fronttext p1"> <a title="Clicar aqui para se validar" href="/login/index.php"><img alt="Login eLearning@UP" src="http://moodle.up.pt/file.php/1/img/moodle-logo.gif" style="float: left;"></a>  <strong style="color: rgb(128, 112, 64);">How to login:</strong><br><strong>U.Porto Community: </strong>You may automatically login clicking on <em>Moodle U.PORTO</em> item that will show on your SiGARRA (IS) personal page after validation.<br><strong>External user and FEUP: </strong>Insert username and password on "Login" block. <br><br>Check for more information: <a href="/login/index.php">First time here</a>, or <a href="http://elearning.up.pt" target="_blank">http://elearning.up.pt</a>, or contact <a target="_blank" href="http://sigarra.up.pt/up/web_base.gera_pagina?p_pagina=18377">GATIUP</a> by email [<a href="mailto:gatiup@reit.up.pt" target="_blank">gatiup@reit.up.pt</a>]  </p> </div>
								<div class="frontblock">
									<h2 class="frontblock fronthead p2">U.PORTO courses</h2>
									<p class="fronttext p2">
										<a title="Clicar aqui para listar cursos" href="course/index.php">
										<img alt="Cursos Moodle U.PORTO" src="http://moodle.up.pt/file.php/1/img/cursos.png" style="float: left;">
										</a> Check U.PORTO course list!<br>On the left side of the interface you can find a list of all Institutions and Faculties of the University of Porto presenting e-learning courses in this platform.  </p>
								</div>
								<div class="frontblock">
									<h2 class="frontblock fronthead p3">Training</h2>
									<p class="fronttext p3"> <a href="/course/category.php?id=20"><img alt="Formação" src="http://moodle.up.pt/file.php/1/img/form-continua.png" style="float: left;"></a>  Check out the list of <a href="course/category.php?id=20">Continuing Education</a> and <a href="course/category.php?id=8">Internal Training</a> courses available in this platform. <br> Go to <a href="http://elearning.up.pt" target="_blank">eLearning portal</a> for more information about current training courses.  </p> </div>        
								<div class="frontblock">
									<h2 class="frontblock fronthead p4">SiGARRA courses</h2>
									<p class="fronttext p4"> <a href="/course/category.php?id=6"><img alt="Formação SiGARRA" src="http://moodle.up.pt/file.php/1/img/cursos-sigarra.png" style="float: left;"></a>  SiGARRA courses are free courses to support you using U.Porto IS - SiGARRA. There you can find documentation, tutorials, tips and FAQs to help you to take advantage of all SiGARRA potentialities. Click <a href="course/category.php?id=6">FORMAÇÃO SiGARRA</a> and choose a subcategory of your interest.</p> </div>     
                       		</div>
                       	<div id="uni">
                       		<h2>Unidades Curriculares</h2>
	                       	<ul class="list">
								<li class="r0"><div class="icon column c0"><img src="http://moodle.up.pt/pix/smartpix.php/Universidade-do-Porto/i/course.gif" class="icon" alt="Categoria da disciplina"></div><div class="column c1"><a href="http://moodle.up.pt/course/category.php?id=26">GESTÃO DE PROJECTOS</a></div></li>
								<li class="r1"><div class="icon column c0"><img src="http://moodle.up.pt/pix/smartpix.php/Universidade-do-Porto/i/course.gif" class="icon" alt="Categoria da disciplina"></div><div class="column c1"><a href="http://moodle.up.pt/course/category.php?id=6">FORMACAO SIGARRA</a></div></li>
								<li class="r0"><div class="icon column c0"><img src="http://moodle.up.pt/pix/smartpix.php/Universidade-do-Porto/i/course.gif" class="icon" alt="Categoria da disciplina"></div><div class="column c1"><a href="http://moodle.up.pt/course/category.php?id=18">EGP</a></div></li>
								<li class="r1"><div class="icon column c0"><img src="http://moodle.up.pt/pix/smartpix.php/Universidade-do-Porto/i/course.gif" class="icon" alt="Categoria da disciplina"></div><div class="column c1"><a href="http://moodle.up.pt/course/category.php?id=9">FAUP</a></div></li>
								<li class="r0"><div class="icon column c0"><img src="http://moodle.up.pt/pix/smartpix.php/Universidade-do-Porto/i/course.gif" class="icon" alt="Categoria da disciplina"></div><div class="column c1"><a href="http://moodle.up.pt/course/category.php?id=12">FADEUP</a></div></li>
								<li class="r1"><div class="icon column c0"><img src="http://moodle.up.pt/pix/smartpix.php/Universidade-do-Porto/i/course.gif" class="icon" alt="Categoria da disciplina"></div><div class="column c1"><a href="http://moodle.up.pt/course/category.php?id=10">FBAUP</a></div></li>
								<li class="r0"><div class="icon column c0"><img src="http://moodle.up.pt/pix/smartpix.php/Universidade-do-Porto/i/course.gif" class="icon" alt="Categoria da disciplina"></div><div class="column c1"><a href="http://moodle.up.pt/course/category.php?id=21">FCNAUP</a></div></li>
								<li class="r1"><div class="icon column c0"><img src="http://moodle.up.pt/pix/smartpix.php/Universidade-do-Porto/i/course.gif" class="icon" alt="Categoria da disciplina"></div><div class="column c1"><a href="http://moodle.up.pt/course/category.php?id=11">FCUP</a></div></li>
								<li class="r0"><div class="icon column c0"><img src="http://moodle.up.pt/pix/smartpix.php/Universidade-do-Porto/i/course.gif" class="icon" alt="Categoria da disciplina"></div><div class="column c1"><a href="http://moodle.up.pt/course/category.php?id=16">FDUP</a></div></li>
								<li class="r1"><div class="icon column c0"><img src="http://moodle.up.pt/pix/smartpix.php/Universidade-do-Porto/i/course.gif" class="icon" alt="Categoria da disciplina"></div><div class="column c1"><a href="http://moodle.up.pt/course/category.php?id=14">FEP</a></div></li>
								<li class="r0"><div class="icon column c0"><img src="http://moodle.up.pt/pix/smartpix.php/Universidade-do-Porto/i/course.gif" class="icon" alt="Categoria da disciplina"></div><div class="column c1"><a href="http://moodle.up.pt/course/category.php?id=15">FEUP</a></div></li>
								<li class="r1"><div class="icon column c0"><img src="http://moodle.up.pt/pix/smartpix.php/Universidade-do-Porto/i/course.gif" class="icon" alt="Categoria da disciplina"></div><div class="column c1"><a href="http://moodle.up.pt/course/category.php?id=25">FFUP</a></div></li>
								<li class="r0"><div class="icon column c0"><img src="http://moodle.up.pt/pix/smartpix.php/Universidade-do-Porto/i/course.gif" class="icon" alt="Categoria da disciplina"></div><div class="column c1"><a href="http://moodle.up.pt/course/category.php?id=17">FLUP</a></div></li>
								<li class="r1"><div class="icon column c0"><img src="http://moodle.up.pt/pix/smartpix.php/Universidade-do-Porto/i/course.gif" class="icon" alt="Categoria da disciplina"></div><div class="column c1"><a href="http://moodle.up.pt/course/category.php?id=23">FMDUP</a></div></li>
								<li class="r0"><div class="icon column c0"><img src="http://moodle.up.pt/pix/smartpix.php/Universidade-do-Porto/i/course.gif" class="icon" alt="Categoria da disciplina"></div><div class="column c1"><a href="http://moodle.up.pt/course/category.php?id=22">FMUP</a></div></li>
								<li class="r1"><div class="icon column c0"><img src="http://moodle.up.pt/pix/smartpix.php/Universidade-do-Porto/i/course.gif" class="icon" alt="Categoria da disciplina"></div><div class="column c1"><a href="http://moodle.up.pt/course/category.php?id=13">FPCEUP</a></div></li>
								<li class="r0"><div class="icon column c0"><img src="http://moodle.up.pt/pix/smartpix.php/Universidade-do-Porto/i/course.gif" class="icon" alt="Categoria da disciplina"></div><div class="column c1"><a href="http://moodle.up.pt/course/category.php?id=19">ICBAS</a></div></li>
								<li class="r1"><div class="icon column c0"><img src="http://moodle.up.pt/pix/smartpix.php/Universidade-do-Porto/i/course.gif" class="icon" alt="Categoria da disciplina"></div><div class="column c1"><a href="http://moodle.up.pt/course/category.php?id=32">REITORIA</a></div></li>
								<li class="r0"><div class="icon column c0"><img src="http://moodle.up.pt/pix/smartpix.php/Universidade-do-Porto/i/course.gif" class="icon" alt="Categoria da disciplina"></div><div class="column c1"><a href="http://moodle.up.pt/course/category.php?id=36">MOSTRA UP</a></div></li>
								<li class="r1"><div class="icon column c0"><img src="http://moodle.up.pt/pix/smartpix.php/Universidade-do-Porto/i/course.gif" class="icon" alt="Categoria da disciplina"></div><div class="column c1"><a href="http://moodle.up.pt/course/category.php?id=118">UNIVERSIDADE JÚNIOR</a></div></li>
								<li class="r0"><div class="icon column c0"><img src="http://moodle.up.pt/pix/smartpix.php/Universidade-do-Porto/i/course.gif" class="icon" alt="Categoria da disciplina"></div><div class="column c1"><a href="http://moodle.up.pt/course/category.php?id=612">FORMAÇÃO CONTÍNUA</a></div></li>
								<li class="r1"><div class="icon column c0"><img src="http://moodle.up.pt/pix/smartpix.php/Universidade-do-Porto/i/course.gif" class="icon" alt="Categoria da disciplina"></div><div class="column c1"><a href="http://moodle.up.pt/course/category.php?id=778">UNIVERSIDADE DE VERÃO</a></div></li>
							</ul>
                       	</div>	
                       		
                        </div>
                    </div>
                </div>

                <?php if ($hassidepre) { ?>
                <div id="region-pre" class="block-region">
                    <div class="region-content">
                    	<?php echo $OUTPUT->blocks_for_region('side-pre') ?>
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
    <div id="page-footer">
     <!--   <p class="helplink">
        <?php echo page_doc_link(get_string('moodledocslink')) ?>
     </p> -->
     <img src="<?php echo $OUTPUT->pix_url('logo_up', 'theme'); ?>" alt="logo_up" />
        <?php        
        echo $OUTPUT->login_info();
    //   echo $OUTPUT->home_link();
        echo $OUTPUT->standard_footer_html();
        ?>
    </div>
</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>