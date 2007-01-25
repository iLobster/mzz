<?php
    $criteria = new criteria('table');
    $criteria->setLimit(10)->setOffset(15)->setOrderByFieldDesc('field');
    $select = new simpleSelect($criteria);
    $select->toString(); // "SELECT * FROM `table` ORDER BY `table`.`field` DESC LIMIT 15, 10"
?>