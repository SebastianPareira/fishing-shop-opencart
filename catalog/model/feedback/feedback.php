<?php

class ModelFeedbackFeedback extends Model
{
	public function add($data)
	{
		$this->db->query("INSERT INTO `" . DB_PREFIX . "feedback` SET firstname = '" . $this->db->escape($data['firstname']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', url = '" . $this->db->escape($data['url']) . "', status = '" . (int)($data['status']) . "', ip = '" . $this->db->escape($data['ip']) . "', forwarded_ip = '" .  $this->db->escape($data['forwarded_ip']) . "', user_agent = '" . $this->db->escape($data['user_agent']) . "', accept_language = '" . $this->db->escape($data['accept_language']) . "', date_added = NOW(), date_modified = NOW()");
	}
}
