
<? if ($logs): ?>

<table class="table table-striped">
  <thead>
  	<tr>
  		<th>Label</th>
  		<th>Date</th>
  		<th>Description</th>
  	</tr>
  </thead>
  <tbody>


  		<? foreach($logs as $log): ?>

		  	<tr>
		  		<td><span class="label <?= $log['css_label'] ?>"><?= $log['label'] ?></span></td>
		  		<td><?= $log['date_human'] ?></td>
		  		<td><?= $log['description'] ?></td>
		  	</tr>

		<? endforeach; ?>

  </tbody>
</table>
</div>

<? else: ?>

  <div class="alert alert-warning"><strong>Ooops !</strong> <small>Nothing to display.</smalL></div>

<? endif; ?>