<?php
include_once 'config/Database.php';
include_once 'class/Campaign.php';

$database = new Database();
$db = $database->getConnection();

$campaign = new Campaign($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listCampaign') {
	$campaign->listCampaign();
}

if(!empty($_POST['action']) && $_POST['action'] == 'addCampaign') {	
	$campaign->name = $_POST["name"];
    $campaign->start_date = $_POST["start_date"];
	$campaign->end_date = $_POST["end_date"];
	$campaign->description = $_POST["description"];
	$campaign->status = $_POST["status"];
	$campaign->insert();
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
	$campaign->update();
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteCampaign') {
	$campaign->id = $_POST["id"];
	$campaign->delete();
}
?>
