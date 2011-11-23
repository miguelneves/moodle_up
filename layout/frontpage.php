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
	<div id="page-header-wrap">
    	<div id="page-header">
    		
		        <h1 class="headermain">
		        	<a href="/?redirect=0"><img src="<?php echo $OUTPUT->pix_url('header', 'theme'); ?>" alt="logo_fcpe" /></a>
		        </h1>
		   
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
	        	<?php  
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
						echo "<div id=\"header-login\">";
						$children = $elem->childNodes; 
						foreach ($children as $child) { 
				    		$tmp_doc = new DOMDocument(); 
				  			$tmp_doc->appendChild($tmp_doc->importNode($child,true));        
				    		$innerHTML .= $tmp_doc->saveHTML(); 
						}
						echo $innerHTML;
						echo "</div>";
					}					
				}
				
				?>
	  
	        <div id="login-info-wrap">
		    	<?php 
		    		echo $OUTPUT->lang_menu();
		  			echo $OUTPUT->login_info();
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
<!--                         <?php echo core_renderer::MAIN_CONTENT_TOKEN ?> -->

<!-- START OF HOMEPAGE CONTENT -->
							<div class="welcome">
							<img src="<?php echo $OUTPUT->pix_url('welcome', 'theme'); ?>" />

								<h2>Bem-vindo ao Moodle da U.Porto</h2>
								<h3>Plataforma de gestão de apredizagem da Universidade do Porto</h3>
							</div>
							<div class="frontbloc">
								<h4>Como Aceder</h4>
								<p>Utilizador da U.Porto: Poderá agora entrar automaticamente na plataforma acedendo ao item Moodle U.PORTO existente, após autenticação, no menu direito da sua página pessoal no SiGARRA da sua instituição.
Utilizador externo e FEUP: Introduza os seus dados de acesso no bloco "Entrar" que se encontra do lado direito da interface.</p>

Para mais informações aceda a: Instruções 1º acesso, ou http://elearning.up.pt, ou contacte directamente o GATIUP por email [gatiup@reit.up.pt]
							</div>
							<div class="frontbloc">
								<h4>Cursos Online</h4>
								<p>Consulte a lista de cursos disponíveis na plataforma Moodle U.PORTO! 
Do lado esquerdo da interface estão listadas as Instituições/Faculdades da Universidade do Porto que disponibilizam cursos e unidades curriculares com componente e-learning nesta plataforma.</p>
							</div>
							<div class="frontbloc">
								<h4>Sobre a Moodle U.Porto</h4>
								<p>Os cursos SiGARRA são cursos livres onde poderá aprender a tirar partido de todas as potencialidades do Sistema de Informação da Universidade do Porto — o SiGARRA. No bloco "Grupos de disciplinas" seleccione FORMAÇÃO SiGARRA e escolha a sub-categoria que mais lhe interessa. Para aceder aos cursos entre como visitante.</p>
							</div>
<!-- END OF HOMEPAGE CONTENT -->
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
                    	<div class="block highlight">
                    		<h4>A não esquecer…</h4>
                    		<p>Criar uma Unidade Curricular no Moodle!</p>
                    	</div>
                        <?php echo $OUTPUT->blocks_for_region('side-post') ?>
                    </div>
                </div>
                <?php } ?>

            </div>
        </div>
    </div>

<!-- START OF FOOTER -->
    <div id="page-footer-wrapper">
	    <div id="page-footer">
			<div class="footer-item site-info">
				<img class="footer-logo" src="<?php echo $OUTPUT->pix_url('logo_up', 'theme'); ?>" alt="logo_up" />
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
<!-- END OF FOOTER -->
</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>