<div class="column ui-widget">

	<h2>
		<?php echo $column->name ?>
	</h2>

	<ul class="column" data-id="<?php echo $column->id ?>">

		<?php
			$cards = Cards::get_cards_for_column($column->id);
			foreach ($cards as $card) {

				echo Render::card($card);

			}


		?>

	</ul>

	<button class="add_card_button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only ui-state-hover" role="button" aria-disabled="false">
		<span class=" ui-icon ui-icon-plus"></span>
	</button>


</div>