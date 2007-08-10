<?php

class newsFolder extends simpleForTree
{
    [...]

    public function getJip()
    {
        return $this->getJipView($this->name, $this->getPath(), get_class($this));
    }
}

?>