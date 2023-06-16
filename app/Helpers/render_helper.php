<?php
/**
 * 	@author: $rachow
 * 	@copyright: CF Partners 2023
 *
 * 	Rendering helper routines, allowing us
 * 	to seperate layout files and actual body contents.
*/

if( !function_exists('render') )
{
	/**
	 * Replaces the existing CI view routine with this.
	 * Provides a flexible way to inject content into a layouts file
	 *
	 * @param $name
	 * @param $data
	 * @param $options
	*/
	function render(string $name, array $data = [], array $options = [])
	{
		//$layout_path = APPP . '/Views/layouts';
		$layout_path = FCPATH . '../app/Views/layouts';

		$layout_file = (isset($data['_layout'])) ? $layout_path . '/' . $data['_layout'] : 
			$layout_path . '/app';

		if( !file_exists($layout_file . '.php') ) {
			die($layout_file . '.php');
			return view($name, $data, $options);
		}

		// remove the layout name as not needed beyond here.
		unset($data['_layout']);

		return view($layout_file, [

			// load up the view to embed
			'content' => view($name, $data, $options)
		], $options);
	}
}

