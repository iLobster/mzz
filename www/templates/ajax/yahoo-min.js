/* Copyright (c) 2006, Yahoo! Inc. All rights reserved.Code licensed under the BSD License: http://developer.yahoo.net/yui/license.txt Version: 0.11.4*/ if(typeof YAHOO=="undefined"){YAHOO={};}YAHOO.namespace=function(ns){if(!ns||!ns.length){return null;}var _2=ns.split(".");var _3=YAHOO;for(var i=(_2[0]=="YAHOO")?1:0;i<_2.length;++i){_3[_2[i]]=_3[_2[i]]||{};_3=_3[_2[i]];}return _3;};YAHOO.log=function(_5,_6,_7){var l=YAHOO.widget.Logger;if(l&&l.log){return l.log(_5,_6,_7);}else{return false;}};YAHOO.extend=function(_9,_10){var f=function(){};f.prototype=_10.prototype;_9.prototype=new f();_9.prototype.constructor=_9;_9.superclass=_10.prototype;if(_10.prototype.constructor==Object.prototype.constructor){_10.prototype.constructor=_10;}};YAHOO.namespace("util");YAHOO.namespace("widget");YAHOO.namespace("example");