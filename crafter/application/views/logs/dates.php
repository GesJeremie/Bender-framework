
<div class="container">

	<div class="page-header">
		<h1>Logs <small><?= $header_date ?></small></h1>

	</div>

	<? if ($dates): ?>

		<div class="btn-group">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">

				<?= $header_date ?> <span class="caret"></span>

			</button>
			<ul class="dropdown-menu" role="menu">

				<li><a href="<?= site_url('logs') ?>">View all</a></li>
				
				<? foreach ($dates as $date): ?>

					<? if ($date['date_human'] == $header_date): ?>

						<li class="active"><a href="<?= site_url('logs/dates/' . $date['date_raw']) ?>"><?= $date['date_human'] ?></a></li>

					<? else: ?>

						<li><a href="<?= site_url('logs/dates/' . $date['date_raw']) ?>"><?= $date['date_human'] ?></a></li>

					<? endif; ?>

				<? endforeach; ?>

			</ul>
		</div> <!-- /btn-group -->

		<button class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-log"><i class="fa fa-trash-o"></i> Delete log</button>

		<!-- Modal Delete log -->
		<div class="modal fade" id="modal-delete-log" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Delete file log <?= $get_date ?></h4>
		      </div>
		      <div class="modal-body">
		        Are you sure to delete this log ?<br/>
		        <div class="spacer30"></div>
		        <div class="alert alert-warning"><strong>Crafter will delete log file</strong> <small><?= $path_log . $get_date . '.php' ?></small></div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-reply"></i> Cancel</button>
		        <a href="<?= site_url('logs/delete/' . $get_date) ?>" type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete</a>


		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

	<? endif; ?>

	<div class="spacer30"></div>

	<? $this->load->view('logs/table_results', $logs) ?>