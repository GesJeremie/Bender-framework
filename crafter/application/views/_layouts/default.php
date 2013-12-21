<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Dashboard</title>

  <?= stylesheet_include_tag('bootstrap', 'font-awesome', 'layout') ?>
  <?= javascript_include_tag('cssrefresh', 'jquery', 'bootstrap') ?>
  
</head>
<body>

	<!-- Sidebar -->
	<nav class="navbar navbar-default" role="navigation">

		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Crafter</a>
			</div>

			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="#"><i class="fa fa-tasks"></i> Logs</a></li>
					<li><a href="#"><i class="fa fa-terminal"></i> Cmd</a></li>
					<li><a href="#"><i class="fa fa-tint"></i> Assets</a></li>
					<li><a href="#"><i class="fa fa-cogs"></i> Configuration</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					<li><a href="#"><i class="fa fa-unlock"></i></a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div>
	</nav>
	<!-- /Sidebar -->

	<?= $yield ?>
	
</body>
</html>