<?php

/**
 * Class FillInProcessor
 * Processes and generates HTML report for 'fill-in' interaction type.
 */
class TrueFalseProcessor extends TypeProcessor {

  /**
   * Determines options for interaction and generates a human readable HTML
   * report.
   *
   * @param string $description Description of interaction task
   * @param array $crp Correct responses pattern
   * @param string $response User response
   *
   * @return string HTML for report
   */
  public function generateHTML($description, $crp, $response) {
    return "Correct Answer: {$crp[0]}<br/>User Answer: {$response}";
  }
}
