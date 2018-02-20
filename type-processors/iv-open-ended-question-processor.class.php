<?php

/**
 * Class FillInProcessor
 * Processes and generates HTML report for 'fill-in' interaction type.
 */
class IVOpenEndedQuestionProcessor extends TypeProcessor {

  function __construct() {
    $this->counter = 0;
  }

  /**
   * Determines options for interaction and generates a human readable HTML
   * report.
   *
   * @inheritdoc
   */
  public function generateHTML($description, $crp, $response, $extras, $scoreSettings = NULL) {
    // We need some style for our report
    $this->setStyle('styles/iv-open-ended.css');

    // Send the subcontent id to the view so it can render and grade the correct content
    $container =
      '<div class="h5p-iv-open-ended-container ' . ($this->counter == 0 ? "h5p-iv-open-ended-visible" : "h5p-iv-open-ended-hidden") . '" h5p-report-data=' . $extras->subcontent_id . '>' .
        $description .
        '<div class="h5p-iv-open-ended-response-container">' .
          $response .
        '</div>' .
        '<div class="h5p-iv-open-ended-previous"><a><=</a></div>' .
        '<div class="h5p-iv-open-ended-next"><a>=></a></div>' .
      '</div>';

    $this->counter++;

    return $container;
  }
}
