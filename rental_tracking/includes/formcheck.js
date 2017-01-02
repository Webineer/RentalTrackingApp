<!-- 

//Begin Form validation code
	var errIndex
	
	function checkFirstName() {
		
		if (document.fasForm.FirstName.value == "") {
			document.all.Warning1.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning1.style.color = "white"
		}
	}
	
	function checkLastName() {
		
		if (document.fasForm.LastName.value == "") {
			document.all.Warning2.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning2.style.color = "white"
		}
	}
	
	
	function checkTitle() {
		
		if (document.fasForm.Title.value == "") {
			document.all.Warning3.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning3.style.color = "white"
		}
	}
	
	function checkDepartment() {
		
		if (document.fasForm.DepartmentId.options.selectedIndex == 0) {
			document.all.Warning4.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning4.style.color = "white"
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
	
	function checkManager() {
		
		if (document.fasForm.ManagerName.value == "") {
			document.all.Warning6.style.color = "red"
			errIndex = 1
		} else {
			document.all.Warning6.style.color = "white"
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
	
	
// -->
