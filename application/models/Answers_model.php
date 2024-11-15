<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Answers_model extends CI_Model {

	public $primary_table = "answers";

	public function __construct()
	{
		parent::__construct();
	}

	public function get($value='')
	{
		$q = $this->db->get_where('answers', ['id'=>$value]);
		return $q->row_array();
	}

	public function addAnswers($object='')
	{
		$this->db->insert_batch('answers', $object);
		return $this->db->affected_rows();
	}

	public function getAnswersOfQuestion($value='')
	{
		$this->db->select('id, answer_text_en, answer_text_hi, isCorrect');
		$q = $this->db->get_where('answers', ['question_id'=>$value]);
		return $q->result_array();
	}

	public function deleteAnswersOfQuestion($value='')
	{
		$q = $this->db->delete('answers', ['question_id'=>$value]);
		return $this->db->affected_rows();
	}

	public function theCorrectAnswer($question_id='')
	{
		$q = $this->db->get_where('answers', ['question_id'=>$question_id, 'isCorrect' => 1]);
		return $q->row_array();
	}

	public function theCorrectAnswers($question_id='')
	{
		$q = $this->db->get_where('answers', ['question_id'=>$question_id, 'isCorrect' => 1]);
		return $q->result_array();
	}

	public function getMaxOptions($exam_id) {
		$query = $this->db->query("
			SELECT MAX(option_count) AS max_options
			FROM (
				SELECT question_id, COUNT(*) AS option_count
				FROM answers
				WHERE question_id IN (
					SELECT question_id
					FROM exam_questions
					WHERE exam_id = ?
				)
				GROUP BY question_id
			) AS option_counts
		", array($exam_id));

		return $query->row()->max_options;
	}

}

/* End of file  */
/* Location: ./application/models/ */