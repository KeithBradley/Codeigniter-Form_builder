<?php echo $this->form_builder->form_open(); ?>
	<?php echo validation_errors(); ?>	

	<?php echo $this->form_builder->text($fields['overview']['title']); ?>	
	<?php echo $this->form_builder->textarea($fields['overview']['description']); ?>	

	<h4>Event Dates</h4>
	<?php echo $this->form_builder->repeater('admin/events/form_dates', 'dates', $fields['dates'], false); ?>

	<hr>

	<?php echo $this->form_builder->submit(); ?>

<?php echo $this->form_builder->form_close(); ?>	
