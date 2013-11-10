<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class LiveCode extends CI_Model
{
    function create($data) {
        if ($this->db->insert('course', $data)) {
            $course_id = $this->db->insert_id();
            return array('course_id' => $course_id);
        }
        return NULL;
    }
}