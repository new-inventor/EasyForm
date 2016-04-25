<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 04.04.2016
 * Time: 20:35
 */

namespace NewInventor\Form\Renderer\Traits;


use NewInventor\ConfigTool\Config;
use NewInventor\Form\Interfaces\BlockInterface;
use NewInventor\Form\Interfaces\FieldInterface;
use NewInventor\Form\Interfaces\FormInterface;
use NewInventor\Template\Template;

/**
 * Class LabelRendererTrait
 * @package NewInventor\Form\Renderer\Traits
 *
 * @method getReplacements(array $placeholders, $object)
 */
trait Label
{
    /**
     * @param FormInterface|BlockInterface|FieldInterface $object
     *
     * @return string
     */
    public function label($object)
    {
        $templateStr = Config::find(['renderer'], ['templates', $object->getTemplate(), 'label'], $object->getClass(),
            '');
        $template = new Template($templateStr);
        
        return $template->getString($this, $object);
    }
    
    /**
     * @param FormInterface|BlockInterface|FieldInterface $object
     *
     * @return string
     */
    public function title($object)
    {
        return $object->getTitle();
    }
}