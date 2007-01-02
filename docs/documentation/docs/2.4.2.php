<p>������������� (Routing) - ��� ������� ���������� ������������ URL �� ������������� ������ � ������� ������� (route) ��� ���������� ���� �� URL � ���. ������� ������������� �������� � ����� <code>&lt;project_folder&gt;/configs/routes.php</code>.</p>
������ � ���������� �������� ����� ������ <code>httpRequest</code> � ��������� � �������� �������� ��������� <code>SC_PATH</code>.</p>
<p>������ ����������� �������:</p>
<<code>>
$router->addRoute('nameOfRule', new requestRoute('/ru/:section/:action'));
<</code>>
<<note>>������� ��� ������ ����������� ������ �������������� � �������� �������.<</note>>
<p>��� <code>nameOfRule</code> - ���������� ��� ��� �������, <code>/ru/:section/:action</code> - ������. ������ ����� ��������� ����������� <code>/</code> (������ ����), placeholder � raw-�����. � ����� ������� <code>:section</code> � <code>:action</code> - placeholder, <code>ru</code> - raw-�����. ������������� URL <code>example.com/ru/foo/bar</code> �������� � ���� �������� � ���������� ������������ ����: � <code>httpRequest</code> ����� ������� ������������� ������, ��� ����� - ����� placeholder: <code>section</code> � <code>action</code>, �������� - <code>foo</code> � <code>bar</code> ��������������. Raw-����� ��� ���� �������� �� �����, �� ����������� ������ � �������� �������� �� ����������.</p>

<<note>>��� placeholder ������ �������� ������ �� ��������� ���� � ����� ������������� ("_").<</note>>

<p>����� ������� � <code>httpRequest</code> ����� ������� ������:
<<code>>
array([section] => foo, [action] = bar)
<</code>>

<p>����� placeholder ����� ����� �������� �� ���������, ������� ����������� �� ������ ���������. ������������ ����� placeholder � ������� ������������� (� ������� ���� ������� �������� �� ��������� ��� placeholder-� <code>id</code>, �� � ����� ������� ��� ���). </p>
<<code>>
$router->addRoute('nameOfRule', new requestRoute('/:section/:action', array('section' => 'news', 'action' => 'list', 'id' => 1)));
<</code>>
<p>������ ������� �������� �� ���������� URL: <code>example.com/news/list</code>, <code>example.com/news</code>, <code>example.com</code>, <code>example.com/users</code>, <code>example.com/users/edit</code> � �.�.<br /> ����� ������������ � <code>httpRequest</code> ����� ������� ������:</p>
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

<p>�� ��������� ��������� ��� placeholder �������� ����������� <code>/</code> (������ ����). �� ������ ��� ��������, ������ ����������� ���������� �� ����� perl-����������� ���������� ��������� (PCRE) � ������� ���������:</p>
<<code>>
$router->addRoute('nameOfRule', new requestRoute('/:section/:id-:action'), array(), array('id' => '\d+'));
<</code>>
<p>������� �������� � URL <code>example.com/news/1-view</code> � � <code>httpRequest</code> ����� ��������:</p>
<<code>>
array([section] => news, [id] => 1, [action] => view)
<</code>>

<p>������ ��������� ����������:</p>
<<code>>
$section = $this->request->get('section', 'string', SC_PATH);<br />
$id = $this->request->get('id', 'integer', SC_PATH);<br />
$action = $this->request->get('action', 'string', SC_PATH);<br />
<</code>>
