function sendRate(formObj, divObj)
{
    var url = formObj.action;
    new Ajax.Request(url, {
        method: formObj.method,
        parameters: formObj.serialize(),
        onSuccess: function(transport) {
            divObj.update(transport.responseText);
        }
    });
}