<style type="text/css">
	a {
		text-decoration: none !important;
	}
</style>
<div class="row">
	<div class="col-lg-4 col-md-6 col-sm-6">
		<div class="card card-stats">
			<div class="card-body ">
				<div class="row">
					<div class="col-5 col-md-4">
						<div class="icon-big text-center icon-warning">
							<i class="nc-icon nc-single-02 text-success"></i>
						</div>
					</div> 
					<div class="col-7 col-md-8">
						<div class="numbers">
							<p class="card-category">Total Branch</p>
							<p class="card-title"><?php echo '' ?></p>
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer ">
				<hr>
				<div class="stats">
					<a href="<?php echo site_url('merchant/merchant') ?>">
						<i class="nc-icon nc-zoom-split"></i> More List
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-md-6 col-sm-6">
		<div class="card card-stats">
			<div class="card-body ">
				<div class="row">
					<div class="col-5 col-md-4">
						<div class="icon-big text-center icon-info">
							<i class="nc-icon nc-tag-content text-info"></i>
						</div>
					</div>
					<div class="col-7 col-md-8">
						<div class="numbers">
							<p class="card-category">Total Lisence</p>
							<p class="card-title"><?php echo $total_register ?></p>
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer ">
				<hr>
				<div class="stats">
					<a href="<?php echo site_url('merchant/register') ?>">
						<i class="nc-icon nc-zoom-split"></i> More List
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-md-6 col-sm-6">
		<div class="card card-stats">
			<div class="card-body ">
				<div class="row">
					<div class="col-5 col-md-4">
						<div class="icon-big text-center icon-danger">
							<i class="nc-icon nc-single-02 text-danger"></i>
						</div>
					</div>
					<div class="col-7 col-md-8">
						<div class="numbers">
							<p class="card-category">Total Employee</p>
							<p class="card-title"><?php echo $total_employee ?></p>
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer ">
				<hr>
				<div class="stats">
					<a href="<?php echo site_url('merchant/users') ?>">
						<i class="nc-icon nc-zoom-split"></i> More List
					</a>
				</div>
			</div>
		</div>
	</div>
	
</div>
