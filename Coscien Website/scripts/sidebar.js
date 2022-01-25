$("#side-prerequisites").click(function() {
  $("#sidebar-indicate1").removeClass("hidden");
  $("#sidebar-indicate4").addClass("hidden");
  $("#sidebar-indicate2").addClass("hidden");
  $("#sidebar-indicate3").addClass("hidden");
  $("#prerequisites").removeClass("hidden");
  $("#instructors").addClass("hidden");
  $("#timeline").addClass("hidden");
  $("#projects").addClass("hidden");
  $("#side-prerequisites").addClass("selected");
  $("#side-instructors").removeClass("selected");
  $("#side-timeline").removeClass("selected");
  $("#side-projects").removeClass("selected");
})

$("#side-instructors").click(function() {
  $("#sidebar-indicate1").addClass("hidden");
  $("#sidebar-indicate4").removeClass("hidden");
  $("#sidebar-indicate2").addClass("hidden");
  $("#sidebar-indicate3").addClass("hidden");
  $("#prerequisites").addClass("hidden");
  $("#instructors").removeClass("hidden");
  $("#timeline").addClass("hidden");
  $("#projects").addClass("hidden");
  $("#side-prerequisites").removeClass("selected");
  $("#side-instructors").addClass("selected");
  $("#side-timeline").removeClass("selected");
  $("#side-projects").removeClass("selected");
})

$("#side-timeline").click(function() {
  $("#sidebar-indicate1").addClass("hidden");
  $("#sidebar-indicate4").addClass("hidden");
  $("#sidebar-indicate2").removeClass("hidden");
  $("#sidebar-indicate3").addClass("hidden");
  $("#prerequisites").addClass("hidden");
  $("#instructors").addClass("hidden");
  $("#timeline").removeClass("hidden");
  $("#projects").addClass("hidden");
  $("#side-prerequisites").removeClass("selected");
  $("#side-instructors").removeClass("selected");
  $("#side-timeline").addClass("selected");
  $("#side-projects").removeClass("selected");
})

$("#side-projects").click(function() {
  $("#sidebar-indicate1").addClass("hidden");
  $("#sidebar-indicate4").addClass("hidden");
  $("#sidebar-indicate2").addClass("hidden");
  $("#sidebar-indicate3").removeClass("hidden");
  $("#prerequisites").addClass("hidden");
  $("#instructors").addClass("hidden");
  $("#timeline").addClass("hidden");
  $("#projects").removeClass("hidden");
  $("#side-prerequisites").removeClass("selected");
  $("#side-instructors").removeClass("selected");
  $("#side-timeline").removeClass("selected");
  $("#side-projects").addClass("selected");
})
