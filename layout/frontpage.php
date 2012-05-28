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

	<!--[if lt IE 8]>
		<link rel="stylesheet" type="text/css" href="<?php echo $CFG->wwwroot . "/theme/up/style/ie.css" ?>" />
	<![endif]-->

</head>
<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>">
<?php echo $OUTPUT->standard_top_of_body_html() ?>

<div id="page">
	<div id="page-header-wrap">
		<div id="page-header">

				<h1 class="headermain">
					<a href="/?redirect=0"><img src="<?php echo $OUTPUT->pix_url('header', 'theme'); ?>" alt="Moodle" /></a>
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
<ul id="slider1">
									<li>
										<div class="welcome" style="background-image: url(http://moodle2.up.pt/theme/image.php?theme=up&amp;image=welcome&amp;rev=483&amp;component=theme)">
										<!-- <img src="http://moodle2.up.pt/theme/image.php?theme=up&amp;image=welcomeimg&amp;rev=483&amp;component=theme" width="416" height="207"/> -->
											<h2>Bem-vindo ao Moodle2 da U.Porto</h2>
											<h3>Plataforma de gestão de aprendizagem da Universidade do Porto</h3>
										</div>
									</li>
									<!--<li>
										<div class="welcome" style="background-image: url(http://moodle2.up.pt/theme/image.php?theme=up&amp;image=welcome-monkey&amp;rev=483&amp;component=theme)">
											<h2>Bem-vindo ao Moodle2 da U.Porto</h2>
											<h3>Novos conceitos de utilizacao numa plataforma mais intuitiva e acessivel</h3>
										</div>
									</li>
									<li>
										<div class="welcome" style="background-image: url(http://moodle2.up.pt/theme/image.php?theme=up&amp;image=welcome-usb&amp;rev=483&amp;component=theme)">
											<h2>Bem-vindo ao Moodle2 da U.Porto</h2>
											<h3>Plataforma de gestão de aprendizagem da Universidade do Porto</h3>
										</div>
									</li> -->
								</ul>

								<div class="frontbloc">
									<h4>Como Aceder</h4>
									<p> Siga os passos indicados na <a href="login/index.php">Pagina de login</a>. Mais informações no <a href="http://elearning.up.pt">portal de e-learning</a>, ou por email GATIUP/NTE [gatiup@reit.up.pt]</p>
								</div>
								<div class="frontbloc">
									<h4>Cursos Online</h4>
									<p>Consulte a <a href="https://sigarra.up.pt/up/web_base.gera_pagina?P_pagina=1000435">lista de cursos</a> disponíveis na plataforma Moodle U.PORTO! A Universidade do Porto disponibiliza um ambiente virtual de ensino para unidades curriculares e <a href="https://sigarra.up.pt/up/web_base.gera_pagina?P_pagina=1000419">cursos de formacao continua</a>.</p>
								</div>
								<div class="frontbloc">
									<h4>Sobre Moodle U.Porto</h4>
										<p>O Moodle 2 U.PORTO apresenta novas funcionalidades, novos conceitos de utilização, numa interface mais acessível e intuitiva. Mais informações sobre o <a href="http://moodle2.up.pt/mod/page/view.php?id=5">Moodle 2 Projeto Piloto</a>.</p></div>
								<!-- END OF HOMEPAGE CONTENT -->						</div>
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
						<!--<div class="block highlight">
							<h4>Moodle 2 U.PORTO</h4>
							<p>A plataforma e-learning para docentes e estudantes da Universidade do Porto</p>
						</div>-->
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
				<img class="footer-logo" src="<?php echo $OUTPUT->pix_url('logo_up', 'theme'); ?>" alt="U.Porto" />
			<p>Gestão e manutenção da plataforma Moodle U.PORTO da responsabilidade do GATIUP - Novas Tecnologias na Educação</p>
			<p>Tema gráfico criado por <a href="http://idd.fba.up.pt">idd.fba.up.pt</a></p>
			</div>
			<div class="footer-item help">
				<h5>Ajuda</h5>
				<ul>
					<li><a href="https://sigarra.up.pt/up/web_base.gera_pagina?P_pagina=1000431">Suporte Moodle UP</a></li>
					<li><a href="https://sigarra.up.pt/up/web_base.gera_pagina?P_pagina=18390">Manuais e Tutoriais UP</a></li>
					<li><a href="http://elearning.up.pt">Portal e-learning@UP</a></li>
					<li><a href="http://moodlept.net.educom.pt">MoodlePT</a></li>
					<li><a href="http://moodle.org">Moodle.org</a></li>
				</ul>
			</div>
			<div class="footer-item links">
				<h5>Outros Sites</h5>
				<ul>
					<li><a href="http://elearningcafe.up.pt">E-learning Café</a></li>
					<li><a href="http://up.pt">Universidade do Porto</a></li>
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