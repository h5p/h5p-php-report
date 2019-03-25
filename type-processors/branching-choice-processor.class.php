<?php

/**
 * Class BranchingChoiceProcessor
 * Processes and generates HTML report for 'choice' interaction type with no
 * correct answer.
 */
class BranchingChoiceProcessor extends TypeProcessor {

  /**
   * Determines options for interaction and generates a human readable HTML
   * report.
   *
   * @inheritdoc
   */
  public function generateHTML($description, $crp, $response, $extras = NULL, $scoreSettings = NULL) {
    // We need some style for our report
    $this->setStyle('styles/choice.css');

    $header = $this->generateHeader($description, $scoreSettings);
    $body = $this->generateBody($extras, $response);

    return
      '<div class="h5p-reporting-container h5p-choices-container">' .
        $header . $body .
      '</div>';
  }

  /**
   * Generate header element
   *
   * @param $description
   * @param $scoreSettings
   *
   * @return string
   */
  private function generateHeader($description, $scoreSettings) {
    $descriptionHtml = $this->generateDescription($description);
    $scoreHtml = $this->generateScoreHtml($scoreSettings);

    return
      "<div class='h5p-choices-header'>" .
        $descriptionHtml . $scoreHtml .
      "</div>";
  }

  /**
   * Generates description element
   *
   * @param string $description
   *
   * @return string Description element
   */
  private function generateDescription($description) {
    if (!$description) {
      return '';
    }

    return'<p class="h5p-reporting-description h5p-choices-task-description">'
          . $description .
          '</p>';
  }

  /**
   * Generates report body from words
   *
   * @param object $extras Additional information used to render report
   * @param int $response
   *
   * @return string Body element as a string
   */
  private function generateBody($extras, $response) {

    $choices = $extras->choices;
    $tableHeader =
      '<tr class="h5p-choices-table-heading">' .
        '<td class="h5p-choices-choice">Options</td>' .
        '<td class="h5p-choices-user-answer">Chosen</td>' .
      '</tr>';

    $rows = '';
    foreach ($choices as $choice) {
      $chosen = 'h5p-choices-user';
      if ($choice->id == $response) {
        $chosen = 'h5p-choices-answered h5p-choices-user-correct';
      }

      $row =
        '<td class="h5p-choices-alternative">' .
            $choice->description->{'en-US'} .
        '</td>' .
        '<td class="h5p-choices-icon-cell">' .
          '<span class="' . $chosen . '"></span>' .
        '</td>';

      $rows .= '<tr>' . $row . '</tr>';
    }

    $tableContent = '<tbody>' . $tableHeader . $rows . '</tbody>';
    return '<table class="h5p-choices-table">' . $tableContent . '</table>';
  }
}
