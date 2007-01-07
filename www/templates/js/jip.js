
var OpacityEffect= function(){};

OpacityEffect.prototype = {
	step: function(){
		var time = new Date().getTime();
		if (time < this.time + 500){
			this.cTime = time - this.time;
			this.setNow();
		} else {
			this.clearTimer();
			this.now = this.to;
		}
		this.increase();
	},
	increase: function(){
                if (this.now == 0) {
                    this.element.style.display = 'none';
                }
		if (window.ActiveXObject) this.element.style.filter = "alpha(opacity=" + this.now*100 + ")";
		this.element.style.opacity = this.now;
	},
	setNow: function(){
		this.now = this.compute(this.from, this.to);
	},
	compute: function(from, to){
		return -(to - from)/2 * (Math.cos(Math.PI*this.cTime/500) - 1) + from;
	},
	custom: function(element, from, to){
		if (!this.wait) this.clearTimer();
		if (this.timer) return;
		this.from = from;
		this.to = to;
                this.element = element;
		this.time = new Date().getTime();
		this.timer = this.periodical(Math.round(1000/50), this);
		return this;
	},
	periodical: function(ms, bind){
		var fn = this.step;
		return setInterval(function(){ return fn.apply(bind, arguments);}, ms);
	},
	clearTimer: function(){
	        clearTimeout(this.timer);
	        clearInterval(this.timer);
                this.timer = false;
		return this;
	}
};

OpacityEffect.prototype.wait = true;


var last_jipmenu_id;
var agt = navigator.userAgent.toLowerCase();
var is_ie = (agt.indexOf("msie") != -1) && (agt.indexOf("opera") == -1);
var is_gecko = navigator.product == "Gecko";
var layertimer;

var urlStack = new Array;

var responseXML = false;
var responseHtml = false;
var currentUrl;
var formSuccess = false;
var jipButton;

var $break    = new Object();
var $continue = new Object();

function getInnerX(){
return window.pageXOffset||document.documentElement.scrollLeft||document.body.scrollLeft||0;
}

function getInnerY(){
return window.pageYOffset||document.documentElement.scrollTop||document.body.scrollTop||0;
}

function getInnerWidth(){
return typeof window.innerWidth=="number"?window.innerWidth:document.compatMode=="CSS1Compat"?document.documentElement.clientWidth:document.body.clientWidth;
}

function getInnerHeight(){
return typeof window.innerHeight=="number"?window.innerHeight:document.compatMode=="CSS1Compat"?document.documentElement.clientHeight:document.body.clientHeight;
}


//
// getPageScroll()
// Returns array with x,y page scroll values.
// Core code from - quirksmode.org
//
function getPageScroll(){

	var yScroll;

	if (self.pageYOffset) {
		yScroll = self.pageYOffset;
	} else if (document.documentElement && document.documentElement.scrollTop){	 // Explorer 6 Strict
		yScroll = document.documentElement.scrollTop;
	} else if (document.body) {// all other Explorers
		yScroll = document.body.scrollTop;
	}

	arrayPageScroll = new Array('',yScroll) 
	return arrayPageScroll;
}

// -----------------------------------------------------------------------------------

//
// getPageSize()
// Returns array with page width, height and window width, height
// Core code from - quirksmode.org
// Edit for Firefox by pHaez
//
function getPageSize(){
	
	var xScroll, yScroll;
	
	if (window.innerHeight && window.scrollMaxY) {	
		xScroll = document.body.scrollWidth;
		yScroll = window.innerHeight + window.scrollMaxY;
	} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
		xScroll = document.body.scrollWidth;
		yScroll = document.body.scrollHeight;
	} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
		xScroll = document.body.offsetWidth;
		yScroll = document.body.offsetHeight;
	}
	
	var windowWidth, windowHeight;
	if (self.innerHeight) {	// all except Explorer
		windowWidth = self.innerWidth;
		windowHeight = self.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
		windowWidth = document.documentElement.clientWidth;
		windowHeight = document.documentElement.clientHeight;
	} else if (document.body) { // other Explorers
		windowWidth = document.body.clientWidth;
		windowHeight = document.body.clientHeight;
	}	
	
	// for small pages with total height less then height of the viewport
	if(yScroll < windowHeight){
		pageHeight = windowHeight;
	} else { 
		pageHeight = yScroll;
	}

	// for small pages with total width less then width of the viewport
	if(xScroll < windowWidth){	
		pageWidth = windowWidth;
	} else {
		pageWidth = xScroll;
	}


	arrayPageSize = new Array(pageWidth,pageHeight,windowWidth,windowHeight) 
	return arrayPageSize;
}



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

    } while (objParent && (objParent != body && objParent.id != 'fcontainer' && objParent.id != 'footer'))

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


function extractScripts(response, onlyLoadJs) {
    jsFragment = '(?:<script.*?>)((\n|\r|.)*?)(?:<\/script>)';
    var matchAll = new RegExp(jsFragment, 'img');
    var matchOne = new RegExp(jsFragment, 'im');

    if (true || !onlyLoadJs) {
        return collect(response.match(matchAll) || [], function(scriptTag) {
            return (scriptTag.match(matchOne) || ['', ''])[1];
        });
    } else {
        var matchOnlyLoad = new RegExp(jsFragment, 'im');
        return collect(response.match(matchAll) || [], function(scriptTag) { alert(scriptTag);
            var matchOnlyLoadJS = new RegExp('((?!/\\*)loadJS\(.*\);?)+', 'img');
            alert((scriptTag.match(matchOnlyLoadJS) || ['', ''])/*[1]*/);
        });
    }

}


    function onScriptLoad(evt)
    {
        evt = evt || event;
        var elem = evt.target || evt.srcElement;
        if (evt.type == 'readystatechange' && elem.readyState && !(elem.readyState == 'complete' || elem.readyState == 'loaded')) { return }
        
        evalScripts(responseHtml, false)
        
    }


function evalScripts(response, onlyLoadJs) {
    onlyLoadJs = onlyLoadJs || false;
    return collect(extractScripts(response, onlyLoadJs), evalScript);
}



function evalScript(script) {
    try { eval(script); } catch(err) { alert('Inline script error '+err.name+ ': '+err.message); }
}


var handleSuccess = function(o){
    if(typeof o.responseText !== undefined){
        urlStack.push([currentUrl]);
        o.argument.div.innerHTML = "<div class='jipClose'><img alt='Закрыть' class='jip' width='16' height='16' src='" + SITE_PATH + "/templates/images/close.gif' onclick='javascript: hideJip();' /></div>";
        if (o.argument.success == true) {
            o.argument.div.innerHTML += "<div class='jipSuccess'>Данные сохранены.</div>";
        }
        responseXML = o.responseXML.documentElement;
        // for html
        var item = responseXML.getElementsByTagName('html')[0];

        var tmp = '';
        var cnodes = item.childNodes.length;
        for (var i=0; i<cnodes; i++) {
            if (item.childNodes[i].data != '') {
                tmp += item.childNodes[i].data;
            }
        }
        o.argument.div.innerHTML += tmp;


        // for JS
        var items = responseXML.getElementsByTagName('javascript');
        if (items) {
            var cn = items.length
            for (var i=0; i<cn; i++) {
                addJS(SITE_PATH + items[i].getAttribute('src'));
            }
        }



        // for inner JS
        var items = responseXML.getElementsByTagName('execute');
        if (items) {
            var jsExecute = '';
            var cn = items.length
            for (var i=0; i<cn; i++) {
                cn2 = items[i].childNodes.length;
                for (var j=0; j < cn2; j++) {
                    if (items[i].childNodes[j].data != '') {
                        jsExecute += items[i].childNodes[j].data;
                    }
                }
            }
        } 
        if (jsExecute != '') {
            myJsLoader = new jsLoader();
            doOnLoad(function() {
            try { eval(jsExecute); } catch(err) { alert('Inline script error '+err.name+ ': '+err.message); } });
        }


        responseHtml = o.argument.div.innerHTML;
        //evalScripts(o.argument.div.innerHTML, true);
    }
}

var handleInSuccess = function(o){
    if(typeof o.responseText !== undefined){
        o.argument.div.innerHTML = '';
        if (o.argument.success == true) {
            o.argument.div.innerHTML += "<div class='jipSuccess'>Данные сохранены.</div>";
        }
        o.argument.div.innerHTML += o.responseText;
        evalScripts(o.argument.div.innerHTML);
    }
}

var handleFormSuccess = function(o){
    if(typeof o.responseText !== undefined){
        showJip(o.argument.currentUrl);
        //o.argument.div.innerHTML = "<div style='float: right;'><img alt='Закрыть' width='16' height='16' src='" + SITE_PATH + "/templates/images/close.gif' onclick='javascript: hideJip();' /></div>";
        //o.argument.div.innerHTML += '<div style="font-size: 100%;color: green;">Данные сохранены</div>' + o.responseText;
        //div.innerHTML += "<li>HTTP status: " + o.status + "</li>";
    }
}

var handleFailure = function(o){
    if(typeof o.responseText !== undefined){
        alert("No response. Server error. \r\n Trans_id: " + o.tId + "; HTTP status: " + o.status + "; Code message: " + o.statusText);
    }
}

window,onresize = function() { doMoveMask(); }
//window.onscroll = function() { doMoveMask(); }

document.onkeydown = proccessKey;

function proccessKey(key) {
    var code;
    if (!key) key = window.event;
    if (key.keyCode) code = key.keyCode;
    else if (key.which) code = key.which;
    if (code == 27) {
        if (last_jipmenu_id) {
            closeJipMenu(document.getElementById('jip_menu_' + last_jipmenu_id));
        }
        return hideJip();
    }
}
var jipLockResized = false;
/*
function doMoveMask(onresize) {
    onresize = onresize || false;
    if (is_gecko) {
        document.getElementById('blockContent').style.left=getInnerX() - 23 +"px";
    } else {
        document.getElementById('blockContent').style.left=getInnerX() - 8 +"px";
    }
    document.getElementById('blockContent').style.top=getInnerY() - 8 + "px";
    if (onresize || !jipLockResized) {
        document.getElementById('blockContent').style.width=getInnerWidth() +"px";
        document.getElementById('blockContent').style.height=getInnerHeight() +"px";
        jipLockResized = true;
    }

}

*/

function doMoveMask() {
    var arrayPageSize = getPageSize();
    document.getElementById('blockContent').style.height=arrayPageSize[1] +"px";
}

var lastJipUrl = false;
var oldOffset = false;
function showJip(url, success)
{
    cleanJip();
    //doMoveMask();
    if (document.getElementById('jip')) {
        doMoveMask();
        document.getElementById('blockContent').style.display = 'block';

        blockOpacityEffect = new OpacityEffect;
        blockOpacityEffect.custom(document.getElementById('blockContent'), 0, 0.8);


        document.getElementById('jip').style.display = 'block';
        oldOffset = document.getElementById('jip').offsetHeight;
        document.getElementById('jip').style.top = document.documentElement.scrollTop + oldOffset + 'px';


        var callback = {success:handleSuccess, failure:handleFailure, argument: { div:document.getElementById('jip'), success:success }};
        currentUrl = url;
        var request = YAHOO.util.Connect.asyncRequest('GET', url + '&ajax=1', callback);

        document.getElementById('jip').style.left  = document.getElementById('jip').offsetLeft + 'px';
        return false;
    }
    return true;
}


function sendFormWithAjax(form, elementId)
{
    elementId = elementId || 'jip';
    var callback = {success:handleSuccess, failure:handleFailure, argument: { div:document.getElementById(elementId), currentUrl:currentUrl }};
    YAHOO.util.Connect.setForm(form);
    var request = YAHOO.util.Connect.asyncRequest(form.getAttribute('method').toUpperCase(), form.action + '&ajax=1', callback);
    cleanJip();
    return false;
}

function sendFormInAjax(form, elementId)
{
    elementId = elementId || 'jip';
    cleanSubJip(elementId);
    var callback = {success:handleInSuccess, failure:handleFailure, argument: { div:document.getElementById(elementId), currentUrl:currentUrl }};
    YAHOO.util.Connect.setForm(form);
    var request = YAHOO.util.Connect.asyncRequest(form.method.toUpperCase(), form.action + '&ajax=1', callback);
    //cleanJip();
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

        blockOpacityEffect = new OpacityEffect;
        blockOpacityEffect.custom(document.getElementById('blockContent'), 0.8, 0);

        //document.getElementById('blockContent').style.display = 'none';
        document.getElementById('jip').style.display = 'none';
        if (oldOffset) {
            document.getElementById('jip').style.top = oldOffset + 'px';
        }


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


function openJipMenu(button, jipMenu, id) {
    button.src = SITE_PATH + '/templates/images/jip_active.gif';
    jipMenu.style.top = '-100px';
    jipMenu.style.left = '-100px';
    jipMenu.style.display = 'block';

    if (last_jipmenu_id && last_jipmenu_button) {
        closeJipMenu(document.getElementById('jip_menu_' + last_jipmenu_id), last_jipmenu_button);
    }

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
    last_jipmenu_button = button;
}

function closeJipMenu(jipMenu, button) {
    jipMenu.style.display = 'none';
    last_jipmenu_id = false;
    last_jipmenu_button = false;
    button = button || jipButton;
    button.src = SITE_PATH + '/templates/images/jip.gif';
    if(layertimer) {
        clearTimeout(layertimer);
    }
}

function showJipMenu(button, id) {
    jipMenu = document.getElementById('jip_menu_' + id);
    if (!jipMenu.style.display || jipMenu.style.display == 'none') {
        jipButton = button;
        openJipMenu(button, jipMenu, id);
        setMouseInJip(false);
    } else {
        closeJipMenu(jipMenu);
    }
}

function setMouseInJip(status) {
    if (status == false && last_jipmenu_id) {
        jipMenu = document.getElementById('jip_menu_' + last_jipmenu_id);
        layertimer = setTimeout("closeJipMenu(jipMenu)", 900);
    } else {
        clearTimeout(layertimer);
    }
}






var isdrag=false;
var move_x, move_y, tx, ty;
var dobj, old_mousemoveevent;
var arrayPageSize = false;

function movemouse(e)
{
  if (isdrag)
  {
    var _left = (!is_ie ? tx + e.clientX - move_x : tx + event.clientX - move_x);
    
    if (!arrayPageSize) { arrayPageSize = getPageSize();  }

    if (_left >= 0 && _left < arrayPageSize[0] - dobj.offsetWidth) {
       dobj.style.left  = _left + 'px';
    }
    var _top = (!is_ie ? ty + e.clientY - move_y : ty + event.clientY - move_y);


    if (_top >= 0 && _top < arrayPageSize[1] - dobj.offsetHeight) {
       dobj.style.top  = _top + 'px';
    }

    return false;
  } else {
    document.onmousemove = old_mousemoveevent;
  }
}

function selectmouse(e) 
{
  var fobj       = !is_ie ? e.target : event.srcElement;
  var topelement = !is_ie ? "HTML" : "BODY";

  while (fobj.tagName != topelement && fobj.className != "jipMove")
  {
    fobj = !is_ie ? fobj.parentNode : fobj.parentElement;
  }

  if (fobj.className == "jipMove")
  {
    isdrag = true;
    dobj = /*fobjfobj*/ document.getElementById('jip');
    tx = parseInt(/*dobj.style.left + */dobj.offsetLeft + 0);
    ty = parseInt(dobj.style.top + 0);
    move_x = !is_ie ? e.clientX : event.clientX;
    move_y = !is_ie ? e.clientY : event.clientY;
    old_mousemoveevent = document.onmousemove;
    document.onmousemove=movemouse;
    return false;
  }
}

document.onmousedown=selectmouse;
document.onmouseup=new Function("isdrag=false");








