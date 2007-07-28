<?php

class photo extends simple
{
    [...]

    public function getAcl($name = null)
    {
        $access = parent::getAcl($name);

        if (in_array($name, array('viewPhoto', 'viewThumbnail', 'view')) && $access) {
            $access = $this->getAlbum()->getAcl('viewAlbum');
        }

        return $access;
    }
}

?>