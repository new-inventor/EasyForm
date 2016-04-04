<?php
/**
 * User: Ionov George
 * Date: 20.02.2016
 * Time: 18:17
 */

namespace NewInventor\Form\Renderer;


use NewInventor\Abstractions\Interfaces\ObjectInterface;

interface RenderableInterface extends ObjectInterface
{
    /**
     * Преобразовать объект в строку автоматически при конкатенации
     * @return string
     */
    public function __toString();

    /**
     * Преобразовать объект в строку
     * @return string
     */
    public function getString();

    /**
     * Отобразить объект на странице
     * @return void
     */
    public function render();
}