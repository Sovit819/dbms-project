$(document).ready(function () {
  var campaignRecords = $("#campaignsListing").DataTable({
    lengthChange: false,
    processing: true,
    serverSide: true,
    bFilter: false,
    serverMethod: "post",
    order: [],
    ajax: {
      url: "campaign_action.php",
      type: "POST",
      data: { action: "listCampaigns" },
      dataType: "json",
    },
    columnDefs: [
      {
        targets: [0, 6, 7],
        orderable: false,
      },
    ],
    pageLength: 10,
  });

  $("#addCampaign").click(function () {
    $("#campaignModal").modal({
      backdrop: "static",
      keyboard: false,
    });
    $("#campaignForm")[0].reset();
    $("#campaignModal").on("shown.bs.modal", function () {
      $(".modal-title").html("<i class='fa fa-plus'></i> Add Campaign");
      $("#action").val("addCampaign");
      $("#save").val("Save");
    });
  });

  $("#campaignModal").on("submit", "#campaignForm", function (event) {
    event.preventDefault();
    $("#save").attr("disabled", "disabled");
    var formData = $(this).serialize();
    $.ajax({
      url: "campaign_action.php",
      method: "POST",
      data: formData,
      dataType: "json", // Expect JSON response
      success: function (response) {
        // Check if there's a message
        if (response.message) {
          alert(response.message); // Display the message
        }
        $("#campaignForm")[0].reset();
        $("#campaignModal").modal("hide");
        $("#save").attr("disabled", false);
        campaignRecords.ajax.reload();
      },
      error: function (xhr, status, error) {
        // Handle error
        console.log(xhr.responseText); // Log the error response
      },
    });
  });

  $("#campaignsListing").on("click", ".delete", function () {
    var id = $(this).attr("id");
    var action = "deleteCampaign";
    if (confirm("Are you sure you want to delete this record?")) {
      $.ajax({
        url: "campaign_action.php",
        method: "POST",
        data: { id: id, action: action },
        dataType: "json", // Expect JSON response
        success: function (response) {
          if (response.message) {
            alert(response.message); // Display the message
          }
          campaignRecords.ajax.reload();
        },
        error: function (xhr, status, error) {
          // Handle error
          console.log(xhr.responseText); // Log the error response
        },
      });
    } else {
      return false;
    }
  });
});
