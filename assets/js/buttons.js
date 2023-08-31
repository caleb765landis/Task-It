/**************************************
 TITLE: buttons.js
 AUTHOR: Caleb Landis (CL)
 CREATE DATE: 9/4/2022
 PURPOSE: Change backgrounds for buttons during selection changes
 LAST MODIFIED ON: 9/4/2022
 LAST MODIFIED BY: Caleb Landis (CL)
 Modification History:
 9/4/2022: Original Build (CL)
 ***************************************/

$(document).ready(function() {
  // change css for when female radio is selected
  $("#female").click(function() {
    $("#femaleLabel").addClass("active");
    $("#maleLabel").removeClass("active");
    $("#male").prop("checked", false);
  }); // end on female click

  // change css for when female radio is selected
  $("#male").click(function() {
    $("#maleLabel").addClass("active");
    $("#femaleLabel").removeClass("active");
    $("#female").prop("checked", false);
  }); // end on male click

  $("#student").click(function() {
    if ($(this).is(":checked")) {
      $("#studentLabel").addClass("active");
    } else {
      $("#studentLabel").removeClass("active");
    } // end if
  }); // end on student click

  $("#faculty").click(function() {
    if ($(this).is(":checked")) {
      $("#facultyLabel").addClass("active");
    } else {
      $("#facultyLabel").removeClass("active");
    } // end if
  }); // end on faculty click

  $("#staff").click(function() {
    if ($(this).is(":checked")) {
      $("#staffLabel").addClass("active");
    } else {
      $("#staffLabel").removeClass("active");
    } // end if
  }); // end on staff click

});
