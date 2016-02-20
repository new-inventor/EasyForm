<?php

namespace NewInventor\EasyForm\Interfaces;

interface BlockInterface extends FormObjectInterface
{
    public function field($type, $name, $value = '');
    public function block();
    //public function tab();
    public function repeatableBlock();
    public function repeatableField();

    public function button($name, $value = '');
    public function checkbox($name, $value = '');
    public function file($name, $value = '');
    public function hidden($name, $value = '');
    public function image($name, $value = '');
    public function password($name, $value = '');
    public function radio($name, $value = '');
    public function reset($name, $value = '');
    public function submit($name, $value = '');
    public function text($name, $value = '');
    public function color($name, $value = '');
    public function date($name, $value = '');
    public function datetime($name, $value = '');
    public function datetimeLocal($name, $value = '');
    public function email($name, $value = '');
    public function number($name, $value = '');
    public function range($name, $value = '');
    public function search($name, $value = '');
    public function tel($name, $value = '');
    public function time($name, $value = '');
    public function url($name, $value = '');
    public function month($name, $value = '');
    public function week($name, $value = '');
}