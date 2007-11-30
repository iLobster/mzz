<p>Пример типичного маппера:</p>
<!-- php code 1 -->

<p>В общем случае каждый маппер должен лишь переопределить 2 свойства: <code>$name</code> и <code>$className</code> (имя модуля и Доменного Объекта, обслуживаемого данным маппером, соответственно). Методы являются опциональными и предназначены для расширения функциональности и удобства использования мапперов (метод <code>searchById()</code>), либо изменяющие поведение маппера (методы <code>updateDataModify()</code> и <code>insertDataModify()</code>, которые производят модификации данных перед обновлением и созданием DO соответственно. Эти методы являются реализацией The Template Pattern - ссылка).</p>