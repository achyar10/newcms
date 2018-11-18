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
						<form action="<?php echo current_url() ?>" method="post">
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

							<div class="form-group">
								<label>Roles <small>*</small></label>
								<select name="role_id" class="form-control">
									<option value="">-Select Roles-</option>
									<?php foreach ($roles as $row): ?> 
										<option value="<?php echo $row['role_id']; ?>" <?php echo ($inputRoleValue == $row['role_id']) ? 'selected' : '' ?>><?php echo $row['role_name']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="mt-4">
								<button type="submit" class="btn btn-success btn-block">Save</button>
								<a href="<?php echo site_url('manage/users') ?>" class="btn btn-dark btn-block">Cancel</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<script type="text/javascript">
	$('form').submit(function(event) {
		if ($(this).hasClass('submitted')) {
			event.preventDefault();
		} else {
			$(this).find(':submit')
			.html('<i class="fa fa-spinner fa-spin"></i> Saving...')
			.attr('disabled', 'disabled');
			$(this).addClass('submitted');
		}
	});
</script>