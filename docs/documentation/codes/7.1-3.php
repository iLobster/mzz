<?php
    $criteria = new criteria('table');
    $criteria->addSelectField('field1')->addSelectField('field2', 'alias');
    $select = new simpleSelect($criteria);
    $select->toString(); // "SELECT `field1`, `field2` AS `alias`, `field3` FROM `table`"
?>