angular.module("mainApp")
.controller("adminRegisterController", function($scope, $location, $interval, initService, connectDBService){
	console.log("Ctrl of this page: adminRegisterController");
	initService.setViewForAdmin();

	var ajaxUrl = "APIService/AdminAPI.php";
	var param = {};
	$scope.entryRegisterList = [];
	$scope.entryRegister = {
		"username": "",
		"password": "",
		"name": "",
		"email": "",
		"phone": "",
		"position": ""
	};

	$scope.$watchCollection("[entryRegister.username, entryRegister.name, entryRegister.email]", function(newData){
		param["funcName"] = "checkUserAlready";

		if(newData[0] != "" && newData[0] != undefined){
			param["param"] = {
				"field": "username",
				"value": newData[0],
				"messageInfo": "errorUsernameAlready"
			};

			checkUserAlready(param, "username");
		}

		if(newData[1] != "" && newData[1] != undefined){
			param["param"] = {
				"field": "name",
				"value": newData[1],
				"messageInfo": "errorNameAlready"
			};

			checkUserAlready(param, "name");
		}

		if(newData[2] != "" && newData[2] != undefined){
			param["param"] = {
				"field": "email",
				"value": newData[2],
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
						
						$scope.entryRegister[modelName] = "";

						$interval(function(){
							$(".messageInfo").html("");
						}, 5000, true);
					}
				}
			});
		}
	});

	$scope.register = function(){
		$scope.entryRegisterList.push($scope.entryRegister);
		
		param = {
			"funcName": "register",
			"param": {
				"tblName": "users",
				"data": $scope.entryRegisterList
			}
		};

		connectDBService.query(ajaxUrl, param).success(function(response){
			if(response != "" && response != undefined){
				var item = response;
				var msg = '<i class="'+ item["classIcon"] +' indent-text-title"></i>'+ item["msg"];			
				
				$(".messageInfo").html(msg).removeClass("text-success text-danger").addClass(item["classMsg"]);
				
				$scope.entryRegister = {};

				$interval(function(){
					$(".messageInfo").html("");
				}, 5000, true);
			}
		});
	}

	$scope.resetModel = function(self, modelName){
		self[modelName] = {};
	}
});