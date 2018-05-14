<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.Boostrap
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');

// Add Stylesheets
JHtml::_('stylesheet', 'bootstrap.min.css', array('version' => 'auto', 'relative' => true));

// Add Stylesheets
//JHtml::_('stylesheet', 'font-awesome.min.css', array('version' => 'auto', 'relative' => true));
$doc = JFactory::getDocument();
$doc->addStyleSheet('https://use.fontawesome.com/releases/v5.0.10/css/all.css',$type = 'text/css');

// Add Stylesheets
JHtml::_('stylesheet', 'style.css', array('version' => 'auto', 'relative' => true));


// Add template js
//JHtml::_('script', 'template.js', array('version' => 'auto', 'relative' => true));

// Add html5 shiv
JHtml::_('script', 'jui/html5.js', array('version' => 'auto', 'relative' => true, 'conditional' => 'lt IE 9'));

// Add Stylesheets
//JHtml::_('stylesheet', 'template.css', array('version' => 'auto', 'relative' => true));

/** @var JDocumentHtml $this */

$app  = JFactory::getApplication();
$user = JFactory::getUser();

// Output as HTML5
$this->setHtml5(true);

// Getting params from template
$params = $app->getTemplate(true)->params;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->get('sitename');

if ($task === 'edit' || $layout === 'form')
{
	$fullWidth = 1;
}
else
{
	$fullWidth = 0;
}

// Use of Google Font
if ($this->params->get('googleFont'))
{
	JHtml::_('stylesheet', 'https://fonts.googleapis.com/css?family=' . $this->params->get('googleFontName'));
	$this->addStyleDeclaration("
	h1, h2, h3, h4, h5, h6, .site-title {
		font-family: '" . str_replace('+', ' ', $this->params->get('googleFontName')) . "', sans-serif;
	}");
}

// Template color
if ($this->params->get('templateColor'))
{
	$this->addStyleDeclaration('
	body.site {
		border-top: 3px solid ' . $this->params->get('templateColor') . ';
		background-color: ' . $this->params->get('templateBackgroundColor') . ';
	}
	a {
		color: ' . $this->params->get('templateColor') . ';
	}
	.nav-list > .active > a,
	.nav-list > .active > a:hover,
	.dropdown-menu li > a:hover,
	.dropdown-menu .active > a,
	.dropdown-menu .active > a:hover,
	.nav-pills > .active > a,
	.nav-pills > .active > a:hover,
	.btn-primary {
		background: ' . $this->params->get('templateColor') . ';
	}');
}

// Check for a custom CSS file
JHtml::_('stylesheet', 'user.css', array('version' => 'auto', 'relative' => true));

// Check for a custom js file
JHtml::_('script', 'user.js', array('version' => 'auto', 'relative' => true));

// Load optional RTL Bootstrap CSS
//JHtml::_('bootstrap.loadCss', false, $this->direction);

// Adjusting content width
if ($this->countModules('sidebar-right') && $this->countModules('sidebar-left')) {
	$col_class = "col-sm-6";
}
elseif ($this->countModules('sidebar-right') && !$this->countModules('sidebar-left')) {
	$col_class = "col-sm-8";
}
elseif (!$this->countModules('sidebar-right') && $this->countModules('sidebar-left')) {
	$col_class = "col-sm-9";
}
else {
	$col_class = "col-sm-12";
}

// Logo file or site title param
if ($this->params->get('logoFile')) {
	$logo = '<img class="img-responsive" src="' . JUri::root() . $this->params->get('logoFile') . '" alt="' . $sitename . '" />';
}
elseif ($this->params->get('sitetitle')) {
	$logo = '<span class="site-title" title="' . $sitename . '">' . htmlspecialchars($this->params->get('sitetitle')) . '</span>';
}
else {
	$logo = '<span class="site-title" title="' . $sitename . '">' . $sitename . '</span>';
}

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<jdoc:include type="head" />
</head>
<body class="site <?php echo $option
	. ' view-' . $view
	. ($layout ? ' layout-' . $layout : ' no-layout')
	. ($task ? ' task-' . $task : ' no-task')
	. ($itemid ? ' itemid-' . $itemid : '')
	. ($params->get('fluidContainer') ? ' fluid' : '')
	. ($this->direction === 'rtl' ? ' rtl' : '');
?>">

	<!-- Body -->
	<div class="body">
	
		<!-- Header Start -->
		<header class="header">
			<nav class="navbar navbar-default">
				<div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-main-menu">
							<span class="sr-only">Toggle navigation</span>
							<span class="fa fa-bars"></span>
						</button>
						<a class="navbar-brand" href="<?php echo $this->baseurl; ?>">
							<?php echo $logo; ?>
							<?php if ($this->params->get('sitedescription')) : ?>
								<?php echo '<div class="site-description">' . htmlspecialchars($this->params->get('sitedescription')) . '</div>'; ?>
							<?php endif; ?>
						</a>
					</div>
			
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="navbar-main-menu">
						<?php if ($this->countModules('main-menu')) : ?>
						<!-- Joomla NavBar Start -->
						<div class="main-menu">			
							<jdoc:include type="modules" name="main-menu" style="none" />
						</div>
						<!-- Joomla NavBar End-->
						<?php endif; ?>
						
						<?php if ($this->countModules('header-search')) : ?>
                                                    <div class="header-search pull-right">
							<jdoc:include type="modules" name="header-search" style="none" />
                                                    </div>
						<?php endif; ?>
						
					</div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
			</nav>
		</header>
		<!-- Header End -->						

		
		<?php if ($this->countModules('banner')) : ?>
		<!-- banner Start -->	
		<div id="banner" class="banner">
			<div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
				<jdoc:include type="modules" name="banner" />
			</div>
		</div>
		<!-- banner End -->
		<?php endif; ?>
		  		
		<?php if ($this->countModules('top-a')) : ?>
		<div class="container-top-a">
			<jdoc:include type="modules" name="top-a" style="cardGrey" />
		</div>
		<?php endif; ?>

		<?php if ($this->countModules('top-b')) : ?>
		<div class="container-top-b">
			<jdoc:include type="modules" name="top-b" style="card" />
		</div>
		<?php endif; ?>

		<!--Start Main Content -->
		<div class="main-content">
			<div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">				
			  	<div class="row">
					<?php if ($this->countModules('sidebar-left')) : ?>
						<!-- Begin Sidebar left-->
                        <?php if ($col_class == "col-sm-6" || $col_class == "col-sm-9") : ?>
						<div id="sidebar" class="col-sm-3">
                        <?php elseif ($col_class == "col-sm-8") : ?>
                        <div id="sidebar" class="col-sm-4">
                        <?php endif; ?>
								<jdoc:include type="modules" name="sidebar-left" style="default" />
						</div>
						<!-- End Sidebar left-->
					<?php endif; ?>
					
					<main id="content" role="main" class="<?php echo $col_class;?>">
						<!-- Begin Content -->
						<jdoc:include type="message" />
						<jdoc:include type="component" />
						<!-- End Content -->
					</main>
					
					<?php if ($this->countModules('sidebar-right')) : ?>
                        <?php if ($col_class == "col-sm-6" || $col_class == "col-sm-9") : ?>
						<div id="aside" class="col-sm-3">
                        <?php elseif ($col_class == "col-sm-8") : ?>
                        <div id="aside" class="col-sm-4">
                        <?php endif; ?>
							<!-- Begin Right Sidebar -->
							<jdoc:include type="modules" name="sidebar-right" style="default" />
							<!-- End Right Sidebar -->
						</div>
					<?php endif; ?>
				</div>			  	
		  	</div>	
  		</div>
  		<!--End Main Content -->		

		<?php if ($this->countModules('breadcrumbs')) : ?>
		<!-- Begin breadcrumbs -->
		<div id="breadcrumbs" class="breadcrumbs">
			<div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
				<jdoc:include type="modules" name="breadcrumbs" />
			</div>
		</div>
		<!-- End breadcrumbs -->
		<?php endif; ?>

		<?php if ($this->countModules('bottom-a')) : ?>
		<div class="container-bottom-a">
			<jdoc:include type="modules" name="bottom-a" style="cardGrey" />
		</div>
		<?php endif; ?>

		<?php if ($this->countModules('bottom-b')) : ?>
		<div class="container-bottom-b">
			<jdoc:include type="modules" name="bottom-b" style="card" />
		</div>
		<?php endif; ?>
		
		<!-- Footer starts -->
		<footer class="footer" role="contentinfo">
			<div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
				<hr />
				<jdoc:include type="modules" name="footer" style="none" />
				<p class="pull-right">
					<a href="#top" id="back-top" class="back-top">
						<span class="icon-arrow-up-4" aria-hidden="true"></span>
						<span class="sr-only"><?php echo JText::_('TPL_CASSIOPEIA_BACKTOTOP'); ?></span>
					</a>
				</p>
				<p>&copy; <?php echo date('Y'); ?> <?php echo $sitename; ?></p>
			</div>
		</footer>
		<!-- Footer End -->
	</div>

	<jdoc:include type="modules" name="debug" style="none" />
</body>
</html>