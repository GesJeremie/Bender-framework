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
 
</div>