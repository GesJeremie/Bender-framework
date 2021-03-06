<div class="container">
	<div class="spacer40"></div>



	<div class="page-header"><h1>Crafter v0.1 <small>Your favorite tool to manage your application</small></h1></div>

	<p>Crafter is a simple tool to manage your web application built with Bender Framework. In this current version (v<?= $this->config->item('app_version') ?>), you can manage your logs, edit the configuration
		of your application and auto-generate skeleton codes.</p>

		<div class="spacer30"></div>

		<div class="panel panel-default">

			<div class="panel-heading">Tools available</div>

			<table class="table table-striped">
				<tbody>
					<tr>
						<td>Logs</td>
						<td>Manage your logs generated by your web application</td>
						<td><a href="<?= site_url('logs') ?>" class="btn btn-primary">Start</a></td>
					</tr>

					<tr>
						<td>Configuration</td>
						<td>Edit configuration of your web application (database, routes, etc. )</td>
						<td><a href="<?= site_url('config') ?>" class="btn btn-primary">Start</a></td>
					</tr>

					<tr>
						<td>Skeleton</td>
						<td>Auto-generate skeleton codes</td>
						<td><a href="<?= site_url('skeleton') ?>" class="btn btn-primary">Start</a></td>
					</tr>

				</tbody>
			</table>
		</div>





	</div>
