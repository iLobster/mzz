var agt = navigator.userAgent.toLowerCase();
var is_ie = (agt.indexOf("msie") != -1) && (agt.indexOf("opera") == -1);
var is_gecko = navigator.product == "Gecko";

var Imported = new Array;

function addJS(src) {
  if(typeof(Imported[src]) != 'undefined') {
      return;
  }
  Imported.push(src);
}


var jsTimerStart = new Date();
var JS_UNLOADED = 0;
var JS_LOAD = 1;
var JS_LOAD_END = 2;
var JS_LOADED = 3;

function jsLoader() {
  this.loadState=JS_UNLOADED;
  this.loadingScripts=new Array();
  this.scriptsTimer=null;

  this.checkScriptsLoaded=function() {
    if (document.readyState!=null) { 

        while(this.loadingScripts.length>0 && (typeof(this.loadingScripts[0]) == 'string' 
                     || this.loadingScripts[0].readyState=="loaded"
                     ||this.loadingScripts[0].readyState=="complete"
                     ||this.loadingScripts[0].readyState==null)) {
            if (typeof(this.loadingScripts[0]) == 'string') { 
                this.loadingScripts[0] = this.createScriptElement(this.loadingScripts[0]);
            } else {
               this.loadingScripts.shift(); 
            }
        }
        if (this.loadingScripts.length==0) {
            this.setLoadState(this.loadState+1);
        }
    }
    else {
      if (this.loadState==JS_LOAD && typeof(JS_LOADED_END) != 'undefined') {
        this.setLoadState(JS_LOAD_END);
      }
    }
  }

  this.setLoadState=function(newState){
    this.loadState=newState;
    switch (newState){
      case JS_LOAD:
            for (i = 0; i < Imported.length; i++) {
               this.loadScript(Imported[i]);
            }
        this.loadScript(SITE_PATH + '/templates/js/end.js');
        break;
      case JS_LOAD_END:
        if(document.readyState){
          var JS_LOADED_END = true;
        }else{
          this.setLoadState(JS_LOADED);
        }
        break;
      case JS_LOADED:
        clearInterval(this.scriptsTimer);
        break;
    }
  }

  this.loadScript=function(url){
    if(!document.getElementById(url)){
      if (is_ie) {
          this.loadingScripts.push(url);
      } else {
          this.loadingScripts.push(this.createScriptElement(url));
      }
    }
  }

  this.createScriptElement=function(url){
    if(!document.getElementById(url)){
      var script = document.createElement('script');
      script.type = "text/javascript";
      script.src = url;
      script.id = url;
      document.getElementsByTagName('head')[0].appendChild(script);
      return script;
    }
  }

  this.setLoadState(JS_LOAD);
  this.scriptsTimer=setInterval('myJsLoader.checkScriptsLoaded()', 100);
}


function jsLoadInit(){
  if(myJsLoader && myJsLoader.loadState==JS_LOADED){
    clearInterval(jsTimer);
    if (jipTitle) {
      jipTitle.innerHTML = oldJipTitle;
    }
    window.doFunc();
  }
}

var jsTimer;
var oldJipTitle;
var jipTitle;
function doOnLoad(func) {
  jsTimer = setInterval('jsLoadInit()',100);
  if (jipTitle = document.getElementById('jipTitle')) {
      oldJipTitle = jipTitle.innerHTML;
      jipTitle.innerHTML += "<img src='" + SITE_PATH +"/templates/images/statusbar.gif' align='baseline' /> <span class='jipLoadJs'>Подождите. Идет загрузка javascript...</span>";
  }
  window.doFunc = func;
}