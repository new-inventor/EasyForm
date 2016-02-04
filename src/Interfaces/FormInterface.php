<?php

namespace NewInventor\EasyForm\Interfaces;

interface FormInterface extends FormObjectInterface
{
    public function field();
    public function block();
    public function tab();
    public function altBlock();
    public function altField();
}