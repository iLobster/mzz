<p>Работа с пакетом <code>cache</code> происходит единообразно для всех типов хранилищ и всех конфигураций. Для начала работы необходимо получить объект с нужной конфигурацией из <code>toolkit</code>'а:</p>
<<code php>>
$cache = $this->toolkit->getCache('fast');
<</code>>
<p>В результате будет возвращён объект типа <code>cache</code>, реализующий интерфейс:</p>

<table class="beauty">
    <tr>
        <th>Метод</th>
        <th>Аргументы</th>
        <th>Возвращаемое значение</th>
        <th>Описание</th>
    </tr>

    <tr>
        <td>get</td>
        <td>
            <ul>
                <li><code>string $key</code> - извлекаемый ключ;</li>
                <li><code>[mixed &$result = null]</code> - извлекаемое значение.</li>
            </ul>
        </td>
        <td>
            Boolean:
            <ul>
                <li><code>true</code> - искомое значение найдено;</li>
                <li><code>false</code> - в противном случае.</li>
            </ul>
        </td>
        <td>
            Этот метод используется для получения значений, сохранённых в кэше.
<<code php>>
if ($cache->get('key', $value)) {
    echo 'Найденное значение: ' . $value;
} else {
    echo 'Значение не найдено';
}
<</code>>
        </td>
    </tr>

    <tr>
        <td>set</td>
        <td>
            <ul>
                <li><code>string $key</code> - сохраняемый ключ;</li>
                <li><code>mixed $val</code> - сохраняемое значение;</li>
                <li><code>[array $tags = array()]</code> - массив тегов, проассоциированных с данным ключом;</li>
                <li><code>[int $expire = null]</code> - время жизни ключа, в секундах.</li>
            </ul>
        </td>
        <td>
            Mixed: возвращаемое значение зависит от используемого хранилища. Обычно - <code>true/false</code>.
        </td>
        <td>
            Этот метод используется для сохранения значений в кэше.
<<code php>>
$data = array(1, 'some string');
$cache->set('key', $data);
<</code>>
            Сохранение данных с пометкой их тегами "sample" и "documentation" и временем жизни в 1 минуту:
<<code php>>
$data = 'some data to cache';
$cache->set('key', $data, array('sample', 'documentation'), 60);
<</code>>
        С одним и тем же тегом может быть проассоциировано любое число ключей. И наоборот: не накладывается никаких разумных ограничений на число тегов, проассоциированных с ключом.
        </td>
    </tr>

    <tr>
        <td>delete</td>
        <td>
            <ul>
                <li><code>string $key</code> - удаляемый ключ.</li>
            </ul>
        </td>
        <td>
            Mixed: возвращаемое значение зависит от используемого хранилища. Обычно - <code>true/false</code>.
        </td>
        <td>
            Этот метод используется для удаления значений из кэша.
<<code php>>
$cache->delete('key');
<</code>>
        </td>
    </tr>

    <tr>
        <td>clear</td>
        <td>
            <ul>
                <li><code>string $tag</code> - имя очищаемого тега.</li>
            </ul>
        </td>
        <td>
            Mixed: возвращаемое значение зависит от используемого хранилища. Обычно - <code>true/false</code>.
        </td>
        <td>
            Этот метод используется для удаления значений из кэша по связанному с ним тегу. Если ключей, ассоциированных с указанным тегом, несколько, тогда будут удалены все вхождения.
<<code php>>
$data = 'some data to cache';
$cache->set('key', $data, array('sample', 'documentation'), 60);

$cache->clear('sample');
<</code>>
        В примере был удалён установленный ранее ключ 'key', потому как при установке его значения одним из тегов был указан тег 'sample'.
        </td>
    </tr>

    <tr>
        <td>flush</td>
        <td></td>
        <td>void</td>
        <td>
            Этот метод используется для очистки содержимого всего хранилища.
<<code php>>
$cache->flush();
<</code>>
<<note>>В зависимости от типа хранилища, могут очищаться все данные в нём (как в memcache) или только относящиеся к данной конфигурации (как в file).<</note>>
        </td>
    </tr>
</table>