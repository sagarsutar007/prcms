<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

    function get($id='')
    {
        return $this->db->get_where('test', ['id' => $id])->row_array();
    }

    function insert($data=[]) 
    {
        $this->db->insert('test', $data);
        return $this->db->insert_id();
    }

    function update($id='', $first='', $last='', $count=0)
    {
        $count = $count + 1;
        
        if (empty($first)) {
            $arr = ['second'=>$last, 'count'=>$count, 'updated_at' => date('Y-m-d h:i:s')];
        } elseif (empty($last)) {
            $arr = ['first'=>$first, 'count'=>$count, 'updated_at' => date('Y-m-d h:i:s')];
        } else {
            $arr = ['first'=>$first, 'second'=>$last, 'count'=>$count, 'updated_at' => date('Y-m-d h:i:s')];
        }
        $this->db->update('test', $arr, ['id'=>$id]);
        return $this->db->affected_rows();
    }

    function getLast()
    {
        $this->db->order_by('created_at', 'desc');
        $this->db->from('test');
        return $this->db->get()->row_array();
    }

}