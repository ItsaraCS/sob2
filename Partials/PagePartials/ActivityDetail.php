<!--Content-activities-->
<div class="panel panel-default" style="margin-bottom: 10px;">
	<div class="panel-heading text-center"><h3 class="panel-title">กิจกรรม "กองพันปฏิบัติการพิเศษ ๒"</h3></div>
  	<div class="panel-body">
  		<ol class="breadcrumb" style="margin-bottom: 15px;">
			<li><a href="#/">หน้าหลัก</a></li>
			<li><a href="#/activity/{{ activityItem.category_id }}">{{ activityItem.category_name }}</a></li>
			<li class="active">{{ activityItem.activity_name }}</li>
		</ol>
  		<div class="panel panel-default panel-activity-detail">
  			<div class="panel-heading">
				<i class="fa fa-eye indent-text-title"></i>
  				{{ activityItem.activity_name }}
  			</div>
  			<div><!--<div class="table-responsive">-->
  				<table class="table table-bordered">
					<tbody>
						<tr>
							<td class="col-md-3 td-col-left"><i class="fa fa-caret-right indent-text-title"></i> ชื่อกิจกรรม</td>
							<td class="col-md-9 td-col-right">{{ activityItem.activity_name }}</td>
						</tr>
						<tr>
							<td class="col-md-3 td-col-left"><i class="fa fa-caret-right indent-text-title"></i> วันที่อัพเดท</td>
							<td class="col-md-9 td-col-right">{{ activityItem.activity_date }}</td>
						</tr>
						<tr>
							<td class="col-md-3 td-col-left"><i class="fa fa-caret-right indent-text-title"></i> รายละเอียด</td>
							<td class="col-md-9 td-col-right">{{ activityItem.activity_description }}</td>
						</tr>
						<tr>
							<td colspan="2">
								<div id="gallery" style="margin-top: 10px;"></div>
							</td>
						</tr>
					</tbody>
				</table>
  			</div>
  		</div>
  	</div>
</div>