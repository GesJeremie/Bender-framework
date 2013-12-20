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

<div class="container">

<div class="page-header">
	<h1>Logs <small>90 logs disponibles</small></h1>

</div>

<div>
	<span class="badge">Erreur</span>
	<span class="badge">Debug</span>
	<span class="badge">Info</span>
</div>

<div class="spacer30"></div>

<table class="table table-striped">
  <thead>
  	<tr>
  		<th>Label</th>
  		<th>Date</th>
  		<th>Description</th>
  	</tr>
  </thead>
  <tbody>

  	<? if ($logs): ?>

  		<? foreach($logs as $log): ?>

		  	<tr>
		  		<td><?= $log['label'] ?></td>
		  		<td><?= $log['date_gmt'] ?></td>
		  		<td><?= $log['description'] ?></td>
		  	</tr>

		<? endforeach; ?>
  	<? endif; ?>

  </tbody>
</table>
</div>