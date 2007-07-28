<?php

class newsFolder extends new_simpleForTree
{
    [...]

    public function getJip()
    {
        return $this->getJipView($this->name, $this->getPath(), get_class($this));
    }
}

?>