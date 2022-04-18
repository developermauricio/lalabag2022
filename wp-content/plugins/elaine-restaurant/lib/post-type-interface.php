<?php
namespace ElaineRestaurant\Lib;

/**
 * interface PostTypeInterface
 * @package ElaineRestaurant\Lib;
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