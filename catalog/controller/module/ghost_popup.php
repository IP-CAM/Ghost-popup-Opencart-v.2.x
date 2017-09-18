<?php  
class ControllerModuleGhostPopup extends Controller {
	public function index() {
		$this->load->language('module/ghost_popup');
		
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['ghost_popup_cookie'] = $this->config->get('ghost_popup_cookie');
		$data['ghost_popup_status'] = $this->config->get('ghost_popup_status');

		if (file_exists(DIR_TEMPLATE . $this->config->get('template') . '/template/module/ghost_popup.tpl')) {
			return $this->load->view($this->config->get('template') . '/template/module/ghost_popup.tpl', $data);
		} else {
			return $this->load->view('default/template/module/ghost_popup.tpl', $data);
		}

	}

	public function make_subscribe() {
		$json = array();

		$this->language->load('module/ghost_popup');
		$this->load->model('module/ghost_popup');

		// $popup_subscribe_form_data = (array)$this->config->get('popup_subscribe_form_data');

		if (isset($this->request->post['email']) && isset($this->request->post['name'])) {

			if (empty($this->request->post['name'])) {
				$json['error'] = $this->language->get('error_enter_name');
			}

			if (empty($this->request->post['email'])) {
				$json['error'] = $this->language->get('error_enter_email');
			}

			if (!preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email'])) {
				$json['error'] = $this->language->get('error_valid_email');
			}

			$subscribe_status = $this->model_module_ghost_popup->checkSubscribe($this->request->post['email']);

			if ($subscribe_status) {
				$json['error'] = $this->language->get('error_already_subscribed_email');
			}

			if (!isset($json['error'])) {

				if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
					$ip = $this->request->server['HTTP_X_FORWARDED_FOR'];
				} elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
					$ip = $this->request->server['HTTP_CLIENT_IP'];
				} else {
					$ip = $this->request->server['REMOTE_ADDR'];
				}

				$subscribe_data = array (
					'email' => $this->request->post['email'],
					'name' => $this->request->post['name'],
					'ip'		=> $ip
				);

				$this->model_module_ghost_popup->addSubscribe($subscribe_data);

				$json['output'] = $this->language->get('text_success_subscribe');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}


}
?>
