<?php

/**
 * Class FillInProcessor
 * Processes and generates HTML report for 'fill-in' interaction type.
 */
class ChoiceProcessor extends TypeProcessor {

  /**
   * Determines options for interaction and generates a human readable HTML
   * report.
   *
   * @param string $description Description of interaction task
   * @param array $crp Correct responses pattern
   * @param string $response User response
   * @param stdClass $extras Optional xAPI properties like choice descriptions
   * @return string HTML for report
   */
  public function generateHTML($description, $crp, $response, $extras = NULL) {

    // Get correct answers
    $correctAnswers = self::getChoiceList($crp, $extras);

    // Get user answers
    $userAnswers = self::getChoiceList($response, $extras);

    return "Correct Answer: {$correctAnswers}<br/>User Answer: {$userAnswers}";
  }

  /**
   * Generate comma separated list from xAPI choice list
   *
   * @param string $xAPIchoices Special format
   * @param stdClass $extras Contains choice descriptions
   * @param string HTML
   */
  private static function getChoiceList($xAPIchoices, $extras) {
    $choices = explode('[,]', $xAPIchoices);
    $HTML = '';

    foreach ($choices as $choice) {
      $HTML .= (empty($HTML) ? '' : ',') . self::getChoiceDescription($choice, $extras);
    }
  }

  /**
   * Fetch the description for the given choice identifier.
   *
   * @param int $id Choice identifier
   * @param stdClass $extras Contains choice descriptions
   * @return string Descripton
   */
  private static function getChoiceDescription($id, $extras) {
    foreach ($extras->choices as $choice) {
      if ($choice->id == $id) {
        return $choice->description->{'en-US'};
      }
    }
  }
}
