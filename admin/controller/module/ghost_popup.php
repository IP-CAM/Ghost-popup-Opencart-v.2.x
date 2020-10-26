<?php
class ControllerModuleGhostPopup extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/ghost_popup');

		$this->document->setTitle($this->language->get('heading_title'));
		
		if ( VERSION >= '2.3') {
		    if ($this->config->get('config_editor_default')) {
		        $this->document->addScript('view/javascript/ckeditor/ckeditor.js');
		        $this->document->addScript('view/javascript/ckeditor/ckeditor_init.js');
		    } else {
		        $this->document->addScript('view/javascript/summernote/summernote.js');
		        $this->document->addScript('view/javascript/summernote/lang/summernote-' . $this->language->get('lang') . '.js');
		        $this->document->addScript('view/javascript/summernote/opencart.js');
		        $this->document->addStyle('view/javascript/summernote/summernote.css');
		    }
		}

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('ghost_popup', $this->request->post);		

			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('module/ghost_popup', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$data['heading_title'] = $this->language->get('heading_title');


		$data['text_edit'] = 'Настройки модуля';
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_content_top'] = $this->language->get('text_content_top');
		$data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$data['text_column_left'] = $this->language->get('text_column_left');
		$data['text_column_right'] = $this->language->get('text_column_right');
		$data['text_no_results'] = $this->language->get('text_no_results');
				
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_add_module'] = $this->language->get('button_add_module');
		$data['button_remove'] = $this->language->get('button_remove');

		$data['entry_ghost_popup_cookie'] = $this->language->get('entry_ghost_popup_cookie');
		$data['entry_ghost_popup_timeout'] = $this->language->get('entry_ghost_popup_timeout');
		$data['entry_ghost_popup_content'] = $this->language->get('entry_ghost_popup_content');
		$data['ghost_popup_heading_title'] = $this->language->get('ghost_popup_heading_title');
		$data['entry_template_content'] = $this->language->get('entry_template_content');
		$data['value_template_content'] = $this->language->get('value_template_content');
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

	
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['ghost_popup_cookie'] = isset($this->request->post['ghost_popup_cookie']) ? $this->request->post['ghost_popup_cookie'] : $this->config->get('ghost_popup_cookie');
		$data['ghost_popup_timeout'] = isset($this->request->post['ghost_popup_timeout']) ? $this->request->post['ghost_popup_timeout'] : $this->config->get('ghost_popup_timeout');
		$data['ghost_popup_content'] = isset($this->request->post['ghost_popup_content']) ? $this->request->post['ghost_popup_content'] : $this->config->get('ghost_popup_content');

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
