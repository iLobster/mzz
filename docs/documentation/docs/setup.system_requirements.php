Минимальные требования к программному обеспечению веб-сервера:<br />
<ul type="circle">
  <li>PHP >=5.1.4</li>
  <li>PHP модули: PDO, PDO_MYSQL, PCRE</li>
  <li>MySQL: 4 (желательно > 4.1.x), 5</li>
  <li>HTTP-сервер: Apache 1.x/2.x (с модулем mod_rewrite), IIS 6 и выше с наличием модуля rewrite (например, <a href="http://www.isapirewrite.com">isapirewrite</a>)</li>
  <li>OS: Windows / UNIX</li>
</ul>
<p>Перед первым запуском будет определена совместимость с ПО веб-сервера. Если mzz совместим, будет создан файл <code>tmp/checked</code>, блокирующий проверку при следующих запусках. В случае несоответствия будут отображены причины.</p>