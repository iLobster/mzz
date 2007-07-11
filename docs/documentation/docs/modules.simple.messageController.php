<p> онтроллер, используемый дл€ различных информационных сообщений и предупреждений. “ипичный пример использовани€ данного контроллера:</p>
<<code php>>
$controller = new messageController('¬нимание, запрашиваема€ новость не найдена', messageController::WARNING);
return $controller->run();
<</code>>
<p>¬торым аргументом может быть передан тип выводимого сообщени€. ƒоступны следующие типы:</p>
<ul>
    <li><code>messageController::INFO</code> - сообщение информационного характера.</li>
    <li><code>messageController::WARNING</code> - предупреждение.</li>
</ul>