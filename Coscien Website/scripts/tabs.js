$("#left-tab").click(function() {
    $("#mid-tab").removeClass("indicate")
    $("#right-tab").removeClass("indicate")
    $("#left-tab").addClass("indicate")
    $("#reviews").addClass("hidden")
    $("#syllabus").addClass("hidden")
    $("#overview").removeClass("hidden")
});

$("#mid-tab").click(function() {
    $("#left-tab").removeClass("indicate")
    $("#right-tab").removeClass("indicate")
    $("#mid-tab").addClass("indicate")
    $("#overview").addClass("hidden")
    $("#syllabus").addClass("hidden")
    $("#reviews").removeClass("hidden")
});

$("#right-tab").click(function() {
    $("#left-tab").removeClass("indicate")
    $("#mid-tab").removeClass("indicate")
    $("#right-tab").addClass("indicate")
    $("#overview").addClass("hidden")
    $("#reviews").addClass("hidden")
    $("#syllabus").removeClass("hidden")
});
