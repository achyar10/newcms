<?php

if (isset($user)) {
	$id = $user['user_id'];
	$inputFullnameValue = $user['user_full_name'];
	$inputRoleValue = $user['role_role_id'];
	$inputEmailValue = $user['user_email'];

} else {
	$inputFullnameValue = set_value('user_full_name');
	$inputRoleValue = set_value('role_role_id');
	$inputEmailValue = set_value('user_email');
}
?>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title "><?php echo isset($title) ? $title : NULL ?></h4>
			</div>
			<hr class="mt-0 mb-0">
			<div class="card-body mb-3">
				<div class="row">
					<div class="col-md-9">
						<?php echo form_open(current_url()); ?>
						<?php echo validation_errors(); ?>
						<?php if (isset($user)) { ?>
							<input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
						<?php } ?>
						<div class="form-group">
							<label>Email <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<input name="user_email" type="text" class="form-control" <?php echo (isset($user)) ? 'disabled' : ''; ?> value="<?php echo $inputEmailValue ?>" placeholder="email">
						</div> 

						<div class="form-group">
							<label>Full Name <small>*</small></label>
							<input name="user_full_name" type="text" class="form-control" value="<?php echo $inputFullnameValue ?>" placeholder="Full Name">
						</div>

					</div>
					<div class="col-md-3">
						<div class="mt-4">
							<button type="submit" class="btn btn-success btn-block">Save</button>
							<a href="<?php echo site_url('manage/profile') ?>" class="btn btn-dark btn-block">Cancel</a>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>