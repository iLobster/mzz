<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//

class mzzIniFilterIterator extends FilterIterator {
    public function accept() {
        return $this->isFile() && (substr($this->getFilename(), -4) == '.ini');
    }
}

?>