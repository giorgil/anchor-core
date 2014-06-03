<?php namespace Anchor\Forms;

use ArrayIterator;
use IteratorAggregate;

abstract class Form implements IteratorAggregate {

	protected $index = array();

	protected $fields = array();

	protected $attr = array(
		'method' => 'POST'
	);

	protected $values = array();

	protected function getAttrString(array $options) {
		$attr = array();

		foreach($options as $key => $value) {
			$attr[] = $key.'="'.$value.'"';
		}

		return implode(' ', $attr);
	}

	public function append($field) {
		$field->setForm($this);

		$this->fields[$field->getName()] = $field;
	}

	public function setAttr($name, $value) {
		$this->attr[$name] = $value;
	}

	public function getAttr($name, $default = '') {
		return isset($this->attr[$name]) ? $this->attr[$name] : $default;
	}

	public function getIterator() {
		return new ArrayIterator($this->fields);
	}

	public function open(array $options = array()) {
		$options = array_merge($this->attr, $options);

		if( ! isset($options['accept-charset'])) {
			$options['accept-charset'] = 'utf-8';
		}

		return sprintf('<form %s>', $this->getAttrString($options));
	}

	public function close() {
		return '</form>';
	}

	public function removeElements() {
		$this->fields = array();
	}

	public function getElement($name) {
		foreach($this->fields as $field) {
			if($field->getName() == $name) {
				return $field;
			}
		}
	}

	public function getElements(array $elements) {
		$form = clone $this;
		$form->removeElements();

		foreach($this->fields as $field) {
			if(in_array($field->getName(), $elements)) {
				$form->append($field);
			}
		}

		return $form;
	}

	public function getElementsExcept(array $elements) {
		$form = clone $this;
		$form->removeElements();

		foreach($this->fields as $field) {
			if( ! in_array($field->getName(), $elements)) {
				$form->append($field);
			}
		}

		return $form;
	}

	public function setValues(array $values) {
		foreach($values as $key => $value) {
			if(isset($this->fields[$key])) {
				$this->values[$key] = $value;
			}
		}
	}

	public function getValues() {
		return $this->values;
	}

	public function setValue($name, $value) {
		$this->values[$name] = $value;
	}

	public function getValue($name, $default = null) {
		return isset($this->values[$name]) ? $this->values[$name] : $default;
	}

	public function getMessages() {
		return array(array('title' => 'Please enetr a post title'));
	}

}