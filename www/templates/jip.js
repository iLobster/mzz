var last_jipmenu_id;
var agt = navigator.userAgent.toLowerCase();
var is_ie = (agt.indexOf("msie") != -1) && (agt.indexOf("opera") == -1);
var is_gecko = navigator.product == "Gecko";
var layertimer;


var urlStack = new Array;
var currentUrl;
var formSuccess = false;

var handleSuccess = function(o){
	if(typeof o.responseText !== undefined){
		o.argument.div.innerHTML = "<div style='float: right;'><img alt='Закрыть' width='16' height='16' src='/templates/images/close.gif' onclick='javascript: hideJip();' /></div>";
		o.argument.div.innerHTML += o.responseText;
		//div.innerHTML += "<li>HTTP status: " + o.status + "</li>";
	}
}

var handleFormSuccess = function(o){
	if(typeof o.responseText !== undefined){
showJip(o.argument.currentUrl, 1);
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
	if (code == 27) hideJip();
}

var lastJipUrl = false;

function showJip(url, flag)
{
        cleanJip(); 
	if (document.getElementById('jip')) {

                document.getElementById('blockContent').style.display = 'block';
                /*if (lastJipUrl != false) {
                    urlStack.push([lastJipUrl]); alert(lastJipUrl);
                    lastJipUrl = false; 
                } else {
                    lastJipUrl = url + '&xajax=true';
                }*/urlStack.push([url]);

		document.getElementById('jip').style.display = 'block';


                var callback = {success:handleSuccess, failure:handleFailure, argument: { div:document.getElementById('jip') }};
                currentUrl = url;
                 /*   urlStack.push([currentUrl]);
                }*/
	        var request = YAHOO.util.Connect.asyncRequest('GET', url + '&xajax=true', callback);

                delete flag;
		return false;
	}
        delete flag;
	return true;
}


function sendFormWithAjax(form)
{

        urlStack.push([currentUrl]);
        var callback = {success:handleSuccess, failure:handleFailure, argument: { div:document.getElementById('jip'), currentUrl:currentUrl }};
        YAHOO.util.Connect.setForm(form);
	var request = YAHOO.util.Connect.asyncRequest('POST', form.action + '&xajax=true', callback);
        return false;
}


function hideJip()
{ 
	if(document.getElementById('jip')) {

             if (urlStack.length > 0) { 

                 lastJipUrl = urlStack.pop();
                 urlFromStack = urlStack.pop();
                 if (urlFromStack != undefined) {  
                 return showJip(urlFromStack[0], true);}
             }
             
             document.getElementById('blockContent').style.display = 'none';
             document.getElementById('jip').style.display = 'none';
             lastJipUrl = false; 

        }
	return false;
}

function cleanJip()
{
    document.getElementById('jip').innerHTML = 'Загрузка данных. Подождите... <br /> <input type="button" value="Закрыть" onClick="hideJip()">';
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
        jipMenu.style.display = 'block';

        if (last_jipmenu_id) {
             closeJipMenu(document.getElementById('jip_menu_' + last_jipmenu_id));
        }

        if (is_gecko) {
            curr_x = button.x;
            curr_y = button.y + 17;
        } else {
            e = window.event;

            curr_x = (e.pageX) ? e.pageX : e.x /*+ document.documentElement.scrollLeft*/;
            curr_y = (e.pageY) ? e.pageY : e.y /*+ document.documentElement.scrollTop*/;
        } 


        var bottom_position = getBottomPosition(button);

        var x = curr_x , y = curr_y;
        var w = jipMenu.offsetWidth;
        var h = jipMenu.offsetHeight;
        var body = document.documentElement;

        if((body.clientWidth + body.scrollLeft) < (x + jipMenu.clientWidth))
        {
                x = body.scrollLeft + body.clientWidth - 207;
        }

        if((body.clientHeight + body.scrollTop) < (bottom_position + jipMenu.clientHeight + 30))
        {
                y = body.scrollTop - jipMenu.clientHeight + 30;
        }

        jipMenu.style.left = x + 'px';
        jipMenu.style.top = y + 'px';

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
