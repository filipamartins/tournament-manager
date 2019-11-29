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
function buttonConfirm(id_jogo) {
	var button = document.getElementById("delete-"+id_jogo);
	button.style.visibility = "hidden";
	button.style.display = "none";

	var button = document.getElementById("confirm-"+id_jogo);
	button.style.visibility = "visible";
	//button.style.display = "block";

	var button = document.getElementById("cancel-"+id_jogo);
	button.style.visibility = "visible";
	//button.style.display = "block";
}

function buttonCancel(id_jogo) {
	var button = document.getElementById("delete-"+id_jogo);
	button.style.visibility = "visible";
	button.style.display = "block";

	var button = document.getElementById("confirm-"+id_jogo);
	button.style.visibility = "hidden";
	//button.style.display = "none";

	var button = document.getElementById("cancel-"+id_jogo);
	button.style.visibility = "hidden";
	//button.style.display = "none";
}

