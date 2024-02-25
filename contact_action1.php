<?php
include_once 'config/Database.php';
include_once 'class/Campaign.php';

$database = new Database();
$db = $database->getConnection();

$campaign = new Campaign($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        switch ($action) {
            case 'listCampaign':
                listCampaign();
                break;
            case 'addCampaign':
                addCampaign();
                break;
            case 'getCampaign':
                getCampaign();
                break;
            case 'updateCampaign':
                updateCampaign();
                break;
            case 'deleteCampaign':
                deleteCampaign();
                break;
            default:
                echo "Invalid action";
        }
    } else {
        echo "Action parameter is not set";
    }
} else {
    echo "Invalid request method";
}

function listCampaign() {
    global $campaign;
    $campaigns = $campaign->listCampaigns();
    echo json_encode($campaigns);
}

function addCampaign() {
    global $campaign;
    // Extract data from POST request and insert into database
    // Sample code:
    // $campaign->insertCampaign($_POST['name'], $_POST['start_date'], $_POST['end_date'], $_POST['description'], $_POST['status'], $_POST['social_media']);
    // echo "Campaign added successfully";
}

function getCampaign() {
    global $campaign;
    if (!empty($_POST['id'])) {
        $campaign_id = $_POST["id"];
        $campaignData = $campaign->getCampaign($campaign_id);
        echo json_encode($campaignData);
    }
}

function updateCampaign() {
    global $campaign;
    // Extract data from POST request and update the campaign in the database
    // Sample code:
    // $campaign->updateCampaign($_POST['id'], $_POST['name'], $_POST['start_date'], $_POST['end_date'], $_POST['description'], $_POST['status'], $_POST['social_media']);
    // echo "Campaign updated successfully";
}

function deleteCampaign() {
    global $campaign;
    if (!empty($_POST['id'])) {
        $campaign_id = $_POST["id"];
        if ($campaign->deleteCampaign($campaign_id)) {
            echo "Campaign deleted successfully";
        } else {
            echo "Failed to delete campaign";
        }
    }
}
?>
