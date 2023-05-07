$("#ueberschrift2").hide();
$(document).ready(function() {
    console.log("ready!");
    $("#ueberschrift2").fadeIn("slow");
    //after 4 seconds
    setTimeout(function() {
        $("#infoDiv").fadeOut("slow");
    }, 4000);
  });

