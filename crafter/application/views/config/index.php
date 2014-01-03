<div class="container">

	<div class="page-header"><h1>Environment</h1></div>

	<div class="alert alert-info">
		Your are running with <strong><?= $environment ?></strong> mode
	</div>
	<div class="btn-group">


		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
			<?= $environment ?> <span class="caret"></span>
		</button>
		<ul class="dropdown-menu" role="menu">
			<li <? if ($environment == 'development'): ?> class="active" <? endif; ?>><a href="<?= site_url('config/environment/development') ?>">development</a></li>
			<li <? if ($environment == 'testing'): ?> class="active" <? endif; ?>><a href="<?= site_url('config/environment/testing') ?>">testing</a></li>
			<li <? if ($environment == 'production'): ?> class="active" <? endif; ?>><a href="<?= site_url('config/environment/production') ?>">production</a></li>
		</ul>
	</div>

	<div class="spacer30"></div>

	<div class="page-header"><h1>Routing</h1></div>

	<div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Add another route</h3>
			</div>
			<div class="panel-body">

				<? if ($this->session->get('add_route', 'config')): ?>
					<div class="alert alert-danger"><?= $this->session->flash('add_route', 'config') ?></div>
				<? endif; ?>

				<form class="form-inline" role="form" method="POST" action="<?= site_url('config/add_route') ?>">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Rewrite" name="rewrite">
					</div>

					<div class="form-group">
						<input type="text" class="form-control" placeholder="Execute" name="execute">
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Add route</button>

					</div>
				</form>
			</div>
		</div>
	</div>


	<div class="panel panel-default">
	  <!-- Default panel contents -->
	  <div class="panel-heading">
	  	<h3 class="panel-title">All available routes</h3>
	  	</div>
		
		<? if ($this->session->get('delete_reserved_route', 'config')): ?>
			<div class="alert alert-danger"><?= $this->session->flash('delete_reserved_route', 'config') ?></div>
		<? endif; ?>

	  <div class="spacer10"></div>

		<table class="table">
			<thead>
				<tr>
					<th>Rewrite</th>
					<th>Execute</th>
					<th>Actions</th>
				</tr>
			</thead>

			<tbody>
				<? foreach ($routes as $pattern => $route): ?>

				<tr>
					<td><?= $pattern ?></td>
					<td><?= $route ?></td>


					<? if (in_array($pattern, array('default_controller', '404_override'))): ?>
						<td><a class="btn btn-danger" disabled="disabled"><i class="fa fa-trash-o"></i> Delete</a></td>
					<? else: ?>
						<td>

							<form method="post" action="<?= site_url('config/delete_route') ?>">
								<input type="hidden" name="pattern" value="<?= $pattern ?>" />
								<button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete</button>
							</form>

						</td>
					<? endif; ?>

				</tr>

				<? endforeach; ?>
		</tbody>
	</table>
	</div>

</div>