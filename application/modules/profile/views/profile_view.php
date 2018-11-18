<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title"><?php echo ($title != NULL) ? $title : '' ?></h4>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-hover">
								<tr>
									<td>Email</td>
									<td>:</td>
									<td><?php echo $user['user_email'] ?></td>
								</tr>
								<tr>
									<td>Full Name</td>
									<td>:</td>
									<td><?php echo $user['user_full_name'] ?></td>
								</tr>
								<tr>
									<td>Roles</td>
									<td>:</td>
									<td><?php echo $user['role_name'] ?></td>
								</tr>
								<tr>
									<td>Created Date</td>
									<td>:</td>
									<td><?php echo pretty_date($user['user_input_date'],'d F Y',false) ?></td>
								</tr>
							</table>
							<a href="<?php echo site_url('manage') ?>" class="btn btn-primary btn-sm">Back</a>
							<a href="<?php echo site_url('manage/profile/edit') ?>" class="btn btn-success btn-sm">Edit</a>
							<a href="<?php echo site_url('manage/profile/cpw') ?>" class="btn btn-warning btn-sm">Reset Password</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>