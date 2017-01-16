angular.module("mainApp")
.directive("activeNav", function(){
	return {
		restrict: "A",
		link: function(scope, element, attrs, constructor){
			element.bind("click", function(){
				$(element).closest("ul").find("li").removeClass("active");
				$(element).addClass("active");
			});
		}
	}
})
.directive("activeNavLink", function(){
	return {
		restrict: "A",
		link: function(scope, element, attrs, constructor){
			element.bind("click", function(){
				var element = $("#navbar-header-menu > ul");
				element.find("li").removeClass("active");

				if(attrs.value == "หน้าหลัก")
					element.find("li[value='หน้าหลัก']").addClass("active");
				else if(attrs.value == "ประวัติหน่วย")
					element.find("li[value='ประวัติหน่วย']").addClass("active");
				else if(attrs.value == "ภารกิจ")
					element.find("li[value='ภารกิจ']").addClass("active");
				else if(attrs.value == "ผู้บังคับบัญชา")
					element.find("li[value='ผู้บังคับบัญชา']").addClass("active");
				else if(attrs.value == "กิจกรรม")
					element.find("li[value='กิจกรรม']").addClass("active");
				else if(attrs.value == "สิ่งศักดิ์สิทธิ์ประจำกองพัน")
					element.find("li[value='สิ่งศักดิ์สิทธิ์ประจำกองพัน']").addClass("active");
				else if(attrs.value == "ติดต่อเรา")
					element.find("li[value='ติดต่อเรา']").addClass("active");
			});
		}
	}
})
.directive("activePagination", function(){
	return {
		restrict: "A",
		link: function(scope, element, attrs, constructor){
			if(attrs.value == 1)
				$(element).addClass("active").prev().addClass("disabled");

			element.bind("click", function(){
				$(element).closest("ul").find("li").removeClass("disabled active");
				
				if(attrs.value == 1)
					$(element).addClass("active").prev().addClass("disabled");
				else if(attrs.value == scope.totalPage)
					$(element).addClass("active").next().addClass("disabled");
				else if(attrs.value == "prev")
					$(element).addClass("disabled").next().addClass("active");
				else if(attrs.value == "next")
					$(element).addClass("disabled").prev().addClass("active");
				else
					$(element).addClass("active");
			});
		}
	}
})
.directive("activeAdminMenu", function(){
	return {
		restrict: "A",
		link: function(scope, element, attrs, constructor){
			var unActiveStyle = { "background-color": "#f5f5f5", "color": "#333" };
			var element = $(element).find(".menu-list-right");

			scope.titleMenu = "ยินดีต้อนรับสู่ ระบบจัดการกิจกรรม \"กองพันปฏิบัติการพิเศษ ๒\"";
			scope.entryInitialForm = true;

			element.bind("click", function(){
				$(element).closest("ul").find(".menu-list-right").css(unActiveStyle);
				$(".thumbnailActivityImage").html("");
				$(".messageInfo").html("");

				scope.activityList = [];
				scope.entryInsert = {};
				scope.entryDelete = {};
				scope.entryUpdate = {};
				scope.activityImageList = [];
				scope.activityImageOriginList = [];
				scope.activityImageOriginUpdateList = [];
				scope.entrySetting = {};
				scope.permissionOriginList = [];
				scope.permissionOriginUpdateList = [];
				
				if(attrs.value == "insert"){
					element.css({ "background-color": "#5CB85C", "color": "#FFFFFF" });
					scope.titleMenu = "เพิ่มกิจกรรม";
					scope.entryInitialForm = false;
					scope.entryInsertForm = true;
					scope.entryDeleteForm = false;
					scope.entryUpdateForm = false;
					scope.entrySettingForm = false;
					scope.userPermission = scope.userPermissionData[0];
				}else if(attrs.value == "delete"){
					element.css({ "background-color": "#F0AD4E", "color": "#FFFFFF" });
					scope.titleMenu = "ลบกิจกรรม";
					scope.entryInitialForm = false;
					scope.entryInsertForm = false;
					scope.entryDeleteForm = true;
					scope.entryUpdateForm = false;
					scope.entrySettingForm = false;
					scope.userPermission = scope.userPermissionData[1];
				}else if(attrs.value == "update"){
					element.css({ "background-color": "#337AB7", "color": "#FFFFFF" });
					scope.titleMenu = "แก้ไขกิจกรรม";
					scope.entryInitialForm = false;
					scope.entryInsertForm = false;
					scope.entryDeleteForm = false;
					scope.entryUpdateForm = true;
					scope.entrySettingForm = false;
					scope.entryUpdateDisabled = true;
					scope.userPermission = scope.userPermissionData[2];
				}else if(attrs.value == "setting"){
					element.css({ "background-color": "#9966ff", "color": "#FFFFFF" });
					scope.titleMenu = "ตั้งค่าสิทธิ์การใช้งาน";
					scope.entryInitialForm = false;
					scope.entryInsertForm = false;
					scope.entryDeleteForm = false;
					scope.entryUpdateForm = false;
					scope.entrySettingForm = true;
					scope.entrySettingDisabled = true;
					scope.userPermission = scope.userPermissionData[3];
				}

				scope.$apply();
			});
		}
	}
})
.directive("validFile", function(){
	return {
		restrict: "A",
		require: "ngModel",
		link: function(scope, element, attrs, ngModel){
			ngModel.$render = function(){
				ngModel.$setViewValue(element.val());
			}

			element.bind("change", function(){
				scope.$apply(function(){
					ngModel.$render();
				});
			});
		}
	}
});