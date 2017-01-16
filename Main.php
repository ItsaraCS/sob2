<!--Header-->
<?php include("Main_Header.php"); ?>
<!--Section-->
<div class="row row-header no-margin-bottom">
	<!--Content-->
	<div id="section" class="col-md-9 section">
		<!--Content-activities-->
		<span data-ng-view></span>
		<!--Content-link-->
		<?php include("Main_Link.php"); ?>
	</div>
	<!--Aside-->
	<?php include("Main_Aside.php"); ?>
</div>
<!--Footer-->
<?php include("Main_Footer.php"); ?>