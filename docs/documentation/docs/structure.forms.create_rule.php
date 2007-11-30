<p>Валидаторы, так же как и хелперы, также могут быть легко расширены новыми. Создаваемые правила должны быть отнаследованы от базового класса <i>formAbstractRule</i>. Как и в случае с callback-функциями, валидация считается пройденной, если валидатор возвращает <i>true</i>, и проваленной в противном случае. Рассмотрим процесс создания валидаторов на примере. Пусть это будет новый валидатор, который проверяет, что введённое число попадает в определёный диапазон.</p>
<p>Создадим файл <i>formRangeRule.php</i> в каталоге <i>system/forms/validators</i>:</p>
<!-- php code 1 -->
<p>Полученный валидатор можно использовать следующим образом:</p>
<!-- php code 2 -->