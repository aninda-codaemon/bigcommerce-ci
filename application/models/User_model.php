<?php

	class User_model extends CI_Model{

		public function check_store_user_exist_store_context($context){
			$this->db->from('big_store s');
			$this->db->join('big_user u', 'u.store_id = s.id');
			$this->db->where('s.store_context', trim($context));
			return $this->db->count_all_results();
		}

		public function get_user_info_by_email($email){			
			$this->db->from('big_user');
			$this->db->where('email', $email);
			$this->db->limit(1);
			return $this->db->get()->row_array();
		}

		public function save_user_details($user_data){
			$this->db->insert('big_user', $user_data);
			return $this->db->insert_id();
		}

	}
?>