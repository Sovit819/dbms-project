<?php
include_once 'config/Database.php';
include_once 'class/Campaign.php';

$database = new Database();
$db = $database->getConnection();

$campaign = new Campaign($db);

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'listCampaign':
        echo json_encode($campaign->listCampaigns());
        break;
    case 'addCampaign':
        $name = $_POST['name'] ?? '';
        $start_date = $_POST['start_date'] ?? '';
        $end_date = $_POST['end_date'] ?? '';
        $description = $_POST['description'] ?? '';
        $status = $_POST['status'] ?? '';

        if (!empty($name) && !empty($start_date) && !empty($end_date) && isset($status)) {
            $result = $campaign->insertCampaign($name, $start_date, $end_date, $description, $status);
            echo $result ? "Campaign added successfully" : "Failed to add campaign";
        } else {
            echo "Missing required fields for adding campaign";
        }
        break;
    case 'updateCampaign':
        $id = $_POST['id'] ?? '';
        $name = $_POST['name'] ?? '';
        $start_date = $_POST['start_date'] ?? '';
        $end_date = $_POST['end_date'] ?? '';
        $description = $_POST['description'] ?? '';
        $status = $_POST['status'] ?? '';

        if (!empty($id) && !empty($name) && !empty($start_date) && !empty($end_date) && isset($status)) {
            $result = $campaign->updateCampaign($id, $name, $start_date, $end_date, $description, $status);
            echo $result ? "Campaign updated successfully" : "Failed to update campaign";
        } else {
            echo "Missing required fields for updating campaign";
        }
        break;
    case 'deleteCampaign':
        $id = $_POST['id'] ?? '';
        if (!empty($id)) {
            $result = $campaign->deleteCampaign($id);
            echo $result ? "Campaign deleted successfully" : "Failed to delete campaign";
        } else {
            echo "Missing campaign ID for deleting campaign";
        }
        break;
    default:
        echo "Invalid action";
}
?>
