<?php namespace Anchor\Controllers\Admin;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Anchor\Forms\Meta as MetaForm;

class Meta extends Backend {

	public function edit() {
		$form = new MetaForm;
		$form->setAttr('action', $this->uri->to('admin/extend/meta/update'));
		$form->setAttr('method', 'POST');
		$form->setValues($this->meta->toArray());

		$vars['messages'] = $this->messages->render();
		$vars['token'] = $this->csrf->token();

		$vars['title'] = 'Metadata';
		$vars['form'] = $form;

		return $this->getCommonView('meta/index.phtml', $vars)->render();
	}

	public function update() {
		$this->messages->info('Meatdata updated');

		return $this->response->redirect($this->uri->to('admin/extend/meta'));
	}

}