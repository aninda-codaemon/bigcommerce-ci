<?php
	class App_model extends CI_Model{

		public function check_store_already_installed($dataArray){
			$this->db->from('big_store');
			$this->db->where('store_context', $dataArray['store_context']);
			return $this->db->count_all_results();
		}

		public function save_store_details($dataArray){
			$this->db->insert('big_store', $dataArray);
			return $this->db->insert_id();
		}

		public function update_store_details($dataArray){			
			$this->db->set('store_scope', $dataArray['store_scope']);
			$this->db->set('store_token', $dataArray['store_token']);
			$this->db->set('store_token', $dataArray['store_token']);
			$this->db->set('update_date', 'NOW()', FALSE);
			$this->db->where('store_context', $dataArray['store_context']);
			$this->db->update('big_store');

			return 1;
		}

		public function get_store_info_by_context($context){
			$this->db->from('big_store');
			$this->db->where('store_context', $context);
			return $this->db->get()->row_array();
		}

	}
?>