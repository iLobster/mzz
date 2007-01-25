<?php
    $criteria = new criteria('table');
    $criteria->addGroupBy('table.field');
    $select = new simpleSelect($criteria);
    $select->toString(); // "SELECT * FROM `table` GROUP BY `table`.`field`"
?>