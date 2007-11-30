<?php
    $criteria = new criteria('table');
    $criteria->addSelectField('field1');
    $criteria->addSelectField('field2', 'alias');
    $select = new simpleSelect($criteria);
    $select->toString(); // вернёт "SELECT `field1`, `field2` AS `alias` FROM `table`"
?>