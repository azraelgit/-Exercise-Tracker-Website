// 22079916, Charles Buenaventura, 13:00 Thursday

/*
the following Java method was modified from "script.js"
Filename and location: "week5-examples.zip > example 6 > 'script.js'"
File download: "https://vuws.westernsydney.edu.au/bbcswebdav/pid-10092280-dt-content-rid-67965884_1/xid-67965884_1"
Website: "https://vuws.westernsydney.edu.au/webapps/blackboard/content/listContent.jsp?course_id=_49327_1&content_id=_10092215_1"
*/
function validateWorkoutForm(formComplete) {
	var valid = true;
	var currentDate = new Date();
	var userDate = new Date(formComplete.date.value);
	
	// validates when date is valid (not in the future)
	if (!formComplete.date.value.length || inputDate > currentDate) {
        valid = false;
        document.getElementById('dateError').style.display = 'inline-block'; 
    } else {
        document.getElementById('dateError').style.display = 'none'; 
    }
	
	// accepts digits only
	if (!formComplete.duration.value.length || !/^\d+$/.test(formComplete.duration.value)) {
		valid = false;
		document.getElementById('durationError').style.display = 'inline-block';
	} else {
		document.getElementById('durationError').style.display = 'none';
	}
	
	// accepts digits only
	if (!formComplete.distance.value.length || !/^\d+$/.test(formComplete.distance.value)) {
		valid = false;
		document.getElementById('distanceError').style.display = 'inline-block';
	} else {
		document.getElementById('distanceError').style.display = 'none';
	}
	
	// validate exercise
	var exercise = formComplete['exercise'];
	if (exercise.value === "") {
		valid = false;
		document.getElementById('exerciseError').style.display = "inline-block";
	} else {
		document.getElementById('exerciseError').style.display = "none";
	}
	
	return valid;
	
}

function validateFormAdminAndUser(formComplete) {
	var valid = true;
	
	var firstandlastNameFormat = /^[A-Za-z]+$/; // letters only
	if (!firstandlastNameFormat.test(formComplete.firstname.value)) {
		valid = false;
		document.getElementById('firstnameError').style.display = 'inline-block';
	} else {
		document.getElementById('firstnameError').style.display = 'none';
	}
	
	if (!firstandlastNameFormat.test(formComplete.lastname.value)) {
		valid = false;
		document.getElementById('lastnameError').style.display = 'inline-block';
	} else {
		document.getElementById('lastnameError').style.display = 'none';
	}
	
	if (!formComplete.password.value.length) {
		valid = false;
		document.getElementById('passwordError').style.display = 'inline-block';
	} else {
		document.getElementById('passwordError').style.display = 'none';
	}
	
	if (!formComplete.email.value.length) {
		valid = false;
		document.getElementById('emailError').style.display = 'inline-block';
	} else {
		document.getElementById('emailError').style.display = 'none';
	}
	
	var mobileFormat = /^\d{10}$/; // 10 digit num only
	if (!mobileFormat.test(formComplete.mobile.value)) {
		valid = false;
		document.getElementById('mobileError').style.display = 'inline-block';
	} else {
		document.getElementById('mobileError').style.display = 'none';
	}
	
	return valid;
}


function validateLogin(formComplete) {
	var valid = true;
	
	if (!formComplete.username.value.length) {
		valid = false;
		document.getElementById('usernameError').style.display = 'inline-block';
	} else {
		document.getElementById('usernameError').style.display = 'none';
	}
	
	if (!formComplete.password.value.length) {
		valid = false;
		document.getElementById('passwordError').style.display = 'inline-block';
	} else {
		document.getElementById('passwordError').style.display = 'none';
	}
	
	return valid;
}

/*
end of code segment from "Lecture 5 - Example Files"
Filename and location: "week5-examples.zip > example 6 > 'script.js'"
File download: "https://vuws.westernsydney.edu.au/bbcswebdav/pid-10092280-dt-content-rid-67965884_1/xid-67965884_1"
Website: "https://vuws.westernsydney.edu.au/webapps/blackboard/content/listContent.jsp?course_id=_49327_1&content_id=_10092215_1"
*/

