angular.module("mainApp", [ "ngRoute", "LocalStorageModule" ]);

angular.module("mainApp")
.config(function($routeProvider){
	$routeProvider
		.when(
			"/", {
				controller: "homeController",
				templateUrl: "Partials/PagePartials/Home.php"
			}
		)
		.when(
			"/history", {
				controller: "historyController",
				templateUrl: "Partials/PagePartials/History.php"
			}
		)
		.when(
			"/mission", {
				controller: "missionController",
				templateUrl: "Partials/PagePartials/Mission.php"
			}
		)
		.when(
			"/currentCommander", {
				controller: "currentCommanderController",
				templateUrl: "Partials/PagePartials/CurrentCommander.php"
			}
		)
		.when(
			"/formerCommander", {
				controller: "formerCommanderController",
				templateUrl: "Partials/PagePartials/FormerCommander.php"
			}
		)
		.when(
			"/activity/:categoryID", {
				controller: "activityController",
				templateUrl: "Partials/PagePartials/Activity.php"
			}
		)
		.when(
			"/activityDetail/:activityID", {
				controller: "activityDetailController",
				templateUrl: "Partials/PagePartials/ActivityDetail.php"
			}
		)
		.when(
			"/holy", {
				controller: "holyController",
				templateUrl: "Partials/PagePartials/Holy.php"
			}
		)
		.when(
			"/contact", {
				controller: "contactController",
				templateUrl: "Partials/PagePartials/Contact.php"
			}
		)
		.when(
			"/admin", {
				controller: "adminController",
				templateUrl: "Partials/PagePartials/Admin.php"
			}
		)
		.when(
			"/adminRegister", {
				controller: "adminRegisterController",
				templateUrl: "Partials/PagePartials/AdminRegister.php"
			}
		)
		.when(
			"/adminManage", {
				controller: "adminManageController",
				templateUrl: "Partials/PagePartials/AdminManage.php"
			}
		)
		.otherwise({
			redirectTo: "/"
		});
})
.controller("mainController", function($scope, initService){
	console.log("Ctrl of this page: mainController");
	initService.setView();

	$(document).ready(function(){
		//--Button for scroll to top page
		$(window).scroll(function(){
            if($(this).scrollTop() > 50){
                $("#back-to-top").fadeIn();
            }else{
                $("#back-to-top").fadeOut();
            }
        });
        $("#back-to-top").click(function(){ //--Scroll body to 0px on click
            $("#back-to-top").tooltip("hide");
            $("body, html").animate({
                scrollTop: 0
            }, 800);
            return false;
        });
        $("#back-to-top").tooltip("show");

		//--Show/Hide dropdown when on hover link
		$("ul.nav li.dropdown").hover(function(){
			$(this).find(".dropdown-menu").stop(true, true).fadeIn("fast");
			$(this).toggleClass('open'); 
		}, function(){
			$(this).find(".dropdown-menu").stop(true, true).fadeOut("fast");
			$(this).toggleClass('open');
		});
	});
})
.controller("historyController", function($scope, initService){
	console.log("Ctrl of this page: historyController");
	initService.setView();
})
.controller("missionController", function($scope, initService){
	console.log("Ctrl of this page: missionController");
	initService.setView();
})
.controller("currentCommanderController", function($scope, initService){
	console.log("Ctrl of this page: currentCommanderController");
	initService.setView();
})
.controller("formerCommanderController", function($scope, initService){
	console.log("Ctrl of this page: formerCommanderController");
	initService.setView();
})
.controller("holyController", function($scope, initService){
	console.log("Ctrl of this page: holyController");
	initService.setView();
})
.controller("contactController", function($scope, initService){
	console.log("Ctrl of this page: contactController");
	initService.setView();
});