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

function getDropdownValue(id) {
	document.getElementById(id).value = "<?php echo $"+id+"];?>";
	
}