<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 04.04.2016
 * Time: 20:15
 */

namespace NewInventor\Form\Renderer;


use DeepCopy\DeepCopy;
use NewInventor\Abstractions\Interfaces\ObjectInterface;
use NewInventor\ConfigTool\Config;
use NewInventor\Form\Interfaces\BlockInterface;
use NewInventor\Form\Interfaces\FieldInterface;
use NewInventor\Form\Renderer\Traits;
use NewInventor\Template\Template;

class BlockRenderer extends BaseRenderer
{
    use Traits\Errors;
    use Traits\Label;
    use Traits\Children;
    use Traits\Repeatable;
    
    /** @inheritdoc */
    public function render(ObjectInterface $block)
    {
        /** @var BlockInterface $block */
        if ($block->isRepeatable()) {
            $templateStr = Config::get(['renderer', 'templates', $block->getTemplate(), 'repeatBlock']);
        } elseif ($block->isRepeatableContainer()) {
            $templateStr = Config::get(['renderer', 'templates', $block->getTemplate(), 'repeatContainer']);
        } else {
            $templateStr = Config::get(['renderer', 'templates', $block->getTemplate(), 'block']);
        }
        
        $template = new Template($templateStr);
        
        return $template->getString($this, $block);
    }
    
    /**
     * @param BlockInterface $block
     *
     * @return string
     */
    public function repeatScript(BlockInterface $block)
    {
        $deepCopy = new DeepCopy();
        /** @var BlockInterface|FieldInterface|RenderableInterface $childCopy */
        $childCopy = $deepCopy->copy($block->getRepeatObject());
        $childCopy->clear();
        $childCopy->setParent($block);
        /** @var BlockInterface|FieldInterface $child */
        $child = $block->child(0);
        $res = '<script>
$(document).ready(function(e){
    $("[' . $this->containerSelector() . ']").repeatContainer({
        containerSelector : \'[' . $this->containerSelector() . ']\',
        blockSelector : \'[' . $this->blockSelector() . ']\',
        actionsSelector : \'[' . $this->actionsBlockSelector() . '="' . $block->getName() . '"]\',
        addSelector : \'[' . $this->addActionSelector() . ']\',
        deleteSelector : \'[' . $this->deleteActionSelector() . ']\',
        dummyObject: \'' . $childCopy . '\',
        addButton: \'' . $this->addButton($block, false) . '\',
        deleteButton: \'' . $this->deleteButton($block, false) . '\',
        fullActionsBlock: \'' . $this->actions($child, false) . '\'
    });
});
</script>';
        
        return $res;
    }
}