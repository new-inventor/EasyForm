<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 21.02.2016
 * Time: 23:39
 */

namespace NewInventor\EasyForm\Interfaces;


interface HandlerInterface extends FormObjectInterface {
    /**
     * @return bool
     */
    public function process();
} 