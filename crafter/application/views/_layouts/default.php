<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Tableau de bord</title>

  <?= stylesheet_include_tag('bootstrap', 'font-awesome', 'layout') ?>
  <?= javascript_include_tag('cssrefresh', 'jquery', 'bootstrap', 'main') ?>
  
</head>
<body>

	<!-- Sidebar -->
	<nav class="navbar navbar-default" role="navigation">

		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="<?= site_url() ?>">Crafter</a>
			</div>

			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="<?= menu_active('logs') ?>"><a href="<?= site_url('logs') ?>"><i class="fa fa-tasks"></i> Logs</a></li>
					<li class="<?= menu_active('config') ?>"><a href="<?= site_url('config') ?>"><i class="fa fa-cog"></i> Config</a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div>
	</nav>
	<!-- /Sidebar -->

	<?= $yield ?>


</body>
</html>