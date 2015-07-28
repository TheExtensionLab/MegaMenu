/**
 *
 The MIT License (MIT)

 Copyright (c) Gianluca Guarini

 Permission is hereby granted, free of charge, to any person obtaining a copy of
 this software and associated documentation files (the "Software"), to deal in
 the Software without restriction, including without limitation the rights to
 use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 the Software, and to permit persons to whom the Software is furnished to do so,
 subject to the following conditions:

 The above copyright notice and this permission notice shall be included in all
 copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

/*! tocca v0.1.6 || Gianluca Guarini */
!function(a,b){"use strict";if("function"!=typeof a.createEvent)return!1;var c,d,e,f,g,h,i,j="undefined"!=typeof jQuery,k=!!navigator.pointerEnabled||navigator.msPointerEnabled,l=!!("ontouchstart"in b)&&navigator.userAgent.indexOf("PhantomJS")<0||k,m=function(a){var b=a.toLowerCase(),c="MS"+a;return navigator.msPointerEnabled?c:b},n={touchstart:m("PointerDown")+" touchstart",touchend:m("PointerUp")+" touchend",touchmove:m("PointerMove")+" touchmove"},o=function(a,b,c){for(var d=b.split(" "),e=d.length;e--;)a.addEventListener(d[e],c,!1)},p=function(a){return a.targetTouches?a.targetTouches[0]:a},q=function(){return(new Date).getTime()},r=function(b,e,f,g){var h=a.createEvent("Event");if(h.originalEvent=f,g=g||{},g.x=c,g.y=d,g.distance=g.distance,j&&(h=$.Event(e,{originalEvent:f}),jQuery(b).trigger(h,g)),h.initEvent){for(var i in g)h[i]=g[i];h.initEvent(e,!0,!0),b.dispatchEvent(h)}b["on"+e]&&b["on"+e](h)},s=function(a){var b=p(a);e=c=b.pageX,f=d=b.pageY,h=q(),A++},t=function(a){var b=[],j=f-d,k=e-c;if(clearTimeout(g),-v>=k&&b.push("swiperight"),k>=v&&b.push("swipeleft"),-v>=j&&b.push("swipedown"),j>=v&&b.push("swipeup"),b.length)for(var l=0;l<b.length;l++){var m=b[l];r(a.target,m,a,{distance:{x:Math.abs(k),y:Math.abs(j)}})}else h+w-q()>=0&&e>=c-y&&c+y>=e&&f>=d-y&&d+y>=f&&(r(a.target,2===A&&i===a.target?"dbltap":"tap",a),i=a.target),g=setTimeout(function(){A=0},x)},u=function(a){var b=p(a);c=b.pageX,d=b.pageY},v=b.SWIPE_THRESHOLD||100,w=b.TAP_THRESHOLD||150,x=b.DBL_TAP_THRESHOLD||200,y=b.TAP_PRECISION/2||30,z=b.JUST_ON_TOUCH_DEVICES||l,A=0;o(a,n.touchstart+(z?"":" mousedown"),s),o(a,n.touchend+(z?"":" mouseup"),t),o(a,n.touchmove+(z?"":" mousemove"),u)}(document,window);