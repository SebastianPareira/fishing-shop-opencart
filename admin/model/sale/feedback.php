<?php

class ModelSaleFeedback extends Model
{
	public function getFeedbackList($data = array())
	{
		$sql = "SELECT * FROM " . DB_PREFIX . "feedback ORDER BY `feedback_id` DESC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}


		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalFeedback()
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "feedback");

		return $query->row['total'];
	}

	public function getTotalNewFeedback()
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "feedback WHERE `status` = 0");

		return $query->row['total'];
	}

	public function deleteFeedback($id)
	{
		$this->db->query("DELETE FROM `" . DB_PREFIX . "feedback` WHERE feedback_id = '" . (int)$id . "'");
	}

	public function processFeedback($id)
	{
		$this->db->query("UPDATE `" . DB_PREFIX . "feedback` SET status = 1, date_modified = NOW() WHERE feedback_id = '" . (int)$id . "' AND status = 0");
	}
}
