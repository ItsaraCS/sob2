angular.module("mainApp")
.controller("adminController", function($scope, $location, $interval, initService, connectDBService){
	console.log("Ctrl of this page: adminController");
	initService.setViewForAdmin();

	var ajaxUrl = "APIService/AdminAPI.php";
	var param = {};
	$scope.entryLogin = {
		"username": "",
		"password": ""
	};
	$scope.entryUser = {
		"user_id": "",
		"username": "",
		"name": ""
	};

	$scope.getSession = function(){
		param = {
			"funcName": "getSession",
			"param": ""
		};

		connectDBService.query(ajaxUrl, param).success(function(response){
			var session = response;

			if(session["user_id"] != "" && session["user_id"] != undefined){
				angular.copy(session, $scope.entryUser)
				console.log($scope.entryUser);
			}else
				$location.path("/admin");
		});
	}
	$scope.getSession();

	$scope.login = function(){
		param = {
			"funcName": "login",
			"param": $scope.entryLogin
		};

		connectDBService.query(ajaxUrl, param).success(function(response){
			if(response != "" && response != undefined){
				var item = response;
				var msg = '<i class="'+ item["classIcon"] +' indent-text-title"></i>'+ item["msg"];			
				
				$(".messageInfo").html(msg).removeClass("text-success text-danger").addClass(item["classMsg"]);
				
				if(item["status"])
					$location.path("/adminManage");
				else{
					$scope.entryLogin = {};

					$("input[name='username']").focus();
					$interval(function(){
						$(".messageInfo").html("");
					}, 5000, true);
				}
			}
		});
	}

	$scope.resetModel = function(self, modelName){
		self[modelName] = {};
	}

	//--Event
	$(document).on("focus", "#loginForm input[name='password']", function(e){
		$(this).attr("type", "text");
	});
	$(document).on("blur", "#loginForm input[name='password']", function(e){
		if($(this).val() != "")
			$(this).attr("type", "password");
	});
});