const SLIDES = $(".slide");
const DOTS = $(".slide-btn");
const TITLE = $(".banner-title");

function nextSlide() {
  /* TODO: Replace TODO_CSS_HIDDEN_CLASS with the name of the class you will use to hide the non-active slides (i.e. `hidden`). */
  let nextNum = SLIDES.index($(".slide:not(.hidden)")) + 1 + 1; /* +1 for 0-index array */
  if (nextNum > SLIDES.length) {
    nextNum = 1;
  }
  showSlide(nextNum);
}

/* See "show previous slide snippet" to use */
function prevSlide() {
  /* TODO: Replace TODO_CSS_HIDDEN_CLASS with the name of the class you will use to hide the non-active slides (i.e. `hidden`). */
  let prevNum = SLIDES.index($(".slide:not(.hidden)")) - 1 + 1; /* +1 for 0-index array */
  if (prevNum <= 0) {
    prevNum = SLIDES.length;
  }
  showSlide(prevNum);
}

/* See "show slide X snippet" to use */
function showSlide(num) {
  let index = num - 1;
  let currentSlide = SLIDES.eq(index);
  let currentDot = DOTS.eq(index);
  let currentTitle= TITLE.eq(index);


  /* TODO: snippets to hide SLIDES and then show currentSlide
           Use `SLIDES` or `currentSlide` as the "Access Element Snippet"
           (e.g. `SLIDES.addClass()` or `currentSlide.removeClass()`) */

  SLIDES.addClass("hidden");
  currentSlide.removeClass("hidden");

  DOTS.removeClass("current-btn");
  currentDot.addClass("current-btn");

  TITLE.addClass("hidden");
  currentTitle.removeClass("hidden");


}



$("#next-button").click(function() {
  nextSlide()

});


$("#previous-button").click(function() {
  prevSlide()

});


$("#slide-btn1").click(function() {
  showSlide(1)

});

$("#slide-btn2").click(function() {
  showSlide(2)

});
