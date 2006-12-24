<p>������������� (Routing) - ��� ������� ���������� ������������ URL �� ������������� ������ � ������� ������� (route). ������ � ����� ������� �������� ����� ������ <code>httpRequest</code> � ������� ���������� <code>SC_PATH</code>.</p>
<p>��� �������� ������ ������� � ���� configs/routes.php, ������� ���������� � ����� �������, ������������ ��������� ����������� ���:</p>
<<code>>
$router->addRoute('nameOfRule', new requestRoute('/:section/:action'));
<</code>>
<<note>>�������� �� ���������� � �������� ����������� � �������� �������.<</note>>
���� ������������� URL <code>example.com/foo/bar</code>, �� �� �������� � �������� (� ����� ������� �������� �������� <code>/:section/:action</code>, ��� <code>:section</code> � <code>:action</code> - placeholder�) � ���������� ��� ������������. ����� �������������� ������� - ����� placeholder-��. �������� - <code>foo</code> � <code>bar</code> ��������������.</p>

<<note>>����� placeholder-�� ����� �������� ������ �� ��������� ���� � ����� ������������� ("_").<</note>>

<p>����� ������� ��������� ����� ���������:
<<code>>
array([section] => foo, [action] = bar)
<</code>>
<p>� �������, ����� placeholder-��, ����� ���� ������� ����� ����������� ��������, ������� ����������� ������ ��� �������� �� ���������� � ���. ��������, ������ <code>/:section/site/:action</code> �������� � <code>example.com/foo/site/bar</code>, �� ��������� �� ���������.</p>

<p>����� placeholder ����� ����� �������� �� ���������. ��������� ���� placeholder � ������� ������������� (� ������� ���� ������� �������� �� ��������� ��� ��������� <code>id<code>). </p>
<<code>>
$router->addRoute('nameOfRule', new requestRoute('/:section/:action', array('section' => 'news', 'action' => 'list', 'id' => 1)));
<</code>>
<p>������ ������� �������� �� ���������� URL: <code>example.com/news/list</code>, <code>example.com/news</code>, <code>example.com</code>, <code>example.com/users</code>, <code>example.com/users/edit</code> � �.�.<br /> ����� ������������ ����� ������� ��������� ���������:</p>
<<code>>
// example.com/news/list<br />
array([section] => news, [action] => list, [id] => 1)<br /><br />

// example.com/news<br />
array([section] => news, [action] => list, [id] => 1)<br /><br />

// example.com<br />
array([section] => news, [action] => list, [id] => 1)<br /><br />

// example.com/users<br />
array([section] => users, [action] => list, [id] => 1)<br /><br />

// example.com/users/edit<br />
array([section] => users, [action] => edit, [id] => 1)
<</code>>

<p>�� ��������� placeholder ��������� �� ���� ������ �� "/". �� ������ ��� ��������, ������ ����������� ���������� �� ����� perl-����������� ���������� ��������� (PCRE):</p>
<<code>>
$router->addRoute('nameOfRule', new requestRoute('/:section/:id-:action'), array(), array('id' => '\d+'));
<</code>>
<p>������� �������� � URL <code>example.com/news/1-view</code> � ����������� �����:</p>
<<code>>
array([section] => news, [id] => 1, [action] => view)
<</code>>
