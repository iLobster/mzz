function addListener(elm,event,func) {
    if(document.attachEvent) {
        elm.attachEvent("on"+event, func);
    } else if(document.addEventListener) {
        elm.addEventListener(event, func, true);
    } else {
        eval(elm+".on"+event+"="+func);
    }
}

var scriptSaver = {};

function parseJSFromXML(xml) {

    if (!xml || !xml.documentElement) {
        return false;
    }
    xml = xml.documentElement;

    var items = xml.getElementsByTagName('javascript');
    var cn = items.length;
    scriptSaver = {'cn':cn};

    if (cn > 0) {
        for (var i=0; i < cn; i++) {
            var script_src = items[i].getAttribute('src');
            var doLoad = true;
            if (document.scripts) {
                var cn2 = document.scripts.length;
                for (j = 0; j < cn2; j++) {
                    if (document.scripts[j].id == script_src) {
                      doLoad = false;
                      --scriptSaver.cn;
                    }
                }
            }

            if (doLoad) {
                // create script element
                var scr = document.createElement('script');
                if (!window.opera) { addListener(scr, 'readystatechange', onScriptLoad); }
                addListener(scr, 'load',  onScriptLoad);
                addListener(scr, 'error', onScriptLoad);
                scr.type = 'text/javascript';
                void(scr.src = script_src /*+ '?' + new Number(new Date())*/);
                void(scr.id = script_src);
                document.getElementsByTagName('head')[0].appendChild(scr);
            }
        }
    }

    function onScriptLoad(evt) {
        evt = evt || event;
        var elem = evt.target || evt.srcElement;
        if (evt.type == 'readystatechange' && elem.readyState && !(elem.readyState == 'complete' || elem.readyState == 'loaded')) {
            return;
        }
        if (--scriptSaver.cn == 0) {
            executeJsCode(scriptSaver.items);
            delete scriptSaver;
        }
    }

    var items = xml.getElementsByTagName('execute');
    if (items) {
        if (scriptSaver && scriptSaver.cn == 0) {
            executeJsCode(items);
        } else {
            scriptSaver.items = items;
        }
    }
}

function executeJsCode(items) {
    var cn = items.length
    var toEval = '';
    for (var i=0; i<cn; i++) {
        for (var j=0; j<items[i].childNodes.length; j++) {
            var js_code = items[i].childNodes[j].data;
            toEval += js_code;
        }
    }
    try {
        eval(toEval);
    } catch(err) {
        alert('Inline script error ' + err.name + ': ' + err.message);
    }
}