<p>Контроллер, используемый для различных информационных сообщений и предупреждений. Типичный пример использования данного контроллера:</p>
<<code php>>
$controller = new messageController('Запрашиваемая новость не найдена', messageController::INFO);
return $controller->run();
<</code>>
<p>Вторым аргументом может быть передан тип выводимого сообщения. По умолчанию <code>messageController::WARNING</code>.<br />Доступны следующие типы:</p>
<ul>
    <li><code>messageController::INFO</code> - сообщение информационного характера.</li>
    <li><code>messageController::WARNING</code> - предупреждение.</li>
</ul>