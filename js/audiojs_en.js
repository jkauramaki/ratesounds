
var totalDuration = 10000; 
var currentTimeLeft = totalDuration;

var audio = document.getElementById('stimaudio');
audio.onloadedmetadata = function() {
  totalDuration=audio.duration*1000+1000;
};

function updateTimer() {
	currentTimeLeft=currentTimeLeft-1000;
	if (Math.floor(currentTimeLeft/1000)>=0) {
		showTitle("Time left: " + Math.floor(currentTimeLeft/1000) + " s" );
		setTimeout(function() { updateTimer(); }, 1000);
	}
}

function showTitle(text) {
	var element = document.getElementById("headline");
	element.innerHTML = text;
	element.style.visibility = "visible";
}

start.onclick = e => {
	start.disabled = true;
	currentTimeLeft = totalDuration;
	start.style.backgroundColor = "blue";
	showTitle("Sound sample is starting");
	audio.play();
	updateTimer();
	setTimeout(function() {
		stopPlayback();
	}, totalDuration);	
}

function stopPlayback(){
	start.style.backgroundColor = "red";
	//start.disabled = false;
	showTitle("Please complete the evaluation");
}