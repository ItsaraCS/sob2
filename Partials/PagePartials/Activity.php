<div class="panel panel-default" style="margin-bottom: 10px;">
	<div class="panel-heading text-center"><h3 class="panel-title">กิจกรรม "กองพันปฏิบัติการพิเศษ ๒"</h3></div>
  	<div class="panel-body">
    	<div class="callout callout-info">
    		<i class="fa fa-th-large indent-text-title"></i>
    		รวมกิจกรรมของ {{ categoryName }}
    	</div>
    	<div class="panel panel-default panel-activity">
    		<ul class="list-group">
			    <li class="list-group-item" data-ng-repeat="item in activityData"  data-ng-click="sendData(item)">
			    	<a href="#/activityDetail/{{ item.activity_id }}">
				    	<div class="row">
							<div class="col-md-3 main-activity-images">
		    					<div class="thumbnail">
		    						<img data-ng-src="ActivitiesImages/{{ item.activity_image_url }}">
		    					</div>
		    				</div>
		    				<div class="col-md-9">
		    					<p style="font-weight: bold;">
			    					<i class="fa fa-eye indent-text-title"></i>
			    					{{ item.activity_name }}
			    				</p>
			    				<p class="no-margin-bottom">
			    					{{ item.activity_description | limitTo: 150 }}{{ item.activity_description.length > 150 ? '...' : '' }}
			    				</p>
		    				</div>
	    				</div>
    				</a>
			    </li>
		  	</ul>
    	</div>
    	<nav class="text-center">
		  	<ul class="pagination">
			    <li active-pagination value="prev">
			      	<a href="#/activity/{{ categoryID }}" data-ng-click="getDataPerPage(1)" aria-label="Previous">
			        	<span aria-hidden="true">&laquo;</span>
			      	</a>
			    </li>
				<li data-ng-repeat="item in totalPageList" active-pagination value="{{ item }}">
			    	<a href="#/activity/{{ categoryID }}" data-ng-click="getDataPerPage(item)">{{ item }}</a>
			    </li>
			    <li active-pagination value="next">
			      	<a href="#/activity/{{ categoryID }}" data-ng-click="getDataPerPage(totalPage)" aria-label="Next">
			        	<span aria-hidden="true">&raquo;</span>
			      	</a>
			    </li>
		  	</ul>
		</nav>
  	</div>
</div>