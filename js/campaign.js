$(document).ready(function () {
  var campaignRecords = $("#campaignListing").DataTable({
    lengthChange: false,
    processing: true,
    serverSide: true,
    bFilter: false,
    serverMethod: "post",
    order: [],
    ajax: {
      url: "campaign_action.php",
      type: "POST",
      data: { action: "listCampaign" },
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

  $("#campaignListing").on("click", ".update", function () {
    var id = $(this).attr("id");
    var action = "getCampaign";
    $.ajax({
      url: "campaign_action.php",
      method: "POST",
      data: { id: id, action: action },
      dataType: "json",
      success: function (data) {
        $("#campaignModal")
          .on("shown.bs.modal", function () {
            $("#campaign_id").val(data.id);
            $("#campaign_name").val(data.name);
            $("#campaign_desc").val(data.description);
            $("#campaign_start_date").val(data.start_date);
            $("#campaign_end_date").val(data.end_date);
            $("#campaign_status").val(data.status);
            $(".modal-title").html("<i class='fa fa-plus'></i> Edit Campaign");
            $("#action").val("updateCampaign");
            $("#save").val("Save");
          })
          .modal({
            backdrop: "static",
            keyboard: false,
          });
      },
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
      success: function (data) {
        $("#campaignForm")[0].reset();
        $("#campaignModal").modal("hide");
        $("#save").attr("disabled", false);
        campaignRecords.ajax.reload();
      },
    });
  });

  $("#campaignListing").on("click", ".delete", function () {
    var id = $(this).attr("id");
    var action = "deleteCampaign";
    if (confirm("Are you sure you want to delete this record?")) {
      $.ajax({
        url: "campaign_action.php",
        method: "POST",
        data: { id: id, action: action },
        success: function (data) {
          campaignRecords.ajax.reload();
        },
      });
    } else {
      return false;
    }
  });
});
