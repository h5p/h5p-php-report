document.addEventListener("DOMContentLoaded", function(event) {

  var index = 0;

  var container = document.getElementById("gradable-container");
  var results = container.querySelectorAll('.h5p-iv-open-ended-container');
  var currentQuestion = results[0];

  // Add counter to the title
  for (var i = 0; i < results.length; i++) {
    var titleCounter = document.createElement('div');
    titleCounter.innerHTML = 'Open-ended Question ' + (i + 1) + ' of 10';
    results[i].prepend(titleCounter);
  }


  // Initialize buttons
  container.querySelectorAll('.h5p-iv-open-ended-previous').forEach(function(button) {
    button.addEventListener("click", showPreviousQuestion);
  });

  container.querySelectorAll('.h5p-iv-open-ended-next').forEach(function(button) {
    button.addEventListener("click", showNextQuestion);
  });

  function showPreviousQuestion() {
    if (index === 0) {
      return;
    }

    currentQuestion.classList.remove('h5p-iv-open-ended-visible');
    currentQuestion.classList.add('h5p-iv-open-ended-hidden');

    index -= 1;
    currentQuestion = results[index];
    currentQuestion.classList.remove('h5p-iv-open-ended-hidden');
    currentQuestion.classList.add('h5p-iv-open-ended-visible');
  }

  function showNextQuestion() {
    if (index == results.length-1) {
      return;
    }

    currentQuestion.classList.remove('h5p-iv-open-ended-visible');
    currentQuestion.classList.add('h5p-iv-open-ended-hidden');

    index += 1;
    currentQuestion = results[index];
    currentQuestion.classList.remove('h5p-iv-open-ended-hidden');
    currentQuestion.classList.add('h5p-iv-open-ended-visible');
  }
});
