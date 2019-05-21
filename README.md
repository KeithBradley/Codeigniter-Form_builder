# Codeigniter-Form_builder
Very simple library for building bootstrap 4 forms in Codeigniter.

The library only includes text, password, checkbox, checkboxes and dropdown fields currently. Others can easily be added though by editing the library.

## Install

1. Upload Form_builder.php to your libraries directory in the application folder
2. Autoload the library from the autoloader or manually load somewhere like a controller
3. (Optional) Update the core form_helper file to include default css classes for bootstrap.
4. Add 'class' => 'form-control' to line 238 and 368


### (Optional) Repeatable Fields
Include the class has a field repeater built in, which allows drag-drop ordering and javascript adding/deleting of rows.  

Include these JS libraries:

https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js
https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js
https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.js

And add this to a scripts file:
~~~
	var dragDrop = $('[data-repeater-list]').sortable({
		axis: 'y',
		cursor: 'pointer',
		opacity: 0.5,
		placeholder: 'repeater-list-row-dragging',
		delay: 150,
		handle: '.drag',
		start: function(e, ui){
			ui.placeholder.height(ui.item.height());
		},
		update: function(event, ui) {
			$('.repeater').repeater('setIndexes');
		}
	});

	var repeater = $('.repeater').repeater({
		initval: 1,
		ready: function(setIndexes){
			dragDrop.on('drop', setIndexes);
		},
		show: function () {
			$(this).slideDown();
		},
		hide: function (deleteElement) {
			if ( confirm('Are you sure you want to delete this row?') ) {
				$(this).slideUp(deleteElement);
			}
		},
	});
~~~

## Usage

1. Define fields as an array in your model or controller

~~~~
$this->data['fields'] = array(
			'email' => array(
				'type' => 'dropdown',
				'label' => 'Email Address',
				'input' => array(
					'name' => 'auth[email]',
					'value' => '' // $this->form_validation->set_value()
				)
			),
			'password' => array(
				'type' => 'password',
				'label' => 'Password',
				'help' => 'Some help text',
				'input' => array(
					'name' => 'auth[password]',
					'value' => '' // $this->form_validation->set_value()
				)
			),
			'remember' => array(
				'type' => 'checkbox',
				'label' => false,
				'default' => 'N',
				'input' => array(
					'id' => 'remember',
					'label' => 'Remember Me',
					'value' => 'Y'
				)
			),
		);
    
// OPTIONAL
$this->data['submit_btn_options'] = array(
  'name' => 'submit',
  'value' => 'Save Changes',
  'class' => 'btn btn-primary',
);
~~~~

2. On the view call either an individual field with:
~~~~
<?php echo $this->form_builder->text($fields['email']); ?>
~~~~

or generate the whole form with: 
~~~~
<?php echo $this->form_builder->generate($fields, $include_form_tags = true, $submit_btn_options); ?>
~~~~

## Methods
### generate
Params:
1. Array of fields
2. Bool to include form tags
3. Bool to display validation errors
4. Array of options to pass to the submit button

### input
1. Array of single field

### form_open
No options

### form_close
No options

### form_submit
1. Array of submit button options

### text
1. Array of field options
2. Bool to include label
3. Bool to include Help text

### date
1. Array of field options
2. Bool to include label
3. Bool to include Help text

This method will generate an additional hidden field after which stores the altDate (JQUERY UI).

~~~
$('input.date-picker').each(function() {
	$(this).datepicker({
		altField: $(this).parents('div.form-group').find('input[type=hidden]'),
		altFormat: 'yy-mm-dd',
		dateFormat: 'dd/mm/yy',
	});
});
~~~

### textarea
1. Array of field options
2. Bool to include label
3. Bool to include Help text

### hidden
1. Array of field options
2. Bool to include label
3. Bool to include Help text

### password
1. Array of field options
2. Bool to include label
3. Bool to include Help text

### dropdown
1. Array of field options
2. Bool to include label
3. Bool to include Help text### checkbox

### submit
1. Array of submit options (name, value, class)

### repeater
1. String to a View file to repeat
2. Field group E.g. row[0] the group is 'row'
3. $fields array of fields to pass to repeater

~~~
$fields[0] = array(
	array( 'type' => text, 'input' => array( 'name' => 'row[0][name]', 'value' => 123 ....
	array( 'type' => text, 'input' => array( 'name' => 'row[0][other_field]', 'value' => 123 ....
);
$fields[1] = array(
	array( 'type' => text, 'input' => array( 'name' => 'row[1][name]', 'value' => 123 ....
	array( 'type' => text, 'input' => array( 'name' => 'row[1][other_field]', 'value' => 123 ....
);
~~~
