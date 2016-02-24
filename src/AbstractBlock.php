<?php
/**
 * User: Ionov George
 * Date: 18.02.2016
 * Time: 16:00
 */

namespace NewInventor\EasyForm;

use DeepCopy\DeepCopy;
use NewInventor\EasyForm\Exception\ArgumentTypeException;
use NewInventor\EasyForm\Field\AbstractField;
use NewInventor\EasyForm\Field\CheckBox;
use NewInventor\EasyForm\Field\CheckBoxSet;
use NewInventor\EasyForm\Field\Input;
use NewInventor\EasyForm\Field\RadioSet;
use NewInventor\EasyForm\Field\Select;
use NewInventor\EasyForm\Field\TextArea;
use NewInventor\EasyForm\Helper\ObjectHelper;
use NewInventor\EasyForm\Interfaces\BlockInterface;
use NewInventor\EasyForm\Interfaces\FieldInterface;
use NewInventor\EasyForm\Renderer\RenderableInterface;

/**
 * Class AbstractBlock
 * @package NewInventor\EasyForm
 */
class AbstractBlock extends FormObject implements BlockInterface
{
    private $repeatable;
    /**
     * AbstractBlock constructor.
     *
     * @param string $name
     * @param string $title
     */
    public function __construct($name, $title = '')
    {
        parent::__construct($name, $title);
    }

    /**
     * @inheritdoc
     */
    public function validate()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function block($name, $title = '')
    {
        $block = new AbstractBlock($name, $title);
        $block->setParent($this);
        $this->children()->add($block);

        return $block;
    }

    /**
     * @inheritdoc
     */
    public function button($name, $value = '')
    {
        return $this->addInputField('button', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function checkbox($name, $value = false)
    {
        $checkbox = new CheckBox($name, $value);
        return $this->field($checkbox);
    }

    /**
     * @inheritdoc
     */
    public function file($name, $value = '')
    {
        return $this->addInputField('file', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function hidden($name, $value = '')
    {
        return $this->addInputField('hidden', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function image($name, $value = '')
    {
        return $this->addInputField('image', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function password($name, $value = '')
    {
        return $this->addInputField('password', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function radio($name, $value = '')
    {
        return $this->addInputField('radio', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function radioSet($name, $value = '')
    {
        $set = new RadioSet($name, $value);
        $this->field($set);

        return $set;
    }

    /**
     * @inheritdoc
     */
    public function reset($name, $value = '')
    {
        return $this->addInputField('reset', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function submit($name, $value = '')
    {
        return $this->addInputField('submit', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function text($name, $value = '')
    {
        return $this->addInputField('text', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function color($name, $value = '')
    {
        return $this->addInputField('color', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function date($name, $value = '')
    {
        return $this->addInputField('date', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function datetime($name, $value = '')
    {
        return $this->addInputField('datetime', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function datetimeLocal($name, $value = '')
    {
        return $this->addInputField('datetimeLocal', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function email($name, $value = '')
    {
        return $this->addInputField('email', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function number($name, $value = '')
    {
        return $this->addInputField('number', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function range($name, $value = '')
    {
        return $this->addInputField('range', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function search($name, $value = '')
    {
        return $this->addInputField('search', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function tel($name, $value = '')
    {
        return $this->addInputField('tel', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function time($name, $value = '')
    {
        return $this->addInputField('time', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function url($name, $value = '')
    {
        return $this->addInputField('url', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function month($name, $value = '')
    {
        return $this->addInputField('month', $name, $value);
    }

    /**
     * @inheritdoc
     */
    public function week($name, $value = '')
    {
        return $this->addInputField('week', $name, $value);
    }

    protected function addInputField($type, $name, $value)
    {
        $field = new Input($name, $value);
        $field->attribute('type', $type);

        return $this->field($field);
    }

    /**
     * @inheritdoc
     */
    public function select($name, $value = null)
    {
        $select = new Select($name, $value, '');

        return $this->field($select);
    }

    /**
     * @inheritdoc
     */
    public function textArea($name, $value = '')
    {
        $textArea = new TextArea($name, $value);

        return $this->field($textArea);
    }

    /**
     * @inheritdoc
     */
    public function checkBoxSet($name, $value = null)
    {
        $checkBoxSet = new CheckBoxSet($name, $value);

        return $this->field($checkBoxSet);
    }

    /**
     * @inheritdoc
     */
    public function field($field)
    {
        $field->setParent($this);
        $this->children()->add($field);

        return $field;
    }

    /**
     * @inheritdoc
     */
    public function repeatable($object, $values)
    {
        if (!ObjectHelper::isValidType($object, [AbstractBlock::getClass(), AbstractField::getClass()])){
            throw new ArgumentTypeException('object', [AbstractBlock::getClass(), AbstractField::getClass()], $object);
        }
        if (!ObjectHelper::isValidType($values, [ObjectHelper::ARR])){
            throw new ArgumentTypeException('values', [ObjectHelper::ARR], $values);
        }
        $repeatableBlockName = $object->getName();
        $repeatableBlock = new AbstractBlock($repeatableBlockName);
        $repeatableBlock->setRepeatable(true);
        $i = 0;
        $deepCopy = new DeepCopy();
        if(count($values) > 0){
            foreach($values as $value){
                $objectClone = $deepCopy->copy($object);
                $objectClone->setName((string)$i);
                $objectClone->attribute('data-repeatable');
                if($object instanceof AbstractBlock){
                    $objectClone->load($value);
                }else{
                    $objectClone->setValue($value);
                }
                $objectClone->setParent($repeatableBlock);
                $repeatableBlock->children()->add($objectClone);
                $i++;
            }
        }
        if(empty($values)) {
            $objectClone = $deepCopy->copy($object);
            $objectClone->setParent($repeatableBlock);
            $objectClone->setName((string)$i);
            $objectClone->attribute('data-repeatable');
            $repeatableBlock->children()->add($objectClone);
        }

        $repeatableBlock->setParent($this);
        $this->children()->add($repeatableBlock);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getString()
    {
        $isRepeatBlock = $this->getParent() !== null && $this->getParent()->isRepeatable();
        $res = '<div';
        if($this->getParent() !== null && $this->getParent()->isRepeatable()){
            $res .= ' data-repeat-block';
        }elseif($this->isRepeatable()){
            $res .= ' data-repeat-container';
        }
        $res .= '>';
        var_dump($isRepeatBlock);
        $res .= $this->children()->getString();
        if ($isRepeatBlock) {
            if ((int)$this->getName() != 0) {
                $res .= '<span data-repeat-block-delete-' . $this->getParent()->getName() . '>-</span>';
            }
            var_dump($this->getName(), count($this->getParent()->children()));
            if ((int)$this->getName() == count($this->getParent()->children())) {
                $res .= '<span data-repeat-block-add-' . $this->getParent()->getName() . '>+</span>';
            }
        }
        $res .='</div>';
        if($this->isRepeatable()){
            $deepCopy = new DeepCopy();
            /** @var BlockInterface|FieldInterface|RenderableInterface $childCopy */
            $childCopy = $deepCopy->copy($this->child('0'));
            $childCopy->setName('#IND#');
            $childCopy->setParent($this);
            $childCopy->clear();
            $res .= '<script>
$(document).on("click", "[data-repeat-block-delete-' . $this->getName() . ']", function(e){
    e.preventDefault();
    var $this = $(this);
    $this.closest("[data-repeat-block]").remove();
});
$(document).on("click", "[data-repeat-block-add-' . $this->getName() . ']", function(e){
    e.preventDefault();
    var $this = $(this);
    var $container = $this.closest("[data-repeat-container]");
    var dummy = \'' . $childCopy . '\';
    var index = $container.find("[data-repeat-block]").length;
    dummy = dummy.replace(/#IND#/g, index);
    $container.append(dummy);
    var cloneAdd = $this.clone();
    var cloneDelete = $this.prev().clone();
    $container.find("[data-repeat-block]:last").append(cloneDelete);
    $container.find("[data-repeat-block]:last").append(cloneAdd);
    $this.remove();
});
</script>';
            unset($childCopy);
        }

        return $res;
    }

    /**
     * @inheritdoc
     */
    public function load($data = null)
    {
        if (!ObjectHelper::isValidType($data, [ObjectHelper::ARR, ObjectHelper::NULL])) {
            throw new ArgumentTypeException('data', [ObjectHelper::ARR, ObjectHelper::NULL], $data);
        }
        if ($data === null && isset($_REQUEST[$this->getName()])) {
            $data = $_REQUEST[$this->getName()];
        }elseif($data === null){
            return false;
        }

        $deepCopy = new DeepCopy();
        foreach ($data as $name => $value) {
            $child = $this->child($name);
            if ($child instanceof FieldInterface) {
                $child->setValue($value);
            } elseif ($child instanceof BlockInterface && !$child->isRepeatable()) {
                $child->load($value);
            } elseif ($child instanceof BlockInterface && $child->isRepeatable()) {
                $value = array_values($value);
                $childrenCount = count($child->children());
                $childrenMaxIndex = $childrenCount - 1;
                $childrenDelta = count($value) - $childrenCount;
                if($childrenDelta > 0){
                    for($i = 0; $i < $childrenDelta; $i++) {
                        /** @var BlockInterface|FieldInterface $objectClone */
                        $objectClone = $deepCopy->copy($child->child('0'));
                        $objectClone->setName((string)($childrenCount + $i));
                        $objectClone->attribute('data-repeatable');
                        $child->children()->add($objectClone);
                    }
                }elseif($childrenDelta < 0){
                    for ($i = 0; $i < abs($childrenDelta); $i++){
                        $child->children()->delete(($childrenMaxIndex - $i));
                    }
                }
                $child->load($value);
            }
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function isRepeatable()
    {
        return $this->repeatable;
    }

    /**
     * @inheritdoc
     */
    public function setRepeatable($repeatable)
    {
        $this->repeatable = $repeatable;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function clear(){
        foreach($this->children() as $child){
            $child->clear();
        }

        return $this;
    }
}