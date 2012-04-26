<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Image_model extends CI_Model {
  
  var $name;
  var $description;
  var $collection_id;
  var $path;
  var $width;
  var $height;
  var $thumbnail_path;
  var $thumbnail_width;
  var $thumbnail_height;
  
  function __construct() {
    parent::__construct();
  }
  
  function get_images($collection_id) {
    $this->db->where('collection_id', $collection_id);
    $this->db->order_by('id', 'asc');
    $query = $this->db->get('images');
    return $query->result();
  }
  
}
