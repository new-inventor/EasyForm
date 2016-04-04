<?php
/**
 * User: Ionov George
 * Date: 12.02.2016
 * Time: 18:36
 */

namespace NewInventor\Form\Abstraction\asd;


use NewInventor\TypeChecker\Exception\ArgumentException;
use NewInventor\TypeChecker\TypeChecker;

class KeyValuePairBuilder
{
    private $settings;

    /**
     * KeyValuePairBuilder constructor.
     * @param string $type
     * @param string $configFilePath absolute path
     */
    public function __construct($type = '', $configFilePath = '')
    {
        $this->loadSettings($type, $configFilePath);
    }

    public function build($name, $value = '', $canBeShort = null)
    {
        if(!isset($canBeShort) && isset($this->settings['canBeShort'])){
            $canBeShort = $this->settings['canBeShort'];
        }elseif(!isset($canBeShort)){
            $canBeShort = false;
        }
        $pair = new KeyValuePair($name, $value, $canBeShort);
        if(isset($this->settings['delimiter'])){
            $pair->setDelimiter($this->settings['delimiter']);
        }
        if(isset($this->settings['valueComas'])){
            $pair->setComasArray('value', $this->settings['valueComas']);
        }
        if(isset($this->settings['nameComas'])){
            $pair->setComasArray('name', $this->settings['nameComas']);
        }

        return $pair;
    }

    protected function loadSettings($type = '', $settingsPath = '')
    {
        TypeChecker::getInstance()
            ->isString($type, 'type')
            ->throwCustomErrorIfNotValid('Неверный или пустой тип пары ключ-значение.');
        $defaultSettings = include dirname(dirname(__DIR__)) . '/config/key-value-types.php';

        $additionalSettings = [];
        if($this->settingsPathExists($settingsPath)){
            $additionalSettings = include $settingsPath;
        }elseif(!empty($settingsPath)){
            throw new ArgumentException('Путь до дополнительного файла настроек неверный. Проверьте существование файла.', 'settingsPath');
        }

        $allSettings = array_merge($defaultSettings, $additionalSettings);

        if(!isset($allSettings[$type])){
            $this->settings = $allSettings['default'];
        }else{
            $this->settings = $allSettings[$type];
        }
    }

    public function setSettings(array $settings = [])
    {
        $this->settings = $settings;
    }

    protected function settingsPathExists($settingsPath)
    {
        return TypeChecker::getInstance()->isString($settingsPath)->result() && !empty($settingsPath) && file_exists($settingsPath);
    }
}