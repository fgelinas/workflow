<?php

class Render
{

	public function layout()
	{
		include 'inc/layout.php';
	}

	public function column($column)
	{
		ob_start();
		include 'layout/column.php';
		return ob_get_clean();
	}

	public function card($card)
	{
		ob_start();
		include 'layout/card.php';
		return ob_get_clean();
	}


}