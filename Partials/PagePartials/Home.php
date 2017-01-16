<div class="panel panel-default" style="margin-bottom: 10px;">
	<div class="panel-heading text-center"><h3 class="panel-title">กิจกรรมกองพันปฏิบัติการพิเศษ ๒</h3></div>
  	<div class="panel-body">
    	<div class="col-md-6">
    		<div class="row main-activity-left">
    			<div class="panel panel-default" data-ng-repeat="item in activityData | limitTo: 3">
	    			<a href="#/activityDetail/{{ item.activity_id }}">
		    			<div class="panel-body" data-ng-click="sendData(item)">
							<div class="row">
		    					<div class="col-md-6 main-activity-images">
		    						<div class="thumbnail">
			    						<img data-ng-src="ActivitiesImages/{{ item.activity_image_url }}">
			    					</div>
			    				</div>
			    				<div class="col-md-6 main-activity-content">
			    					<p><i class="fa fa-plane indent-text-title"></i> 
			    						{{ item.activity_description | limitTo: 80 }}{{ item.activity_description.length > 80 ? '...' : '' }}
			    					</p>
			    					<img src="Images/News.gif">
			    				</div>
		    				</div>
		    			</div>
	    			</a>
	    		</div>
    		</div>
    	</div>
    	<div class="col-md-6">
    		<div class="row main-activity-right">
				<span data-ng-repeat="item in activityData | limitTo: 6">
					<a href="#/activityDetail/{{ item.activity_id }}">
						<div class="panel panel-default" data-ng-show="$index >= 3">
		    				<div class="panel-body" data-ng-click="sendData(item)">
								<div class="row">
			    					<div class="col-md-6 main-activity-images">
			    						<div class="thumbnail">
				    						<img data-ng-src="ActivitiesImages/{{ item.activity_image_url }}">
				    					</div>
				    				</div>
				    				<div class="col-md-6 main-activity-content">
				    					<p><i class="fa fa-plane indent-text-title"></i> 
				    						{{ item.activity_description | limitTo: 80 }}{{ item.activity_description.length > 80 ? '...' : '' }}
				    					</p>
				    					<img src="Images/News.gif">
				    				</div>
			    				</div>
			    			</div>
			    		</div>
		    		</a>
				</span>
    		</div>
    	</div>
    	<div class="col-md-12 text-right">
			<a href="#/activity/{{ lastCategoryID }}">
				<i class="glyphicon glyphicon-hand-right indent-text-title"></i> ดูกิจกรรมอื่นๆ...
			</a>
    	</div>
  	</div>
</div>