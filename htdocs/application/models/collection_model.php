<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Collection_model extends CI_Model {
  
  var $name;
  var $description;
  var $path;
  var $thumbnail_path;
  
  function __construct() {
    parent::__construct();
  }
  
  function get_most_recent($limit = 5) {
    // most recent collections
    $this->db->order_by('id', 'desc');
    $query = $this->db->get('collections', 5);
    return $query->result();
  }
  
  function get($id) {
    $this->db->where('id', $id);
    $query = $this->db->get('collections');
    return $query->row();
  }
}
