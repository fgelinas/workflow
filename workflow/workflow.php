<?php

/*
 * Workflow project
 * By Francois Gelinas
 * January 2012
 *
 * This project is licensed under both the MIT and GPL license
 */

include 'render.php'; // rendering class
include 'data.php';
include 'cards.php';


global $data; // data represent the columns and cards data to be saved and loaded from the data file.
Data::load();


$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {

	case 'save_reorder':
		Cards::save_reorder();
		break;

	case 'update_card':
		$card = Cards::update_card();
		$output = array(
			'card_html' => Render::card($card)
		);
		echo json_encode($output);
		break;

	case 'remove_card':
		$card_id = $_POST['card_id'];
		Cards::remove($card_id);
		break;

	case 'card_add':
		Cards::add($_GET['column_id']);
		break;

	default:
		include 'layout/layout.php';
}

