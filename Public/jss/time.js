var clock = $('#clock');
var normalelapse = 1000; 
var nextelapse = normalelapse; 
var counter; 
var startTime; 
var start = clock.text(); 
var finish = "00:00:00"; 
var timer = null; 
// 开始运行 
function run() { 
	counter = 0; 
	// 初始化开始时间 
	startTime = new Date().valueOf(); 
	 
	// nextelapse是定时时间, 初始时为100毫秒 
	// 注意setInterval函数: 时间逝去nextelapse(毫秒)后, onTimer才开始执行 
	timer = window.setInterval("onTimer()", nextelapse); 
	
}
// 倒计时函数 
function onTimer() 
{ 
 
	if (start == finish) 
	{ 
		//window.location.href = window.location.href+"/random/"+10000*Math.random();
		return; 
	} 
	 
	var hms = new String(start).split(":"); 
	var s = new Number(hms[2]); 
	var m = new Number(hms[1]); 
	var h = new Number(hms[0]); 
	   

	s -= 1; 
	if (s < 0) 
	{ 
		s = 59; 
		m -= 1; 
	} 
	   
	if (m < 0) 
	{ 
		m = 59; 
		h -= 1; 
	} 
	 
	 
	var ss = s < 10 ? ("0" + s) : s; 
	var sm = m < 10 ? ("0" + m) : m; 
	var sh = h < 10 ? ("0" + h) : h; 
	 
	start = sh + ":" + sm + ":" + ss; 
	clock.text(start); 
	 
	// 清除上一次的定时器 
	window.clearInterval(timer); 
	 
	// 自校验系统时间得到时间差, 并由此得到下次所启动的新定时器的时间nextelapse 
	counter++; 
	var counterSecs = counter * 1000; 
	var elapseSecs = new Date().valueOf() - startTime; 
	var diffSecs = counterSecs - elapseSecs; 
	nextelapse = normalelapse + diffSecs; 

	if (nextelapse < 0) nextelapse = 0; 
	 
	// 启动新的定时器 
	timer = window.setInterval("onTimer()", nextelapse); 
}  
