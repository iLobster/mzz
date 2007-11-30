<p>Структура каталогов типичного модуля mzz выглядит следующим образом (рассмотрим на примере стандартного модуля <code>news</code>):</p>
<<code>>
news/
  actions/
  controllers/
  mappers/
  maps/
  news.php
  newsFactory.php
  newsFolder.php
<</code>>
<p>Перечислим все представленные элементы и опишем их назначение:
<ul>
        <li><em>actions/</em> - каталог, в котором расположены ini-файлы, описывающие, какие действия есть у конкретного Доменного Объекта данного модуля. (ссылка на подробное описание в этом же разделе)
        </li>
        <li><em>controllers/</em> - каталог, в котором расположены контроллеры модуля. (ссылка на описание что такое контроллеры)
        </li>
        <li><em>mappers/</em> - каталог, в котором расположены мапперы. (ссылка на описание мапперов)
        </li>
        <li><em>maps/</em> - каталог, в котором расположены map-файлы, описывающие схему БД каждого из Доменных Объектов. (ДО ссылка на описание ДО, map - на описание мапфайла)
        </li>
        <li><em>news.php, newsFolder.php</em> - Доменные Объекты модуля <code>news</code>.
        </li>
        <li><em>newsFactory.php</em> - фабрика (ссылка на описание паттерна), по запросу возвращающая нужный контроллер. (ссылка на описание контроллера в MVC)
        </li>
</ul>
</p>
<p>Далее рассмотрим примеры файлов рассматриваемого модуля. Для демонстрации выберем метод <code>View</code>.</p>