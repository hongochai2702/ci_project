<?php
class Currency_model extends CI_Model {
	public function getCurrencyByCode($currency) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "currency WHERE code = '" . $this->db->escape($currency) . "'");

		return $query->first_row('array');
	}

	public function getCurrencies() {
			$this->db->cache_on();
			$currency_data = array();
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "currency ORDER BY title ASC");
			foreach ($query->result_array() as $result) {

				$currency_data[$result['code']] = array(
					'currency_id'   => $result['currency_id'],
					'title'         => $result['title'],
					'code'          => $result['code'],
					'symbol_left'   => $result['symbol_left'],
					'symbol_right'  => $result['symbol_right'],
					'decimal_place' => $result['decimal_place'],
					'value'         => $result['value'],
					'status'        => $result['status'],
					'date_modified' => $result['date_modified']
				);


			}
			return $currency_data;
		}

		
	
}