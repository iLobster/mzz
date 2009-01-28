<?php
class advancedMenuItem extends menuItem
{
    protected $url = null;

    public function getUrl()
    {
        if (is_null($this->url)) {
            $route = $this->getRouteName();
            if ($route) {
                $url = new url($route);
                foreach ($this->getUrlArguments() as $key => $value) {
                    $url->add($key, $value);
                }

                $url->disableAddress();
                $this->url = $url->get();
            } else {
                $this->url = '';
            }
        }

        return $this->url;
    }

    public function isActive()
    {
        if (!is_bool($this->isActive)) {
            $toolkit = systemToolkit::getInstance();
            $request = $toolkit->getRequest();

            $currentRoute = $toolkit->getRouter()->getCurrentRoute();

            $match = false;
            foreach ($this->getActiveRoutes() as $route) {
                if ($route['route'] == $currentRoute->getName()) {
                    $values = $currentRoute->getValues();
                    unset($values['lang']);
                    $match = true;
                    foreach ($route['params'] as $key => $value) {
                        $currentValue = (isset($values[$key])) ? $values[$key] : null;
                        if ($value != '*' && $value != $currentValue) {
                            $match = false;
                            break;
                        }
                    }
                }
            }

            $this->isActive = $match;

            /*
            if ($this->getActiveRegExp()) {
                $requestPath = $request->getPath();

                //отрезаем из урла lang
                if ($this->urlLangSpecified) {
                    $requestPath = $this->stripLangFromUrl($requestPath);
                }

                $this->isActive = preg_match($this->getActiveRegExp(), $requestPath);
            } else {
                $url = $request->getUrl() . $this->getUrl();
                $this->isActive = ($url == $request->getRequestUrl());
            }
            */
        }

        return $this->isActive;
    }

    public function getRouteName()
    {
        return $this->getArgument('route');
    }

    public function getActiveRoutes()
    {
        return $this->getArgument('activeRoutes', array());
    }

    public function getActiveRegExp()
    {
        return $this->getArgument('regexp');
    }

    protected function getUrlArguments()
    {
        $arguments = clone $this->getArguments();
        $arguments->delete('route');
        $arguments->delete('activeRoutes');
        return $arguments->export();
    }

    protected function stripLangFromUrl($url)
    {
        return preg_replace('!^' . $this->urlLang . '/!siU', '/', $url);
    }
}
?>