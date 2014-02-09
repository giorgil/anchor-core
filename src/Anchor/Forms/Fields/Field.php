<?php namespace Anchor\Forms\Fields;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

abstract class Field {

	protected $name;

	protected $options = array();

	protected $attr = array();

	protected $form;

	protected $prototype;

	public function __construct($name, array $options = array(), array $attr = array()) {
		$this->name = $name;
		$this->options = $options;
		$this->attr = $attr;
	}

	protected function getAttrString(array $options) {
		$attr = array();

		foreach($options as $key => $value) {
			$attr[] = $key.'="'.$value.'"';
		}

		return implode(' ', $attr);
	}

	abstract public function getHtml();

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;

		return $this;
	}

	public function getForm() {
		return $this->form;
	}

	public function setForm($form) {
		$this->form = $form;

		return $this;
	}

	public function getOption($name, $default = '') {
		return isset($this->options[$name]) ? $this->options[$name] : $default;
	}

	public function setOption($name, $value) {
		$this->options[$name] = $value;

		return $this;
	}

	public function getLabel() {
		return $this->getOption('label', $this->name);
	}

	public function setLabel($label) {
		$this->setOption('label', $label);

		return $this;
	}

	public function getValue($default = '') {
		return $this->form->getValue($this->name, $default);
	}

	public function setValue($value) {
		$this->form->setValue($this->name, $value);

		return $this;
	}

}