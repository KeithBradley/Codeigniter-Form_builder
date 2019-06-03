<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form_builder
{
	////////////////////
	// PUBLIC METHODS //
	////////////////////

	public function generate($fields = array(), $form_tags = true, $validation = true, $submit_options = array())
	{
		$html = ( $form_tags ? $this->form_open() : '');
			$html .= ( $form_tags && $validation ? validation_errors() : '');

			foreach ( $fields as $index => $field ) {
				$html .= $this->{$field['type']}($field);
			}

			$html .= ( $form_tags || $submit_options ? $this->form_submit($submit_options) : '');
	
		$html .= ( $form_tags ? $this->form_close() : '');
		
		return $html;
	}

	public function form_open()
	{
		return form_open( ( site_url(uri_string(), null, get_instance()->input->get()) ) );
	}

	public function form_close()
	{
		return form_close();
	}

	public function form_submit($submit_options = array())
	{
		return '<hr class="my-4">' . $this->submit($submit_options);
	}

	/**
	 * GENERATE TEXT FIELD
	 */
	public function text($options, $label = true, $help = true)
	{
		return $this->field_wrapper( $this->input($options), ( $label ? $this->label($options) : '' ), ( $help ? $this->help($options) : '' ) );
	}


	/**
	 * GENERATE DATE FIELD
	 */
	public function date($options, $label = true, $help = true)
	{
		$hidden_name = $options['input']['name'];
		$hidden_value = ! empty($options['input']['value']) ? $options['input']['value'] : '';

		$options['input']['value'] = ! empty($options['input']['value']) ? date('m/d/Y', strtotime($options['input']['value'])) : '';
		$options['input']['class'] = ! isset($options['input']['class']) ? 'date-picker' : $options['input']['class'] . ' date-picker';

		return $this->field_wrapper( $this->input($options) . form_hidden($hidden_name, $hidden_value), ( $label ? $this->label($options) : '' ), ( $help ? $this->help($options) : '' ) );
	}


	/**
	 * GENERATE TEXTAREA FIELD
	 */
	public function textarea($options, $label = true, $help = true)
	{
		return $this->field_wrapper( $this->input($options), ( $label ? $this->label($options) : '' ), ( $help ? $this->help($options) : '' ) );
	}


	/**
	 * GENERATE HIDDN FIELD
	 */
	public function hidden($options, $label = true, $help = true)
	{
		return $this->input($options);
	}


	/**
	 * GENERATE PASSWORD FIELD
	 */
	public function password($options, $label = true, $help = true)
	{
		return $this->field_wrapper( $this->input($options), ( $label ? $this->label($options) : '' ), ( $help ? $this->help($options) : '' ) );
	}


	/**
	 * GENERATE DRODOWN FIELD
	 */
	public function dropdown($options, $label = true, $help = true)
	{
		return $this->field_wrapper( $this->input($options), ( $label ? $this->label($options) : '' ), ( $help ? $this->help($options) : '' ) );
	}


	/**
	 * GENERATE CHECKBOX FIELD
	 */
	public function checkbox($options, $label = true, $help = true)
	{
		return $this->field_wrapper( $this->input($options), ( $label ? $this->label($options) : '' ), ( $help ? $this->help($options) : '' ) );
	}


	/**
	 * GENERATE RADIO FIELD
	 */
	public function radio($options, $label = true, $help = true)
	{
		return $this->field_wrapper( $this->input($options), ( $label ? $this->label($options) : '' ), ( $help ? $this->help($options) : '' ) );
	}


	/**
	 * GENERATE SUBMIT INPUT
	 */
	public function submit($options = array())
	{
		return '<input type="submit" 
			name="' . ( ! empty($options['name']) ? $options['name'] : 'save' ) . '" 
			value="' . ( ! empty($options['value']) ? $options['value'] : 'Save' ) . '" 
			class="' . ( ! empty($options['class']) ? $options['class'] : 'btn btn-primary' ) . '">';
	}


	/////////////////////
	// PRIVATE METHODS //
	/////////////////////


	/**
	 * ALL INPUTS RUN THROUGH THIS
	 */
	public function input($options)
	{
		if ( method_exists($this, 'input_' . $options['type']) ) {
			return $this->{'input_' . $options['type']}($options);
		} else {
			return 'invalid input type';
		}
	}


	/**
	 * GENERATE LABEL
	 */
	private function label($options)
	{
		return ! empty($options['label']) ? '<label>' . $options['label'] . '</label>' : '';
	}


	/**
	 * GENERATE HELP
	 */
	private function help($options)
	{
		return ! empty($options['help']) ? '<div class="help"><small class="text-muted">' . $options['help'] . '</small></div>' : '';
	}


	/**
	 * ALL FIELD WRAPPERS
	 */
	private function field_wrapper($input, $label = null, $help = null)
	{
		return '<div class="form-group">' . $label . $input . $help . '</div>';
	}


	/////////////////
	// INPUT TYPES //
	/////////////////

	/**
	 * TEXT
	 */
	private function input_text($options)
	{
		$options['input']['class'] = ! isset($options['input']['class']) ? 'form-control' : $options['input']['class'] . ' form-control';

		return form_input($options['input']);
	}


	/**
	 * DATE
	 */
	private function input_date($options)
	{
		$options['input']['class'] = ! isset($options['input']['class']) ? 'form-control' : $options['input']['class'] . ' form-control';

		return form_input($options['input']);
	}


	/**
	 * TEXTAREA
	 */
	private function input_textarea($options)
	{
		$options['input']['rows'] = ! isset($options['input']['rows']) ? 5 : $options['input']['class'];
		$options['input']['class'] = ! isset($options['input']['class']) ? 'form-control' : $options['input']['class'] . ' form-control';

		return form_textarea($options['input']);
	}


	/**
	 * HIDDEN
	 */
	private function input_hidden($options)
	{
		return form_hidden($options['input']['name'], $options['input']['value']);
	}


	/**
	 * PASSWORD
	 */
	private function input_password($options)
	{
		$options['input']['class'] = ! isset($options['input']['class']) ? 'form-control' : $options['input']['class'] . ' form-control';
	
		return form_password($options['input']);
	}


	/**
	 * DROPDOWN
	 */
	private function input_dropdown($options)
	{
		$options['input']['class'] = ! isset($options['input']['class']) ? 'form-control' : $options['input']['class'] . ' form-control';

		return form_dropdown($options['input']);
	}

	
	/**
	 * CHECKBOX
	 */
	private function input_checkbox($options)
	{
		if ( ! empty($options['input'][0]) && is_array($options['input'][0]) ) {
			$html = '';

			if ( isset($options['inline']) && $options['inline'] ) {
				$html .= '<div class=""></div>';
			}

			// LOOP THROUGH MANY CHECKBOXES
			foreach ( $options['input'] as $input ) {
				$field_settings = $options;
				$field_settings['input'] = $input;
				$html .= $this->input_checkbox( $field_settings );
			}

			return $html;
		} else {

			// ADD LABEL
			$options['input']['label'] = ! empty($options['input']['label']) ? $options['input']['label'] : '';

			// ADD BOOTSTRAP CLASS
			$options['input']['class'] = ! empty($options['input']['class']) ? $options['input']['class'] . ' custom-control-input' : 'custom-control-input';
				
			// ADD FIELD ID
			$options['input']['id'] = ! empty($options['input']['id']) ? $options['input']['id'] : url_title($options['input']['name']);

			// GENERATE FORM
			$html = '<div class="custom-control custom-checkbox'  . ( isset($options['inline']) && $options['inline'] ? ' custom-control-inline' : '' ) . '">';
				$html .= isset($options['default']) ? form_hidden($options['input']['name'], $options['default']) : '';
				$html .= form_checkbox($options['input']);
				$html .= '<label class="custom-control-label" for="' . $options['input']['id'] . '">' . $options['input']['label'] . '</label>';
			$html .= '</div>';

			return $html;
		}
	}

	
	/**
	 * RADIO
	 */
	private function input_radio($options)
	{
		if ( ! empty($options['input'][0]) && is_array($options['input'][0]) ) {
			$html = '';

			if ( isset($options['inline']) && $options['inline'] ) {
				$html .= '<div class=""></div>';
			}

			// LOOP THROUGH MANY CHECKBOXES
			foreach ( $options['input'] as $input ) {
				$field_settings = $options;
				$field_settings['input'] = $input;
				$html .= $this->input_radio( $field_settings );
			}

			return $html;
		} else {

			// ADD LABEL
			$options['input']['label'] = ! empty($options['input']['label']) ? $options['input']['label'] : '';

			// ADD BOOTSTRAP CLASS
			$options['input']['class'] = ! empty($options['input']['class']) ? $options['input']['class'] . ' custom-control-input' : 'custom-control-input';
				
			// ADD FIELD ID
			$options['input']['id'] = ( ! empty($options['input']['id']) ? $options['input']['id'] : url_title($options['input']['name']) )
									. ( ! empty($options['input']['value']) ? '_' . $options['input']['value'] : '_' . rand(100,9999) );

			// GENERATE FORM
			$html = '<div class="custom-control custom-radio' . ( isset($options['inline']) && $options['inline'] ? ' custom-control-inline' : '' ) . '">';
				// $html .= isset($options['default']) ? form_hidden($options['input']['name'], $options['default']) : '';
				$html .= form_radio($options['input']);
				$html .= '<label class="custom-control-label" for="' . $options['input']['id'] . '">' . $options['input']['label'] . '</label>';
			$html .= '</div>';

			return $html;
		}
	}


	//////////////
	// REPEATER //
	//////////////

	public function repeater($view, $group = 'row', $fields = array(), $inline = true)
	{

		$html = '<div class="repeater">';
			$html .= '<div data-repeater-list="' . $group . '">';
				if ( isset($fields[0]) ) {
					foreach ( $fields as $field_row ) {
						$html .= '<div data-repeater-item class="p-4 bg-light border">';
							$html .= '<div class="' . ($inline ? 'r-group d-flex align-items-center' : 'r-group') . '">';
								$html .= get_instance()->load->view($view, array( 'fields' => $field_row), true);
								$html .= '<div class="' . ($inline ? 'ml-auto' : '') . '">';
									$html .= '<span class="btn btn-secondary btn-sm drag mr-1">Move</span>';
									$html .= '<input data-repeater-delete class="btn btn-danger btn-sm" type="button" value="Delete"/>';
								$html .= '</div>';
							$html .= '</div>';
						$html .= '</div>';
					}
				} else {
					$html .= '<div data-repeater-item class="p-4 bg-light border">';
						$html .= '<div class="' . ($inline ? 'r-group d-flex align-items-center' : 'r-group') . '">';
							$html .= get_instance()->load->view($view, array( 'fields' => $fields), true);
							$html .= '<div class="' . ($inline ? 'ml-auto' : '') . '">';
								$html .= '<span class="btn btn-secondary btn-sm drag mr-1">Move</span>';
								$html .= '<input data-repeater-delete class="btn btn-danger btn-sm" type="button" value="Delete"/>';
							$html .= '</div>';
						$html .= '</div>';
					$html .= '</div>';
				}
			$html .= '</div>';
			$html .= '<input data-repeater-create class="btn btn-success btn-sm mt-4" type="button" value="Add Row">';
		$html .= '</div>';
		
		return $html;
	}
}
