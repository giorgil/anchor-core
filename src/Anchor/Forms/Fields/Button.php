<?php namespace Anchor\Forms\Fields;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

class Button extends Field {

	protected $prototype = '<button %s>%s</button>';

	public function getHtml() {
		if( ! isset($this->attr['type'])) {
			$this->attr['type'] = 'submit';
		}

		return sprintf($this->prototype, $this->getAttrString($this->attr), $this->getLabel());
	}

}