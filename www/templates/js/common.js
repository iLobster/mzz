
var Imported = new Array;

function import(src) {
  if(typeof(Imported[src]) != 'undefined') {
      return;
  }
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = src;
  document.getElementsByTagName('head')[0].appendChild(script);
  Imported[src] = true;
}

