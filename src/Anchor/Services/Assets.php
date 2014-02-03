<?php namespace Anchor\Services;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use lessc;
use FilesystemIterator;

class Assets {

	private $lessc;

	public function __construct(lessc $lessc) {
		$this->lessc = $lessc;
	}

	public function copy($src, $dest) {
		foreach(new FilesystemIterator($src, FilesystemIterator::SKIP_DOTS) as $fileinfo) {
			$fn = $fileinfo->getFilename();

			if($fileinfo->isFile()) {
				copy($fileinfo->getPathname(), $dest . '/' . $fileinfo->getFilename());
			}
			elseif($fileinfo->isDir()) {
				if( ! is_dir($dest.'/'.$fn)) mkdir($dest.'/'.$fn);

				$this->copy($fileinfo->getPathname(), $dest.'/'.$fn);
			}
		}
	}

	public function compile($src) {
		foreach(new FilesystemIterator($src, FilesystemIterator::SKIP_DOTS) as $fileinfo) {
			if($fileinfo->isFile()) {
				$ext = pathinfo($fileinfo->getPathname(), PATHINFO_EXTENSION);

				if($ext == 'less') {
					$this->lessc->checkedCompile($fileinfo->getPathname(),
						$fileinfo->getPath() . '/' . $fileinfo->getBasename('.less') . '.css');
				}
			}
			elseif($fileinfo->isDir()) {
				$this->compile($fileinfo->getPathname());
			}
		}
	}

}