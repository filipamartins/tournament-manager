function getTime(n) {
	var checkBox = document.getElementById("check"+n);
	var start = document.getElementById("start"+n);
	var end = document.getElementById("end"+n);
	var field = document.getElementById("field"+n);
	if (checkBox.checked == true) {
		start.disabled = false;
		end.disabled = false;
		field.disabled = false;
		
	} else {
		start.disabled = true;
		end.disabled = true;
		field.disabled = true;
	}
}

function getSaveButton() {
	var checkBox = document.getElementById("check");
	var submit = document.getElementById("submit");
	var start = document.getElementById("start");
	var end = document.getElementById("end");
	if (checkBox.checked == true) {
		submit.style.visibility = "visible";
		start.style.background = "aliceblue";
		end.style.background = "aliceblue";
		start.disabled = false;
		end.disabled = false;
	}
	else{
		submit.style.visibility = "hidden";
		start.style.background = "none";
		end.style.background = "none";
		start.disabled = true;
		end.disabled = true;
	}
	
}