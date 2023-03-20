<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends USER_Controller
{
    public function __construct()
    {        
        parent::__construct();
        $this->load->model('Account_model');
    }
    public function index_get()
    {
        $this->response(array('status' => 'success'));
    }

    public function user_get()
    {
        $token = generateToken(['email' => $this->user_data->email, 'user_id' => $this->user_data->id]);
        $response = array(
            'name' => $this->user_data->account_name,
            'email' => $this->user_data->email,
            "user_id" => $this->user_data->id
        );
        $this->response(array('status' => 'success', 'token' => $token, 'data' => $response));
    }
    
    public function building_get($data = false)
    {        
        $home = $this->Account_model->getHome($this->user_id);

        if($data) {
            $rooms = $this->Account_model->getRooms($home ? $home->id : '', $this->user_id, $data);
        }  else {
            $rooms = $this->Account_model->getRooms($home ? $home->id : '', $this->user_id);
        }

        $response = array(
            'home' => $home, 'rooms' => $rooms,
            'total_snag' => 0, 'total_safety_notice' => 0,
        );

        if($home->id) {
            $response['total_snag'] = $this->Account_model->totalSnags($home->id);
            $response['total_safety_notice'] = $this->Account_model->totalSafetyNotice($home->id);
        }
        $this->response(array('status' => 'success', 'data' => $response));
    }

    public function room_get($building)
    {
        $room = $this->Account_model->getRoomsByID($building, $this->user_id);
        $components = $this->Account_model->getComponents($room ? $room->id : '', $this->user_id);
        $response = array(
            'room' => $room,
            'components' => $components,
            'snags' => [],
            'safety_notice' => [],
        );

        if($room->id) {
            $response['snags'] = $this->Account_model->getSnags($room->id);
            $response['safety_notice'] = $this->Account_model->getSafetyNotices($room->id);
        }

        $this->response(array('status' => 'success', 'data' => $response));
    }
    public function component_get($room)
    {
        $component = $this->Account_model->getComponentsByID($room, $this->user_id);
        $response = array(
            'component' => $component,
        );
        $this->response(array('status' => 'success', 'data' => $response));
    }
    public function homehistory_get()
    {
        $home = $this->Account_model->getHome($this->user_id);

        $systems = $this->Account_model->getSystemCertificates($home->id);
        $systemsResult = [];
        foreach ($systems as $key => $sys) {
            $systemsResult[$key]['name'] = $sys->name;
            $systemsResult[$key]['certificates'] = [
                ["name" => "Systems Work Drive Folder URL", "link" => $sys->systems_work_drive_folder_url],
                ["name" => "System Electrical Certificate URL", "link" => $sys->system_electrical_certificate],
                ["name" => "System Survey Link", "link" => $sys->system_survey_link],
                ["name" => "System Test Link", "link" => $sys->system_test_link],
                ["name" => "System Plumbing Certificate URL", "link" => $sys->system_plumbing_certificate]
            ];
        }
        $rooms = $this->Account_model->getRoomCertificates($home->id);
        $roomsResult = [];
        foreach ($rooms as $key => $rm) {
            $roomsResult[$key]['name'] = $rm->name;
            $roomsResult[$key]['certificates'] = [
                ["name" => "Rooms Workdrive Folder URL", "link" => $rm->rooms_work_drive_folder_url],
                ["name" => "Room Electrical Certificate URL", "link" => $rm->room_electrical_certificate_url],
                ["name" => "Room Electrical Test Sheet URL", "link" => $rm->room_electrical_test_sheet_url],
                ["name" => "Room Survey Link", "link" => $rm->room_survey_link],
                ["name" => "Room Plumbing Test Sheet URL", "link" => $rm->room_plumbing_test_sheet_url],
                ["name" => "Room Test Link", "link" => $rm->room_test_link],
                ["name" => "Room Plumbing Certificate URL", "link" => $rm->room_plumbing_certificate_url]
            ];
        }
        $assets = $this->Account_model->getAssetCertificates($home->id);
        $assetsResult = [];
        foreach ($assets as $key => $ass) {
            $assetsResult[$key]['name'] = $ass->name;
            $assetsResult[$key]['certificates'] = [
                ["name" => "Assets Work Drive Folder URL", "link" => $ass->assets_work_drive_folder_url],
                ["name" => "Asset Mechanical Test Sheet URL", "link" => $ass->asset_mechanical_certificate],
                ["name" => "Assets Survey Link", "link" => $ass->assets_survey_link],
                ["name" => "Asset Mechanical Survey URL", "link" => $ass->asset_mechanical_survey_url],
                ["name" => "Assets Test Link", "link" => $ass->assets_test_link],
            ];
        }
        $components = $this->Account_model->getComponentCertificates($home->id);
        $componentsResult = [];
        foreach ($components as $key => $com) {
            $componentsResult[$key]['name'] = $com->name;
            $componentsResult[$key]['certificates'] = [
                ["name" => "Components Work Drive Folder URL", "link" => $com->components_work_drive_folder_url],
                ["name" => "Component Test Certificate URL", "link" => $com->component_test_certificate_url],
                ["name" => "Component Survey URL", "link" => $com->component_survey_url],
                ["name" => "Component Test Sheet URL", "link" => $com->component_test_sheet_url],
                ["name" => "Components Survey Link", "link" => $com->components_survey_link],
                ["name" => "Components Test Link", "link" => $com->components_test_link],
            ];
        }
        $response = array(
            'home' => $home,
            'systems'=>$systemsResult,
            'assets'=>$assetsResult,
            'rooms'=>$roomsResult,
            'components'=>$componentsResult
        );
        $this->response(array('status' => 'success', 'data' => $response));
    }
}
