<?php namespace Anchor\Services;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

class Csrf {

	public function __construct($session) {
		$this->session = $session;
	}

	public function token() {
		$tokens = $this->session->get('tokens', array());

		$token = uniqid();
		$tokens[] = $token;

		$this->session->put('tokens', $tokens);

		return $token;
	}

	public function verify($token) {
		$tokens = $this->session->get('tokens', array());
		$offset = array_search($token, $tokens);

		if(false !== $offset) {
			unset($tokens[$offset]);

			$this->session->put('tokens', $tokens);

			return true;
		}

		return false;
	}

}