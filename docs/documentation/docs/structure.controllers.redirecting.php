<p>Переадресация в контроллерах осуществляется с помощью метода <code>redirect</code>:</p>
<<code php>>
    $this->redirect($url, [$code = 302]);
<</code>>
<p>В переменной $url хранится адрес, на который нужно перейти.</p>
<p>Необязательный параметр $code содержит в себе код HTTP ответа, который будет послан при редиректе (<a href="http://en.wikipedia.org/wiki/List_of_HTTP_status_codes#3xx_Redirection">подробно</a>).</p>