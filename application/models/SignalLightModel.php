<?php

class SignalLightModel extends CI_Model
{

    public function getData()
    {
        $this->db->select("id, light_name, light_sequence, green_interval, yellow_interval");
        $query = $this->db->get("signal_lights");

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return [];
        }
    }

    public function saveLightData($data){
        $this->db->update_batch("signal_lights", $data, "id");
    }
}
