<?php namespace Anchor\Forms\Fields;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

class Hidden extends Field {

	protected $prototype = '<input %s>';

	public function getHtml() {
		$this->attr['name'] = $this->name;
		$this->attr['type'] = 'hidden';
		$this->attr['value'] = $this->getValue();

		return sprintf($this->prototype, $this->getAttrString($this->attr));
	}

}