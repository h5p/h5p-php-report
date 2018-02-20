var $ = H5P.jQuery;

document.addEventListener("DOMContentLoaded", function(event) {

  var index = 0;
  var inputs = [];

  var container = document.getElementById("gradable-container");
  var results = container.querySelectorAll('.h5p-iv-open-ended-container');
  var currentQuestion = results[0];

  for (var i = 0; i < results.length; i++) {
    // Add a grading input to the container
    var inputDiv = document.createElement('div');
    var input = document.createElement('input');
    input.setAttribute('type', 'number');
    input.id = 'h5p-grade-input-' + i;

    var subcontent_id = results[i].getAttribute('h5p-report-data'); // Give it a more specific name
    input.subcontentID = subcontent_id;

    inputDiv.append(input);
    inputs.push(input);
    results[i].prepend(inputDiv);

    // Add counter to the title
    var titleCounter = document.createElement('div');
    titleCounter.innerHTML = 'Open-ended Question ' + (i + 1) + ' of 10';
    results[i].prepend(titleCounter);
  }

  // Populate the inputs with existing results
  inputs.forEach(function (input, index) {
    H5P.jQuery.get(data_for_page.getSubContentEndpoint, {subcontent_id : input.subcontentID}, function (grade) {
      var loadedInput = document.getElementById('h5p-grade-input-' + index);
      loadedInput.value = grade.data.score;
    });

    input.addEventListener('blur', function() {
      // Validate?
      // Post the results
      // Pass in max score
      H5P.jQuery.post(data_for_page.setSubContentEndpoint, {
        subcontent_id: input.subcontentID,
        score: this.value
      });
    });
  });

  // Initialize buttons
  container.querySelectorAll('.h5p-iv-open-ended-previous').forEach(function(button) {
    button.addEventListener("click", showPreviousQuestion);
  });

  container.querySelectorAll('.h5p-iv-open-ended-next').forEach(function(button) {
    button.addEventListener("click", showNextQuestion);
  });

  /**
   * showPreviousQuestion
   */
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

  /**
   * showNextQuestion
   */
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
