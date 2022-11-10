<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FeatureControllerTutor extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Feature', 'model_data');
		// if ($this->session->userdata('success') != TRUE) {
		//     redirect(base_url());
		// }
	}


	public function index()
	{
		$data['content'] = 'tutors/pages/_feature';
		$this->load->view('tutors/layouts/master', $data);
	}

	function get_data_user()
	{
		$list = $this->model_data->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $field->package_id;
			$row[] = $field->name;
			$row[] = '<td><button class="btn btn-primary btn-class" onclick="updateList(' . "'" . $field->id . "'" . ')"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger btn-class" onclick="deleteList(' . "'" . $field->id . "'" . ')"><i class="fa fa-trash"></i></button></td>';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->model_data->count_all(),
			"recordsFiltered" => $this->model_data->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	function get_data_package()
	{
		$output = $this->model_data->get_packages();
		echo json_encode($output);
	}
	public function add()
	{
		$this->_validate();
		$package_id = $this->input->post('package_id');
		$data = array(
			'package_id' => $package_id,
			'name' => $this->input->post('name'),
		);
		$insert = $this->model_data->add($data);
		echo json_encode(array("status" => TRUE));
	}
	public function get_id($id)
	{
		$data = $this->model_data->get_id($id);
		echo json_encode($data);
	}
	public function update($id)
	{
		$this->_validate();
		$package_id = $this->input->post('package_id');
		$data = array(
			'package_id' => $package_id,
			'name' => $this->input->post('name'),
		);
		$this->model_data->update(array('id' => $id), $data);
		echo json_encode(array("status" => TRUE));
	}
	public function delete($id)
	{
		$this->model_data->delete($id);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		// if ($this->input->post('question') == '') {
		// 	$data['inputerror'][] = 'question';
		// 	$data['error_string'][] = 'question is required';
		// 	$data['status'] = FALSE;
		// }
		// if ($this->input->post('answer') == '') {
		// 	$data['inputerror'][] = 'answer';
		// 	$data['error_string'][] = 'asnwer is required';
		// 	$data['status'] = FALSE;
		// }

		// if ($data['status'] === FALSE) {
		// 	echo json_encode($data);
		// 	exit();
		// }
	}
}

/* End of file FeatureController.php */
