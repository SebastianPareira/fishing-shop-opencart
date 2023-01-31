<?php

class ControllerSaleFeedback extends Controller
{
	private $error = array();

	public function index()
	{
		$this->load->language('sale/feedback');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/feedback');

		$this->getList();
	}

	public function delete()
	{
		$this->load->language('sale/feedback');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/feedback');

		if (isset($this->request->post['selected']) && $this->validateModifyPermission()) {
			foreach ($this->request->post['selected'] as $feedback_id) {
				$this->model_sale_feedback->deleteFeedback($feedback_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('sale/feedback', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	public function process()
	{
		$this->load->language('sale/feedback');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/feedback');

		$feedback_id = (int)$this->request->get['feedback_id'];
		if ($feedback_id > 0 && $this->validateModifyPermission()) {
			$this->model_sale_feedback->processFeedback($feedback_id);
			$this->session->data['success'] = $this->language->get('text_success_process');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('sale/feedback', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList()
	{
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('sale/feedback', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['delete'] = $this->url->link('sale/feedback/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['feedbacks'] = array();

		$filter_data = array(
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$feedback_total = $this->model_sale_feedback->getTotalFeedback();

		$results = $this->model_sale_feedback->getFeedbackList($filter_data);

		foreach ($results as $result) {
			$data['feedbacks'][] = array(
				'feedback_id' => $result['feedback_id'],
				'firstname' => $result['firstname'],
				'telephone' => $result['telephone'],
				'url' => $result['url'],
				'status' => $result['status'],
				'status_name' => $result['status'] == 0 ? 'Новая' : 'Обработанная',
				'date_added' => $result['date_added'],
				'date_modified' => $result['date_modified'],
				'process' => $this->url->link('sale/feedback/process', 'user_token=' . $this->session->data['user_token'] . '&feedback_id=' . $result['feedback_id'] . $url, true)
			);
		}

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

		$pagination = new Pagination();
		$pagination->total = $feedback_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('sale/feedback', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($feedback_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($feedback_total - $this->config->get('config_limit_admin'))) ? $feedback_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $feedback_total, ceil($feedback_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('sale/feedback_list', $data));
	}

	protected function validateModifyPermission()
	{
		if (!$this->user->hasPermission('modify', 'sale/feedback')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}