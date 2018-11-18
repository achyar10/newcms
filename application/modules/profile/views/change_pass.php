<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title"><?php echo ($title != NULL) ? $title : '' ?></h4>
			</div>
			<div class="card-body mb-3">
				<?php echo form_open(current_url()); ?>
				<div class="row">
					<div class="col-md-9">
						<?php echo validation_errors(); ?>
						<?php if ($this->uri->segment(3) == 'cpw') { ?>
							<div class="form-group">
								<label >Old Password *</label>
								<input type="password" name="user_current_password" class="form-control" placeholder="Old Password">
							</div>
						<?php } ?>
						<div class="form-group">
							<label>New Password*</label>
							<input type="password" name="user_password" class="form-control" placeholder="New Password">
							<?php if ($this->uri->segment(3) == 'cpw') { ?>
								<input type="hidden" name="user_id" value="<?php echo $this->session->userdata('uid'); ?>" >
							<?php } else { ?>
								<input type="hidden" name="user_id" value="<?php echo $user['user_id'] ?>" >
							<?php } ?>
						</div>
						<div class="form-group">
							<label> New Password Confirmation*</label>
							<input type="password" name="passconf" class="form-control" placeholder="New Password Confirmation" >
						</div>
					</div>
					<div class="col-md-3">
						<div class="mt-4">
							<button type="submit" class="btn btn-block btn-success">Save</button>
							<a href="<?php echo site_url('manage/profile'); ?>" class="btn btn-block btn-secondary">Cancel</a>
						</div>
					</div>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>


