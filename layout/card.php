<li class="card" data-id="<?php echo $card->id; ?>">
	
	<p class="card_content">
		<?php
			$content = $card->content;
			$content = htmlentities( $content );
			$content = str_replace( "\n", '<br>', $content );

			if ( ! $content) {
				$content = "&nbsp;";
			}

			echo $content;
		?>
	</p>

	<div class="edit_container">
		<textarea class="edit_box"><?php echo htmlentities( $card->content ) ?></textarea>
	</div>



</li>