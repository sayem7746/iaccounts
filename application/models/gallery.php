<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gallery extends CI_Model{
	var $gallery_path;
	var $gallery_path_url;
	
	function gallery(){
		$this->gallery_path = realpath(APPPATH . "../images");
		$this->gallery_path_url = base_url() . 'images/';
	}
	
	function do_upload(){
		$config = array(
			'allowed_types' => 'jpg|jpeg|gif|png',
			'upload_path' => $this->gallery_path,
		);
		$this->load->library('upload', $config);
		$this->upload->do_upload();
		$image_data = $this->upload->data();
		$data = array(
			'aset_img' => $image_data['file_name']
		);
		
		$config = array(
			'source_image' => $image_data['full_path'],
			'new_image' => $this->gallery_path . '/thumbs',
			'maintain_ratio' => true,
			'width' => 150,
			'height' => 100
		);
		
		
		$this->load->library('image_lib', $config);
		$this->image_lib->resize();
	}
	
}
