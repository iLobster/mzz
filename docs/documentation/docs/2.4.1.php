<p>������������ mzz ���������� � ����� <code>config.php</code> � ����� �������. ��� ������������� ����� �������� ����������� �����.</p>
<p>�������� �����:</p>

<center>
<div class="options_name">SYSTEM_PATH <span class="options_value">= ../system/</span></div>
<div class="options_desc">���� �� mzz. �������� �������� ��� ��������������, ��� � ����������� ����</div>

<div class="options_name">DEBUG_MODE <span class="options_value">= true</span></div>
<div class="options_desc">���������/���������� debug-������. ��������� ��������: <code>true</code> ��� <code>false</code>. ���� ������� 'true',
 �� ������ �������������� � ���������� ������ mzz ����� ���������� ��������������� � �������.
 <<note>>����������� debug ����� ������ � �������� ���������� �����, � ������� �������� ��� ����� ������ ���� ��������� (false),
 ��� ��� � ������� ������ ����� ����������� ���������������� ����������<</note>>
</div>

<div class="options_name">MZZ_USER_GUEST_ID <span class="options_value">= 1</span></div>
<div class="options_desc">������������� ������ � ���� ������ ��� ������������������ �������������. ��������� ��������� ��� �������
 ���� ������ � ������� ��� ���� ������������ � ��������������� ������������� �� ���������. 
 <<note>>������������ � ��������� ��������������� � ��������� <code>MZZ_USER_GUEST_ID</code> ������ ������������<</note>>
</div>

<div class="options_name">systemConfig::$db['default']['driver'] <span class="options_value">= PDO</span></div>
<div class="options_desc">������� ��� ������ � ��.</div>

<div class="options_name">systemConfig::$db['default']['dsn'] <span class="options_value">= mysql:host=localhost;dbname=mzz</span></div>
<div class="options_desc">DSN, �������� ����������� ���������� � ���� ������. ����� �������� � ������� [todo]</div>

<div class="options_name">systemConfig::$db['default']['user'] <span class="options_value">= root</span></div>
<div class="options_desc">��� ������������ ��� ������� � ��, ��������� � DNS</div>

<div class="options_name">systemConfig::$db['default']['password'] <span class="options_value">= null</span></div>
<div class="options_desc">������ ��� ������� � ��, ��������� � DNS</div>

<div class="options_name">systemConfig::$db['default']['charset'] <span class="options_value">= cp1251</span></div>
<div class="options_desc">��������� ��. ����� ��������� ���������� � �� ����������� ������: <code>SET NAMES `���������`</code></div>

<div class="options_name">systemConfig::$db['default']['pdoOptions'] <span class="options_value">= array()</span></div>
<div class="options_desc">�������������� ����� ���������� � �� ��� PDO. ����� ��������� ���������� �������� � <a href="http://www.php.net/manual/ref.pdo.php">����������� �� PHP</a></div>


</center>

