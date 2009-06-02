<?php

class newsMapper extends mapper
{
    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $class = 'news';
    protected $table = 'news_news';

    protected $map = array(...);

    [...]

    protected function preInsert(& $data)
    {
        if (is_array($data)) {
            $data['updated'] = $data['created'];
        }
    }

    protected function preUpdate(& $data)
    {
        if (is_array($data)) {
            $data['updated'] = new sqlFunction('UNIX_TIMESTAMP');
        }
    }
    
    [...]
}

?>