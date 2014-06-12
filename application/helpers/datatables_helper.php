<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function get_buttons($id)
{
    $ci = & get_instance();
    $html = '<span class="actions">';
    $html .= '<a href="' . base_url() . 'subscriber/edit/' . $id . '"><img src="' . base_url() . 'assets/images/edit.png"/></a>';
    $html .= '<a href="' . base_url() . 'subscriber/delete/' . $id . '"><img src="' . base_url() . 'assets/images/delete.png"/></a>';
    $html .= '</span>';
 
    return $html;
}