var Imported = new Array;
function addJS(src) {
  if(typeof(Imported[src]) != 'undefined') {
      return;
  }
  Imported.push([src]);
}


var jsTimerStart = new Date();
var JS_UNLOADED = 0;
var JS_LOAD = 1;
var JS_LOADED = 2;

function jsLoader() {
  this.loadState=JS_UNLOADED;
  this.loadingScripts=new Array();
  this.scriptsTimer=null;

  this.checkScriptsLoaded=function() {
    if (document.readyState!=null) {
      while(this.loadingScripts.length>0
        &&(this.loadingScripts[0].readyState=="loaded"
          ||this.loadingScripts[0].readyState=="complete"
          ||this.loadingScripts[0].readyState==null)) {
        this.loadingScripts.shift();
      }
      if (this.loadingScripts.length==0) {
        this.setLoadState(this.loadState+1);
      }
    }
    else {
      if (this.loadState==JS_LOAD) {
        this.setLoadState(JS_LOADED);
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
        break;
      case JS_LOADED:
        clearInterval(this.scriptsTimer);
        break;
    }
  }

  this.loadScript=function(url){
    if(!document.getElementById(url)){
      var script = document.createElement('script');
      script.type = "text/javascript";
      script.src = url;
      script.id = url;
      document.getElementsByTagName('head')[0].appendChild(script);
      this.loadingScripts.push(script);
    }
  }

  this.setLoadState(JS_LOAD);
  this.scriptsTimer=setInterval('myJsLoader.checkScriptsLoaded()', 100);
}


function jsLoadInit(){
  if(myJsLoader && myJsLoader.loadState==JS_LOADED){
    clearInterval(jsTimer);
    window.doFunc();
  }
}

var jsTimer;
function doOnLoad(func) {
  jsTimer = setInterval('jsLoadInit()',100);
  window.doFunc = func;
}