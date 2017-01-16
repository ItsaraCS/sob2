<div class="panel panel-default" style="margin-bottom: 10px;">
	<div class="panel-heading text-center"><h3 class="panel-title">ระบบจัดการกิจกรรม "กองพันปฏิบัติการพิเศษ ๒"</h3></div>
  	<div class="panel-body">
  		<div class="col-md-1"></div>
		<div class="col-md-10">
			<div class="panel panel-default">
				<div class="panel-heading text-center">
					<i class="fa fa-lock indent-text-title"></i>
						เข้าสู่ระบบ
				</div>
				<form id="loginForm" name="loginForm" novalidate>
					<div class="table-responsive">
						<table class="table table-bordered no-margin-bottom text-center">
							<tbody>
								<tr class="active">
									<td>ชื่อผู้ใช้</td>
									<td>
										<input type="text" name="username" class="form-control" placeholder="กรอกชื่อผู้ใช้"
											data-ng-model="entryLogin.username" autofocus required>
									</td>
								</tr>
								<tr class="active">
									<td>รหัสผ่าน</td>
									<td>
										<input type="text" name="password" class="form-control" placeholder="กรอกรหัสผ่าน"
											data-ng-model="entryLogin.password" required>
									</td>
								</tr>
								<tr class="active text-right">
									<td colspan="2">
										<span class="messageInfo"></span>
										<button type="submit" class="btn btn-primary" 
											data-ng-click="login()"
											data-ng-disabled="loginForm.$invalid">
											<i class="fa fa-key"></i> เข้าสู่ระบบ</button>
										<button type="reset" class="btn btn-danger"
											data-ng-click="resetModel(this, 'entryLogin')">
											<i class="glyphicon glyphicon-remove"></i> ยกเลิก</button>
										<span>|<span>
										<a href="#/adminRegister" class="btn btn-success">
											<i class="glyphicon glyphicon-user"></i> สมัครสมาชิก
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