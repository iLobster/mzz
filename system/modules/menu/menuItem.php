<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * menuItem: класс для работы c данными
 *
 * @package modules
 * @subpackage menu
 * @version 0.2
 */
abstract class menuItem extends entity
{
    protected $name = 'menu';

    protected $childrens = array();
    protected $arguments = null;
    protected $isActive;
    protected $typeId;
    protected $urlLang;
    protected $urlLangSpecified;

    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;
    }

    public function getTypeId()
    {
        return $this->typeId;
    }

    public function getArgument($argument, $default = null)
    {
        $arguments = $this->getArguments();
        $value = $arguments->get($argument);

        return is_null($value) ? $default : $value;
    }

    protected function getArguments()
    {
        if (is_null($this->arguments)) {
            $arguments = $this->getArgs();
            try {
                $arguments = unserialize($arguments);
                if (!is_array($arguments)) {
                    $arguments = array();
                }
            } catch (mzzException $e) {
                $arguments = array();
            }

            $this->arguments = new arrayDataspace($arguments);
        }

        return $this->arguments;
    }

    public function setArgument($name, $value)
    {
        $arguments = $this->getArguments();
        $arguments->set($name, $value);
        $this->setArguments($arguments->export());
    }

    public function setArguments(Array $args)
    {
        $this->arguments = new arrayDataspace($args);
        $this->setArgs(serialize($args));
    }

    public function getChildrens()
    {
        return $this->childrens;
    }

    public function setChildrens(Array $childrens, $parent)
    {
        foreach ($childrens as $child) {
            if ($child->isActive()) {
                $this->isActive = true;
            }
        }

        $this->childrens = $childrens;
    }

    public function move($target)
    {
        $this->mapper->move($this, $target);
    }

    /**
     * Возвращает JIP-меню
     * Переопределяется если требуется использовать другие данные для построения JIP-меню
     *
     * @param string $tpl шаблон JIP-меню
     * @return string
     */
    public function getJip($tpl = jip::DEFAULT_TEMPLATE)
    {
        return $this->getJipView($this->name, $this->getId(), __CLASS__, $tpl);
    }

    public function setUrlLang($lang, $specified)
    {
        $this->urlLang = $lang;
        $this->urlLangSpecified = (bool)$specified;
    }

    public function getTypeTitle()
    {
        return $this->mapper->getTitleByType($this->getTypeId());
    }

    abstract function getUrl();
    abstract function isActive();
}

?>