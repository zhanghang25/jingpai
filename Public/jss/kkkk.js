window.FontAwesomeCdnConfig = {
  autoA11y：{
    启用：false
  }，
  asyncLoading：{
    启用：false
  }，
  报告：{
    启用：false
  }，
  useUrl：“use.fontawesome.com”，
  faCdnUrl：“https://cdn.fontawesome.com:443”，
  代码：“b4784f3c7b”
};
！function（）{function a（a）{var b，c = []，d = document，e = d.documentElement.doScroll，f =“DOMContentLoaded”，g =（e？/ ^ loaded | ^ c /： /^loaded|^i|^c/).test(d.readyState);g||d.addEventListener(f,b=function(){for(d.removeEventListener(f,b),g=1;b = c.shift（）;）b（）}），g？setTimeout（a，0）：c.push（a）} function b（a，b）{var c =！1; return a.split（“ ，“）。forEach（function（a）{var d = new RegExp（a.trim（）。replace（”。“，”\\。“）。replace（”*“，”（。*）“）） ; b.match（d）&&（c =！0）}），c}函数c（a）{“undefined”！= typeof MutationObserver && new MutationObserver（a）.observe（document，{childList：！0，subtree :! 0}）}函数d（a）{var b，c，d，e; a = a ||“fa”，b = document.querySelectorAll（“。”+ a），Array.prototype.forEach.call（b ，函数（）{C = a.getAttribute（ “标题”），a.setAttribute（ “咏叹调隐藏”， “真”），d = a.nextElementSibling？！a.nextElementSibling.classList.contains（ “SR-仅”）：！0，C && d &&（E =使用document.createElement（ “跨度”），e.innerHTML = C，e.classList.add（ “sr-only”），a.parentNode.insertBefore（e，a.nextSibling））}）}！function（）{“use strict”; function a（a）{l.push（a），1 == l .length && k（）} function b（）{for（; l.length;）l [0]（），l.shift（）} function c（a）{this.a = m，this.b = void 0， this.f = []; var b = this; try {a（function（a）{f（b，a）}，function（a）{g（b，a）}）} catch（c）{g（ b，c）}} function d（a）{return new c（function（b，c）{c（a）}）} function e（a）{return new c（function（b）{b（a）}函数f（a，b）{if（aa == m）{if（b == a）抛出新的TypeError; var c =！1;尝试{var d = b && b.then; if（null！= b && “object”== typeof b &&“function”== typeof d）return void d.call（b，function（b）{c || f（a，b），c =！0}，function（b）{c || G（A，b），C =！0}）} catch（e）{return void（c || g（a，e））} aa = 0，ab = b，h（a）}}函数g（a，b）{if（aa == m）{if（b == a）抛出新的TypeError; aa = 1，ab = b，h（a）}}函数h（b）{a（function（）{if（ba！= m）for（;; bflength;）{var a = bfshift（），c = a [0]，d = a [1]，e = a [2]，a = a [3];尝试{0 == ba？e（“function” “== typeof c？c.call（void 0，bb）：bb）：1 == ba &&（”function“== typeof d？e（d.call（void 0，bb））：a（bb）） } catch（f）{a（f）}}}}} function i（a）{return new c（function（b，c）{function d（c）{return function（d）{g [c] = d ，f + = 1，f == a.length && b（g）}} var f = 0，g = []; 0 == a.length && b（g）; for（var h = 0; h <a.length; h + = 1）e（a [h]）。c（d（h），c）}）}函数j（a）{return new c（function（b，c）{for（var d = 0; d <a .length; d + = 1）e（a [d]）。c（b，c）}）} var k，l = []; k = function（）{setTimeout（b）}; var m = 2; c .prototype.g = function（a）{return this.c（void 0，a）}，c.prototype.c = function（a，b）{var d = this; return new c（function（c，e） {dfpush（并[a，B，C，E]）中，h（d）}）}，window.Promise ||（window.Promise = C，window.Promise.resolve = E，window.Promise.reject = d，window.Promise.race = Ĵ，window.Promise.all = I，window.Promise.prototype.then = c.prototype.c，window.Promise.prototype [ “捕获”] = c.prototype.g）}（），函数（）{函数a（a）{this.el = a; for（var b = a.className.replace（/ ^ \ s + | \ s + $ / g，“”）。split（/ \ s + /），c = 0; c <b.length; c ++）d.call（this，b [c]）} function b（a，b，c）{Object.defineProperty？Object.defineProperty（a，b，{get：c}）：a。 __defineGetter __（b，c）} if（！（“undefined”== typeof window.Element ||“classList”in document.documentElement））{var c = Array.prototype，d = c.push，e = c.splice中，f = c.join; a.prototype = {添加：功能的（a）{this.contains的（a）||（d.call（此，a）中，this.el.className = this.toString（））} ，contains：function（a）{return-1！= this.el.className.indexOf（a）}，item：function（a）{return this [a] || null}，remove：function（a）{if（this.contains（a））{for（var b = 0; b <this.length && this [b]！= a; b ++）; e.call（this，b，1），this。 el.className = this.toString（）}}，toString：function（）{return f.call（this，“”）}，toggle：function（a）{return this.contains（a）？this.remove（a ）：this.add（a），this.contains（a）}}，window.DOMTokenList = a，b（Element.prototype，“classList”，function（）{return new a（this）}）}}（） ; var e = function（a，b，c）{function d（a）{return g.body？a（）：void setTimeout（function（）{d（a）}）} function e（）{h.addEventListener && h .removeEventListener（“load”，e），h.media = c ||“all”} var f，g = window.document，h = g.createElement（“link”）; if（b）f = b;否则{var i =（g.body || g.getElementsByTagName（“head”）[0]）。childNodes; f = i [i.length-1]} var j = g.styleSheets; h.rel =“stylesheet” ，h.href = a，h.media =“only x”，d（function（）{f.parentNode。insertBefore（h，b？f：f.nextSibling）}）; var k = function（a）{for（var b = h.href，c = j.length; c  - ;）if（j [c]。 href === b）返回a（）; setTimeout（function（）{k（a）}）};返回h.addEventListener && h.addEventListener（“load”，e），h.onloadcssdefined = k，k（e）， h}，f = null;！function（）{function a（a，b）{document.addEventListener？a.addEventListener（“scroll”，b，！1）：a.attachEvent（“scroll”，b）} function b（a）{document.body？a（）：document.addEventListener？document.addEventListener（“DOMContentLoaded”，function b（）{document.removeEventListener（“DOMContentLoaded”，b），a（）}）：document.attachEvent （“onreadystatechange”，函数c（）{“interactive”！= document.readyState &&“complete”！= document.readyState ||（document.detachEvent（“onreadystatechange”，c），a（））}）} function c（一个）{this.a =使用document.createElement（”格 “），this.a.setAttribute（” 咏叹调隐藏”， “真”），this.a.appendChild（document.createTextNode的（a）），this.b =使用document.createElement（ “跨度”），这一点。 C =使用document.createElement（ “跨度”），this.h =使用document.createElement（ “跨度”），this.f =使用document.createElement（ “跨度”），this.g = -1，this.b.style。 cssText = “最大宽度：无;显示：内联块;位置：绝对的;高度：100％;宽度：100％;溢出：滚动;字体大小：16px的;”，this.c.style.cssText =”最大宽度：无;显示：内联块;位置：绝对的;高度：100％;宽度：100％;溢出：滚动;字体大小：16px的; “this.f.style.cssText =” 最大宽度：无;显示：内联块;位置：绝对的;高度：100％;宽度：100％;溢出：滚动;字体大小：16px的; “this.h.style.cssText =” 显示：内联块;宽度：200％;高度：200％;字体大小：16px的;最大宽度：无;”，this.b.appendChild（this.h），this.c.appendChild（this.f），this.a.appendChild（this.b），this.a.appendChild（this.c）} function d（a，b ）{aastyle.cssText =“最大宽度：无;最小宽度：20像素;最小高度：20像素;显示：内联块;溢出：隐藏;位置：绝对的;宽度：汽车;余量：0;填充：0 ; top：-999px; left：-999px; white-space：nowrap; font：“+ b +”;“} function e（a）{var b = aaoffsetWidth，c = b + 100; return afstyle.width = c +” px“，acscrollLeft = c，abscrollLeft = abscrollWidth + 100，ag！== b？（ag = b，！0）：！1}函数g（b，c）{function d（）{var a = f; e （a）&& a.a.parentNode && c（ag）} var f = b; a（bb，d），a（bc，d），e（b）}函数h（a，b）{var c = b || {}; this.family = a，this.style = c.style ||“normal”，this.weight = c.weight ||“normal”，this.stretch = c.stretch ||“normal”} function i （）{if（null === l）{var a = document.createElement（“div”）;尝试{a.style.font =“浓缩100px sans-serif”} catch（b）{} l =“”！== a.style.font} return l} function j（a，b）{return [a。 style，a.weight，i（）？a.stretch：“”，“100px”，b] .join（“”）} var k = null，l = null，m = null; h.prototype.load = function （a，e）{var f = this，h = a ||“BESbswy”，i = e || 3e3，l =（new Date）.getTime（）;返回新的Promise（函数（a，e）{if （null === m &&（m = !! window.FontFace），m）{var n = new Promise（function（a，b）{function c（）{（new Date）.getTime（） -  l> = i ？b（）：document.fonts.load（j（F，f.family）中，h）。然后（函数（b）{1 <= b.length个一（）：的setTimeout（C，25）}，功能（）{b（）}）} c（）}），o = new Promise（function（a，b）{setTimeout（b，i）}）; Promise.race（[o，n]）。then（function （）{a（f）}，function（）{e（f）}）} else b（function（）{function b（）{var b;（b = -1！= q &&  -  1！= r || ！-1 = q &&！ -  1 = S || -1 = R &&！ - ！1 = S）&&（（b = q = R && q = S＆＆R = S）||（空===ķ&&（B = /为AppleWebKit \ /（[0-9] +）（：！？\（[0-9] +））/ EXEC（window.navigator。的userAgent）中，k = !! b &&（536> parseInt函数（b [1]，10）|| 536 === parseInt函数（b [1]，10）&& 11> = parseInt函数（b [2]，10）））， b =ķ&&（q ==吨&&ř==吨&&小号==吨||常见==ù&&ř==ù&&小号==ù||常见== v &&ř== v &&小号== v））中，b =！b）中，b &&（瓦特.parentNode && w.parentNode.removeChild（w），clearTimeout（x），a（f））} function m（）{if（（new Date）.getTime（） -  l> = i）w.parentNode && w.parentNode.removeChild（ w），e（f）; else {var a = document.hidden;！0！== a && void 0！== a ||（q = naoffsetWidth，r = oaoffsetWidth，s = paoffsetWidth，b（）），x = setTimeout（m，50）}} var n = new c（h），o = new c（h），p = new c（h），q = -1，r = -1，s = -1，t = -1，U = -1，v = -1，W =使用document.createElement（ “DIV”）中，x = 0; w.dir = “LTR”，d（N，J（F， “无衬线”）峰），d（邻，J（F， “衬线”）），d（p，J（F，”等宽“）），w.appendChild（NA），w.appendChild（OA），w.appendChild（PA），document.body.appendChild（W），T = naoffsetWidth，U = oaoffsetWidth，V = paoffsetWidth，米（） ，G（N，函数的（a）{q = A，b（）}），d（N，J（F， ' '+ f.family +“'，无衬线'）），克（邻，功能的（a）{R = A，b（）}），d（邻，J（F， ' '+ f.family +“'，衬线'）），G（p，函数的（a）{S = A， b（）}），d（p，j（f，'“'+ f.family +'”，monospace'））}）}）}，f = h}（）; var g = {observe：function（a ，b）{for（var c = b.prefix，d = function（a）{var b = a.weight？“ - ”+ a.weight：“”，d = a.style？“ - ”+ a。式： “”？，E = a.className “ - ” + a.className： “”，G = a.className “ - ” + a.className + b + d：？ “”，H = document.getElementsByTagName（” HTML “）[0] .classList，I =函数（）{h.add（C + E +”  -  “+ a）中，h.add（C + G +”  - “+α）}，J =函数（一个）{H。remove（c + e +“ - ”+ a），h.remove（c + g +“ - ”+ a）}; i（“loading”），new f（a.familyName）.load（a.testString）.then （函数（）{I（ “就绪”），J（ “加载”）}，函数（）{I（ “失败”），J（ “加载”）}）}，E = 0，E <则为a.length ; e ++）d（a [e]）}}，h = {load：function（a）{var b = document.createElement（“link”）; b.href = a，b.media =“all”，b的.rel = “样式表”，document.getElementsByTagName（ “头”）[0] .appendChild（b）}，loadAsync：功能的（a）{E（一）}}，I = {负载：函数（）{风险b = document.createElement（“script”），c = document.scripts [0]; b.src = a，c.parentNode.appendChild（b）}}; try {if（window.FontAwesomeCdnConfig）{var j = window .FontAwesomeCdnConfig中，k = j.useUrl，L = j.faCdnUrl，M = j.code中，n = “FontAwesome”，O = “FA”，p = “飰€”，q = d.bind（d，“FA “）中，r =函数（）{}; j.autoA11y.enabled &&（一（Q），C（Q）），j.reporting.enabled && B（j.reporting.domains，location.host）&& i.load（L + “/js/stats.js”），cssUrl =“https：//开头“+ k +”/“+ m +”。css“，new f（n）.load（p）.then（function（）{var a =（window.FontAwesomeHooks || {}）。loaded || r; a（ ）}，R），j.asyncLoading.enabled h.loadAsync（cssUrl）：h.load（cssUrl），g.observe（[{familyName：N，的TestString：p}]，{前缀：2 O +“ - 事件 - 图标“}）}}赶上（S）{}}（）;