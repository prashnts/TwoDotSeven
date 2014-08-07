<?php
namespace TwoDOt7\Bit\in_ac_ducic_library\View;

function init($Data) {
	?>
	<section class="scrollable padder">
		<div class="m-b-md row padder">
			<div class="col-lg-6">
				<h3 class="m-b-none">Library /Catalogue/</h3>
				<small>View and Manage the registered Users and their Sessions.</small>
			</div>
			<div class="col-lg-6">
				<div class="text-right m-b-n m-t-sm">

				</div>
			</div>
			<hr>
		</div>
	</section>
	<?php
	\TwoDOt7\Bit\in_ac_ducic_library\View\Render::Catalogue();
}

class Render {
	public static function Catalogue() {
		echo "LOL";
	}
}

?>