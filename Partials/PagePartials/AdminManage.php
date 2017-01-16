<div class="panel panel-default" style="margin-bottom: 10px;">
	<div class="panel-heading text-center"><h3 class="panel-title">ระบบจัดการกิจกรรม "กองพันปฏิบัติการพิเศษ ๒"</h3></div>
  	<div class="panel-body">
  		<div class="col-md-3">
			<div class="panel panel-default panel-admin-login">
				<div class="panel-heading text-center"><i class="fa fa-lock indent-text-title"></i> เข้าสู่ระบบโดย</div>
				<ul class="list-group">
					<li class="list-group-item"><i class="glyphicon glyphicon-user indent-text-title"></i>
						{{ entryUser.name }}
					</li>
				</ul>
			</div>
			<div class="panel panel-default panel-admin-menu">
				<div class="panel-heading text-center"><i class="glyphicon glyphicon-cog indent-text-title"></i> เมนูจัดการ</div>
				<ul class="list-group">
					<li class="list-group-item list-group-item-insert" active-admin-menu value="insert">
						<a href="">
							<div class="row">
								<div class="menu-list-left" style="background-color: #5CB85C;"><i class="glyphicon glyphicon-plus"></i></div>
								<div class="menu-list-right">เพิ่มกิจกรรม</div>
							</div>
						</a>
					</li>
					<li class="list-group-item list-group-item-delete" active-admin-menu value="delete">
						<a href="">
							<div class="row">
								<div class="menu-list-left" style="background-color: #F0AD4E;"><i class="glyphicon glyphicon-trash"></i></div>
								<div class="menu-list-right">ลบกิจกรรม</div>
							</div>
						</a>
					</li>
					<li class="list-group-item list-group-item-update" active-admin-menu value="update">
						<a href="">
							<div class="row">
								<div class="menu-list-left" style="background-color: #337AB7;"><i class="glyphicon glyphicon-scissors"></i></div>
								<div class="menu-list-right">แก้ไขกิจกรรม</div>
							</div>
						</a>
					</li>
					<li class="list-group-item list-group-item-setting" active-admin-menu value="setting">
						<a href="">
							<div class="row">
								<div class="menu-list-left" style="background-color: #9966ff;"><i class="glyphicon glyphicon-menu-hamburger"></i></div>
								<div class="menu-list-right">ตั้งค่าสิทธิ์การใช้งาน</div>
							</div>
						</a>
					</li>
					<li class="list-group-item list-group-item-logout"
						data-toggle="modal" data-target=".logout-popup">
						<a href="">
							<div class="row">
								<div class="menu-list-left" style="background-color: #D9534F;"><i class="glyphicon glyphicon-off"></i></div>
								<div class="menu-list-right">ออกจากระบบ</div>
							</div>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="col-md-9">
			<div class="panel panel-default panel-admin-content">
				<div class="panel-heading text-center">{{ titleMenu }}</div>
				<!--Initial data form-->
				<form name="initialForm" data-ng-show="entryInitialForm">
					<div class="row text-center">
						<img src="Images/Logo.png" style="width: 30%; margin: 20px auto; opacity: 0.5;">
					</div>
				</form>
				<!--Insert data form-->
				<form name="insertForm" enctype="multipart/form-data"
					data-ng-show="entryInsertForm" novalidate>
					<div class="table-responsive">
						<table class="table table-bordered no-margin-bottom text-center">
							<tbody>
								<tr class="active">
									<td class="col-md-3">ชื่อกิจกรรม</td>
									<td class="col-md-9">
										<input type="text" class="form-control" name="activity_name" placeholder="กรอกชื่อกิจกรรม"
											data-ng-model="entryInsert.activity_name" 
											data-ng-disabled="userPermission.perm_status == 'DN'" required>
									</td>
								</tr>
								<tr class="active">
									<td class="col-md-3">หมวดหมู่ของกิจกรรม</td>
									<td class="col-md-9">
										<select class="form-control" name="category_id" 
											data-ng-model="entryInsert.category_id" 
											data-ng-disabled="userPermission.perm_status == 'DN'" required>
											<option value="" disabled selected>เลือกหมวดหมู่ของกิจกรรม</option>
											<option data-ng-repeat="item in categoryList" 
												value="{{ item.category_id }}">{{ item.category_name }}</option>
										</select>
									</td>
								</tr>
								<tr class="active">
									<td class="col-md-3">วันที่จัดกิจกรรม</td>
									<td class="col-md-9">
										<div class="input-group">
										  	<input type="text" class="form-control datepicker" name="activity_date" placeholder="เลือกวันที่จัดกิจกรรม"
										  		data-ng-model="entryInsert.activity_date" 
										  		data-ng-disabled="userPermission.perm_status == 'DN'" required>
										  	<span class="input-group-btn" data-ng-disabled="userPermission.perm_status == 'DN'">
										  		<button type="button" id="datepickerBtn" class="btn btn-default"
										  			data-ng-disabled="userPermission.perm_status == 'DN'">
										  			<i class="glyphicon glyphicon-calendar"></i>
										  		</button>
										  	</span>
										</div>
									</td>
								</tr>
								<tr class="active">
									<td class="col-md-3">รายละเอียด</td>
									<td class="col-md-9">
										<textarea class="form-control" name="activity_description" placeholder="กรอกชื่อกิจกรรม"
											data-ng-model="entryInsert.activity_description" 
											data-ng-disabled="userPermission.perm_status == 'DN'" required></textarea>
									</td>
								</tr>
								<tr class="active">
									<td class="col-md-3">รูปกิจกรรม</td>
									<td class="col-md-9" style="overflow-x: hidden;">
								        <div class="row">
								            <div class="col-md-12 text-left">
								                <span class="btn btn-primary btn-fileinput" data-ng-disabled="userPermission.perm_status == 'DN'">
								                    <i class="glyphicon glyphicon-plus"></i> เลือกรูปภาพ
								                    <input type="file" id="activityImage" name="activityImage[]" 
								                    	accept="image/jpeg, image/png" multiple 
								                    	data-ng-model="entryInsert.activity_image" 
								                    	data-ng-disabled="userPermission.perm_status == 'DN'" valid-file required>
								                </span>
								                <span style="padding: 5px;" class="alert alert-warning no-margin-bottom">
								                	<i class="glyphicon glyphicon-picture indent-text-title"></i> ขนาดไม่เกิน 500 Kb ชนิด .jpg, .jpeg, .png
								                </span>
								            </div>
								            <div class="col-md-12 thumbnailActivityImage"></div>
								        </div>
									</td>
								</tr>
								<tr class="active text-right">
									<td colspan="2">
										<span class="messageInfo"></span>
										<button type="submit" class="btn btn-success"
											data-toggle="modal" data-target=".insert-popup"
											data-ng-disabled="userPermission.perm_status == 'DN' || userPermission.perm_status == 'R' || insertForm.$invalid">
											<i class="glyphicon glyphicon-plus"></i> บันทึก</button>
										<button type="reset" class="btn btn-danger"
											data-ng-click="resetModel(this, 'entryInsert')"
											data-ng-disabled="userPermission.perm_status == 'DN' || userPermission.perm_status == 'R'">
											<i class="glyphicon glyphicon-remove"></i> ยกเลิก</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</form>
				<!--Delete data form-->
				<form name="deleteForm" data-ng-show="entryDeleteForm" novalidate>
					<div class="table-responsive">
						<table class="table table-bordered no-margin-bottom text-center">
							<tbody>
								<tr class="active">
									<td>หมวดหมู่ของกิจกรรม</td>
									<td>
										<select class="form-control" name="category_id"
											data-ng-model="entryDelete.category_id" 
											data-ng-change="getActivityList(entryDelete.category_id)" 
											data-ng-disabled="userPermission.perm_status == 'DN'" required>
											<option value="" disabled selected>เลือกหมวดหมู่ของกิจกรรม</option>
											<option data-ng-repeat="item in categoryList" 
												value="{{ item.category_id }}">{{ item.category_name }}</option>
										</select>
									</td>
								</tr>
								<tr class="active">
									<td>ชื่อกิจกรรม</td>
									<td>
										<select class="form-control" name="activity_id" 
											data-ng-model="entryDelete.activity_id"
											data-ng-disabled="userPermission.perm_status == 'DN'" required>
											<option value="" disabled selected>เลือกชื่อกิจกรรม</option>
											<option data-ng-repeat="item in activityList" 
													value="{{ item.activity_id }}">{{ item.activity_name }}</option>
										</select>
									</td>
								</tr>
								<tr class="active text-right">
									<td colspan="2">
										<span class="messageInfo"></span>
										<button type="submit" class="btn btn-warning"
											data-toggle="modal" data-target=".delete-popup"
											data-ng-disabled="userPermission.perm_status == 'DN' || userPermission.perm_status == 'R' || deleteForm.$invalid">
											<i class="glyphicon glyphicon-trash"></i> ลบ</button>
										<button type="reset" class="btn btn-danger"
											data-ng-click="resetModel(this, 'entryDelete')"
											data-ng-disabled="userPermission.perm_status == 'DN' || userPermission.perm_status == 'R'">
											<i class="glyphicon glyphicon-remove"></i> ยกเลิก</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</form>
				<!--Update data form-->
				<form name="updateForm" enctype="multipart/form-data"
					data-ng-show="entryUpdateForm" novalidate>
					<div class="table-responsive">
						<table class="table table-bordered no-margin-bottom text-center">
							<tbody>
								<tr class="active">
									<td>หมวดหมู่ของกิจกรรม</td>
									<td>
										<select class="form-control" name="update_category_id" 
											data-ng-model="entryUpdate.update_category_id" 
											data-ng-change="getActivityList(entryUpdate.update_category_id)" 
											data-ng-disabled="userPermission.perm_status == 'DN'" required>
											<option value="" disabled selected>เลือกหมวดหมู่ของกิจกรรม</option>
											<option data-ng-repeat="item in categoryList" 
												value="{{ item.category_id }}">{{ item.category_name }}</option>
										</select>
									</td>
								</tr>
								<tr class="active">
									<td>ชื่อกิจกรรม</td>
									<td>
										<select class="form-control" name="activity_id" 
											data-ng-model="entryUpdate.activity_id" 
											data-ng-change="getDataUpdate(entryUpdate.activity_id)" 
											data-ng-disabled="userPermission.perm_status == 'DN'" required>
											<option value="" disabled selected>เลือกชื่อกิจกรรม</option>
											<option data-ng-repeat="item in activityList" 
													value="{{ item.activity_id }}">{{ item.activity_name }}</option>
										</select>
									</td>
								</tr>
								<tr class="active">
									<td class="col-md-3">ชื่อกิจกรรม</td>
									<td class="col-md-9">
										<input type="text" class="form-control" name="activity_name" placeholder="กรอกชื่อกิจกรรม"
											data-ng-model="entryUpdate.activity_name"
											data-ng-disabled="userPermission.perm_status == 'DN' || entryUpdateDisabled" required>
									</td>
								</tr>
								<tr class="active">
									<td class="col-md-3">หมวดหมู่ของกิจกรรม</td>
									<td class="col-md-9">
										<select class="form-control" name="category_id" 
											data-ng-model="entryUpdate.category_id" 
											data-ng-disabled="userPermission.perm_status == 'DN' || entryUpdateDisabled" required>
											<option value="" disabled selected>เลือกหมวดหมู่ของกิจกรรม</option>
											<option data-ng-repeat="item in categoryList" 
												value="{{ item.category_id }}">{{ item.category_name }}</option>
										</select>
									</td>
								</tr>
								<tr class="active">
									<td class="col-md-3">ชื่อกิจกรรม</td>
									<td class="col-md-9">
										<div class="input-group">
										  	<input type="text" class="form-control datepicker" name="activity_date" placeholder="เลือกวันที่จัดกิจกรรม"
										  		data-ng-model="entryUpdate.activity_date" 
										  		data-ng-disabled="userPermission.perm_status == 'DN' || entryUpdateDisabled" required>
										  	<span class="input-group-btn" data-ng-disabled="userPermission.perm_status == 'DN' || entryUpdateDisabled">
										  		<button type="button" id="datepickerBtn" class="btn btn-default"
										  			data-ng-disabled="userPermission.perm_status == 'DN' || entryUpdateDisabled">
										  			<i class="glyphicon glyphicon-calendar"></i>
										  		</button>
										  	</span>
										</div>
									</td>
								</tr>
								<tr class="active">
									<td class="col-md-3">รายละเอียด</td>
									<td class="col-md-9">
										<textarea class="form-control" name="activity_description" placeholder="กรอกชื่อกิจกรรม"
											data-ng-model="entryUpdate.activity_description" 
											data-ng-disabled="userPermission.perm_status == 'DN' || entryUpdateDisabled" required></textarea>
									</td>
								</tr>
								<tr class="active">
									<td class="col-md-3">รูปกิจกรรม</td>
									<td class="col-md-9" style="overflow-x: hidden;">
								        <div class="row selectImage">
								            <div class="col-md-12 text-left">
								                <span class="btn btn-primary btn-fileinput" data-ng-disabled="userPermission.perm_status == 'DN' || entryUpdateDisabled">
								                    <i class="glyphicon glyphicon-plus"></i> เลือกรูปภาพ
								                    <input type="file" id="activityImageUpdate" name="activityImage[]" 
								                    	accept="image/jpeg, image/png" multiple 
								                    	data-ng-model="entryUpdate.activity_image" 
								                    	data-ng-disabled="userPermission.perm_status == 'DN' || entryUpdateDisabled" valid-file required>
								                </span>
								                <span style="padding: 5px;" class="alert alert-warning no-margin-bottom">
								                	<i class="glyphicon glyphicon-picture indent-text-title"></i> ขนาดไม่เกิน 500 Kb ชนิด .jpg, .jpeg, .png
								                </span>
								            </div>
								            <div class="col-md-12 thumbnailActivityImage"></div>
								        </div>
									</td>
								</tr>
								<tr class="active text-right">
									<td colspan="2">
										<span class="messageInfo"></span>
										<button type="submit" class="btn btn-primary"
											data-toggle="modal" data-target=".update-popup"
											data-ng-disabled="userPermission.perm_status == 'DN' || userPermission.perm_status == 'R' || updateForm.$invalid">
											<i class="glyphicon glyphicon-scissors"></i> แก้ไข</button>
										<button type="reset" class="btn btn-danger"
											data-ng-click="resetModel(this, 'entryUpdate')"
											data-ng-disabled="userPermission.perm_status == 'DN' || userPermission.perm_status == 'R'">
											<i class="glyphicon glyphicon-remove"></i> ยกเลิก</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</form>
				<!--Setting data form-->
				<form name="settingForm" data-ng-show="entrySettingForm" novalidate>
					<div class="table-responsive">
						<table class="table table-bordered no-margin-bottom text-center">
							<tbody>
								<tr class="active">
									<td>ชื่อที่ใช้แสดง</td>
									<td>
										<select class="form-control" name="setting_user_id" 
											data-ng-model="entrySetting.setting_user_id" 
											data-ng-change="getDataSetting(entrySetting.setting_user_id)" 
											data-ng-disabled="userPermission.perm_status == 'DN'" required>
											<option value="" disabled selected>เลือกชื่อที่ใช้แสดง</option>
											<option data-ng-repeat="item in nameUserList" 
												value="{{ item.user_id }}">{{ item.name }}</option>
										</select>
									</td>
								</tr>
								<tr class="active">
									<td class="col-md-3">ชื่อผู้ใช้</td>
									<td class="col-md-9">
										<input type="text" class="form-control" name="username" placeholder="กรอกชื่อผู้ใช้"
											data-ng-model="entrySetting.username" 
											data-ng-disabled="userPermission.perm_status == 'DN' || entrySettingDisabled" required>
									</td>
								</tr>
								<tr class="active">
									<td class="col-md-3">ชื่อที่ใช้แสดง</td>
									<td class="col-md-9">
										<input type="text" class="form-control" name="name" placeholder="กรอกชื่อที่ใช้แสดง"
											data-ng-model="entrySetting.name" 
											data-ng-disabled="userPermission.perm_status == 'DN' || entrySettingDisabled" required>
									</td>
								</tr>
								<tr class="active">
									<td class="col-md-3">อีเมล์</td>
									<td class="col-md-9">
										<input type="text" class="form-control" name="email" placeholder="กรอกอีเมล์"
											data-ng-model="entrySetting.email" 
											data-ng-disabled="userPermission.perm_status == 'DN' || entrySettingDisabled" required>
									</td>
								</tr>
								<tr class="active">
									<td class="col-md-3">เบอร์โทรศัพท์</td>
									<td class="col-md-9">
										<input type="text" class="form-control" name="phone" placeholder="กรอกเบอร์โทรศัพท์"
											data-ng-model="entrySetting.phone" 
											data-ng-disabled="userPermission.perm_status == 'DN' || entrySettingDisabled" required>
									</td>
								</tr>
								<tr class="active">
									<td class="col-md-3">ตำแหน่ง</td>
									<td class="col-md-9">
										<input type="text" class="form-control" name="position" placeholder="กรอกตำแหน่ง"
											data-ng-model="entrySetting.position" 
											data-ng-disabled="userPermission.perm_status == 'DN' || entrySettingDisabled" required>
									</td>
								</tr>
								<tr class="active">
									<td class="col-md-3">รหัสผ่าน</td>
									<td class="col-md-9">
										<input type="text" class="form-control" name="password" placeholder="กรอกรหัสผ่าน"
											data-ng-model="entrySetting.password" 
											data-ng-disabled="userPermission.perm_status == 'DN' || entrySettingDisabled" required>
									</td>
								</tr>
								<tr class="active">
									<td class="col-md-3">ตั้งค่าสิทธิ์การใช้งาน</td>
									<td class="col-md-9">
										<table class="table table-bordered table-striped no-margin-bottom">
											<thead>
												<th class="active text-center">ชื่อเมนู</th>
												<th class="active text-center">สิทธิ์การใช้งาน</th>
											</thead>
											<tbody>
												<tr data-ng-repeat="item in permissionOriginList">
													<td class="text-left">{{ $index + 1 }}. {{ item.menu_name }}</td>
													<td>
														<select class="form-control" name="perm_status_id"
															data-ng-model="permissionOriginUpdateList[$index].perm_status_id" required>
															<option value="" disabled selected>เลือกสิทธ์การใช้งาน</option>
															<option 
																data-ng-repeat="subItem in permissionStatusList" 
																value="{{ subItem.perm_status_id }}">{{ subItem.perm_status_name }}</option>
														</select>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
								<tr class="active text-right">
									<td colspan="2">
										<span class="messageInfo"></span>
										<button type="submit" class="btn btn-primary"
											data-toggle="modal" data-target=".update-setting-popup"
											data-ng-disabled="userPermission.perm_status == 'DN' || userPermission.perm_status == 'R' || settingForm.$invalid">
											<i class="glyphicon glyphicon-scissors"></i> แก้ไข</button>
										<button type="submit" class="btn btn-warning"
											data-toggle="modal" data-target=".delete-setting-popup"
											data-ng-disabled="userPermission.perm_status == 'DN' || userPermission.perm_status == 'R' || settingForm.setting_user_id.$invalid">
											<i class="glyphicon glyphicon-trash"></i> ลบ</button>
										<button type="reset" class="btn btn-danger"
											data-ng-click="resetModel(this, 'entrySetting')"
											data-ng-disabled="userPermission.perm_status == 'DN' || userPermission.perm_status == 'R'">
											<i class="glyphicon glyphicon-remove"></i> ยกเลิก</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</form>
			</div>
		</div>
  	</div>
</div>
<?php
	require_once("../PopupPartials/LogoutPopup.php");
	require_once("../PopupPartials/InsertPopup.php");
	require_once("../PopupPartials/DeletePopup.php");
	require_once("../PopupPartials/UpdatePopup.php");
	require_once("../PopupPartials/UpdateSettingPopup.php");
	require_once("../PopupPartials/DeleteSettingPopup.php");
?>