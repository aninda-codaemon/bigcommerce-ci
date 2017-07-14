<?php
	class Order_model extends CI_Model{

		public function check_order_exist_store_increment($store_id, $increment_id){
			$this->db->where('store_id', $store_id);
			$this->db->where('increment_id', $increment_id);
			$this->db->from('big_orders');
			return $this->db->count_all_results();
		}

		public function get_order_details_store_increment($store_id, $increment_id){			
			$this->db->where('store_id', $store_id);
			$this->db->where('increment_id', $increment_id);
			$this->db->from('big_orders');
			return $this->db->get()->row_array();
		}

		public function get_total_order_store_by_store_id($store_id){

			$this->db->where('store_id', $store_id);			
			$this->db->from('big_orders o');			
			return $this->db->count_all_results();
		}

		public function get_all_order_details_store($store_id, $offset, $limit){

			$this->db->where('store_id', $store_id);			
			$this->db->from('big_orders o');
			$this->db->join('big_order_address oa', 'oa.order_id = o.id');
			$this->db->limit($limit, $offset);
			$this->db->order_by('o.increment_id', 'desc');
			return $this->db->get()->result_array();
		}

		public function get_order_details_order_id($order_id){
			
			//$this->db->where('o.id', $order_id);
			$this->db->where('o.increment_id', $order_id);
			$this->db->from('big_orders o');
			$this->db->join('big_order_address oa', 'oa.order_id = o.id');
			return $this->db->get()->row_array();
		}

		public function save_order_details($orderArray, $addressArray){

			$this->db->insert('big_orders', $orderArray);
			$order_id = $this->db->insert_id();

			$this->db->set('order_id', $order_id);
			$this->db->insert('big_order_address', $addressArray);

			return 1;
		}

		public function update_order_details($orderArray, $addressArray, $store_id, $increment_id){

			//get order details
			$order_details = $this->get_order_details_store_increment($store_id, $increment_id);

			$this->db->set('update_date', 'NOW()', false);
			$this->db->update('big_orders', $orderArray, ['id' => $order_details['id']]);			
			
			$this->db->update('big_order_address', $addressArray, ['order_id' => $order_details['id']]);

			return 1;
		}
	}
?>