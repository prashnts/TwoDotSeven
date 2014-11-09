<?php
namespace TwoDot7\Bit\in_ac_ducic_courses\View;

function _Interface($Data = False) {
	?>
	<section class="scrollable padder bg-dark  fill">
		<div class="m-b-md row padder">
			<div class="col-lg-6">
			<h1><?php \TwoDot7\Util\_echo($Data['Greet']); ?></h1>
			</div>
		</div>
	</section>
	<?php
}

?>