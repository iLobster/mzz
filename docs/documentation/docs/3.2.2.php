<p>��� ������� ������ ������ ���� �������� ����� ������ <code>httpRequest</code>. ������������ ����� ������ ���� ����� ������, ������� ����� �������� �� Toolkit</p>
<<code>>
$request = $toolkit->getRequest();
<</code>>
<p>����� �������� ������� ������ ���������� �������� <code>httpRequest::get()</code>, ������� ��������� ������ ���������� ��� ������� ����������, ������ - ���, � �������� ����� ��������� �������� � ������� - �������� ������.</p>
<!-- code 1 -->

<p>��������� ����:</p>
<table border="1">
<tr>
 <td><strong>���</strong></td>
 <td><strong>��������</strong></td>
</tr>
<tr>
 <td>mixed</td>
 <td>����� ��� ������</td>
</tr>
<tr>
 <td>string</td>
 <td>������</td>
</tr>
<tr>
 <td>integer</td>
 <td>�����</td>
</tr>
<tr>
 <td>array</td>
 <td>������</td>
</tr>
<tr>
 <td>boolean</td>
 <td>������ �������� (true ��� false)</td>
</tr>
</table>
<<note>>���� ������ ��� ������� ������, � ��������� ��� �� �������� 'array', �� �� ������� ����� ������� ������ �������, ������� � ����� �������� � ������� ����.<</note>>

<p><code>httpRequest</code> ����� � ��������� ���������� ������� ������:</p>
<table border="1">
<tr>
 <td><strong>���������</strong></td>
 <td><strong>��������</strong></td>
</tr>
<tr>
 <td>SC_GET</td>
 <td>������, ���������� �� ������� $_GET (��� GET-�������)</td>
</tr>
<tr>
 <td>SC_POST</td>
 <td>������, ���������� �� ������� $_POST (��� POST-�������)</td>
</tr>
<tr>
 <td>SC_REQUEST</td>
 <td>������, ���������� �� ������� $_GET ��� $_POST (��������� ����� ��������� ������)</td>
</tr>
<tr>
 <td>SC_COOKIE</td>
 <td>������, ���������� �� ������� $_COOKIE</td>
</tr>
<tr>
 <td>SC_SERVER</td>
 <td>������, ���������� �� ������� $_SERVER</td>
</tr>
<tr>
 <td>SC_PATH</td>
 <td>������ �� ����, ������������ ������������� (������� � ��������� �� ������ <code>requestRouter</code>)</td>
</tr>
</table>

<p>�� <code>httpRequest</code> ����� ���� �������� ����� ����� ������, ���: ����������� URL, ������� ��������, ������, ������ �� ������ ���������� AJAX � ��.</p>
