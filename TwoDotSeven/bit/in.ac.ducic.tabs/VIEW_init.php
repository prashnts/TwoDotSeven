<?php
namespace TwoDOt7\Bit\in_ac_ducic_tabs\View;

function _Interface($Data = False) {
	?>
	<section class="scrollable padder bg-dark  fill">
		<div class="m-b-md row padder">
			<div class="col-lg-6">
				<h3 class="m-b-none"><img src="<?php echo in_ac_ducic_tabs_ASSET."/asset/TABS-main.png"; ?>" class="pull-left m-r-sm" height="45px"> Address Book</h3>
				<small>All the Address Book entries are shown.</small>
			</div>
		</div>
		<div class="row padder">
			<div class="col-xs-6">
				<?php if ($Data['Buttons']['Add']) {
					?>
					<button class="btn btn-primary" onclick="ModalShowAddWindow()">
						<i class="fa fa-plus-square"></i>&nbsp;Add a Contact
					</button>
					<?php 
					}
				?>
			</div>
			<div class="col-xs-6">
				<div class="btn-group pull-right" data-toggle="buttons">
					<label class="btn btn-primary active"  style="">
						<input type="radio" name="options" id="option1">
						Grid
					</label>
					<label class="btn btn-success"  style="">
						<input type="radio" name="options" id="option2">
						List
					</label>
				</div>
			</div>
		</div>
		<div class="row padder">
			<div id="contains">
			<?php
			foreach ($Data['AddressBookData'] as $Card) {
				$ID = "CardData-".$Card['ID'];
				$Display = strlen($Card['DisplayName'])>1 ? $Card['DisplayName'] : "{$Card['FirstName']} {$Card['LastName']}";
				$Sub1 = 
					($Card['SecondEmail']).
					($Card['CellularNumber'] ? " &bull; {$Card['CellularNumber']}" : "").
					($Card['_AimScreenName'] ? " &bull; {$Card['_AimScreenName']}" : "");
				$Sub2 =
					($Card['JobTitle']).
					($Card['Department'] ? " &bull; {$Card['Department']}" : "").
					($Card['Company'] ? " &bull; {$Card['Company']}" : "").
					($Card['WorkCity'] ? " &bull; {$Card['WorkCity']}" : "").
					($Card['WorkCountry'] ? " &bull; {$Card['WorkCountry']}" : "");
				?>
				<div class="item bg-light" id="<?php echo $ID; ?>">
					<div class="thumb avatar float">
						<img src="/assetserver/userNameIcon/<?php echo $Card['FirstName'];?>">
					</div>
					<div class="clear">
						<p class="h3"><?php echo $Display; ?></p>
						<p class="h4 m-b-sm"><?php echo $Card['PrimaryEmail']; ?></p>
						<p class="h5 m-t-sm"><?php echo $Sub1; ?></p>
						<p class="h5 m-t-sm"><?php echo $Sub2; ?></p>

						<span class="btn btn-xs btn-success m-t-sm" onclick="Utils.GetMoreDetails(<?php echo $Card['ID']; ?>);">More</span>
						<?php echo ($Data['Buttons']['Add']) ? "<span class=\"btn btn-xs btn-primary m-t-sm\" data-tabs-id=\"{$Card['ID']}\" id=\"CardUpdateI{$Card['ID']}\" onclick=\"ModalShowUpdateWindow(this.id);\">Update</span>" : ""; ?>
						<?php echo ($Data['Buttons']['Add']) ? "<span class=\"btn btn-xs btn-default m-t-sm pull-right\" data-tabs-id=\"{$Card['ID']}\" id=\"CardDelI{$Card['ID']}\" onclick=\"Utils.DeleteCard(this.id);\">Delete</span>" : ""; ?>
					</div>
				</div>
				<?php
			}
			?>
			</div>
		</div>
	</section>
	<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" id="ModalDismiss1"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel"><img src="<?php echo in_ac_ducic_tabs_ASSET."/asset/TABS-main.png"; ?>" height="30px"> <span id="ModalTitle">Add Contact</span></h4>
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
											<label class="col-lg-2 control-label">First Name <span class="label label-danger ModalAdd">*</span></label>
											<div class="col-lg-10">
												<input type="text" class="form-control" name="FirstName" required>
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">Last Name</label>
											<div class="col-lg-10">
												<input type="text" class="form-control" name="LastName">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">Display</label>
											<div class="col-lg-10">
												<input type="text" class="form-control" name="DisplayName">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">NickName</label>
											<div class="col-lg-10">
												<input type="text" class="form-control" name="NickName">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">Email <span class="label label-danger ModalAdd">*</span></label>
											<div class="col-lg-10">
												<input type="email" class="form-control" name="PrimaryEmail" required>
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">Additional Email</label>
											<div class="col-lg-10">
												<input type="email" class="form-control" name="SecondEmail">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">Chat Name</label>
											<div class="col-lg-10">
												<input type="text" class="form-control" name="_AimScreenName">
											</div>
										</div>
									</div>
									<div class="col-sm-4 form-horizontal">
										<div class="form-group">
											<label class="col-lg-2 control-label">Work</label>
											<div class="col-lg-10">
												<input type="tel" class="form-control" name="WorkPhone">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">Home</label>
											<div class="col-lg-10">
												<input type="tel" class="form-control" name="HomePhone">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">Fax</label>
											<div class="col-lg-10">
												<input type="tel" class="form-control" name="FaxNumber">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">Mobile</label>
											<div class="col-lg-10">
												<input type="tel" class="form-control" name="CellularNumber">
											</div>
										</div>
										<div class="m-t ModalAdd">
											<img src="/assetserver/admin/assets/images/generic/icons/waitx120.png" width="50px" class="m-r" style="float:left">
											<p>Fields marked with <span class="label label-danger">*</span> are Required.</p>
											<p>Rest of the Fields are Optional.</p>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="PrivateInfo">
									<div class="col-sm-12 form-horizontal">
										<div class="form-group">
											<label class="col-lg-2 control-label">Address</label>
											<div class="col-lg-10">
												<input type="text" class="form-control" name="HomeAddress">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label"></label>
											<div class="col-lg-10">
												<input type="text" class="form-control" name="HomeAddress2">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">City</label>
											<div class="col-lg-10">
												<input type="text" class="form-control" name="HomeCity">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">State</label>
											<div class="col-lg-5">
												<input type="text" class="form-control" name="HomeState">
											</div>
											<label class="col-lg-3 control-label">Zip/Postal Code</label>
											<div class="col-lg-2">
												<input type="email" class="form-control" name="HomeZipCode">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">Country</label>
											<div class="col-lg-10">
												<input type="text" class="form-control" name="HomeCountry">
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="WorkInfo">
									<div class="col-sm-12 form-horizontal">
										<div class="form-group">
											<label class="col-lg-2 control-label">Title</label>
											<div class="col-lg-4">
												<input type="text" class="form-control" name="JobTitle">
											</div>
											<label class="col-lg-2 control-label">Department</label>
											<div class="col-lg-4">
												<input type="text" class="form-control" name="Department">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">Organization</label>
											<div class="col-lg-10">
												<input type="text" class="form-control" name="Company">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">Address</label>
											<div class="col-lg-10">
												<input type="text" class="form-control" name="WorkAddress">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label"></label>
											<div class="col-lg-10">
												<input type="text" class="form-control" name="WorkAddress2">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">City</label>
											<div class="col-lg-10">
												<input type="text" class="form-control" name="WorkCity">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">State</label>
											<div class="col-lg-5">
												<input type="text" class="form-control" name="WorkState">
											</div>
											<label class="col-lg-3 control-label">Zip/Postal Code</label>
											<div class="col-lg-2">
												<input type="text" class="form-control" name="WorkZipCode">
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label">Country</label>
											<div class="col-lg-10">
												<input type="text" class="form-control" name="WorkCountry">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" id="ModalDismiss2">Close</button>
					<button type="button" class="btn btn-success ModalAdd" onclick="InitClick()" id="ModalAction">Add Contact to Addressbook</button>
				</div>
			</div>
		</div>
	</div>
	<style type="text/css">
		@media (min-width: 767px) {
			.item {
				width: 300px;
				margin: 20px;
				padding: 10px;
				border-radius: 5px;
				min-width: 220px;
			}
		}
		@media (max-width: 768px) {
			.item {
				width: 95%;
				margin: 10px;
				padding: 10px;
				border-radius: 5px;
				min-width: 220px;
			}
		}
		.avatar.float {
			float: right;
		}
		.item.w2 { width: 50%; }
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
	<script type="text/javascript" src="<?php echo in_ac_ducic_tabs_ASSET."/asset/ajax.js"?>"></script>
	<script type="text/javascript" src="<?php echo in_ac_ducic_tabs_ASSET.'/asset/masonry.pkgd.min.js'; ?>"></script>
	<script type="text/javascript">
	var $container = $('#contains');
	// initialize
	$container.masonry({
		columnWidth: ".item",
		itemSelector: '.item'
	});
	</script>
	<?php
}

?>