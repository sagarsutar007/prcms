<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Questions_model extends CI_Model {

	public $primary_table = "questions";

	public function __construct()
	{
		parent::__construct();
		
	}

	public function count()
	{
		return $this->db->count_all_results($this->primary_table);
	}

	public function create($object='')
	{
		$data = [
			'question_en'=>$object['question_en'],
			'question_hi'=>$object['question_hi'],
			'question_img'=>$object['question_img']??'',
			'category_id'=>$object['category_id'],
			'status'=>$object['status'],
			'created_by'=>$object['created_by'],
			'created_at'=>$object['created_at'],
			'question_type'=>$object['question_type']
		];
		$this->db->insert('questions', $data);
		return $this->db->insert_id();
	}

	public function getQuestion($value='')
	{
		$this->db->select('*');
		$this->db->select('(SELECT category_name FROM `categories` WHERE id = questions.category_id) AS category_name');
		$q = $this->db->get_where('questions', ['question_id'=>$value]);
		return $q->row_array();
	}

	public function getAllQuestions()
	{
		$this->db->select('*');
		$this->db->select('(SELECT category_name FROM `categories` WHERE id = questions.category_id) AS category_name');
		$this->db->from('questions');
		$q = $this->db->get();
		return $q->result_array();
	}

	public function get_data($limit="", $offset="", $order="desc")
    {
    	$this->db->select('*');
    	$this->db->select('(SELECT COUNT(*) AS total FROM `answers` WHERE question_id = questions.question_id) AS total');
    	$this->db->select('(SELECT category_name FROM `categories` WHERE id = questions.category_id) AS category_name');
    	$this->db->order_by('created_at', $order);
        $this->db->limit($limit, $offset);
        $this->db->from($this->primary_table);
        $query = $this->db->get();
        return $query->result_array();
    }

	public function updateQuestion($object='')
	{

		$updata = [
			'question_en'=>$object['question_en'], 
			'question_hi'=>$object['question_hi'], 
			'status' => $object['status'], 
			'question_type' => $object['question_type'],
			'category_id' => $object['category_id'],
		];


		if(!empty($object['question_img'])) { $updata['question_img'] = $object['question_img']; }
		$this->db->update('questions',  $updata, ['question_id'=>$object['question_id']]);
		return $this->db->affected_rows();
	}

	public function deleteQuestion($value='')
	{
		$this->db->delete('answers', ['question_id'=>$value]);
		$this->db->delete('questions', ['question_id'=>$value]);
		return $this->db->affected_rows();
	}

	public function removeQuestionImage($object='') {
		$this->db->update('questions', ['question_img'=>''], ['question_id'=>$object['question_id']]);
		return $this->db->affected_rows();
	}

	public function changeQuestionStatus($id='', $status='0')
	{
		$this->db->update('questions', ['status'=>$status], ['question_id'=>$id]);
		return $this->db->affected_rows();
	}

	public function getCategoryQuestions($value='')
	{
		$this->db->select('*');
    	$this->db->select('(SELECT COUNT(*) AS total FROM `answers` WHERE question_id = questions.question_id) AS total');
		$this->db->from($this->primary_table);
		$this->db->where(['category_id'=>$value]);
		$q = $this->db->get();
		return $q->result_array();
	}

	public function getCategoriesQuestions($value='')
	{
		$this->db->where_in('category_id', $value);
		$q = $this->db->get('questions');
		return $q->result_array();
	}

	public function getQuestionsOfCategories($value='')
	{	
		$this->db->where_in('category_id', $value);
		$q = $this->db->get('questions');
		return $q->result_array();
	}

	public function countExamQuestion($exam_id='')
	{
		$this->db->where('exam_id', $exam_id);
		$this->db->from('exam_questions');
		return $this->db->count_all_results();
	}
}

/* End of file  */
/* Location: ./application/models/ */