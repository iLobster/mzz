<?php
    $criteria = new criteria('table');
    $select = new simpleSelect($criteria);
    $select->toString(); // вернёт "SELECT * FROM `table`"
?>