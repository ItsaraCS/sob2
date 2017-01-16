<!DOCTYPE html>
<html lang="en" data-ng-app="mainApp">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>กองพันปฏิบัติการพิเศษ ๒</title>
		<link rel="shortcut icon" type="text/x-icon" href="Images/Logo.png">
		<!--Bootstrap CSS-->
		<link rel="stylesheet" type="text/css" href="Scripts/Bootstrap/css/bootstrap.css">
		<!--Font-awesome CSS-->
		<link rel="stylesheet" type="text/css" href="Scripts/FontAwesome/css/font-awesome.css">
		<!--Custom CSS-->
		<link rel="stylesheet" type="text/css" href="Styles/Style.css">
	</head>
	<body>
		<div class="container-fluid">
			<div class="container" style="margin: 15px auto;" data-ng-controller="mainController as mainCtrl">
				<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-10" style="background-color: #FFFFFF;">
						<!--Header-->
						<div class="row row-header">
							<img src="Images/Header-top.png" class="img-responsive" style="width: 100%;">
						</div>
						<!--Nav-->
						<div class="row row-header">
							<nav class="navbar navbar-default">
  								<div class="container-fluid">
  									<div class="navbar-header">
										<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" 
											data-target="#navbar-header-menu">
									        <span class="sr-only">Toggle navigation</span>
									        <span class="icon-bar"></span>
									        <span class="icon-bar"></span>
									        <span class="icon-bar"></span>
									 	</button>
								    </div>
								    <div class="collapse navbar-collapse" id="navbar-header-menu">
								      	<ul class="nav navbar-nav">
								        	<li class="active" active-nav value="หน้าหลัก"><a href="#/">หน้าหลัก</a></li>
								        	<li active-nav value="ประวัติหน่วย"><a href="#/history">ประวัติหน่วย</a></li>
								        	<li active-nav value="ภารกิจ"><a href="#/mission">ภารกิจ</a></li>
											<li class="dropdown" active-nav value="ผู้บังคับบัญชา">
												<a href="" class="dropdown-toggle" data-toggle="dropdown">ผู้บังคับบัญชา <span class="caret"></span></a>
												<ul class="dropdown-menu">
													<li><a href="#/currentCommander">ผู้บังคับบัญชาคนปัจจุบัน</a></li>
													<li><a href="#/formerCommander">อดีตผู้บังคับบัญชา</a></li>
												</ul>
											</li>
											<li class="dropdown" active-nav value="กิจกรรม">
												<a href="" class="dropdown-toggle" data-toggle="dropdown">กิจกรรม <span class="caret"></span></a>
												<ul class="dropdown-menu">
													<li><a href="#/activity/1">ร้อย ๑ พัน ๒</a></li>
													<li><a href="#/activity/2">ร้อย ๒, ร้อย ๓ พัน ๒</a></li>
													<li><a href="#/activity/3">ทหารใหม่</a></li>
												</ul>
											</li>
											<li active-nav value="สิ่งศักดิ์สิทธิ์ประจำกองพัน"><a href="#/holy">สิ่งศักดิ์สิทธิ์ประจำกองพัน</a></li>
											<li active-nav value="ติดต่อเรา"><a href="#/contact">ติดต่อเรา</a></li>
								      	</ul>
									</div>
								</div>
							</nav>
						</div>
						<!--Carousel-->
						<div class="row row-header">
							<div id="carousel-header" class="carousel slide" data-ride="carousel">
								<ol class="carousel-indicators">
							    	<li data-target="#carousel-header" data-slide-to="0" class="active"></li>
								    <li data-target="#carousel-header" data-slide-to="1"></li>
								    <li data-target="#carousel-header" data-slide-to="2"></li>
							  	</ol>
								<div class="carousel-inner">
							    	<div class="item active">
							      		<img src="Images/Carousel-header-1.png" style="width: 100%;">
							    	</div>
							    	<div class="item">
							    		<img src="Images/Carousel-header-2.png" style="width: 100%;">
							    	</div>
							    	<div class="item">
							    		<img src="Images/Carousel-header-3.png" style="width: 100%;">
							    	</div>
							    	<div class="item">
							    		<img src="Images/Carousel-header-4.png" style="width: 100%;">
							    	</div>
							  	</div>
							  	<a class="left carousel-control" href="#carousel-header" data-slide="prev">
							    	<span class="glyphicon glyphicon-chevron-left"></span>
							    	<span class="sr-only">Previous</span>
							  	</a>
							  	<a class="right carousel-control" href="#carousel-header" data-slide="next">
							    	<span class="glyphicon glyphicon-chevron-right"></span>
							    	<span class="sr-only">Next</span>
							  	</a>
							</div>
						</div>