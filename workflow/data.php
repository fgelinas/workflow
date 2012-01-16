<?php

class Data
{

	function __construct()
	{
	}

	function load()
	{
		$data_file = BASE_PATH . '/data/flowdata.dat';

		global $data;
		$data = Data::factory_default();

		try {
			if ( ! file_exists($data_file) ) {
				return false;
			}

			$data = json_decode(file_get_contents($data_file));
		}
		catch (Exception $e) {
			return false;
		}

		$data->columns = (array) $data->columns;
		$data->cards = (array) $data->cards;

		return true;
	}

	function save() {

		if ( ! is_dir ( BASE_PATH . '/data/') ) {
			mkdir ( BASE_PATH . '/data/' );
		}

		$data_file = BASE_PATH . '/data/flowdata.dat';
		global $data;
		file_put_contents( $data_file, json_encode($data) );
	}

	// initialize the data for first use
	function factory_default()
	{

		$data = array(
			'columns' => array(
				array(
					'id'    => 1,
					'name'  => 'Upcoming',
				),
				array(
					'id'    => 2,
					'name'  => 'In progress',
				),
				array(
					'id'    => 3,
					'name'  => 'Archives',
				)
			),

			'cards' => array(
				array(
					'id'      	=> 1,
					'column_id'	=> 1,
					'order'		=> 1,
					'content'	=> 'Hello, this is Workflow, a 3 column tool to organize your work or stuff'
				),
				array(
					'id'     	=> 2,
					'column_id'	=> 1,
					'order'		=> 2,
					'content' 	=> 'Each of theses boxes are cards. Write stuff on cards and drag them around.'
				),
				array(
					'id'     	=> 3,
					'column_id'	=> 1,
					'order'		=> 3,
					'content' => 'Important: everything is stored in /flow/data/flowdata.dat, you should add this file to your backups.'
				),
				array(
					'id'		=> 4,
					'column_id'	=> 2,
					'order'		=> 1,
					'content'	=> 'Use CTRL+Return to add line when editing a card'
				),
				array(
					'id'      	=> 5,
					'column_id'	=> 2,
					'order'		=> 1,
					'content' => 'Fix this and that'
				),
				array(
					'id'      	=> 6,
					'column_id'	=> 2,
					'order'		=> 2,
					'content' 	=> 'This task is taking forever ...'
				),
				array(
					'id'		=> 7,
					'column_id'	=> 3,
					'order'		=> 2,
					'content'	=> 'Make pancakes.'
				),
				array(
					'id'		=> 8,
					'column_id'	=> 3,
					'order'		=> 1,
					'content'	=> 'Drag a card to the bottom of the screen to delete it'
				)
			)

		);

		// convert everything to object, the lazy way
		$data = json_decode( json_encode( $data ) );

		return $data;

	}
}