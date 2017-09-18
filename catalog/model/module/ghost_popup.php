<?php
class ModelModuleGhostPopup extends Model {

	public function addSubscribe($data) {
		$this->load->language('module/ghost_popup');

		$this->db->query("INSERT INTO " . DB_PREFIX . "ghost_popup
		SET
			email = '" . $this->db->escape($data['email']) . "',
			name = '" . $this->db->escape($data['name']) . "',
			ip = '" . $this->db->escape($data['ip']) . "',
			date_added = NOW()");

		$id = $this->db->getLastId();

		$store_name = $this->config->get('config_name');

		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		$message  = sprintf($this->language->get('text_approve_welcome'), html_entity_decode($store_name, ENT_QUOTES, 'UTF-8')) . "\n\n";
		$message .= $this->language->get('text_approve_services') . "\n\n";
		// $message .= sprintf($this->language->get('text_subscribe_services'), $server . 'index.php?route=account/module_subscribe&approve=' . (int)$id ) . "\n\n";
		$message .= $this->language->get('text_thanks') . "\n";
		$message .= html_entity_decode($store_name, ENT_QUOTES, 'UTF-8');

		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
		$mail->smtp_username = $this->config->get('config_mail_smtp_username');
		$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
		$mail->smtp_port = $this->config->get('config_mail_smtp_port');
		$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

		$mail->setTo($data['email']);
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender(html_entity_decode($store_name, ENT_QUOTES, 'UTF-8'));
		$mail->setSubject(sprintf($this->language->get('text_approve_subject'), html_entity_decode($store_name, ENT_QUOTES, 'UTF-8')));
		$mail->setText($message);
		$mail->send();
	}

	public function checkSubscribe($email) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "ghost_popup WHERE email = '" . $this->db->escape($email) . "'");

		if ($query->row) {
			return true;
		} else {
			return false;
		}
	}

	public function getSubscribe($id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ghost_popup WHERE id = '" . (int)$id . "' ");

		return $query->row;
	}

	public function getSubscribeById($id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ghost_popup WHERE id = '" . (int)$id . "'");

		return $query->row;
	}

	public function unSubscribe($id)	{
		$this->db->query("DELETE FROM " . DB_PREFIX . "ghost_popup WHERE id = '" . (int)$id . "'");
	}

	public function approve($id)	{
		$subscribe_info = $this->getSubscribeById($id);

		if ($subscribe_info) {

			$this->db->query("UPDATE " . DB_PREFIX . "ghost_popup SET approved = '1' WHERE id = '" . (int)$id . "'");

			$this->load->language('module/ghost_popup');

			$store_name = $this->config->get('config_name');

			if ($this->request->server['HTTPS']) {
				$server = $this->config->get('config_ssl');
			} else {
				$server = $this->config->get('config_url');
			}

			$message  = sprintf($this->language->get('text_unsubscribe_welcome'), html_entity_decode($store_name, ENT_QUOTES, 'UTF-8')) . "\n\n";
			$message .= sprintf($this->language->get('text_unsubscribe_services'), $server . 'index.php?route=account/module_subscribe&unsubscribe=' . (int)$id . '&hash='.$subscribe_info['hash']) . "\n\n";
			$message .= $this->language->get('text_thanks') . "\n";
			$message .= html_entity_decode($store_name, ENT_QUOTES, 'UTF-8');

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
			$mail->setSubject(sprintf($this->language->get('text_unsubscribe_subject'), html_entity_decode($store_name, ENT_QUOTES, 'UTF-8')));
			$mail->setText($message);
			$mail->send();
		}
	}

}

?>