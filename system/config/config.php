<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2005
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * config: класс для работы с конфигурацией
 *
 * @package system
 * @version 0.2
*/
class config
{
    /**
     * Свойство для хранения результата обработки конфиг-файла
     *
     * @var array
     * @access protected
     */
    protected $_ini;

    /**
     * Имя обработанного конфиг-файла
     *
     * @var string
     * @access protected
     */
    protected $_ini_file;

    /**
     * Constructor
     *
     * @access public
     * @return void
     */
    public function __construct() {

    }

    /**
     * Загрузка и обработка конфиг-файла. Результат обработки сохраняется и при
     * повторном вызове метода load с тем же именем конфиг-файла будет возвращен
     * сохраненный результат. Для обновления результата используется метод update.
     *
     * @access public
     * @param string $file имя файла (без '.ini' в конце)
     * @param boolean $process_sections
     * @return bolean
     */
    public function load($file, $process_sections = true)
    {
        $file = fileLoader::resolve('configs/'.$file.'.ini');
        if(!isset($this->_ini_file) || $this->_ini_file != $file) {
            if(($this->_ini = parse_ini_file($file, $process_sections)) !== false) {
                $this->_ini_file = $file;
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }

    }

    /**
     * Получение значения опции
     *
     * @access public
     * @param string $section имя секции
     * @param string $name имя опции
     * @return string|false
     */
    public function getOption($section, $name)
    {
        if(isset($this->_ini[$section][$name])) {
            return $this->_ini[$section][$name];
        } else {
            return false;
        }

    }

    /**
     * Получение всей секции
     *
     * @access public
     * @param string $section имя секции
     * @return array|false
     */
    public function getSection($section)
    {
        if(isset($this->_ini[$section])) {
            return $this->_ini[$section];
        } else {
            return false;
        }
    }

    /**
     * Обновление результата обработки
     *
     * @access public
     * @return void
     */
    public function update() {
        $file = $this->_ini_file;
        unset($this->_ini_file);
        $this->load($file);
    }

}

?>