<?php

class Campaigns {    
    
    private $campaignTable = 'crm_campaign';
    private $conn;
    
    public function __construct($db){
        $this->conn = $db;
    }        
        
    public function listCampaigns(){
        
        $sqlQuery = "SELECT * FROM ".$this->campaignTable;
        
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        $result = $stmt->get_result();    
        
        $campaigns = array();        
        while ($campaign = $result->fetch_assoc()) {               
            $campaigns[] = $campaign;
        }
        
        return $campaigns;
    }
    public function listActiveCampaigns(){
        $sqlQuery = "SELECT * FROM ".$this->campaignTable." WHERE status = 'Active'";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        $result = $stmt->get_result();
        $activeCampaigns = array();
        while ($campaign = $result->fetch_assoc()) {
            $activeCampaigns[] = $campaign;
        }
        return $activeCampaigns;
    }

    public function insertCampaign($name, $start_date, $end_date, $description, $status, $social_media, $admin_id){
        $sqlQuery = "INSERT INTO ".$this->campaignTable."(`name`, `start_date`, `end_date`, `description`, `status`, `social_media`, `admin_id`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("ssssssi", $name, $start_date, $end_date, $description, $status, $social_media, $admin_id);
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    

    public function getCampaign($campaign_id){
        $sqlQuery = "SELECT * FROM ".$this->campaignTable." WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("i", $campaign_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result;
    }

    public function updateCampaign($campaign_id, $name, $start_date, $end_date, $description, $status, $social_media){
        $sqlQuery = "UPDATE ".$this->campaignTable." SET `name` = ?, `start_date` = ?, `end_date` = ?, `description` = ?, `status` = ?, `social_media` = ? WHERE `id` = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("sssssii", $name, $start_date, $end_date, $description, $status, $social_media, $campaign_id);
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function deleteCampaign($campaign_id){
       
    
        $sqlQuery = "DELETE FROM ".$this->campaignTable." WHERE `id` = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("i", $campaign_id);
    
        if($stmt->execute()){
            // Check if any rows were affected by the deletion
            if ($stmt->affected_rows > 0) {
                return true; // Deletion successful
            } else {
                return false; // No rows affected, might mean the campaign doesn't exist
            }
        } else {
            // Handle any potential errors during execution
            // You might want to log the error for debugging purposes
            // For simplicity, I'll just return false here
            return false;
        }
    }
    

}
?>
