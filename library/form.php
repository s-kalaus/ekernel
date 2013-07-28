<?php

class k_form {
	public $group = array();
	public $view = null;
	public $class = '';
	public $class_element_control = '';
	public $class_element_frame = '';
	public $class_element_error = '';
	public $class_element_text = '';
	public $class_element_textarea = '';
	public $class_element_select = '';
	public $error_view_script = 'form/error';
	public $element_view_script = 'form/element';
	public $view_script = 'form/form';
	public $action = '';
	public $method = 'post';
	public $enctype = 'multipart/form-data';
	public $element = null;

	public function __construct($param = array()) {
		if (isset($param['element_view_script'])) $this->element_view_script = $param['element_view_script'];
		if (isset($param['error_view_script'])) $this->error_view_script = $param['error_view_script'];
		if (isset($param['view_script'])) $this->view_script = $param['view_script'];
		if (isset($param['class'])) $this->class = $param['class'];
		if (isset($param['class_element_frame'])) $this->class_element_frame = $param['class_element_frame'];
		if (isset($param['class_element_control'])) $this->class_element_control = $param['class_element_control'];
		if (isset($param['class_element_error'])) $this->class_element_error = $param['class_element_error'];
		if (isset($param['class_element_text'])) $this->class_element_text = $param['class_element_text'];
		if (isset($param['class_element_textarea'])) $this->class_element_textarea = $param['class_element_textarea'];
		if (isset($param['class_element_select'])) $this->class_element_select = $param['class_element_select'];
		if (isset($param['action'])) $this->action = $param['action'];
		if (isset($param['method'])) $this->method = $param['method'];
		if (isset($param['enctype'])) $this->enctype = $param['enctype'];
		$this->view = application::get_instance()->controller->view;
		$this->element = new data;
	}

	public function render() {
		return $this->view->render($this->view_script, array(
			'class' => $this->class,
			'action' => $this->action,
			'method' => $this->method,
			'enctype' => $this->enctype,
			'element' => $this->element,
			'group' => $this->group,
			'error_view_script' => $this->error_view_script
		));
	}

	public function add($type, $name, $param = array()) {
		$class = 'form_element_'.$type;
		if (!isset($param['class_frame']) && $this->class_element_frame) $param['class_frame'] = $this->class_element_frame;
		if (!isset($param['class_control']) && $this->class_element_control) $param['class_control'] = $this->class_element_control;
		if (!isset($param['class_error']) && $this->class_element_error) $param['class_error'] = $this->class_element_error;
		if (!isset($param['frame_view_script']) && $this->element_view_script) $param['frame_view_script'] = $this->element_view_script;
		if (($type == 'text' || $type == 'date' || $type == 'password') && !isset($param['class']) && $this->class_element_text) $param['class'] = $this->class_element_text;
		if ($type == 'textarea' && !isset($param['class']) && $this->class_element_textarea) $param['class'] = $this->class_element_textarea;
		if ($type == 'select' && !isset($param['class']) && $this->class_element_select) $param['class'] = $this->class_element_select;
		$this->element->$name = new $class($name, $param);
	}

	public function populate($data) {
		if ($this->element) {
			foreach ($this->element as $k => $el) {
				if (!isset($data[$k])) continue;
				$el->set($data[$k]);
			}
		}
	}

	public function validate($data) {
		$ok = true;
		if ($this->element) {
			foreach ($this->element as $k => $el) {
				if (!isset($data[$k]) && !($el instanceof form_element_file)) $data[$k] = '';
				$el->validate($data[$k]);
				if ($el->get_error()) $ok = false;
			}
		}
		return $ok;
	}

	public function get() {
		$data = array();
		if ($this->element) {
			foreach ($this->element as $k => $el) {
				if (!$k) continue;
				$data[$k] = $el->get();
				if ($el instanceof form_element_file && !$data[$k]) unset($data[$k]);
			}
		}
		return $data;
	}

	public function __toString() {
		return (string)$this->render();
	}

	public function add_display_group($els, $name, $param = array()) {
		if (!isset($param['view_script'])) $param['view_script'] = 'form/group';
		$form = new form($param);
		foreach ($els as $el) {
			$form->element->$el = clone $this->element->$el;
			unset($this->element->$el);
		}
		$this->group[$name] = $form;
	}
}