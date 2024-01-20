<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function createThumbnail($filename='') {
    $config['image_library'] = 'gd2';
	$config['source_image'] = './assets/img/' . $filename;
	$config['new_image'] = './assets/img/thumbnails/';
	$config['create_thumb'] = true;
	$config['maintain_ratio'] = true;
	$config['thumb_marker'] = "_thumb";
	$config['width'] = 100;
	$config['height'] = 150;
	$ci =& get_instance();
	$ci->image_lib->initialize($config);
	if ( ! $ci->image_lib->resize())
	{
	    return false;
	} else {
		$path_info = pathinfo($filename);
		$thumbnail = $path_info['filename'] . '_thumb.' . $path_info['extension'];
		return $thumbnail;
	}
}