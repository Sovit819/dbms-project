<?php

include_once 'config/Database.php';
include_once 'class/Campaign.php';
include_once 'campaign.php';

$database = new Database();
$db = $database->getConnection();

$campaign = new Campaigns($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listCampaigns') {
    $campaign->listCampaigns();
    echo "$campaign";
}

if(!empty($_POST['action']) && $_POST['action'] == 'addCampaign') {   
    $campaign->name = $_POST["name"];
    $campaign->start_date = $_POST["start_date"];
    $campaign->end_date = $_POST["end_date"];
    $campaign->description = $_POST["description"];
    $campaign->status = $_POST["status"];
    $campaign->social_media = $_POST["social_media"];  
    // $campaign->insertCampaign($name, $start_date, $end_date, $description, $status, $social_media);
    // echo "Campaign added successfully"; 
    // $campaign->insertCampaign();
    // echo "$campaign";
    $result = $campaign->insertCampaign($name, $start_date, $end_date, $description, $status, $social_media);

    // Check the result of the insert operation and provide appropriate feedback
    if ($result) {
        echo "Campaign added successfully";
    } else {
        echo "Failed to add campaign";
    }
}

if(!empty($_POST['action']) && $_POST['action'] == 'getCampaign') {
    $campaign->id = $_POST["id"];
    $campaign->getCampaign();
}

if(!empty($_POST['action']) && $_POST['action'] == 'updateCampaign') {
    $campaign->id = $_POST["id"];
    $campaign->name = $_POST["name"];
    $campaign->start_date = $_POST["start_date"];
    $campaign->end_date = $_POST["end_date"];
    $campaign->description = $_POST["description"];
    $campaign->status = $_POST["status"];
    $campaign->social_media = $_POST["social_media"];
    $campaign->updateCampaign();
}

if (!empty($_POST['action']) && $_POST['action'] == 'deleteCampaign') {
    $campaignId = $_POST['id'];

    // Call the deleteCampaign method from your Campaigns class
    if ($campaign->deleteCampaign($campaignId)) {
        echo "Campaign deleted successfully";
    } else {
        echo "Failed to delete campaign";
    }
}
echo json_encode($response);
?>
