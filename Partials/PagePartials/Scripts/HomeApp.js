angular.module("mainApp")
.controller("homeController", function($scope, initService, connectDBService, dataService){
	console.log("Ctrl of this page: homeController");
	initService.setView();

	var ajaxUrl = "APIService/HomeAPI.php";
	var param = {
		"funcName": "getActivityList",
		"param": ""
	};
	$scope.activityData = [];

	connectDBService.query(ajaxUrl, param).success(function(response){
		if(response != "" && response != undefined){
			angular.copy(response, $scope.activityData);
			$scope.lastCategoryID = $scope.activityData[6] != undefined ? $scope.activityData[6]["category_id"] : 1;
		}
	});

	//--Sharing data between controller
	$scope.sendData = function(item){
		dataService.sendData(item);
	}

	$scope.$on("sharedData", function(){
		$scope.savedData = dataService.savedData;
	});
});