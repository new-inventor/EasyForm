<?php
/**
 * User: Ionov George
 * Date: 18.02.2016
 * Time: 16:48
 */

namespace Interfaces;

interface ValidatorInterface
{
    public function isValid();
    public function getError();
}