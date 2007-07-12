<?php

// ����������� ��������
$sqlOperator = new sqlOperator('+', array(1, 2));
echo $sqlOperator->toString(); // 1 + 2

// ������������� � ����������� ����������
$sqlOperator = new sqlOperator('-', array('table.field', 'field2', 1 , 2));
echo $sqlOperator->toString(); // `table`.`field` - `field2` - 1 - 2

// ����������� �����������
$operatorNested = new sqlOperator('+', array(1, 2));
$operatorNested2 = new sqlOperator('/', array($operatorNested, 'field'));

$sqlOperator = new sqlOperator('*', array($operatorNested2, $operatorNested));
echo $sqlOperator->toString(); // ((1 + 2) / `field`) * (1 + 2)

// ������������� ��������� � sqlFunction
$sqlOperator = new sqlOperator('-', array(new sqlFunction('NOW'), new sqlOperator('INTERVAL', array('1 DAY'))));
echo $sqlOperator->toString(); // NOW() - INTERVAL 1 DAY

?>