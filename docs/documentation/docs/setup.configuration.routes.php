<p>������������� (Routing) - ��� ������� ���������� ������������ URL �� ������������� ������ � ������� ������� (route) ��� ���������� ���� �� URL � ���. ������� ������������� �������� � ����� <code>&lt;project_folder&gt;/configs/routes.php</code>.</p>
������ � ���������� �������� ����� ������ <code>httpRequest</code> � ��������� � �������� �������� ��������� <code>SC_PATH</code>.</p>
<p>������ ����������� �������:</p>
<<code php>>
$router->addRoute('nameOfRule', new requestRoute('/ru/:section/:action'));
<</code>>
<<note>>������� ��� ������ ����������� ������ �������������� � �������� �������.<</note>>
<p>��� <code>nameOfRule</code> - ���������� ��� ��� �������, <code>/ru/:section/:action</code> - ������. ������ ����� ��������� ����������� <code>/</code> (������ ����), placeholder � raw-�����. � ����� ������� <code>:section</code> � <code>:action</code> - placeholder, <code>ru</code> - raw-�����. ������������� URL <code>example.com/ru/foo/bar</code> �������� � ���� �������� � ���������� ������������ ����: � <code>httpRequest</code> ����� ������� ������������� ������, ��� ����� - ����� placeholder: <code>section</code> � <code>action</code>, �������� - <code>foo</code> � <code>bar</code> ��������������. Raw-����� ��� ���� �������� �� �����, �� ����������� ������ � �������� �������� �� ����������.</p>

<<note>>��� placeholder ������ �������� ������ �� ��������� ���� � ����� ������������� ("_").<</note>>

<p>����� ������� � <code>httpRequest</code> ����� ������� ������:
<<code php>>
array([section] => foo, [action] = bar)
<</code>>

<p>����� placeholder ����� ����� �������� �� ���������, ������� ����������� �� ������ ���������. ������������ ����� placeholder � ������� ������������� (� ������� ���� ������� �������� �� ��������� ��� placeholder-� <code>id</code>, �� � ����� ������� ��� ���). </p>
<<code php>>
$router->addRoute('nameOfRule', new requestRoute('/:section/:action', array('section' => 'news', 'action' => 'list', 'id' => 1)));
<</code>>
<p>������ ������� �������� �� ���������� URL: <code>example.com/news/list</code>, <code>example.com/news</code>, <code>example.com</code>, <code>example.com/users</code>, <code>example.com/users/edit</code> � �.�.<br /> ����� ������������ � <code>httpRequest</code> ����� ������� ������:</p>
<<code php>>
// example.com/news/list
array([section] => news, [action] => list, [id] => 1)

// example.com/news
array([section] => news, [action] => list, [id] => 1)

// example.com
array([section] => news, [action] => list, [id] => 1)

// example.com/users
array([section] => users, [action] => list, [id] => 1)

// example.com/users/edit
array([section] => users, [action] => edit, [id] => 1)
<</code>>

<p>�� ��������� ��������� ��� placeholder �������� ����������� <code>/</code> (������ ����). �� ������ ��� ��������, ������ ����������� ���������� �� ����� perl-����������� ���������� ��������� (PCRE) � ������� ���������:</p>
<<code php>>
$router->addRoute('nameOfRule', new requestRoute('/:section/:id-:action'), array(), array('id' => '\d+'));
<</code>>
<p>������� �������� � URL <code>example.com/news/1-view</code> � � <code>httpRequest</code> ����� ��������:</p>
<<code php>>
array([section] => news, [id] => 1, [action] => view)
<</code>>

<p>������ ��������� ����������:</p>
<<code php>>
$section = $this->request->get('section', 'string', SC_PATH);
$id = $this->request->get('id', 'integer', SC_PATH);
$action = $this->request->get('action', 'string', SC_PATH);
<</code>>
