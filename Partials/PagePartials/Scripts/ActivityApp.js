angular.module("mainApp")
.controller("activityController", function($scope, $routeParams, initService, connectDBService, dataService){
	console.log("Ctrl of this page: activityController");
	initService.setView();

	var ajaxUrl = "APIService/ActivityAPI.php";
	var param = {};
	$scope.activityData = [];
	$scope.categoryID = $routeParams.categoryID;
	$scope.categoryName = "";

	if($routeParams.categoryID == 1)
		$scope.categoryName = "ร้อย ๑ พัน ๒";
	else if($routeParams.categoryID == 2)
		$scope.categoryName = "ร้อย ๒, ร้อย ๓ พัน ๒";
	else if($routeParams.categoryID == 3)
		$scope.categoryName = "ทหารใหม่";

	//--Get total of page
	$scope.getTotalPage = function(){
		param = {
			"funcName": "getTotalPage",
			"param": $scope.categoryID
		};

		connectDBService.query(ajaxUrl, param).success(function(response){
			if(response != "" && response != undefined){
				$scope.totalPage = response;
				$scope.totalPageList = [];
				for(var i=1; i<=$scope.totalPage; i++){
					$scope.totalPageList.push(i);
				}
			}
		});
	}
	$scope.getTotalPage();

	//--Get data per page
	$scope.getDataPerPage = function(page){
		var param = {
			"funcName": "getActivityList",
			"param": {
				"categoryID": $scope.categoryID,
				"page": page
			}
		};

		connectDBService.query(ajaxUrl, param).success(function(response){
			if(response != "" && response != undefined){
				angular.copy(response, $scope.activityData);
			}
		});
	}
	$scope.getDataPerPage(1);

	//--Sharing data between controller
	$scope.sendData = function(item){
		dataService.sendData(item);
	}

	$scope.$on("sharedData", function(){
		$scope.savedData = dataService.savedData;
	});
});