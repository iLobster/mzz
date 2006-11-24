var last_jipmenu_id;
var agt = navigator.userAgent.toLowerCase();
var is_ie = (agt.indexOf("msie") != -1) && (agt.indexOf("opera") == -1);
var is_gecko = navigator.product == "Gecko";
var layertimer;

var urlStack = new Array;
var currentUrl;
var formSuccess = false;


var $break    = new Object();
var $continue = new Object();


function getPosition(el, body)
{
    if(!el || !el.offsetParent) {
        return false;
    }
    var left = 0, top = 0, right = 0, bottom = 0;

    objParent = el;
   
    do { 
        left += objParent.offsetLeft;
        top += objParent.offsetTop;
        objParent = objParent.offsetParent;
    } while (objParent && objParent != body)
        
    right = left + el.offsetWidth;
    bottom = top + el.offsetHeight;

    return {"left": left, "top": top, "right": right, "bottom": bottom};
}



function each(values, iterator) {
    var index = 0;
    try {
      _each(values, function(value) {
        try {
          iterator(value, index++);
        } catch (e) {
          if (e != $continue) throw e;
        }
      });
    } catch (e) {
      if (e != $break) throw e;
    }
}


function collect(values, iterator) {
    var results = [];
    each(values, function(value, index) {
      results.push(iterator(value, index));
    });
    return results;
}


function _each(values, iterator) {
   for (var i = 0; i < values.length; i++)
   iterator(values[i]);
}


function extractScripts(response) {
    jsFragment = '(?:<script.*?>)((\n|\r|.)*?)(?:<\/script>)';
    var matchAll = new RegExp(jsFragment, 'img');
    var matchOne = new RegExp(jsFragment, 'im');

    return collect(response.match(matchAll) || [], function(scriptTag) {
        return (scriptTag.match(matchOne) || ['', ''])[1];
    });

}

function evalScripts(response) {
    return collect(extractScripts(response), eval);
}


var handleSuccess = function(o){
    if(typeof o.responseText !== undefined){
        urlStack.push([currentUrl]);
        o.argument.div.innerHTML = "<div style='float: right;'><img alt='Закрыть' class='jip' width='16' height='16' src='/templates/images/close.gif' onclick='javascript: hideJip();' /></div>";
        if (o.argument.success == true) {
            o.argument.div.innerHTML += "<div style='background-color: #EEF8E7; padding: 2px; text-align: center; width: 160px; border: 1px solid #C9E9B1; color: green; font-weight: bold;'>Данные сохранены.</div>";
        }
        o.argument.div.innerHTML += o.responseText;
        evalScripts(o.argument.div.innerHTML);
    }
}

var handleInSuccess = function(o){
    if(typeof o.responseText !== undefined){
        o.argument.div.innerHTML = '';
        if (o.argument.success == true) {
            o.argument.div.innerHTML += "<div style='background-color: #EEF8E7; padding: 2px; text-align: center; width: 160px; border: 1px solid #C9E9B1; color: green; font-weight: bold;'>Данные сохранены.</div>";
        }
        o.argument.div.innerHTML += o.responseText;
        evalScripts(o.argument.div.innerHTML);
    }
}

var handleFormSuccess = function(o){
    if(typeof o.responseText !== undefined){
        showJip(o.argument.currentUrl);
        //o.argument.div.innerHTML = "<div style='float: right;'><img alt='Закрыть' width='16' height='16' src='/templates/images/close.gif' onclick='javascript: hideJip();' /></div>";
        //o.argument.div.innerHTML += '<div style="font-size: 100%;color: green;">Данные сохранены</div>' + o.responseText;
        //div.innerHTML += "<li>HTTP status: " + o.status + "</li>";
    }
}

var handleFailure = function(o){
    if(typeof o.responseText !== undefined){
        alert("No response. Server error. \r\n Trans_id: " + o.tId + "; HTTP status: " + o.status + "; Code message: " + o.statusText);
    }
}


document.onkeydown = proccessKey;

function proccessKey(key) {
    var code;
    if (!key) key = window.event;
    if (key.keyCode) code = key.keyCode;
    else if (key.which) code = key.which;
    if (code == 27) {
        return hideJip();
    }
}

var lastJipUrl = false;

function showJip(url, success)
{
    cleanJip();
    if (document.getElementById('jip')) {

        document.getElementById('blockContent').style.display = 'block';
        /*if (lastJipUrl != false) {
        urlStack.push([lastJipUrl]); alert(lastJipUrl);
        lastJipUrl = false;
        } else {
        lastJipUrl = url + '&xajax=true';
        }*/
        //urlStack.push([url]);

        document.getElementById('jip').style.display = 'block';


        var callback = {success:handleSuccess, failure:handleFailure, argument: { div:document.getElementById('jip'), success:success }};
        currentUrl = url;
        /*   urlStack.push([currentUrl]);
        }*/
        var request = YAHOO.util.Connect.asyncRequest('GET', url + '&ajax=1', callback);

        return false;
    }
    return true;
}


function sendFormWithAjax(form, elementId)
{
    elementId = elementId || 'jip';
    //(urlStack.slice(urlStack.length - 1, urlStack.length));
    //if (urlStack.slice(urlStack.length - 1, urlStack.length) != currentUrl) {
    //    urlStack.push([currentUrl]);
    //}
    //if(currentUrl != undefined) {
    //urlStack.push([currentUrl]);
    //    delete currentUrl;
    //}
    var callback = {success:handleSuccess, failure:handleFailure, argument: { div:document.getElementById(elementId), currentUrl:currentUrl }};
    YAHOO.util.Connect.setForm(form);
    var request = YAHOO.util.Connect.asyncRequest(form.getAttribute('method').toUpperCase(), form.action + '&ajax=1', callback);
    return false;
}

function sendFormInAjax(form, elementId)
{
    elementId = elementId || 'jip';
    cleanSubJip(elementId);
    var callback = {success:handleInSuccess, failure:handleFailure, argument: { div:document.getElementById(elementId), currentUrl:currentUrl }};
    YAHOO.util.Connect.setForm(form);
    var request = YAHOO.util.Connect.asyncRequest(form.method.toUpperCase(), form.action + '&ajax=1', callback);
    return false;
}



function hideJip(windows, success)
{
    if(success === undefined){
        success = false;
    }
    if(windows == undefined){
        windows = 1;
    }
    if(document.getElementById('jip')) {

        if (urlStack.length > 0) {
            for (i = 0; i < windows - 1 ; i++) {
                urlFromStack = urlStack.pop();
            }
            lastJipUrl = urlStack.pop();
            urlFromStack = urlStack.pop();
            if (urlFromStack != undefined) {
                return showJip(urlFromStack[0], success);}
        }
        last_jipmenu_id = false;
        document.getElementById('blockContent').style.display = 'none';
        document.getElementById('jip').style.display = 'none';
        lastJipUrl = false;
        cleanJip();
        return true;

    }
    return true;
}

function cleanJip()
{
    document.getElementById('jip').innerHTML = 'Загрузка данных. Подождите... <br /> <input type="button" value="Закрыть" onClick="hideJip()">';
}

function cleanSubJip(elementId)
{
    elementId = elementId || 'jip';
    document.getElementById(elementId).innerHTML = 'Загрузка данных. Подождите...';
}



function getBottomPosition(el)
{
    if(!el || !el.offsetParent) {
        return false;
    }

    top_position = el.offsetTop;
    var objParent = el.offsetParent;

    while(objParent && objParent.tagName != "body")
    {
        top_position += objParent.offsetTop;
        objParent = objParent.offsetParent;
    }
    return top_position + el.offsetHeight;
}


function openJipMenu(button, jipMenu, id) {


    jipMenu.style.top = '-100px';
    jipMenu.style.left = '-100px';
    jipMenu.style.display = 'block';

    if (last_jipmenu_id) {
        closeJipMenu(document.getElementById('jip_menu_' + last_jipmenu_id));
    }
    /**************
    if (is_gecko) {
        curr_x = button.x;
        curr_y = button.y + 17;
    } else {
        e = window.event;

        curr_x = (e.pageX) ? e.pageX : e.x + 2; // + document.documentElement.scrollLeft;
        curr_y = (e.pageY) ? e.pageY : e.y + 2; // + document.documentElement.scrollTop;
    }

    var bottom_position = getBottomPosition(button);

    var x = curr_x , y = curr_y;
    var w = jipMenu.offsetWidth;
    var h = jipMenu.offsetHeight;
    var body = document.documentElement;

    if((body.clientWidth + body.scrollLeft) < (x + jipMenu.clientWidth))
    {
        x = body.scrollLeft + body.clientWidth - (jipMenu.clientWidth + 20);
    }

    if((body.clientHeight + body.scrollTop) < (bottom_position + jipMenu.clientHeight ))
    { 
        y = ( body.clientHeight - body.scrollTop) - bottom_position-  jipMenu.clientHeight + 30;
    }
    **********/


    if (document.getElementById('jip').style.display == 'block') {
         var body = document.getElementById('jip');
    } else {
         var body = document.body;
    }

    pos = getPosition(button, body);
    var x = pos["left"], y = pos["bottom"], w = jipMenu.offsetWidth, h = jipMenu.offsetHeight;

    if((body.clientWidth + body.scrollLeft) - (pos["left"] + w) < 0) {
        x = (pos["right"] - w >= 0) ? (pos["right"] - w) : body.scrollLeft;
    }

    if((body.clientHeight + body.scrollTop) - (pos["bottom"] + h) < 0) {
        y = (pos["top"] - h >= 0) ? (pos["top"] - h) : body.scrollTop;
    }

    if (body != document.body && is_gecko) {
        x += 4;
        y += 4;
    }

    jipMenu.style.left = x + 'px';
    jipMenu.style.top = (y + 1) + 'px';
    //jipMenu.style.width = w + 'px';
    last_jipmenu_id = id;
}

function closeJipMenu(jipMenu) {
    jipMenu.style.display = 'none';
    last_jipmenu_id = false;
    if(layertimer) {
        clearTimeout(layertimer);
    }
}


function showJipMenu(button, id) {
    jipMenu = document.getElementById('jip_menu_' + id);
    if (!jipMenu.style.display || jipMenu.style.display == 'none') {
        openJipMenu(button, jipMenu, id);
    } else {
        closeJipMenu(jipMenu);
    }
}

function setMouseInJip(status) {
    if (status == false && last_jipmenu_id) {
        jipMenu = document.getElementById('jip_menu_' + last_jipmenu_id);
        layertimer = setTimeout("closeJipMenu(jipMenu)", 800);
    } else {
        clearTimeout(layertimer);
    }
}
