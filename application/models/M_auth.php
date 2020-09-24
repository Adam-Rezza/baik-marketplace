<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_auth extends CI_Model
{
    public function __construct(){
        parent::__construct();
    }

	public function get($table, $select = '*', $where = NULL, $orderBy = NULL, $orderOrien = 'ASC', $limit = NULL, $offset = NULL, $groupBy = NULL)
	{
		$this->db->select($select);
		if ($where != NULL) {
			$this->db->where($where);
		}

		if($orderBy != NULL){
			$this->db->order_by($orderBy, $orderOrien);
		}

		if($groupBy != NULL){
			$this->db->group_by($groupBy);
		}

		return $this->db->get($table, $limit, $offset);
	}

	function insert($table, $data){
        $this->db->insert($table, $data);
        return $this->db->insert_id();
        
    }
}

/* End of file M_core.php */
/* Location: ./application/models/M_core.php */
