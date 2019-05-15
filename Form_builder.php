<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form_builder
{
	////////////////////
	// PUBLIC METHODS //
	////////////////////

	public function generate($fields = array(), $form_tags = true, $validation = true, $submit_options = array())
	{
		$html = ( $form_tags ? form_open() : '');
			$html .= ( $form_tags && $validation ? validation_errors() : '');

			foreach ( $fields as $index => $field ) {
				$html .= $this->{$field['type']}($field);
			}

			$html .= ( $form_tags || $submit_options ? $this->submit($submit_options) : '');
	
		$html .= ( $form_tags ? form_close() : '');
		
		return $html;
	}

	/**
	 * GENERATE TEXT FIELD
	 */
	public function text($options, $label = true, $help = true)
	{
		return $this->field_wrapper( $this->input($options), ( $label ? $this->label($options) : '' ), ( $help ? $this->help($options) : '' ) );
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
	private function input($options)
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
		return form_input($options['input']);
	}


	/**
	 * PASSWORD
	 */
	private function input_password($options)
	{
		return form_password($options['input']);
	}


	/**
	 * DROPDOWN
	 */
	private function input_dropdown($options)
	{
		return form_dropdown($options['input']);
	}

	
	/**
	 * CHECKBOX
	 */
	private function input_checkbox($options)
	{
		if ( ! empty($options['input'][0]) && is_array($options['input'][0]) ) {
			$html = '';

			// LOOP THROUGH MANY CHECKBOXES
			foreach ( $options['input'] as $input ) {
				$html .= $this->input_checkbox( array( 'input' => $input ) );
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
			$html = '<div class="custom-control custom-checkbox">';
				$html .= isset($options['default']) ? form_hidden($options['input']['name'], $options['default']) : '';
				$html .= form_checkbox($options['input']);
				$html .= '<label class="custom-control-label" for="' . $options['input']['id'] . '">' . $options['input']['label'] . '</label>';
			$html .= '</div>';

			return $html;
		}
	}
}