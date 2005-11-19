<?php
final class cachingResolver extends decoratingResolver
{
    private $cache = array();
    private $cache_file;
    private $cached = true;

    public function __construct($resolver)
    {
        $filename = TEMP_DIR . 'resolver.cache';
        if(file_exists($filename)) {
            $this->cache = unserialize(file_get_contents($filename));
        }
        $this->cache_file = new Fs($filename, 'w');
        parent::__construct($resolver);
    }


    public function resolve($request)
    {
        if (!isset($this->cache[$request])) {
            $this->cache[$request] = $this->resolver->resolve($request);
        }
        return $this->cache[$request];
    }

    public function __destruct()
    {
        $this->cache_file->write(serialize($this->cache));
    }

}
?>