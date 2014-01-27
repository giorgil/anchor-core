<?php namespace Anchor\Forms\Fields;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

class Select extends Field {

	protected $prototype = '<select %s>%s</select>';

	public function getHtml() {
		$this->attr['name'] = $this->name;

		return sprintf($this->prototype, $this->getAttrString($this->attr), $this->getOptions());
	}

	protected function getOptions() {
		$options = isset($this->options['options']) ? $this->options['options'] : array();
		$html = '';

		foreach($options as $key => $value) {
			$selected = ($this->getValue() == $key) ? ' selected' : '';
			$html .= '<option value="'.$key.'"'.$selected.'>'.$value.'</option>';
		}

		return $html;
	}

}