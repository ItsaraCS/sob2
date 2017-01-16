angular.module("mainApp")
.controller("adminManageController", function($scope, $location, $interval, initService, connectDBService, dataService){
	console.log("Ctrl of this page: adminManageController");
	initService.setViewForAdmin();

	var ajaxUrl = "";
	var param = {};

	$scope.userPermissionData = [];
	$scope.userPermission = {};

	$scope.categoryList = [];
	$scope.activityList = [];

	$scope.entryUser = {
		"user_id": "",
		"username": "",
		"name": ""
	};

	$scope.entryInsertList = [];
	$scope.entryInsert = {
		"activity_name": "",
		"activity_description": "",
		"activity_date": "",
		"category_id": "",
		"user_id": ""
	};

	$scope.entryDelete = {
		"category_id": "",
		"activity_id": ""
	};

	$scope.entryUpdateList = [];
	$scope.entryUpdate = {
		"update_category_id": "",
		"activity_id": "",
		"activity_name": "",
		"activity_description": "",
		"activity_date": "",
		"category_id": "",
		"user_id": ""
	};
	$scope.activityImageList = [];
	$scope.activityImageOriginList = [];
	$scope.activityImageOriginUpdateList = [];

	$scope.entrySettingList = [];
	$scope.entrySetting = {
		"setting_user_id": "",
		"username": "",
		"password": "",
		"name": "",
		"email": "",
		"phone": "",
		"position": ""
	};
	$scope.nameUserList = [];
	$scope.permissionStatusList = [];
	$scope.permissionOriginList = [];
	$scope.permissionOriginUpdateList = [];

	$scope.getSession = function(){
		ajaxUrl = "APIService/AdminAPI.php";
		param = {
			"funcName": "getSession",
			"param": ""
		};

		connectDBService.query(ajaxUrl, param).success(function(response){
			var session = response;

			if(session["user_id"] != "" && session["user_id"] != undefined){
				angular.copy(session, $scope.entryUser);

				$scope.getDataUserPermission();
				console.log($scope.entryUser);
			}else
				$location.path("/admin");
		});
	}
	$scope.getSession();

	$scope.getDataUserPermission = function(){
		ajaxUrl = "APIService/AdminManageAPI.php";
		param = {
			"funcName": "getDataUserPermission",
			"param": $scope.entryUser["user_id"]
		};
		
		connectDBService.query(ajaxUrl, param).success(function(response){
			angular.copy(response, $scope.userPermissionData);
			console.log($scope.userPermissionData);
		});
	}

	$scope.logout = function(){
		ajaxUrl = "APIService/AdminAPI.php";
		param = {
			"funcName": "logout",
			"param": ""
		};

		connectDBService.query(ajaxUrl, param).success(function(response){
			$("body").removeClass("modal-open");
			$(".modal-backdrop").remove();
			$location.path("/admin");
		});
	}

	$scope.resetModel = function(self, modelName){
		self[modelName] = {};

		$scope.activityList = [];
		$scope.entryInsertList = [];

		$scope.entryUpdateList = [];
		$scope.activityImageList = [];
		$scope.activityImageOriginList = [];
		$scope.activityImageOriginUpdateList = [];
		$scope.entryUpdateDisabled = true;
		$(".thumbnailActivityImage").html("");

		$scope.entrySettingList = [];
		$scope.permissionOriginList = [];
		$scope.permissionOriginUpdateList = [];
		$scope.entrySettingDisabled = true;
		$scope.getNameUserList();
	}

	$scope.getCategoryList = function(){
		ajaxUrl = "APIService/AdminManageAPI.php";
		param = {
			"funcName": "getCategoryList",
			"param": ""
		};

		connectDBService.query(ajaxUrl, param).success(function(response){
			angular.copy(response, $scope.categoryList);
		});
	}
	$scope.getCategoryList();

	$scope.getActivityList = function(categoryID){
		ajaxUrl = "APIService/AdminManageAPI.php";
		param = {
			"funcName": "getActivityList",
			"param": categoryID | 0
		};

		connectDBService.query(ajaxUrl, param).success(function(response){
			angular.copy(response, $scope.activityList);

			$scope.entryDelete.activity_id = "";

			$scope.entryUpdate = {};
			$scope.entryUpdate.update_category_id = categoryID;
			$scope.activityImageList = [];
			$scope.entryUpdateDisabled = true;
			$(".thumbnailActivityImage").html("");
		});
	}

	$scope.getDataUpdate = function(activityID){
		ajaxUrl = "APIService/AdminManageAPI.php";
		param = {
			"funcName": "getDataUpdate",
			"param": activityID | 0
		};

		connectDBService.query(ajaxUrl, param).success(function(response){
			if(response != "" && response != undefined){
				$scope.originData = {};
				angular.copy(response["activitiesData"], $scope.originData);
				angular.copy(response["activitiesData"], $scope.entryUpdate);
				angular.copy(response["activitiesImagesData"], $scope.activityImageOriginList);
				
				$scope.entryUpdateDisabled = false;
				var thumbnailActivityImage = $(".thumbnailActivityImage");
		        var pathUpload = "ActivitiesImages/";
		        var imageItem = "";
		        thumbnailActivityImage.html("");

				$.each($scope.activityImageOriginList, function(index, item){
					imageItem = '<div class="col-md-3 thumbnailOriginItem" data-item="'+ item["activity_image_id"] +'">';
					imageItem += '<div class="thumbnail" style="position: relative;">';
					imageItem += '<span style="position: absolute; top: 0; right: 0; left: 0; background-color: rgba(245, 245, 245, 0.7)">';
					imageItem += 'รูปเดิม</span>';
					imageItem += '<img src="'+ pathUpload + item["activity_image_url"] +'?'+ (Math.random() * Math.random()) +'" style="width: 140px; height: 80px;">';
					imageItem += '<button type="button" class="btn btn-danger btn-xs remove-thumbnail-origin" ';
					imageItem += 'style="position: absolute; bottom: 0; right: 0;">';
					imageItem += '<i class="glyphicon glyphicon-remove"></i></button>';
					imageItem += '</button>';
					imageItem += '</div>';
					imageItem += '</div>';

					thumbnailActivityImage.append(imageItem);
				});

				if($scope.activityImageOriginList.length != 0){
					var activityItem = $scope.activityImageOriginList[$scope.activityImageOriginList.length - 1]["activity_image_url"];
					
					$scope.updateForm["activityImage[]"].$setViewValue(activityItem);
				}
			}
		});
	}

	$scope.getNameUserList = function(){
		ajaxUrl = "APIService/AdminManageAPI.php";
		param = {
			"funcName": "getNameUserList",
			"param": ""
		};

		connectDBService.query(ajaxUrl, param).success(function(response){
			angular.copy(response, $scope.nameUserList);
		});
	}
	$scope.getNameUserList();

	$scope.getPermissionStatusList = function(){
		ajaxUrl = "APIService/AdminManageAPI.php";
		param = {
			"funcName": "getPermissionStatusList",
			"param": ""
		};

		connectDBService.query(ajaxUrl, param).success(function(response){
			angular.copy(response, $scope.permissionStatusList);
		});
	}

	$scope.getDataSetting = function(userID){
		ajaxUrl = "APIService/AdminManageAPI.php";
		param = {
			"funcName": "getDataSetting",
			"param": userID | 0
		};

		connectDBService.query(ajaxUrl, param).success(function(response){
			if(response != "" && response != undefined){
				$scope.originData = {};
				$scope.permissionOriginList = [];
				angular.copy(response["usersData"], $scope.originData);
				angular.copy(response["usersData"], $scope.entrySetting);
				angular.copy(response["permissionData"], $scope.permissionOriginList);
				angular.copy(response["permissionData"], $scope.permissionOriginUpdateList);

				$scope.entrySettingDisabled = false;
				$scope.getPermissionStatusList();
			}
		});
	}

	$scope.insertData = function(){
		$("body").removeClass("modal-open");
		$(".modal-backdrop").remove();

		var formData = new FormData();
		$scope.entryInsert["user_id"] = $scope.entryUser["user_id"];
		$scope.entryInsert["activity_date"] = dataService.getDateFormat($scope.entryInsert["activity_date"]);
        
        if($scope.activityImageList.length > 0){
        	$scope.entryInsert["tbl_activities_images"] = {
	        	"tblName": "activities_images",
	        	"foreignKey": "activity_id",
	        	"data": []
	        };

	        $.each($scope.activityImageList, function(key, item){
	            formData.append("activity-1-" + (key + 1), item);
	            $scope.entryInsert["tbl_activities_images"]["data"].push({
	            	"activity_image_url": "activity-1-" + (key + 1) + (item["type"] == "image/jpeg" ? ".jpg" : ".png")
	            });
	        });
        }

        $scope.entryInsertList.push($scope.entryInsert);
		$scope.entryInsertList = dataService.filterNoUseKey($scope.entryInsertList, ["activity_image"]);

		ajaxUrl = "APIService/AdminManageAPI.php";
		formData.append("funcName", "insertActivities");     
        formData.append("tblName", "activities");     
        formData.append("data", JSON.stringify($scope.entryInsertList));

		connectDBService.queryUpload(ajaxUrl, formData).success(function(response){
			if(response != "" && response != undefined){
				var item = JSON.parse(response);
				var msg = '<i class="'+ item["classIcon"] +' indent-text-title"></i>'+ item["msg"];	
				$(".messageInfo").html(msg).removeClass("text-success text-danger").addClass(item["classMsg"]);		
				
				$interval(function(){
					$(".messageInfo").html("");
				}, 5000, true);
			}

			$scope.entryInsertList = [];
			$scope.entryInsert = {};
			$scope.activityImageList = [];
			$(".thumbnailActivityImage").html("");		

			$scope.$apply();
	    });
	}

	$scope.deleteData = function(){
		$("body").removeClass("modal-open");
		$(".modal-backdrop").remove();

		ajaxUrl = "APIService/AdminManageAPI.php";
		param = {
			"funcName": "deleteActivities",
			"param": $scope.entryDelete.activity_id
		};

		connectDBService.query(ajaxUrl, param).success(function(response){
			if(response != "" && response != undefined){
				var item = response;
				var msg = '<i class="'+ item["classIcon"] +' indent-text-title"></i>'+ item["msg"];	
				$(".messageInfo").html(msg).removeClass("text-success text-danger").addClass(item["classMsg"]);		
				
				$interval(function(){
					$(".messageInfo").html("");
				}, 5000, true);
			}

			$scope.entryDelete = {};
			$scope.activityList = [];
		});
	}

	$scope.updateData = function(){
		$("body").removeClass("modal-open");
		$(".modal-backdrop").remove();

		var formData = new FormData();
		var activityID = $scope.entryUpdate["activity_id"];
		$scope.entryUpdate = dataService.getDataChange($scope.originData, $scope.entryUpdate, "activity_id");

		if(!$.isEmptyObject($scope.entryUpdate)){
			$scope.entryUpdate["user_id"] = $scope.entryUser["user_id"];
			$scope.entryUpdate["updated"] = "";

			if($scope.entryUpdate["activity_date"])
				$scope.entryUpdate["activity_date"] = dataService.getDateFormat($scope.entryUpdate["activity_date"]);
		}
     
       	if($scope.activityImageOriginUpdateList.length > 0)
        	$scope.entryUpdate["activityImageOriginUpdateList"] = $scope.activityImageOriginUpdateList;

        if($scope.activityImageList.length > 0){
        	$scope.entryUpdate["tbl_activities_images"] = {
	        	"tblName": "activities_images",
	        	"foreignKey": "activity_id",
	        	"foreignKeyID": activityID,
	        	"data": []
	        };

        	$.each($scope.activityImageList, function(key, item){
	            formData.append("activity-"+ activityID +"-" + (key + 1), item);
	            $scope.entryUpdate["tbl_activities_images"]["data"].push({
	            	"activity_image_url": "activity-"+ activityID +"-"+ (key + 1) + (item["type"] == "image/jpeg" ? ".jpg" : ".png")
	            });
	        });
        }
        
        if(!$.isEmptyObject($scope.entryUpdate)){
        	$scope.entryUpdateList.push($scope.entryUpdate);
        	$scope.entryUpdateList = dataService.filterNoUseKey($scope.entryUpdateList, ["activity_image"]);
        }

		ajaxUrl = "APIService/AdminManageAPI.php";
		formData.append("funcName", "updateActivities");     
        formData.append("tblName", "activities");     
        formData.append("data", JSON.stringify($scope.entryUpdateList));
        
		connectDBService.queryUpload(ajaxUrl, formData).success(function(response){
			if(response != "" && response != undefined){
				var item = JSON.parse(response);
				var msg = '<i class="'+ item["classIcon"] +' indent-text-title"></i>'+ item["msg"];	
				$(".messageInfo").html(msg).removeClass("text-success text-danger").addClass(item["classMsg"]);		
				
				$interval(function(){
					$(".messageInfo").html("");
				}, 5000, true);
			}

			$scope.entryUpdateList = [];
			$scope.entryUpdate = {};
			$scope.activityImageList = [];
			$scope.activityImageOriginList = [];
			$scope.activityImageOriginUpdateList = [];
			$scope.entryUpdateDisabled = true;
			$(".thumbnailActivityImage").html("");

			$scope.$apply();
	    });
	}

	$scope.$watchCollection("[entrySetting.username, entrySetting.name, entrySetting.email]", function(newData){
		ajaxUrl = "APIService/AdminManageAPI.php";
		param["funcName"] = "checkUserAlready";
		
		if(newData[0] != "" && newData[0] != undefined){
			param["param"] = {
				"field": "username",
				"value": newData[0],
				"userID": $scope.entrySetting["user_id"],
				"messageInfo": "errorUsernameAlready"
			};

			checkUserAlready(param, "username");
		}

		if(newData[1] != "" && newData[1] != undefined){
			param["param"] = {
				"field": "name",
				"value": newData[1],
				"userID": $scope.entrySetting["user_id"],
				"messageInfo": "errorNameAlready"
			};

			checkUserAlready(param, "name");
		}

		if(newData[2] != "" && newData[2] != undefined){
			param["param"] = {
				"field": "email",
				"value": newData[2],
				"userID": $scope.entrySetting["user_id"],
				"messageInfo": "errorEmailAlready"
			};

			checkUserAlready(param, "email");
		}

		function checkUserAlready(param, modelName){
			connectDBService.query(ajaxUrl, param).success(function(response){
				if(response != "" && response != undefined){
					console.log(response);
					var item = response;
					var msg = '<i class="'+ item["classIcon"] +' indent-text-title"></i>'+ item["msg"];

					if(!item["status"]){
						$(".messageInfo").html(msg).removeClass("text-success text-danger").addClass(item["classMsg"]);
						
						$scope.entrySetting[modelName] = "";

						$interval(function(){
							$(".messageInfo").html("");
						}, 5000, true);
					}
				}
			});
		}
	});

	$scope.deleteSettingData = function(){
		$("body").removeClass("modal-open");
		$(".modal-backdrop").remove();

		ajaxUrl = "APIService/AdminManageAPI.php";
		param = {
			"funcName": "deleteSetting",
			"param": $scope.entrySetting.user_id
		};

		connectDBService.query(ajaxUrl, param).success(function(response){
			if(response != "" && response != undefined){
				var item = response;
				var msg = '<i class="'+ item["classIcon"] +' indent-text-title"></i>'+ item["msg"];	
				$(".messageInfo").html(msg).removeClass("text-success text-danger").addClass(item["classMsg"]);		
				
				$interval(function(){
					$(".messageInfo").html("");
				}, 5000, true);
			}

			$scope.entrySetting = {};
			$scope.permissionOriginList = [];
			$scope.permissionOriginUpdateList = [];
			$scope.entrySettingDisabled = true;
			$scope.getNameUserList();
		});
	}

	$scope.updateSettingData = function(){
		$("body").removeClass("modal-open");
		$(".modal-backdrop").remove();

		$scope.entrySetting = dataService.getDataChange($scope.originData, $scope.entrySetting, "user_id");

		if(!$.isEmptyObject($scope.entrySetting)){
			$scope.entrySetting["user_id_updated"] = $scope.entryUser["user_id"];
			$scope.entrySetting["updated"] = "";
		}

		$scope.permissionOriginUpdateList = dataService.getDataArrChange($scope.permissionOriginList, $scope.permissionOriginUpdateList, "perm_id");
		
		if($scope.permissionOriginUpdateList.length > 0){
			$.each($scope.permissionOriginUpdateList, function(index, item){
				item["user_id_updated"] = $scope.entryUser["user_id"];
				item["updated"] = "";
			});

			$scope.entrySetting["permissionOriginUpdateList"] = {
				"tblName": "permission",
				"foreignKey": "user_id",
				"data": $scope.permissionOriginUpdateList
			};
		}

		if(!$.isEmptyObject($scope.entrySetting))
			$scope.entrySettingList.push($scope.entrySetting);

		ajaxUrl = "APIService/AdminManageAPI.php";
		param = {
			"funcName": "updateSetting",
			"param": {
				"tblName": "users",
				"data": $scope.entrySettingList
			}
		};
		
		connectDBService.query(ajaxUrl, param).success(function(response){
			if(response != "" && response != undefined){
				var item = response;
				var msg = '<i class="'+ item["classIcon"] +' indent-text-title"></i>'+ item["msg"];	
				$(".messageInfo").html(msg).removeClass("text-success text-danger").addClass(item["classMsg"]);		
				
				$interval(function(){
					$(".messageInfo").html("");
				}, 5000, true);
			}

			$scope.entrySettingList = [];
			$scope.entrySetting = {};
			$scope.permissionOriginList = [];
			$scope.permissionOriginUpdateList = [];
			$scope.entrySettingDisabled = true;
			$scope.getNameUserList();
			$scope.getDataUserPermission();
	    });
	}

	$(document).ready(function(){
		//--Datepicker
		$(".datepicker").datepicker({ 
			dateFormat: "dd/mm/yy",
			changeMonth: true,
        	changeYear: true
		});

		$(document).on("click", "#datepickerBtn", function(e){
			$(".datepicker").focus();
		});

		//--Upload image
		$(document).on("change", "#activityImage, #activityImageUpdate", function(){
			if(typeof (FileReader) != "undefined"){
	            var regexp = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.png)$/;
	            var thumbnailActivityImage = $(".thumbnailActivityImage");
	            var imageItem = "";
	            
	            $.each($(this)[0].files, function(index, item){
	                var file = $(this);

	                if(regexp.test(file[0].name.toLowerCase())){
	                	if(file[0].size <= 500000){
		                    var reader = new FileReader();

		                    reader.onload = function(e){
		                    	imageItem = '<div class="col-md-3 thumbnailItem" data-item="'+ ($scope.activityImageList.length + 1) +'">';
								imageItem += '<div class="thumbnail" style="position: relative;">';
								imageItem += '<img src="'+ e.target.result +'" style="width: 140px; height: 80px;">';
								imageItem += '<button type="button" class="btn btn-danger btn-xs remove-thumbnail" ';
								imageItem += 'style="position: absolute; bottom: 0; right: 0;">';
								imageItem += '<i class="glyphicon glyphicon-remove"></i></button>';
								imageItem += '</button>';
								imageItem += '</div>';
								imageItem += '</div>';

								thumbnailActivityImage.append(imageItem);

								item["item"] = $scope.activityImageList.length + 1;
		                    	item["dataImage"] = e.target.result;
								$scope.activityImageList.push(item);

								console.log($scope.activityImageList);
		                    }

		                    reader.readAsDataURL(file[0]);
	                	}
	                }
	            });

				if($scope.activityImageList.length != 0 || $scope.activityImageOriginList.length != 0){
					var activityImageName = $scope.activityImageList.length != 0 ? 
						$scope.activityImageList[$scope.activityImageList.length - 1]["name"] : 
							$scope.activityImageOriginList[$scope.activityImageOriginList.length - 1]["activity_image_url"];
					
					console.log(activityImageName);
					$scope.insertForm["activityImage[]"].$setViewValue(activityImageName);
					$scope.updateForm["activityImage[]"].$setViewValue(activityImageName);
				}

				$scope.$apply();
	        }
		});

		$(".thumbnailActivityImage").on("click", ".remove-thumbnail", function(){		
			var thumbnail = $(this).closest(".thumbnailItem");
			var thumbnailItem = thumbnail.data("item");
			var idx_thumbnail = 1;
			var thumbnailActivityImage = $(".thumbnailActivityImage");
			thumbnailActivityImage.find(".thumbnailItem").remove();

			$scope.activityImageList = $.grep($scope.activityImageList, function(item, key){
				if(item["item"] != thumbnailItem){
					imageItem = '<div class="col-md-3 thumbnailItem" data-item="'+ idx_thumbnail +'">';
					imageItem += '<div class="thumbnail" style="position: relative;">';
					imageItem += '<img src="'+ item["dataImage"] +'" style="width: 140px; height: 80px;">';
					imageItem += '<button type="button" class="btn btn-danger btn-xs remove-thumbnail" ';
					imageItem += 'style="position: absolute; bottom: 0; right: 0;">';
					imageItem += '<i class="glyphicon glyphicon-remove"></i></button>';
					imageItem += '</button>';
					imageItem += '</div>';
					imageItem += '</div>';

					thumbnailActivityImage.append(imageItem);

					item["item"] = idx_thumbnail;
					idx_thumbnail++;
					return item;
				}
			});

			console.log($scope.activityImageList);

			if($scope.activityImageList.length == 0 && $scope.activityImageOriginList.length == 0){
				$("#activityImage").val("").change();
				$("#activityImageUpdate").val("").change();
			}

			$scope.$apply();
		});

		$(".thumbnailActivityImage").on("click", ".remove-thumbnail-origin", function(){		
			var thumbnailOrigin = $(this).closest(".thumbnailOriginItem");
			var thumbnailOriginItem = thumbnailOrigin.data("item");

			$scope.activityImageOriginList = $.grep($scope.activityImageOriginList, function(item, index){
				if(thumbnailOriginItem == item["activity_image_id"])
					$scope.activityImageOriginUpdateList.push(item);
				else
					return item;
			});

			thumbnailOrigin.remove();
			console.log($scope.activityImageOriginUpdateList);

			if($scope.activityImageList.length == 0 && $scope.activityImageOriginList.length == 0)
				$("#activityImageUpdate").val("").change();

			$scope.$apply();
		});
	});
});