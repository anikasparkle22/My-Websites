var btn = document.getElementsByClassName("collapse");

btn[0].addEventListener("click", function () {
    var content = this.parentNode.nextElementSibling;
    if (content.style.display === "block") {
        content.style.display = "none";
    } else {
        content.style.display = "block";
    }
});
