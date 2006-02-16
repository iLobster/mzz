<?php

fileLoader::load('dataspace/dataspaceFilter');

class dateFormatDataspaceFilter extends dataspaceFilter
{
    private $format;
    private $keys;

    public function __construct($dataspace, $keys, $format = 'd M Y / H:i:s')
    {
        // возможно воткнуть какую то проверку на формат переменной $format
        // дефолтный формат возможно будет браться из конфига
        $this->format = $format;
        $this->keys = $keys;
        parent::__construct($dataspace);
    }

    public function get($key)
    {
        // может ещё проверять что запрашивается именно timestamp (is_int)
        // или форматировать при выводе.. хотя хз
        return (in_array($key, $this->keys)) ? date($this->format, $this->dataspace->get($key)) : $this->dataspace->get($key);
    }
}

?>