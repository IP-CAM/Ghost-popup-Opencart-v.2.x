<?php  
class ControllerModuleGhostPopup extends Controller {
	public function index() {
		$this->load->language('module/ghost_popup');
		
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['cookie'] = $this->config->get('ghost_popup_cookie');
		$data['timeout'] = $this->config->get('ghost_popup_timeout');
		$data['content'] = html_entity_decode($this->config->get('ghost_popup_content'));
		$data['status'] = $this->config->get('ghost_popup_status');

		if (file_exists(DIR_TEMPLATE . $this->config->get('template') . '/template/module/ghost_popup.tpl')) {
			return $this->load->view($this->config->get('template') . '/template/module/ghost_popup.tpl', $data);
		} else {
			return $this->load->view('default/template/module/ghost_popup.tpl', $data);
		}

	}
}
?>
