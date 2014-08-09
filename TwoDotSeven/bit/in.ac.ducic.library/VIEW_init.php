<?php
namespace TwoDOt7\Bit\in_ac_ducic_library\View;

function Catalogue($Data = False) {
	?>
	<section class="scrollable padder">
		<div class="m-b-md row padder">
			<div class="col-lg-6">
				<h3 class="m-b-none">Library /Catalogue/</h3>
				<small>View and Manage the registered Users and their Sessions.</small>
			</div>
			<div class="col-lg-6">
			</div>
			<hr>
		</div>
			<?php
			var_dump($Data['ViewData']);
			for ($i = 0; $i<3; $i++) {
			?>
				<div class="col-xs-3">
					<div class="card">
						<span class="badge bg-danger">267889</span>
						<h4>ISBN12 - 234-2332-222</h4>
						<h1>Calculus: Applications</h1>
						<h2 class="m-b">DC Lay. Tata McGraw</h2>
						<hr>
						<h3>In Stock: 30</h3>
						<h3>Available: 30</h3>
						<button class="btn btn-success text-center">Request</button>
						<
					</div>
				</div>
			<?php
			}
			?>
	</section>
	<?php
};

function FoursOFour() {
	echo "LOL";
}

?>