
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

				<li><a href="<?= site_url('logs') ?>">Tout voir</a></li>
				
				<? foreach ($dates as $date): ?>

					<? if ($date['date_human'] == $header_date): ?>

						<li class="active"><a href="<?= site_url('logs/dates/' . $date['date_raw']) ?>"><?= $date['date_human'] ?></a></li>

					<? else: ?>

						<li><a href="<?= site_url('logs/dates/' . $date['date_raw']) ?>"><?= $date['date_human'] ?></a></li>

					<? endif; ?>

				<? endforeach; ?>

			</ul>
		</div> <!-- /btn-group -->

	<? endif; ?>

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
			  		<td><span class="label <?= $log['css_label'] ?>"><?= $log['label'] ?></span></td>
			  		<td><?= $log['date_fr'] ?></td>
			  		<td><?= $log['description'] ?></td>
			  	</tr>

			<? endforeach; ?>
	  	<? endif; ?>

	  </tbody>
	</table>

</div>