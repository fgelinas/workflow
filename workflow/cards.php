<?php
class Cards
{

	function __construct()
	{
	}

	function get_card_by_id($card_id)
	{
		global $data;
		foreach ($data->cards as &$card) {
			if ($card->id == $card_id) {
				return $card;
			}
		}
	}

	function get_cards_for_column($column_id)
	{
		global $data;
		$cards = array();
		foreach ($data->cards as $card) {
			if ($card->column_id == $column_id) {
				array_push( $cards, $card );
			}
		}
		uasort($cards, 'Cards::cards_order_compare');
		return $cards;
	}
	// used for uasort()
	function cards_order_compare($card1, $card2) {
		if ($card1->order == $card2->order) {
			return 0;
		}
		return ($card1->order < $card2->order) ? -1 : 1;
	}

	function sort($cards)
	{

	}

	function update_card()
	{
		$card_id = $_POST['id'];
		$card =& Cards::get_card_by_id($card_id);
		$card->content = $_POST['content'];
		Data::save();
		return $card;
	}

	function save_reorder()
	{
		foreach ($_POST['card_ids'] as $card_id => $card_data )
		{
			$card = Cards::get_card_by_id($card_id);
			$card->order = $card_data['order'];
			$card->column_id = $card_data['column_id'];
		}

		Data::save();
		echo json_encode( array( 'success' => 'yes') );
	}

	function add($column_id)
	{
		global $data;
		// get next id
		$card = (object)array(
			'id'		=> -1,
			'column_id'	=> $column_id,
			'order'		=> -1,
			'content'	=> ''
		);
		foreach ($data->cards as $c)
		{
			if ($c->id >= $card->id) {
				$card->id = $c->id + 1;
			}
		}
		$data->cards[] = $card;
		Data::save();

		echo Render::card($card);
	}

	function remove($card_id)
	{
		global $data;
		foreach ($data->cards as $key => $card)
		{
			if ($card->id == $card_id) {
				array_splice( $data->cards, $key  ,  1);
			}
		}
		Data::save();
	}


}