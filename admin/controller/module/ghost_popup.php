<?php
class ControllerModuleGhostPopup extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/ghost_popup');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		$this->load->model('module/ghost_popup');

		$this->model_module_ghost_popup->makeDB();

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('ghost_popup', $this->request->post);		

			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('module/ghost_popup', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$data['heading_title'] = $this->language->get('heading_title');

		$data['column_email'] = $this->language->get('column_email');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_approved'] = $this->language->get('column_approved');
		$data['column_ip'] = $this->language->get('column_ip');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_date_last_send'] = $this->language->get('column_date_last_send');
		$data['column_action'] = $this->language->get('column_action');

		$data['text_edit'] = 'Настройки модуля';
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_content_top'] = $this->language->get('text_content_top');
		$data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$data['text_column_left'] = $this->language->get('text_column_left');
		$data['text_column_right'] = $this->language->get('text_column_right');
		$data['text_no_results'] = $this->language->get('text_no_results');
		
		$data['entry_layout'] = $this->language->get('entry_layout');
		$data['entry_position'] = $this->language->get('entry_position');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_add_module'] = $this->language->get('button_add_module');
		$data['button_remove'] = $this->language->get('button_remove');

		$data['entry_ghost_popup_cookie'] = $this->language->get('entry_ghost_popup_cookie');
		$data['entry_subscribe_message'] = $this->language->get('entry_subscribe_message');
		$data['ghost_popup_heading_title'] = $this->language->get('ghost_popup_heading_title');
		$data['on_off_text'] = $this->language->get('on_off_text');
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}


  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/ghost_popup', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$data['token'] = $this->session->data['token'];

		$data['action'] = $this->url->link('module/ghost_popup', 'token=' . $this->session->data['token'], 'SSL');

		$data['delete'] = $this->url->link('module/ghost_popup/delete_subscribe', 'token=' . $this->session->data['token'] . '&subscribe_id=', 'SSL');
		$data['send'] = $this->url->link('module/ghost_popup/send_message', 'token=' . $this->session->data['token'] . '&subscribe_id=', 'SSL');
		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['ghost_popup_cookie'] = isset($this->request->post['ghost_popup_cookie']) ? $this->request->post['ghost_popup_cookie'] : $this->config->get('ghost_popup_cookie');
		$data['ghost_popup_subscribe_message'] = isset($this->request->post['ghost_popup_subscribe_message']) ? $this->request->post['ghost_popup_subscribe_message'] : $this->config->get('ghost_popup_subscribe_message');



		$data['subscribes'] = array();

		$subscribe_total = $this->model_module_ghost_popup->getTotalSubscribes();

		$results = $this->model_module_ghost_popup->getSubscribes();

		foreach ($results as $result) {
			// if (!$result['approved']) {
			// 	$approve = $this->url->link('module/popup_subscribe/approve', 'token=' . $this->session->data['token'] . '&subscribe_id=' . $result['subscribe_id'] . $url, 'SSL');
			// } else {
			// 	$approve = 1;
			// }

			$data['subscribes'][] = array(
				'subscribe_id'   => $result['id'],
				'email'          => $result['email'],
				'ip'             => $result['ip'],
				'date_last_send' => date("d/m/y H:i:s", strtotime($result['date_last_send'])),
				'date_added'     => date("d/m/y H:i:s", strtotime($result['date_added']))
			);
		}

		if (isset($this->request->post['ghost_popup_status'])) {
			$data['ghost_popup_status'] = $this->request->post['ghost_popup_status'];
		} else {
			$data['ghost_popup_status'] = $this->config->get('ghost_popup_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/ghost_popup.tpl', $data));
		
	}
	
	public function send_message() {
		$json = array();

		$this->language->load('module/ghost_popup');
		$this->load->model('module/ghost_popup');

		// $popup_subscribe_form_data = (array)$this->config->get('popup_subscribe_form_data');
		$subscribes = array();

		if (isset($this->request->post['selected'])) {
			$subscribes = $this->request->post['selected'];
		} elseif (isset($this->request->get['subscribe_id'])) {
			$subscribes[] = $this->request->get['subscribe_id'];
		}

		if ($subscribes) {

			$this->model_module_ghost_popup->sendTo($subscribes);

			$this->session->data['success'] = $this->language->get('text_success_send_message');

			if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
				$this->response->addHeader('Content-Type: application/json');
				$this->response->setOutput(json_encode($json));
			} elseif (($this->request->server['REQUEST_METHOD'] == 'GET')) {
				$this->response->redirect($this->url->link('module/ghost_popup', 'token=' . $this->session->data['token'], 'SSL'));
			}
			// return;		
		} else {
			$this->response->redirect($this->url->link('module/ghost_popup', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}

	public function delete_subscribe() {
		$json = array();

		$this->language->load('module/ghost_popup');
		$this->load->model('module/ghost_popup');

		// $popup_subscribe_form_data = (array)$this->config->get('popup_subscribe_form_data');

		if (isset($this->request->get['subscribe_id']) && !empty($this->request->get['subscribe_id'])) {

			$this->model_module_ghost_popup->deleteSubscribe($this->request->get['subscribe_id']);

			$this->session->data['success'] = $this->language->get('text_success_delete_subscribe');

			$this->response->redirect($this->url->link('module/ghost_popup', 'token=' . $this->session->data['token'], 'SSL'));
		} else {
			$this->index();
		}

	}

	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/ghost_popup')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>
