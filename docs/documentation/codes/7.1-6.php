<?php
    $criteria = new criteria('table');
    $criteria->addJoin('foo', new criterion('alias.id', 'table.id', criteria::EQUAL, true), 'alias', criteria::JOIN_INNER);
    $select = new simpleSelect($criteria);
    $select->toString(); // "SELECT * FROM `table` INNER JOIN `foo` `alias` ON `alias`.`id` = `table`.`id`"
?>