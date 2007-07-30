<?php
    $criteria = new criteria('table');
    $criteria->add('field', 'value', criteria::GREATER)->add('field2', 'value2');
    $select = new simpleSelect($criteria);
    $select->toString(); // "SELECT * FROM `table` WHERE `table`.`field` > 'value' AND `table`.`field2` = 'value2'"
?>