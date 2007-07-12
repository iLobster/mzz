<?php

// ������� ������� ��� ����������:
$sqlFunction = new sqlFunction('Unix_Timestamp');
echo $sqlFunction->toString(); // UNIX_TIMESTAMP()

// ������� � ����������� �����������
$sqlFunction = new sqlFunction('Function', array('field' => true, "value", 3));
echo $sqlFunction->toString(); // FUNCTION(`field`, 'value', 3)

// �������������� ���������� ` ��� ��� ������ � �����:
$sqlFunction = new sqlFunction('Function', 'table.field', true);
echo $sqlFunction->toString(); // FUNCTION(`table`.`field`)"

// ����������� ���������� �� ���������� �������
$function1 = new sqlFunction('Function_1', 'table.field', true);

$function2_arguments = array('table.field' => true, 'value');
$function2 = new sqlFunction('Function_2', $function2_arguments);

$arguments = array($function1, $function2, 'value', 'field' => true);
$sqlFunction = new sqlFunction('Function', $arguments);
echo $sqlFunction->toString() // FUNCTION(FUNCTION_1(`table`.`field`), FUNCTION_2(`table`.`field`, 'value'), 'value', `field`)

?>