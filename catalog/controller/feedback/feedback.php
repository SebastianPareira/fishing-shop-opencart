<?php

class ControllerFeedbackFeedback extends Controller
{
	private $error = array();

	public function index()
	{
		$json = array();

		if ($this->validate()) {
			try {
				$this->save();
				$json['success'] = '<h3>Спасибо за обращение. Мы Вам скоро перезвоним!</h3>';
			} catch (Exception $exception) {
				$json['error_warning'] = 'Произошла ошибка. Попробуйте позже.';
			}
		} else {
			$html = "";
			foreach ($this->error as $error) {
				$html .= "<li>$error</li>";
			}
			$json['error_warning'] = "<ul>$html</ul>";
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	protected function validate()
	{
		if ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$this->error['general'] = 'Произошла ошибка';
			return false;
		}

		if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
			$this->error['telephone'] = 'Номер телефона должен быть от 3 до 32 символов!';
		}

		if ((utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
			$this->error['firstname'] = 'Имя должно быть от 1 до 32 символов!';
		}

		return !$this->error;
	}

	protected function save()
	{
		$this->load->model('feedback/feedback');

		$data = [
			'url' => isset($this->request->post['url']) ? clear_string($this->request->post['url']) : '',
			'firstname' => isset($this->request->post['firstname']) ? clear_string($this->request->post['firstname']) : '',
			'telephone' => isset($this->request->post['telephone']) ? clear_string($this->request->post['telephone']) : '',
			'status' => 0,
		];

		$data['ip'] = $this->request->server['REMOTE_ADDR'];

		if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
			$data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];
		} elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
			$data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];
		} else {
			$data['forwarded_ip'] = '';
		}

		if (isset($this->request->server['HTTP_USER_AGENT'])) {
			$data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];
		} else {
			$data['user_agent'] = '';
		}

		if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
			$data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
		} else {
			$data['accept_language'] = '';
		}

		$this->model_feedback_feedback->add($data);
	}
}
