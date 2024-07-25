<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Test extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Test_model', 'test');
    }

    function index() {
        echo "Successfully loaded testing assets!";
    }

    function load() {
        $first = uniqid();
        $record = [
            'first' => $first,
            'count' => 0
        ];
        $last = $this->test->insert($record);
        $record = $this->test->get($last);
        $this->test->update($record['id'], NULL, $first, $record['count']);
        $record = $this->test->get($record['id']);

        echo json_encode(['status'=>'SUCCESS', 'record'=>$record]);
    }
}