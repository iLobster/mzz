<p>��� ��������� ����� ����� � ������� ������������ �������� ��������. ����� � �������� �������� ����������� � �������� <i>system/forms</i>. ����� ������� ��������, ��� ��������� ������������ �������� xhtml-���. ������ ������� ����������� �� ������������� ���������� � �������������� �������� �����, � ������ ������������� � ����������. ������� ����������� �� ������� ��������� �������:</p>
<<code>>
    {form->helper_name ...}
<</code>>
<p>������� ����� ��������� ��������� ���������. ��� ���� �������� ����� ���� ����������:</p>
<ul>
    <li>
        <i>name</i> - ��������, ������������ ��� �������
    </li>
    <li>
        <i>value</i> - ��������, ������������ ��������, ������������� � �������
    </li>
    <li>
        <i>freeze</i> - ��������, ������������, ��� ���� ����� ����������, �.�. ������ ��������� ��������, � ������� ����� ����������� ��������� �������� (�������� �������, ������������� ��������, �������� �������� �� ������), ����� ������� �������
    </li>
</ul>
<p>����� ����� ���� ������� ����� ��������� html-����������, ������������ � �����. ��������: <i>style</i>, <i>class</i>, <i>id</i>. ������� �� �������������:</p>
<<code>>
    {form->text style="form_text_field" id="some_field" name="login"}
<</code>>
<p>� ������������� �������� ��������� �������:</p>
<ul>
    <li>
        <i>caption</i> - ������������ ��� ������ �������� ���� �����. � ������� ��������� <i>name</i> �����������, � ������ �� ����� ����� ��������� ���� ���������.
        <<code>>
            {form->caption name="title" value="��������" onError="style=color: red;" onRequired='&lt;span style="color: red; font-size: 150%;"&gt;*&lt;/span&gt; '}
        <</code>>
        ���� ������, ��� ���������� ������ � ��� �������, ��� ���� ����� � ������ <i>title</i> ����� ��������� ��� ������, ����������� ��������� ���:
        <<code>>
            ��������
        <</code>>
        � �������������� ���� ����������� ��� ��������� ���������, ������� ����� ���� ������������ � �������
        <ul>
            <li>
                <i>onError</i> - ������������ ����-�����, ������� ����� ��������� � ����� <i>&lt;span&gt;</i>, � ������� ������������� ����������� ������ ������ (� ������ - ���� ����, � �������� ��������� �������, ������� � ��������).<br />
                ��������������� ����:
                <<code>>
                    &lt;span style="color: red;"&gt;��������&lt;/span&gt;<br />
                <</code>>
                �����������:
                <<code>>
                    <span style="color: red;">��������</span>
                <</code>>
            </li>
            <li>
                <i>onRequired</i> - ��������, ���������� �� ����, ��������� ����� ���������� ���� � ������������, ��� ������ ���� �������� ������������ � ����������. ��������� �� ��������� ��� ������� ��������� ��������:<br />
                <<code>>
                    &lt;span style="color: red;"&gt;*&lt;/span&gt; 
                <</code>>
                ��� ��������������� ����, � ������, ���� ���� ����� <i>title</i> �������� ������������ � ����������, ��������������� ���� �����:
                <<code>>
                    &lt;span style="color: red; font-size: 150%;"&gt;*&lt;/span&gt; ��������
                <</code>>
                �����������:
                <<code>>
                    <span style="color: red; font-size: 150%;">*</span> ��������
                <</code>>
            </li>
        </ul>
    </li>
    <li>
        <i>checkbox</i> - ������ ��� ������ checkbox'��. �������� ������ ������������� �������:
        <<code>>
            {form->checkbox name="save" text="���������" value="off" values="off|on"}
        <</code>>
        �� ������ ������� ���� ����� ������������ �������� html:
        <<code>>
            &lt;input name="save" type="hidden" value="off" /&gt;&lt;input id="mzzForms_ccbde77946cbec11692f84948f593d48" name="save" type="checkbox" value="on" /&gt;&lt;label for="mzzForms_ccbde77946cbec11692f84948f593d48" style="cursor: pointer; cursor: hand;"&gt;���������&lt;/label&gt;
        <</code>>
        � �������� ������������ ��� ����� ��������� ��������� �������:
        <<code>>
            <input name="save" type="hidden" value="off" /><input id="mzzForms_ccbde77946cbec11692f84948f593d48" name="save" type="checkbox" value="on" /><label for="mzzForms_ccbde77946cbec11692f84948f593d48" style="cursor: pointer; cursor: hand;">���������</label>
        <</code>>
        � �������� ����������� ���������� ����� ������������� <i>name</i> � <i>value</i>, checkbox ����� ����� ��������� ������� <i>text</i>, ������� ����� �������� �����, ���������� ���������� ������� ��������. ���� �������� �������������� � �������� <i>values</i>, � ������� ����������� ��������, ������������ �� ������ ��� ����������� � ���������� ��������� �������������� (�������� �� ���������: <i>0|1</i>).
    </li>
    <li>
        <i>file</i> - ������, �������������� ����������� ���� ������ �����. ������ �������������:
        <<code>>
            {form->file name="file"}
        <</code>>
        ��������������� html:
        <<code>>
            &lt;input name="file" type="file" /&gt;
        <</code>>
        �����������:
        <<code>>
            <input name="file" type="file" />
        <</code>>
    </li>
    <li>
        <i>radio</i> - ������ ��� ��������� �������� ���������� "�����-������" (radio-button). ������ �������������:
        <<code>>
            {form->radio name="field" text="sample radio button" value=10}
        <</code>>
        Html:
        <<code>>
            &lt;input id="mzzForms_25c6f3917428566415187f5b2d3020f1" name="field" type="radio" value="10" /&gt;&lt;label for="mzzForms_25c6f3917428566415187f5b2d3020f1" style="cursor: pointer; cursor: hand;"&gt;sample radio button&lt;/label&gt;
        <</code>>
        �����������:
        <<code>>
            <input id="mzzForms_25c6f3917428566415187f5b2d3020f1" name="field" type="radio" value="10" /><label for="mzzForms_25c6f3917428566415187f5b2d3020f1" style="cursor: pointer; cursor: hand;">sample radio button</label>
        <</code>>
    </li>
    <li>
        <i>select</i> - ������ ��� ��������� ����������� ������. ������ �������������:
        � ��� ������� ���������� ������ � �������� ����������� ������:
        <!-- code 1 -->
        � � ������� ������� ������:
        <<code>>
            {form->select name="sample_select" options=$data one_item_freeze=1 value="2" emptyFirst=1}
        <</code>>
        �� ����� �������������:
        <<code>>
            &lt;select name="sample_select"&gt;<br />
            &lt;option value=""&gt;&amp;nbsp;&lt;/option&gt;<br />
            &lt;option value="1"&gt;One&lt;/option&gt;<br />
            &lt;option value="2" selected="selected"&gt;Two&lt;/option&gt;<br />
            &lt;option value="3"&gt;Three&lt;/option&gt;<br />
            &lt;/select&gt;
        <</code>>
        �����������:
        <<code>>
            <select name="sample_select">
            <option value="">&nbsp;</option>
            <option value="1">One</option>
            <option value="2" selected="selected">Two</option>
            <option value="3">Three</option>
            </select>
        <</code>>
        �������������� ���������, ������� ����� ��������� ������ ������:
        <ul>
            <li><i>emptyFirst</i> - ������������� � �������� "<i>1</i>", ������ �������� ������� � ������� ������� ������ ������ �����, � ������ ���������. �������� �� ���������: "<i>0</i>"</li>
            <li><i>one_item_freeze</i> - ������������� � �������� "<i>1</i>", ������ �������� "���������" (�.�. ��������� �� ������ � ������� �������) ������ � ������, ���� ������� ���� 1 ������� ��� ������. �������� �� ���������: "<i>0</i>"</li>
        </ul>
    </li>
    <li>
        <i>textarea</i> - ������ ��� ��������� ���������
        <<code>>
            {form->textarea content="���������� ����������" name="sample"}
        <</code>>
        Html:
        <<code>>
            &lt;textarea name="sample"&gt;���������� ���������&lt;/textarea&gt;
        <</code>>
        ���� ������ ������� ���������� <i>text</i>, � ��� ���� ��������, ��� ��������, ������� ����� �������� � ���� ���� - ������������ � �������� <i>content</i>.
    </li>
    <li>
        <i>text</i> - ������ ��� ����������� ���� ������������� ���� �����.
        <<code>>
            {form->text value="����������" name="sample"}
        <</code>>
        Html:
        <<code>>
            &lt;input type="text" name="sample" value="����������" /&gt;
        <</code>>
    </li>
    <li>
        ��������� �������: <i>password</i>, <i>image</i>, <i>hidden</i>, <i>submit</i>, <i>reset</i>, ������������ ���������� ������� <i>text</i>.
    </li>
</ul>
