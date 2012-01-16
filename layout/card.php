<li class="card" data-id="<?php echo $card->id; ?>">
	
	<p class="card_content">
		<?php
			$content = $card->content;
			$content = htmlentities( $content, ENT_NOQUOTES );
			$content = str_replace( "\n", '<br>', $content );

			$content = preg_replace("#\"([^\"]+)\"\:((http|https|ftp)://(\S*?\.\S*?))(\s|\;|\)|\]|\[|\{|\}|,|\"|'|:|\<|$|\.\s)#ie",
				"'<a href=\"$2\" target=\"_blank\">$1</a>$5'",
				$content
			);

			$content = preg_replace("#([^\"])((http|https|ftp)://(\S*?\.\S*?))(\s|\;|\)|\]|\[|\{|\}|,|\"|'|:|\<|$|\.\s)#ie",
				"'$1<a href=\"$2\" target=\"_blank\">$4</a>$5'",
				$content
			);




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