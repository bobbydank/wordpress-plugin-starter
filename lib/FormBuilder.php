<?php

namespace CL\NAMESPACE;

// Form Helper
class FormBuilder {

	function __construct() { }

	function file($name, $label = NULL, $options = NULL) {
		if (!$name) return;
		
		$options['type'] = 'file';
		return $this->input($name, $label, $options);
	}

	function input($name, $label=NULL, $options=NULL, $inline = FALSE) {
		if (!$name) return;

		// Loop through options
		$opts = '';
		$label_opts = '';
		$label_options = '';
		$before = '';
		$after = '';
		if (!$options) {
			$options['type'] = 'text';
			$options['id'] = $name;
		} else {
			if (!isset($options['type'])) {
				$options['type'] = 'text';
			}
			if (isset($options['id']) && !$options['id']) {
				unset($options['id']);
			} else {
				if (!isset($options['id'])) {
					$options['id'] = $name;
				}
			}
			if (isset($options['label'])) {
				$label_options = $options['label'];
				unset($options['label']);
			}
			if (isset($options['before'])) {
				$before = $options['before'];
				unset($options['before']);
			}
			if (isset($options['after'])) {
				$after = $options['after'];
				unset($options['after']);
			}
		}
		/*if (isset($_POST[$name])) {
			$options['value'] = $_POST[$name];
		}*/

		$opts = $this->_parse_options($options);
		$label_opts = $this->_parse_options($label_options);

		$ret = '<input name="'.$name.'" '.$opts.' />';
		if ($label) {
			$ret = '<label for="'.$name.'" '.$label_opts.'>'.$label.'</label>' . $before . $ret . $after;
		} else {
			$ret = $before . $ret . $after;
		}

		$cc = '';
		if ($inline) {
			$cc = 'inline';
		}

		return '<div class="clearfix formbuilder ' . $options['type'] . ' ' . $cc . '">' . $ret . '</div>';
	}

	function textarea($name, $label=NULL, $options=NULL) {
		if (!$name) return;

		// Loop through options
		$opts = '';
		$label_opts = '';
		$label_options = '';
		$value = '';
		$before = '';
		$after = '';
		if (!$options) {
			$options['id'] = $name;
		} else {
			if (isset($options['id']) && !$options['id']) {
				unset($options['id']);
			} else {
				if (!isset($options['id'])) {
					$options['id'] = $name;
				}
			}
			if (isset($options['label'])) {
				$label_options = $options['label'];
				unset($options['label']);
			}
			if (isset($options['value'])) {
				$value = $options['value'];
				unset($options['value']);
			}
			if (isset($options['before'])) {
				$before = $options['before'];
				unset($options['before']);
			}
			if (isset($options['after'])) {
				$after = $options['after'];
				unset($options['after']);
			}
		}
		if (!isset($options['rows'])) {
			$options['rows'] = '8';
		}
		if (!isset($options['cols'])) {
			$options['cols'] = '40';
		}
		if (isset($_POST[$name])) {
			$value = $_POST[$name];
		}

		$opts = $this->_parse_options($options);
		$label_opts = $this->_parse_options($label_options);
		$ret = '<textarea name="'.$name.'" '.$opts.'>'.$value.'</textarea>';
		if ($label) {
			$ret = '<label for="'.$name.'" '.$label_opts.'>'.$label.'</label>' . $before . $ret . $after;
		}
		return '<div class="clearfix formbuilder textarea">' . $ret . '</div>';
	}

	function select($name, $option_array, $label=NULL, $options=NULL, $inline = FALSE) {
		if (!$name || !$option_array) return;

		$option_array = $this->_prep_array($option_array);

		// Check for "Select a xxxx..." text
		if (isset($option_array[1]) && is_array($option_array[1])) {
			$first_option = $option_array[0];
			$option_array = $option_array[1];
		}

		// Loop through options
		$opts = '';
		$label_opts = '';
		$label_options = '';
		$option_values = '';
		$selected = '';
		if (!$options) {
			$options['id'] = $name;
		} else {
			if (isset($options['id']) && !$options['id']) {
				unset($options['id']);
			} else {
				if (!isset($options['id'])) {
					$options['id'] = $name;
				}
			}
			if (isset($options['value'])) {
				$selected = $options['value'];
				unset($options['value']);
			}
			if (isset($options['label'])) {
				$label_options = $options['label'];
				unset($options['label']);
			}
		}
		if (isset($_POST[$name])) {
			$selected = $_POST[$name];
		}
		$opts = $this->_parse_options($options);
		$label_opts = $this->_parse_options($label_options);

		if (isset($first_option)) {
			if (is_array($first_option)) {
				$first_option_value = $first_option[0];
				$first_option = $first_option[1];
			} else {
				$first_option_value = '';
			}
			$option_values = '<option value="'.$first_option_value.'">'.$first_option.'</option>';
		}
		
		foreach ($option_array as $id => $text) {
			if (is_array($selected)) {
				$option_values .= '<option value="'.$id.'"'.(in_array($id, $selected) ? ' selected="selected"' : '').'>'.$text.'</option>';
			} else {
				$option_values .= '<option value="'.$id.'"'.($id == $selected ? ' selected="selected"' : '').'>'.$text.'</option>';
			}
		}
		if ($label) {
			$ret = '<label for="'.$options['id'].'" '.$label_opts.'>'.$label.'</label><div class="select-container"><select name="'.$name.'" '.$opts.'>' . $option_values . '</select></div>';
		} else {
			$ret = '<div class="select-container"><select name="'.$name.'" '.$opts.'>'.$option_values.'</select></div>';
		}

		$cc = '';
		if ($inline) {
			$cc = 'inline';
		}

		return '<div class="clearfix formbuilder select '.$cc.'">' . $ret . '</div>';
	}

	function radio($name, $option_array, $selected=NULL, $label=NULL, $options=NULL) {
		if (!$name || !$option_array) return;

		$option_array = $this->_prep_array($option_array);

		// Loop through options
		$opts = '';
		$option_values = '';
		if (!$options) {
			$options['id'] = $name;
		} else {
			if (isset($options['id']) && !$options['id']) {
				unset($options['id']);
			}
			if (isset($options['value'])) {
				$selected = $options['value'];
				unset($options['value']);
			}
		}
		if (isset($_POST[$name])) {
			$selected = $_POST[$name];
		}

		$opts = $this->_parse_options($options);

		foreach ($option_array as $id => $text) {
			$option_values .= '<div class="fb-flex-cont"><input type="radio" name="'.$name.'" value="'.$id.'" id="'.$name.'_'.strtolower($text).'"'.(isset($selected) && $id == $selected ? ' checked="checked"' : '').' /> <label class="radio" for="'.$name.'_'.strtolower($text).'">'.$text.'</label></div>';
		}
		$ret = $option_values;
		if ($label) {
			$ret = '<label>'.$label.'</label>' . $ret;
		}
		return '<div class="clearfix formbuilder radio">' . $ret . '</div>';
	}

	function checkbox($name, $value, $label=NULL, $options=NULL) {
		if (!$name || !$value) return;

		$input_value = $value;

		// Loop through options
		$opts = '';
		$label_options = '';
		$value = '';
		$before = '';
		$after  = '';
		if (!$options) {
			$options['id'] = $name;
		} else {
			if (isset($options['id']) && !$options['id']) {
				unset($options['id']);
			} else {
				if (!isset($options['id'])) {
					$options['id'] = $name;
				}
			}
			if (isset($options['label'])) {
				$label_options = $options['label'];
				unset($options['label']);
			}
			if (isset($options['value'])) {
				if ($options['value'] == $input_value) {
					$options['checked'] = 'checked';
				}
				unset($options['value']);
			}
			if (isset($options['before'])) {
				$before = $options['before'];
				unset($options['before']);
			}
			if (isset($options['after'])) {
				$after = $options['after'];
				unset($options['after']);
			}
		}

		$opts = $this->_parse_options($options);
		$label_opts = $this->_parse_options($label_options);

		$ret = '<input name="'.$name.'" type="checkbox" value="'.$input_value.'" '.$opts.' />';
		if ($label) {
			$ret = $before . $ret . $after . '<label for="'.$name.'" '.$label_opts.'>'.$label.'</label>';
		} else {
			$ret = $before . $ret . $after;
		}
		return '<div class="clearfix formbuilder checkbox"><div class="fb-flex-cont">' . $ret . '</div></div>';
	}

	function submit($name='submit', $value='Submit', $options=NULL) {
		if (!$options) $options = array();

		$options['type'] = 'submit';
		$options['value'] = $value;

		return $this->input($name, NULL, $options);
	}

	function cancel() {
		return $this->submit('cancel', 'Cancel', array('class'=>'cancel'));
	}

	function _parse_options($options) {
		if (!is_array($options)) {
			return '';
		}
		$opts = array();
		foreach ($options as $option => $value) {
			if ($option == 'link') continue;
			$opts[] = $option.'="'.$value.'"';
		}
		$opts = implode(' ', $opts);
		return $opts;
	}

	function _classify($string) {
		$whatToStrip = array("?","!",",",";",'.',"'","/","&","$");
		$string = str_replace($whatToStrip, "", strtolower($string));
		return str_replace(' ', '_', $string);
	}

	function _prep_array($option_array) {
		$t = array();
		foreach ($option_array as $key => $value) {
			$v = '';
			if ( is_numeric($key) ) {
				if ( $key === -1 ) {
					$v = $key;
				} else {
					$v = $this->_classify($value);
				}
			} else {
				$v = $key;
			}
			
			$t[$v] = $value;
		}
		return $t;
	}

}
