<?php namespace Anchor\Services;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

class Messages {

	protected $format = '<p class="{type}">{message}</p>';

	public function __construct($storage) {
		$this->storage = $storage;
	}

	public function __call($method, $args) {
		$this->add($method, $args[0]);
	}

	public function setFormat($format) {
		$thi->format = $format;
	}

	public function add($type, $message) {
		$messages = $this->storage->get('messages');

		if( ! is_array($message)) {
			$message = array($message);
		}

		if( ! isset($messages[$type])) {
			$messages[$type] = array();
		}

		$messages[$type] = array_merge($messages[$type], $message);

		$this->storage->put('messages', $messages);
	}

	public function render($format = null) {
		$messages = $this->storage->get('messages', array());
		$html = '';

		foreach($messages as $type => $group) {
			foreach($group as $message) {
				$html .= str_replace(array('{type}', '{message}'), array($type, $message), $this->format);
			}
		}

		$this->storage->remove('messages');
		return $html;
	}

}