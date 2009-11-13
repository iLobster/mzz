<p>Работа с пакетом <code>cache</cache> происходит единообразно для всех типов хранилищ и всех конфигураций. Для начала работы необходимо получить объект с нужной конфигурацией из <code>toolkit</code>'а:</p>
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
$cache->set('key1', $data, array('sample', 'documentation'), 60);
<</code>>
        </td>
    </tr>
</table>