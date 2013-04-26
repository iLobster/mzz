<p>Тулкит предназначен для того, чтобы получать необходимыe для работы объекты. Тулкит является реализацией The Composite Pattern и The Registry Pattern. В стандартной поставке <code>toolkit</code> составляется из класса <code>stdToolkit</code> и вы можете посмотреть методы этого класса непосредственно в файле <code>system/toolkit/stdToolkit.php</code>. Сам объект <code>toolkit</code>'а вы можете получить с помощью метода-синглтона:</p>
<<code php>>
$toolkit = systemToolkit::getInstance();
<</code>>
<p>Также в контроллерах <code>toolkit</code> уже доступен через свойство <code>toolkit</code>. Пример получения текущего пользователя:</p>
<<code php>>
$this->toolkit->getUser();
<</code>>