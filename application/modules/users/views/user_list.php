<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title"><?php echo $title ?> <a href="<?php echo site_url('manage/users/add') ?>" class="btn btn-success btn-round btn-icon btn-sm"><i class="fa fa-plus"></i></a></h4>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table">
						<thead class=" text-primary">
							<th>No</th>
							<th>Email</th>
							<th>Full Name</th>
							<th>Roles</th>
							<th>Action</th>
						</thead>
						<tbody>
							<?php
							if (!empty($user)) {
								$i = 1;
								foreach ($user as $row):
									?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $row['user_email']; ?></td>
										<td><?php echo $row['user_full_name']; ?></td>
										<td><?php echo $row['role_name']; ?></td>
										<td>
											<?php if ($this->session->userdata('uid') != $row['user_id']) { ?>
												<a href="<?php echo site_url('manage/users/view/' . $row['user_id']) ?>" class="btn btn-info btn-round btn-icon btn-sm"><i class="fa fa-eye"></i></a>
											<?php } else { ?>
												<a href="<?php echo site_url('manage/profile') ?>" class="btn btn-info btn-round btn-icon btn-sm"><i class="fa fa-eye"></i></a>
											<?php } ?>
											<?php if ($this->session->userdata('uid') != $row['user_id']) { ?>
												<a href="<?php echo site_url('manage/users/rpw/' . $row['user_id']) ?>" class="btn btn-warning btn-round btn-icon btn-sm"><i class="fa fa-lock"></i></a>
											<?php } else {
												?>
												<a href="<?php echo site_url('manage/profile/cpw/'); ?>" class="btn btn-warning btn-round btn-icon btn-sm"><i class="fa fa-rotate-left"></i></a>
											<?php } ?>

										</td>	
									</tr>
									<?php
									$i++;
								endforeach;
							} else {
								?>
								<tr id="row">
									<td colspan="6" align="center">Data Empty</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			<?php echo $this->pagination->create_links(); ?>
		</div>
	</div>
</div>