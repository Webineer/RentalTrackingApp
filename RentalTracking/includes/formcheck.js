<!-- 

//Begin Form validation code
	var errIndex
	
	function checkLocationName() {
		
		if (document.locationForm.LocationName.value == "") {
			document.all.Warning1.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning1.style.color = "white"
		}
	}
	
	function checkTrackName() {
		
		if (document.trackForm.TrackName.value == "") {
			document.all.Warning1.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning1.style.color = "white"
		}
	}
	
	
	function checkSearchString() {
		
		if (document.userSearchForm.SearchString.value == "") {
			document.all.Warning1.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning1.style.color = "white"
		}
	}
	
	function checkTrackSecurity() {
		
		if (document.trackForm.Security.options.selectedIndex == 0) {
			document.all.Warning3.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning3.style.color = "white"
		}
	}
	
	function checkLocation() {
		
		if (document.fasForm.LocationId.options.selectedIndex == 0) {
			document.all.Warning5.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning5.style.color = "white"
		}
	}
	
	function checkFirstname() {
		
		if (document.userForm.FirstName.value == "") {
			document.all.Warning1.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning1.style.color = "white"
		}
	}
	
	function checkLastname() {
		
		if (document.userForm.LastName.value == "") {
			document.all.Warning4.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning4.style.color = "white"
		}
	}
	
	function checkUsername() {
		
		if (document.userForm.Username.value == "") {
			document.all.Warning5.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning5.style.color = "white"
		}
	}
	
	function checkPassword() {
		
		if (document.userForm.Password.value == "") {
			document.all.Warning6.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning6.style.color = "white"
		}
	}
	
	function checkCourseName() {
		
		if (document.courseForm.CourseName.value == "") {
			document.all.Warning1.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning1.style.color = "white"
		}
	}
	
	function checkCourseNumber() {
		
		if (document.courseForm.CourseNumber.value == "") {
			document.all.Warning8.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning8.style.color = "white"
		}
	}
	
	function checkCourseSynopsis() {
		
		if (document.courseForm.Synopsis.value == "") {
			document.all.Warning4.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning4.style.color = "white"
		}
	}
	
	function checkCourseDescription() {
		
		if (document.courseForm.Description.value == "") {
			document.all.Warning5.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning5.style.color = "white"
		}
	}
	
	function checkCourseDuration() {
		
		if ((document.courseForm.CourseDuration.value == "") || (check4Text(document.courseForm.CourseDuration.value) == true)) {
			document.all.Warning6.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning6.style.color = "white"
		}
	}
	
	function checkCoursePricing() {
		
		if ((document.courseForm.CoursePricing.value == "") || (check4Text(document.courseForm.CoursePricing.value) == true)) {
			document.all.Warning7.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning7.style.color = "white"
		}
	}
	
	function checkCourseMinimumSeats() {
		
		if (document.courseForm.CourseMinimumSeats.value == "") {
			document.all.Warning8.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning8.style.color = "white"
		}
	}
	
	function checkCourseMaximumSeats() {
		
		if (document.courseForm.MaximumSeats.value == "") {
			document.all.Warning9.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning9.style.color = "white"
		}
	}
	
	function checkCourseOrder() {
		
		if ((document.courseForm.CourseOrder.value == "") || (check4Text(document.courseForm.CourseOrder.value) == true)) {
			document.all.Warning1.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning1.style.color = "white"
		}
	}
	
	function checkPrereqOrder() {
		
		if ((document.courseForm.PrereqOrder.value == "") || (check4Text(document.courseForm.PrereqOrder.value) == true)) {
			document.all.Warning1.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning1.style.color = "white"
		}
	}
	
	function checkQualificationDate() {
		
		if ((document.courseForm.QualificationDate.value == "") || (check4Text(document.courseForm.QualificationDate.value) == true)) {
			document.all.Warning1.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning1.style.color = "white"
		}
	}
	
	function checkCommDescription() {
		
		if (document.commForm.Description.value == "") {
			document.all.Warning4.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning4.style.color = "white"
		}
	}
	
	function checkCommText() {
		
		if (document.commForm.CommText.value == "") {
			document.all.Warning3.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning3.style.color = "white"
		}
	}
	
	function checkRegistrationUserId() {
		
		if (document.registrationForm.UserId.value == "") {
			document.all.Warning1.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning1.style.color = "white"
		}
	}
	
	function checkRegistrationClassId() {
		if (document.registrationForm.ClassId.options.selectedIndex == 0) {
			document.all.Warning2.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning2.style.color = "white"
		}
	}
	
	function checkRegistrationPrice() {
		
		if (document.registrationForm.RegistrationPrice.value == "") {
			document.all.Warning6.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning6.style.color = "white"
		}
	}
	
	function checkRegistrationCurrency() {
		
		if (document.registrationForm.RegistrationPriceCurrency.value == "") {
			document.all.Warning7.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning7.style.color = "white"
		}
	}
	
	
	function checkBulkRegistrationClassId() {
		if (document.bulkRegistrationForm.ClassId.options.selectedIndex == 0) {
			document.all.Warning1.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning1.style.color = "white"
		}
	}
	
	function checkBulkRegistrationPrice() {
		
		if (document.bulkRegistrationForm.RegistrationPrice.value == "") {
			document.all.Warning3.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning3.style.color = "white"
		}
	}
	
	function checkBulkRegistrationCurrency() {
		
		if (document.bulkRegistrationForm.RegistrationPriceCurrency.value == "") {
			document.all.Warning4.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning4.style.color = "white"
		}
	}
	
	
	
	function checkClassCourseId() {
		
		if (document.classForm.CourseId.options.selectedIndex == 0) {
			document.all.Warning1.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning1.style.color = "white"
		}
	}
	
	function checkClassDateStart() {
		
		if ((document.classForm.ClassDateStart.value == "") || (check4Text(document.classForm.ClassDateStart.value) == true)) {
		//if (document.classForm.ClassDateStart.value == "") {
			document.all.Warning5.style.color = "red"
			errIndex = 1
		} else {
			//if (check4Text(document.classForm.ClassDateStart.value) == true) {
			//	alert(document.classForm.ClassDateStart.value)
			//	document.all.Warning5.style.color = "red"
			//} else {
				document.all.Warning5.style.color = "white"
			//}
		}
	}
	
	function checkClassDateEnd() {
		
		if ((document.classForm.ClassDateEnd.value == "") || (check4Text(document.classForm.ClassDateEnd.value) == true) || (document.classForm.ClassDateEnd.value < document.classForm.ClassDateStart.value) ) {
			document.all.Warning6.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning6.style.color = "white"
		}
	}
	
	function checkClassMinSeats() {
		
		if ((document.classForm.ClassMinSeats.value == "") || (check4Text(document.classForm.ClassMinSeats.value) == true)) {
			document.all.Warning7.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning7.style.color = "white"
		}
	}

	function checkClassMaxSeats() {
		
		if ((document.classForm.ClassMaxSeats.value == "") || (check4Text(document.classForm.ClassMaxSeats.value) == true) || (document.classForm.ClassMaxSeats.value != Math.max(document.classForm.ClassMinSeats.value, document.classForm.ClassMaxSeats.value)) ) {
			document.all.Warning8.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning8.style.color = "white"
		}
	}
	
	function checkClassPrice() {
		
		if ((document.classForm.ClassPrice.value == "") || (check4Text(document.classForm.ClassPrice.value) == true)) {
			document.all.Warning9.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning9.style.color = "white"
		}
	}
	
	function checkClassCurrency() {
		
		if (document.classForm.ClassPriceCurrency.value == "") {
			document.all.Warning10.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning10.style.color = "white"
		}
	}
	
	function checkClassroomName() {
		
		if (document.classroomForm.ClassroomName.value == "") {
			document.all.Warning1.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning1.style.color = "white"
		}
	}
	
	function checkAssetType() {
		
		if (document.assetForm.AssetType.options.selectedIndex == 0) {
			document.all.Warning1.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning1.style.color = "white"
		}
	}
	
	function checkAssetLocation() {
		
		if (document.assetForm.LocationId.options.selectedIndex == 0) {
			document.all.Warning2.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning2.style.color = "white"
		}
	}
	
	function checkVendor() {
		
		if (document.assetForm.AssetVendor.value == "") {
			document.all.Warning3.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning3.style.color = "white"
		}
	}
	
	function check4Text(testString) {
		var err = "0"
		//alert("we are here")
    	var checkRef = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.-"
    	for (i = 0; i < testString.length; i++) {
    		var theChar = testString.charAt(i)
    	    var validChar = checkRef.indexOf(theChar)
			//alert(validChar)
    	    if (validChar != "-1") {
				err = "1"
				//alert(err) 
    	    }
    	}
		
		if (err == "1") {
			return true
		} else {
			return false
		}
	}
	
	function cleanFormData(form) {
		for (var i = 0; i < form.length; i++) {
			var element = f.elements[i]
			if ((element.type == "text") || (element.type == "textarea")) {
				if ( (element.value != null) || (element.value != "") ) {
					element.replace(/"'"/g, "`")
					element.replace(/\n/g, "<br>")
					element.replace(/\r/g, "<br>")
					element.replace(/\t/g, "<br>")
				}
			}
		}
	}
	
// -->
