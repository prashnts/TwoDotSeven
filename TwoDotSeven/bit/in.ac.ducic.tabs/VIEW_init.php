<?php
namespace TwoDOt7\Bit\in_ac_ducic_tabs\View;

function _Interface($Data = False) {
	?>
	<section class="scrollable padder bg-dark  fill">
		<div class="m-b-md row padder">
			<div class="col-lg-6">
				<h3 class="m-b-none">TABS - Address Book</h3>
				<small>All the Address Book entries are shown.</small>
			</div>
			<div class="col-lg-6">
			</div>
		</div>
		<div class="row padder">
			<div class="m-b-lg col-lg-12 text-center">
				<div class="btn-group btn-group-center" data-toggle="buttons">
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

		</div>
	</section>
	<?php
}

function FourOFour() {
	echo "LOL";
}

?>