<?php
namespace TwoDOt7\Bit\in_ac_ducic_tabs\View;

function _Interface($Data = False) {
	?>
	<section class="scrollable padder bg-dark  fill">
		<div class="m-b-md row padder">
			<div class="col-lg-6">
				<h3 class="m-b-none">TABS - Address Book <?php echo in_ac_ducic_tabs_ASSET; ?></h3>
				<small>All the Address Book entries are shown.</small>
			</div>
			<div class="col-lg-6 m-t-lg padder">
				<div class="btn-group" data-toggle="buttons">
					<label class="btn btn-primary active"  style="width: 120px;">
						<input type="radio" name="options" id="option1">
						<i class="fa fa-check text-active"></i>
						Grid View
					</label>
					<label class="btn btn-success"  style="width: 120px;">
						<input type="radio" name="options" id="option2">
						<i class="fa fa-check text-active"></i>
						List View
					</label>
				</div>
			</div>
		</div>
		<div class="row padder">

		</div>
		<div class="row padder">
			<?php
				for($i=0; $i<8; $i++) {
			?>
			<div class="col-lg-3 m-b-lg">
				<div class="panel-body panel-info bg-light">
					<div class="thumb pull-right m-l m-t-xs avatar">
						<img src="/assetserver/userNameIcon/<?php echo $i;?>">
					</div>
					<div class="clear">
						<p class="h3">Leo Waldez</p>
						<p class="h4 m-b-sm">waldez@chbd.com</p>
						<p class="h5">Trinayan Groups Pvt. Limited, Faridabad</p>

						<a href="#" class="btn btn-xs btn-success m-t-sm">More</a> <br>
					</div>
				</div>
			</div>
			<?php 
				}
			?>
		</div>
	</section>
	<?php
}

function _Manage($Data = False) {
	?>
	<section class="scrollable padder">
		<div class="m-b-md row padder">
			<div class="col-lg-6">
				<h3 class="m-b-none">TABS - Manage Address Book</h3>
				<small>Add, Remove or Update the Contacts.</small>
			</div>
			<div class="col-lg-6">
			</div>
			<hr>
		</div>
		<div class="row padder">
		<div class="col-lg-12">
		<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
			Launch demo modal
		</button>
		<style type="text/css">
			@media(min-width: 768px) {
				.modal-dialog {
					width: 80%;
				}
			}
			.modal-header {
				background: #f9fafc;
				border-radius: inherit;
				border-bottom: 0;
			}
			.modal-footer {
				margin-top: 0;
				border-top: none;
			}
			.panel-default {
				border-top: none;
				margin: 0;
			}
		</style>
		</div>
		</div>
	</section>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel"><img src="<?php echo in_ac_ducic_tabs_ASSET."/asset/TABS-main.png"; ?>" height="30px">Add Into</h4>
				</div>
				<div>
					<section class="panel panel-default">
						<header class="panel-heading text-right bg-light">
							<ul class="nav nav-tabs pull-left">
								<li class="active"><a href="#ContactInfo" data-toggle="tab"><i class="fa fa-envelope text-muted"></i> Contact Details</a>
								</li>
								<li class=""><a href="#PrivateInfo" data-toggle="tab"><i class="fa fa-home text-muted"></i> Private Info</a>
								</li>
								<li class=""><a href="#WorkInfo" data-toggle="tab"><i class="fa fa-briefcase text-muted"></i> Work Info</a>
								</li>
							</ul>
							<span class="hidden-sm">&nbsp;</span> 
						</header>
						<div class="panel-body">
							<div class="tab-content">
								<div class="tab-pane fade active in" id="ContactInfo">
									<div class="col-sm-8 form-horizontal">
										<div class="form-group">
											<label class="col-lg-2 control-label">First Name</label>
											<div class="col-lg-10">
												<input type="email" class="form-control" name="FirstName">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">Last Name</label>
											<div class="col-lg-10">
												<input type="email" class="form-control" name="LastName">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">Display</label>
											<div class="col-lg-10">
												<input type="email" class="form-control" name="DisplayName">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">NickName</label>
											<div class="col-lg-10">
												<input type="email" class="form-control" name="NickName">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">Email</label>
											<div class="col-lg-10">
												<input type="email" class="form-control" name="PrimaryEmail">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">Additional Email</label>
											<div class="col-lg-10">
												<input type="email" class="form-control" name="SecondaryEmail">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">Chat Name</label>
											<div class="col-lg-10">
												<input type="email" class="form-control" name="_AimScreenName">
											</div>
										</div>
									</div>
									<div class="col-sm-4 form-horizontal">
										<div class="form-group">
											<label class="col-lg-2 control-label">Work</label>
											<div class="col-lg-10">
												<input type="email" class="form-control" name="WorkPhone">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">Home</label>
											<div class="col-lg-10">
												<input type="email" class="form-control" name="HomePhone">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">Fax</label>
											<div class="col-lg-10">
												<input type="email" class="form-control" name="FaxNumber">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">Mobile</label>
											<div class="col-lg-10">
												<input type="email" class="form-control" name="CellularNumber">
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="PrivateInfo">
									<div class="col-sm-12 form-horizontal">
										<div class="form-group">
											<label class="col-lg-2 control-label">Address</label>
											<div class="col-lg-10">
												<input type="email" class="form-control" name="HomeAddress">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label"></label>
											<div class="col-lg-10">
												<input type="email" class="form-control" name="HomeAddress2">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">City</label>
											<div class="col-lg-10">
												<input type="email" class="form-control" name="HomeCity">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">State</label>
											<div class="col-lg-5">
												<input type="email" class="form-control" name="HomeState">
											</div>
											<label class="col-lg-3 control-label">Zip/Postal Code</label>
											<div class="col-lg-2">
												<input type="email" class="form-control" name="HomeZipCode">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">Country</label>
											<div class="col-lg-10">
												<input type="email" class="form-control" name="HomeCountry">
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="WorkInfo">
									<div class="col-sm-12 form-horizontal">
										<div class="form-group">
											<label class="col-lg-2 control-label">Title</label>
											<div class="col-lg-4">
												<input type="email" class="form-control" name="JobTitle">
											</div>
											<label class="col-lg-2 control-label">Department</label>
											<div class="col-lg-4">
												<input type="email" class="form-control" name="Department">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">Organization</label>
											<div class="col-lg-10">
												<input type="email" class="form-control" name="Company">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">Address</label>
											<div class="col-lg-10">
												<input type="email" class="form-control" name="WorkAddress">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label"></label>
											<div class="col-lg-10">
												<input type="email" class="form-control" name="WorkAddress2">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">City</label>
											<div class="col-lg-10">
												<input type="email" class="form-control" name="WorkCity">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">State</label>
											<div class="col-lg-5">
												<input type="email" class="form-control" name="WorkState">
											</div>
											<label class="col-lg-3 control-label">Zip/Postal Code</label>
											<div class="col-lg-2">
												<input type="email" class="form-control" name="WorkZipCode">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">Country</label>
											<div class="col-lg-10">
												<input type="email" class="form-control" name="WorkCountry">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Discard Changes</button>
					<button type="button" class="btn btn-primary">Add Contact to Addressbook</button>
				</div>
			</div>
		</div>
	</div>
	<?php
}

function FourOFour() {
	echo "LOL";
}

?>