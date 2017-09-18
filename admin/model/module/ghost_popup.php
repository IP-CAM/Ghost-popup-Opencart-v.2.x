<?php
class ModelModuleGhostPopup extends Model {

	public function getSubscribes($data=array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "ghost_popup ";

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY date_added";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function deleteSubscribe($subscribe_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "ghost_popup WHERE id = '" . (int)$subscribe_id . "'");
	}

	public function getTotalSubscribes() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "ghost_popup");

		return $query->row['total'];
	}

	public function exportCSV() {
		$output = '';

		$fp = fopen('php://temp', 'r+');

		fputs($fp, $bom = ( chr(0xEF) . chr(0xBB) . chr(0xBF) ));

		$query = "SELECT email AS `Email`, approved AS `Approved`, ip AS `IP`, date_added AS `Date Added` FROM " . DB_PREFIX . "ghost_popup WHERE approved = '1'";

		$results = $this->db->query($query);

		$row = $results->row;

		fputcsv($fp, array_keys($row));

		rewind($fp);

		$output .= fgets($fp);

		foreach ($results->rows as $result) {
			rewind($fp);
			fputcsv($fp, $result);
			rewind($fp);
			$output .= fgets($fp);
		}

		return $output;
	}

	public function getSubscribe($subscribe_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "ghost_popup WHERE id = '" . (int)$subscribe_id . "'");

		return $query->row;
	}

	public function sendTo($subscribes=array()) {
		foreach ($subscribes as $key => $subscribe_id) {

			$subscribe_info = $this->getSubscribe($subscribe_id);

			if ($subscribe_info) {
				$this->db->query("UPDATE " . DB_PREFIX . "ghost_popup SET date_last_send = NOW() WHERE id = '" . (int)$subscribe_id . "'");

				$this->load->language('module/ghost_popup');

				$store_name = $this->config->get('config_name');

				$message  = '';

				$text_message = $this->config->get('ghost_popup_subscribe_message');
				$find = array("{name}", "{email}");
				$replace = array($subscribe_info['name'], $subscribe_info['email']);
				$message = str_replace($find, $replace, $message);
				$html .= html_entity_decode($message, ENT_QUOTES, 'UTF-8');

				$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

				$mail->setTo($subscribe_info['email']);
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender(html_entity_decode($store_name, ENT_QUOTES, 'UTF-8'));
				$mail->setSubject(sprintf($this->language->get('text_approve_subject'), $subscribe_info['name'], html_entity_decode($store_name, ENT_QUOTES, 'UTF-8')));
				$mail->setHtml($html);
				$mail->send();
			}
		}
	}

	public function makeDB() {
		$sql  = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ghost_popup` ( ";
		$sql .= "`id` int(11) NOT NULL AUTO_INCREMENT, ";
		$sql .= "`email` varchar(96) NOT NULL, ";
		$sql .= "`name` varchar(255) NOT NULL, ";
		$sql .= "`ip` varchar(96) NOT NULL, ";
		$sql .= "`date_last_send` datetime NOT NULL, ";
		$sql .= "`date_added` datetime NOT NULL, ";
		$sql .= "PRIMARY KEY (`id`) ";
		$sql .= ") ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

		$this->db->query( $sql );
	}

	public function removeDB() {
		$sql  = "DROP TABLE IF EXISTS `" . DB_PREFIX . "ghost_popup`;";

		$this->db->query( $sql );
	}
}
