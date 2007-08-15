<p>������ ������������ ��� ����, ����� �������� ����������e ��� ������ ���������� �������. ������ �������� ����������� The Composite Pattern � The Registry Pattern. � � ���� ������� ��� ����� ������� ������������ ���������� ���������� ��� ��������� ��������. � ����������� �������� � ������ ������� (���������� - ����� stdToolkit) ������ ��������� ������:</p>
<ul>
    <li><em>getRequest()</em> - ���������� ������ Request</li>
    <li><em>getResponse()</em> - ���������� ������ Response</li>
    <li><em>getSession()</em> - ���������� ������ Session</li>
    <li><em>getSmarty()</em> - ���������� ������ Smarty</li>
    <li><em>getRouter($request = null)</em> - ���������� ������ requestRouter</li>
    <li><em>getConfig($section, $module)</em> - ���������� ������ Config</li>
    <li><em>getSectionMapper($path = null)</em> - ���������� ������ SectionMapper</li>
    <li><em>getTimer()</em> - ���������� ������ Timer</li>
    <li><em>getAction($module)</em> - ���������� ������ Action ��� ������ $module</li>
    <li><em>getUser()</em> - ���������� ������ �������� ������������</li>
    <li><em>getObjectId($name = null)</em> - ���������� ���������� ������������� ����������� ��� <a href="structure.acl.html">ACL</a> (� <a href="structure.acl.html#structure.acl.obj_id">"��������" ��������</a> � ���������)</li>
    <li><em>getMapper($module, $do, $section)</em> - ���������� ����������� ������</li>
    <li><em>getCache()</em> - ���������� ������ ��� ������ � �����</li>
    <li><em>getValidator()</em> - ��������� �������� ����������</li>
    <li><em>setRequest($request)</em> - ������������� ������ Request</li>
    <li><em>setResponse($response)</em> - ������������� ������ Response</li>
    <li><em>setSession($session)</em> - ������������� ������ Session</li>
    <li><em>setSmarty($smarty)</em> - ������������� ������ Smarty</li>
    <li><em>setRouter($router)</em> - ������������� ������ requestRouter</li>
    <li><em>setSectionMapper($sectionMapper)</em> - ������������� ������ SectionMapper</li>
    <li><em>setUser($user)</em> - ������������� ������ ������������</li>
    <li><em>setConfig($config)</em> - ������������� ������ ������������</li>
    <li><em>setValidator($validator)</em> - ��������� ����������</li>
</ul>
<p>��� ��������� ��������� ������� ���������� ��������������� ��������� ������������:</p>
<<code php>>
$toolkit = systemToolkit::getInstance();
<</code>>