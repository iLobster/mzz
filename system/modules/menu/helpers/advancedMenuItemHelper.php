<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('menu/helpers/iMenuItemHelper');

/**
 * advancedMenuItemHelper: хелпер для advanced меню
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */
class advancedMenuItemHelper implements iMenuItemHelper
{
    protected $routes;
    protected $routesSelect;
    protected $routesParts;
    protected $routesPartsData;

    public function setArguments($item, array $args)
    {
        //Обнуляем старые аргументы
        $item->setArguments(array());

        $item->setArgument('route', $routeName = $this->getRouteName($item, $args));
        $item->setArgument('regexp', array_key_exists('regexp', $args) ? $args['regexp'] : '');

        $this->prepareRoutes($item, $args);
        foreach ($this->routesPartsData as $key => $value) {
            $item->setArgument($key, $value);
        }

        $activeRoutes = array();

        $routeActive = $args['routeActive'];
        if (!is_array($routeActive)) {
            $routeActive = array();
        }

        $routeActiveData = $args['routeActiveParts'];
        if (!is_array($routeActiveData)) {
            $routeActiveData = array();
        }

        foreach ($routeActive as $key => $routeActiveName) {
            $activeRoutes[] = array(
                'route' => $routeActiveName,
                'params' => array_key_exists($key, $routeActiveData) ? $routeActiveData[$key] : array()
            );
        }
        $item->setArgument('activeRoutes', $activeRoutes);

        return $item;
    }

    public function injectItem($validator, $item = null, $smarty = null, array $args = null)
    {
        $validator->add('callback', 'activeRegExp', 'Введенная строка является ошибочным рег.выражением', array(array($this, 'checkStringRegex')));
        $validator->add('required', 'route', 'Укажите роут');
        $routeName = $this->getRouteName($item, $args);
        $this->prepareRoutes($item, $args);
        $validator->add('in', 'route', 'Укажите правильный роут', array_keys($this->routesSelect));

        $smarty->assign('routesSelect', $this->routesSelect);
        $smarty->assign('routesParts', $this->routesParts);
        $smarty->assign('current', $routeName);
    }

    protected function prepareRoutes($item, $args)
    {
        if (empty($this->routesSelect)) {
            $router = systemToolkit::getInstance()->getRouter();
            $this->routes = $router->getRoutes();
            $routesSelect = array();
            $routesParts = array();

            foreach ($this->routes as $route) {
                $routesSelect[$route->getName()] = $route->getName();
                $routesParts[$route->getName()] = array();

                foreach ($route->getParts() as $part) {
                    if ($part['name'] != 'lang' && $part['isVar']) {
                        if ($item->getId()) {
                            $part['value'] = $item->getArgument($part['name']);
                        } else {
                            $defaults = $route->getDefaults();
                            $part['value'] = (array_key_exists($part['name'], $defaults)) ? $defaults[$part['name']] : '';
                        }

                        $routesParts[$route->getName()][] = $part;
                    }
                }
            }

            $this->routesSelect = $routesSelect;
            $this->routesParts = $routesParts;
        }
        $routeName = $this->getRouteName($item, $args);
        if ($routeName && isset($routesParts[$routeName])) {
            $routePartsData = isset($args['parts']) && is_array($args['parts']) ? $args['parts'] : array();
            foreach ($routesParts[$routeName] as &$cPart) {
                if (isset($routePartsData[$cPart['name']])) {
                    $cPart['value'] = $routePartsData[$cPart['name']];
                }
            }
            $this->routesPartsData = $routePartsData;
        }
    }

    public function getRouteName($item, array $args)
    {
        return isset($args['routeName']) ? $args['routeName'] : $item->getRouteName();
    }

    public function checkStringRegex($string)
    {
        // Does another way exist?
        try {
            preg_match($string, 'test');
            return true;
        } catch (mzzException $e) {
            return false;
        }
    }
}

?>