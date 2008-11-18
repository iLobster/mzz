function rate(url, container)
{
    new Ajax.Request(url, {
        method: 'get',
        onSuccess: function(transport) {
            container.update(transport.responseText);
        }
    });
}