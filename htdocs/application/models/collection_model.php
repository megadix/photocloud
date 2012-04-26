<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Collection_model extends CI_Model {
  
  private static $table_name = 'collections';
  
  var $id;
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
    $query = $this->db->get(Collection_model::$table_name, 5);
    return $query->result();
  }
  
  function get($id) {
    $this->db->where('id', $id);
    $query = $this->db->get(Collection_model::$table_name);
    return $query->row();
  }
  
  public function insert() {
    $this->db->insert(Collection_model::$table_name, $this);
    $this->id = $this->db->insert_id();
  }
  
  public function update() {
    $this->db->where('id', $this->id);
    $this->db->update(Collection_model::$table_name, $this);
  }
  
}
