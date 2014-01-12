<div class="container">
	<div class="page-header"><h1>Skeleton <small>Stop doing the dirty work</small></h1> </div>

	<!-- Skeleton Model notifications -->
	<? if ($this->session->get('create_model_error', 'skeleton')): ?>
		<div class="alert alert-danger"><?= $this->session->flash('create_model_error', 'skeleton') ?></div>
	<? endif; ?>


	<? if ($this->session->get('create_model_built_success', 'skeleton')): ?>
		<div class="alert alert-success"><?= $this->session->flash('create_model_built_success', 'skeleton') ?></div>
	<? endif; ?>


	<? if ($this->session->get('create_model_built_error', 'skeleton')): ?>
		<div class="alert alert-danger"><?= $this->session->flash('create_model_built_error', 'skeleton') ?></div>
	<? endif; ?>

	<!-- Skeleton Controller notifications -->
	<? if ($this->session->get('create_controller_error', 'skeleton')): ?>
		<div class="alert alert-danger"><?= $this->session->flash('create_controller_error', 'skeleton') ?></div>
	<? endif; ?>


	<? if ($this->session->get('create_controller_built_success', 'skeleton')): ?>
		<div class="alert alert-success"><?= $this->session->flash('create_controller_built_success', 'skeleton') ?></div>
	<? endif; ?>


	<? if ($this->session->get('create_controller_built_error', 'skeleton')): ?>
		<div class="alert alert-danger"><?= $this->session->flash('create_controller_built_error', 'skeleton') ?></div>
	<? endif; ?>


	<table class="table">
		<thead>
			<tr>
				<th>Skeleton type</th>
				<th>Description</th>
				<th>Action</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td>Create model</td>
				<td>Create simple skeleton model</td>
				<td><a class="btn btn-primary" data-toggle="modal" data-target="#modal-create-skeleton-model"><i class="fa fa-magic"></i> Build</a></td>
			</tr>
			<tr>
				<td>Create controller</td>
				<td>Create simple skeleton controller</td>
				<td><a class="btn btn-primary" data-toggle="modal" data-target="#modal-create-skeleton-controller"><i class="fa fa-magic"></i> Build</a></td>
			</tr>
		</tbody>
	</table>



	<!-- Modal build skeleton model -->
	<div class="modal fade" id="modal-create-skeleton-model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Create skeleton model</h4>
				</div>
				<form method="post" action="<?= site_url('skeleton/create_skeleton_model') ?>" class="form-inline" role="form">

					<div class="modal-body text-center">
						<div class="form-group">
							<input class="form-control" type="text" placeholder="Model's name" name="name_model" /> 
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary"><i class="fa fa-magic"></i> Create skeleton</button>

						</div>
					</div>

				</form>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->


	<!-- Modal build skeleton controller -->
	<div class="modal fade" id="modal-create-skeleton-controller" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Create skeleton controller</h4>
				</div>
				<form method="post" action="<?= site_url('skeleton/create_skeleton_controller') ?>" class="form-inline" role="form">

					<div class="modal-body text-center">
						<div class="form-group">
							<input class="form-control" type="text" placeholder="Controller's name" name="name_controller" /> 
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary"><i class="fa fa-magic"></i> Create skeleton</button>
						</div>
					</div>
				</form>

				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

	</div>