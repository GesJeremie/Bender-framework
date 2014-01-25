
<div class="container">

<div class="page-header">
	<h1>Logs <small>What's happen in the core of my application</small></h1>

</div>

<!-- Check session -->
<? if ($this->session->has('deleted_file')): ?>
	
	<? if ($this->session->flash('deleted_file')): ?>

		<div class="alert alert-success">Log file deleted</div>

	<? else: ?>

		<div class="alert alert-error">Unable to delete the log file</div>

	<? endif; ?>

<? endif; ?>

<? if ($dates): ?>

	<div class="btn-group">
		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
		  Display log by date <span class="caret"></span>
		</button>
		<ul class="dropdown-menu" role="menu">

		<? foreach ($dates as $date): ?>

			<li><a href="<?= site_url('logs/dates/' . $date['date_raw']) ?>"><?= $date['date_human'] ?></a></li>

		<? endforeach; ?>

		</ul>
	</div> <!-- /btn-group -->

<? endif; ?>

<div class="spacer30"></div>

<? $this->load->view('logs/table_results', $logs) ?>