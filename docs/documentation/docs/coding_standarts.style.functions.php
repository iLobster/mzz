<p>������ ������ ������ ���������� ���� ������� ��������� � ������� ������ �� ��������� private, protected ��� public.</p>

<p>��� � � �������, �������� ������ ������ ������� �� ��������� ������ ��� ������ �������. ������� ����� ������ ������� � ������� ������� ��� ���������� �����������. ��������� ����������� ��������.</p>

<p>������� � ���������� ������� ��������� ������ �� ��������������.</p>

<p>������ ����������� ������:</p>
<<code php>>
/**
&nbsp;* ���� ������������
&nbsp;*/
class Foo
{
&nbsp;&nbsp;&nbsp;&nbsp;/**
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* ���� ������������
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*/
&nbsp;&nbsp;&nbsp;&nbsp;public function bar($arg, $name, $value = 'default')
&nbsp;&nbsp;&nbsp;&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;// ���������� ������
&nbsp;&nbsp;&nbsp;&nbsp;}
}
<</code>>

<p>������������ �������� �� ������ ����������� � ������� ������:</p>
<<code php>>
return $this->bar; // ���������
return($this->bar); // �����������
<</code>>