<div class="panel panel-default" style="margin-bottom: 10px;">
	<div class="panel-heading text-center"><h3 class="panel-title">ระบบจัดการกิจกรรม "กองพันปฏิบัติการพิเศษ ๒"</h3></div>
  	<div class="panel-body">
  		<div class="col-md-1"></div>
		<div class="col-md-10">
			<div class="panel panel-default">
				<div class="panel-heading text-center">
					<i class="glyphicon glyphicon-user indent-text-title"></i>
						สมัครสมาชิก
				</div>
				<form name="registerForm" novalidate>
					<div class="table-responsive">
						<table class="table table-bordered no-margin-bottom text-center">
							<tbody>
								<tr class="active">
									<td>ชื่อผู้ใช้</td>
									<td>
										<input type="text" name="username" class="form-control" placeholder="กรอกชื่อผู้ใช้"
											data-ng-model="entryRegister.username" autofocus required>
									</td>
								</tr>
								<tr class="active">
									<td>ชื่อที่ใช้แสดง</td>
									<td>
										<input type="text" name="name" class="form-control" placeholder="กรอกชื่อที่ใช้แสดง"
											data-ng-model="entryRegister.name" required>
									</td>
								</tr>
								<tr class="active">
									<td>อีเมล์</td>
									<td>
										<input type="text" name="email" class="form-control" placeholder="กรอกอีเมล์"
											data-ng-model="entryRegister.email" required>
									</td>
								</tr>
								<tr class="active">
									<td>เบอร์โทรศัพท์</td>
									<td>
										<input type="text" name="phone" class="form-control" placeholder="กรอกเบอร์โทรศัพท์"
											data-ng-model="entryRegister.phone" required>
									</td>
								</tr>
								<tr class="active">
									<td>ตำแหน่ง</td>
									<td>
										<input type="text" name="position" class="form-control" placeholder="กรอกตำแหน่ง"
											data-ng-model="entryRegister.position" required>
									</td>
								</tr>
								<tr class="active">
									<td>รหัสผ่าน</td>
									<td>
										<input type="text" name="password" class="form-control" placeholder="กรอกรหัสผ่าน"
											data-ng-model="entryRegister.password" required>
									</td>
								</tr>
								<tr class="active text-right">
									<td colspan="2">
										<span class="messageInfo"></span>
										<button type="submit" class="btn btn-success" 
											data-ng-click="register()"
											data-ng-disabled="registerForm.$invalid">
											<i class="glyphicon glyphicon-user"></i> สมัครสมาชิก</button>
										<button type="reset" class="btn btn-danger"
											data-ng-click="resetModel(this, 'entryRegister')">
											<i class="glyphicon glyphicon-remove"></i> ยกเลิก</button>
										<span>|<span>
										<a href="#/admin" class="btn btn-primary">
											<i class="fa fa-lock"></i> เข้าสู่ระบบ
										</a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</form>
			</div>
		</div>
		<div class="col-md-1"></div>
  	</div>
</div>