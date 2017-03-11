angular.module("mainApp")
.controller("activityDetailController", function($scope, $routeParams, initService, connectDBService, localStorageService){
	console.log("Ctrl of this page: activityDetailController");
	initService.setView();

	var ajaxUrl = "APIService/ActivityDetailAPI.php";
	var param = {
		"funcName": "getActivityList",
		"param": $routeParams.activityID
	};
	$scope.activityItem = {};
	
	if(localStorageService.isSupported){
		if(!$.isEmptyObject(localStorageService.get("activityItem"))){
				angular.copy(localStorageService.get("activityItem"), $scope.activityItem);
				appendImageGallery($scope.activityItem["activity_image_url_list"]);
				console.log(localStorageService.get("activityItem"));
		}
	}

	function appendImageGallery(activityImageUrlList){
		$.each(activityImageUrlList, function(obj, item){
			$("#gallery").append('<img src="ActivitiesImages/'+ item["activity_image_url"] +'" data-image="ActivitiesImages/'+ item["activity_image_url"] +'">');
		});
	}

	$("#gallery").unitegallery({
		gallery_theme: "compact",
		theme_panel_position: "bottom",
		gallery_autoplay: true,
		gallery_play_interval: 5000,
		slider_scale_mode: "fit"
	});
});