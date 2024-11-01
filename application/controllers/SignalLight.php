<?php

defined('BASEPATH') or exit('No direct script access allowed');

class SignalLight extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        header("Access-Control-Allow-Origin: *");

        $this->load->helper("general");
        $this->load->model("signalLightModel");
    }

    public function index()
    {
        $data['data'] = $this->signalLightModel->getData();

        $this->load->view("signal-light/index", $data);
    }

    public function saveData()
    {
        $light_seq = [1, 2, 3, 4];
        $return["success"] = true;
        $return["message"] = "Data saved successfully";

        $post               = $this->input->post();
        $lights             = $post['light'];
        $green_interval     = $post['green_interval'];
        $yellow_interval    = $post['yellow_interval'];

        try {
            $diff = array_diff($light_seq, $lights);
            if (count($diff) > 0) {
                throw new Exception("Same light sequence appiled multiple times!");
            }

            $update_data = array();



            foreach ($post['id'] as $key => $id) {
                $update_data[] = array(
                    "id" => $id,
                    "light_sequence"    => $lights[$key],
                    "green_interval"    => $green_interval,
                    "yellow_interval"   => $yellow_interval,
                    "updated_date"      => date("Y-m-d H:i:s")
                );
            }

            $this->signalLightModel->saveLightData($update_data);
        } catch (Exception $e) {
            $return["message"] = $e->getMessage();
            $return["success"] = false;
        }

        $post['green_interval'] = $green_interval * 1000;
        $post['yellow_interval'] = $yellow_interval * 1000;
        $return['data'] = $post;

        echo json_encode($return);
    }
}
