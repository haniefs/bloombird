$(document).ready(function() {
  $("#submit").click(function() {
    var company = $("#company").val();
    console.log(company);
    if (company == "null") {
      alert("Please select a comany to proceed!");
    }
    else {
      $.ajax({
        url: "bloomberg.php",
        type: "POST",
        data: {
          company: company
        },
        beforeSend: function() {
          console.log("request sent.")
        },
        success: function(res) {
          console.log(res);
        },
        error: function() {
          console.log("error occured.");
        }
      });
    }
  });
});