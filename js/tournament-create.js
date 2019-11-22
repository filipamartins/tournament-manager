function getTime(n) {
	var checkBox = document.getElementById("check"+n);
	var start = document.getElementById("start"+n);
	var end = document.getElementById("end"+n);
	var camp = document.getElementById("camp"+n);
	if (checkBox.checked == true) {
		start.disabled = false;
		end.disabled = false;
		camp.disabled = false;
		
	} else {
		start.disabled = true;
		end.disabled = true;
		camp.disabled = true;
	}
}

function getTime2() {
	var checkBox = document.getElementById("check");
	var time = document.getElementById("time2");
	if (checkBox.checked == true) {
		time.disabled = false;
	} else {
		time.disabled = true;
	}
}