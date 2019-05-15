# Codeigniter-Form_builder
Very simple library for assisting with bootstrap 4 forms.

The library only includes text, password and dropdown fields currently. They can easily be added though by editing the library.

## Install

1. Upload Form_builder.php to your libraries directory in the application folder
2. Autoload the library from the autoloader or manually load somewhere like a controller
3. (Optional) Update the core form_helper file to include default css classes for bootstrap.
3.1 Add 'class' => 'form-control' to line 238 and 368

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
			)
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
