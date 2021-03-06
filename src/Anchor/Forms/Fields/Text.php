<?php namespace Anchor\Forms\Fields;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

class Text extends Field {

	protected $prototype = '<input %s>';

	public function getHtml() {
		$this->attr['name'] = $this->name;
		$this->attr['type'] = 'text';
		$this->attr['value'] = $this->getValue() ? $this->getValue() : $this->getOption('default');

		return sprintf($this->prototype, $this->getAttrString($this->attr));
	}

}