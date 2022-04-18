<?php

namespace ElaineCore\Lib;

/**
 * interface PostTypeInterface
 * @package ElaineCore\Lib;
 */
interface PostTypeInterface {
	/**
	 * @return string
	 */
	public function getBase();
	
	/**
	 * Registers custom post type with WordPress
	 */
	public function register();
}