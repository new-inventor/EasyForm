<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 21.02.2016
 * Time: 23:39
 */

namespace NewInventor\Form\Interfaces;


use NewInventor\TypeChecker\Exception\ArgumentException;

interface HandlerInterface extends FormObjectInterface {
    /**
     * @return bool
     */
    public function process();
    
    /**
     * @param callable|\Closure $process
     * @throws ArgumentException
     */
    public function setProcess($process);
} 