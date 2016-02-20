<?php
/**
 * User: Ionov George
 * Date: 12.02.2016
 * Time: 18:36
 */

namespace NewInventor\EasyForm\Abstraction;

use NewInventor\EasyForm\Exception\ArgumentException;
use NewInventor\EasyForm\Helper\ObjectHelper;

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
        if($this->badKeyValueType($type)){
            throw new ArgumentException('Неверный или пустой тип пары ключ-значение.', 'type');
        }
        $defaultSettings = include dirname(__DIR__) . '/config/key-value-types.php';

        $additionalSettings = [];
        if($this->badSettingsPath($settingsPath)){
            throw new ArgumentException('Путь до дополнительного файла настроек неверный. Проверьте существование файла.', 'settingsPath');
        }elseif(!empty($settingsPath)){
            $additionalSettings = include $settingsPath;
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

    protected function badKeyValueType($type)
    {
        return !ObjectHelper::isValidType($type, [ObjectHelper::STRING]) || empty($type);
    }

    protected function badSettingsPath($settingsPath)
    {
        return !empty($settingsPath) && (!ObjectHelper::isValidType($settingsPath, [ObjectHelper::STRING]) || !file_exists($settingsPath));
    }
}