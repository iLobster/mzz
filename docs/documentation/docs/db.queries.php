<p>Для генерации SQL-запросов в mzz предназначен специальный класс simpleSelect. SimpleSelect собирает запрос из составных частей, которыми являются объекты классов criteria. Рассмотрим простейший пример:</p>
<!-- php code 1 -->
<p>Как видите - генератор запросов сам позаботился о помещении имени таблицы в обратные кавычки (`). Аналогичным образом вам не нужно заботиться об одинарных кавычках ('), в которые помещаются строковые константы, и об экранировании этих строковых констант.</p>
<p>Рассмотрим основные приёмы работы с генератором запросов (более полный вариант - как всегда смотрите в модульных тестах).</p>
<ul>
    <li>
        Выборка определённых полей
        <!-- php code 2 -->
        <<note>>Каждый из методов критерия возвращает ссылку на самого себя, таким образом методы можно выстраивать в цепочку подобным образом:<!-- php code 3 --><</note>>
    </li>
    <li>
        Выборка по условию
        <!-- php code 4 -->
        Третьим аргументом у метода criteria::add() является способ сравнения. К ним относятся: EQUAL('='), NOT_EQUAL('<>'), GREATER('&gt;'), LESS('&lt;') и другие. Список констант можно посмотреть непосредственно в классе criteria либо в API-документации (!!).
    </li>
    <li>
        Сортировка и ограничение числа записей
        <!-- php code 5 -->
    </li>
    <li>
        Объединения с другими таблицами
        <!-- php code 6 -->
        <<note>>Описание класса criterion смотрите ниже<</note>>
        Из примера видно - что в качестве условия объединения в метод criteria::addJoin() вторым аргументом передаётся объект класса criterion. Тип объединения задаётся четвёртым аргументом и может быть criteria::JOIN_INNER либо criteria::JOIN_LEFT (значение по умолчанию).
    </li>
    <li>
        Добавление группировки
        <!-- php code 7 -->
    </li>
</ul>
<p><b>Criterion</b></p>
<p>Класс criterion является атомарной составляющей в генераторе запросов. Именно он хранит информацию об операндах и условиях их сравнения. Обычной практикой является передача ему первым аргументом - имени поля, вторым - строковой константы, имени другого поля, массива с данными (для случаев с IN и BETWEEN). Третьим аргументом является тип сравнения операндов. Четвёртым - флаг, обозначающий что второй операнд является полем (вследствие чего его нужно заключать в `, а не в ' и не экранировать). Примеры использования класса:</p>
<!-- php code 8 -->
<p>Также объекты criterion можно объединять друг с другом посредством методов criterion::addAnd() и criterion::addOr(), обозначающих соответственно связь посредством логических and и or.</p>
<!-- php code 9 -->
<<note>>Метод criteria::generate() здесь вызывается в демонстрационных целей - вам не придётся его вызывать вручную, эту работу выполняет сам simpleSelect.<</note>>