angular.module("mainApp")
.factory("initService", function($location, $routeParams){
	var initService = {};

	//--Set page style
	initService.setView = function(){
		$(".aside").show();
		$(".section-link").show();
		$("#section").removeClass().addClass("col-md-9 section");

		initService.setViewActiveNav();
	}

	initService.setViewForAdmin = function(){
		$(".aside").hide();
		$(".section-link").hide();
		$("#section").removeClass().addClass("col-md-12 section-round");

		initService.setViewActiveNav();
	}

	initService.setViewActiveNav = function(){
		var element = $("#navbar-header-menu > ul");
		element.find("li").removeClass("active");

		if($location.path() == "/")
			element.find("li[value='หน้าหลัก']").addClass("active");
		else if($location.path() == "/history")
			element.find("li[value='ประวัติหน่วย']").addClass("active");
		else if($location.path() == "/mission")
			element.find("li[value='ภารกิจ']").addClass("active");
		else if($location.path() == "/currentCommander" || 
			$location.path() == "/formerCommander")
			element.find("li[value='ผู้บังคับบัญชา']").addClass("active");
		else if($location.path() == "/activity/1" || 
			$location.path() == "/activity/2" || 
			$location.path() == "/activity/3")
			element.find("li[value='กิจกรรม']").addClass("active");
		else if($location.path() == "/holy")
			element.find("li[value='สิ่งศักดิ์สิทธิ์ประจำกองพัน']").addClass("active");
		else if($location.path() == "/contact")
			element.find("li[value='ติดต่อเรา']").addClass("active");
		else if($location.path() == "/admin")
			element.find("li").removeClass("active");
	}

	return initService;
})
.factory("connectDBService", function($http){
	var connectDBService = {} ;

	//--Pass data for query to database
	connectDBService.query = function(ajaxUrl, param){
		var options = {
			method: "POST",
			url: ajaxUrl,
			cache: false
		};

		if(param != "" && param != undefined)
			options.data = JSON.stringify(param);
			
		return $http(options);
	}

	connectDBService.queryUpload = function(ajaxUrl, param){
		var options = {
	        type: "POST",
	        url: ajaxUrl,
	        processData: false,
	        contentType: false,
	        data: param
	    };

	    return $.ajax(options);
	}

	return connectDBService;
})
.factory("dataService", function($rootScope){
	var dataService = {};

	//--Sharing data between controller
	dataService.savedData = {};
	dataService.sendData = function(item){
		this.savedData = item;
		$rootScope.$broadcast("sharedData");
	}

	dataService.filterUseObj = function(obj, filterKey){
		var newObj = {};

		$.each(obj, function(key, value){
			if($.inArray(key, filterKey) != -1)
				newObj[key] = value;
		});

		return newObj;
	}

	dataService.filterNoUseObj = function(obj, filterKey){
		var newObj = {};

		$.each(obj, function(key, value){
			if($.inArray(key, filterKey) == -1)
				newObj[key] = value;
		});

		return newObj;
	}

	dataService.filterUseKey = function(array, filterKey){
		var newObj = {};
		var newArr = [];

		$.each(array, function(index, item){
			newObj = {};
			$.each(item, function(key, value){
				if($.inArray(key, filterKey) != -1)
					newObj[key] = value;
			});
			newArr.push(newObj);
		});

		return newArr;
	}

	dataService.filterNoUseKey = function(array, filterKey){
		var newObj = {};
		var newArr = [];

		$.each(array, function(index, item){
			newObj = {};
			$.each(item, function(key, value){
				if($.inArray(key, filterKey) == -1)
					newObj[key] = value;
			});
			newArr.push(newObj);
		});

		return newArr;
	}

	dataService.getDataChange = function(originData, updateData, key){
		var dataChange = {};

		$.each(originData, function(keyOrigin, valOrigin){
			$.each(updateData, function(keyUpdate, valUpdate){
				if(keyOrigin == keyUpdate){
					if(valOrigin != valUpdate){
						if(key != "" && key != undefined)
							dataChange["condition"] = key +" = '"+ updateData[key] +"'";

						dataChange[keyUpdate] = valUpdate;
					}
				}
			});
		});

		return dataChange;
	}

	dataService.getDataArrChange = function(originData, updateData, key){
		var dataArrChange = [];
		var dataChange = {};

		$.each(originData, function(originIndex, originItem){
			dataChange = {};

			$.each(originItem, function(keyOrigin, valOrigin){
				$.each(updateData[originIndex], function(keyUpdate, valUpdate){
					if(keyOrigin == keyUpdate){
						if(valOrigin != valUpdate){
							if(key != "" && key != undefined)
								dataChange["condition"] = key +" = '"+ updateData[originIndex][key] +"'";

							dataChange[keyUpdate] = valUpdate;
						}
					}
				});
			});
			
			if(!$.isEmptyObject(dataChange))
				dataArrChange.push(dataChange);
		});

		return dataArrChange;
	}

	dataService.getDateFormat = function(date){
		var dateArr = date.split("/");
		var dateFormat = dateArr[2] + "-" + dateArr[1] + "-" + dateArr[0];

		return dateFormat;
	}

	return dataService;
});