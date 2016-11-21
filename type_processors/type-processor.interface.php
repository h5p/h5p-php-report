<?php

/**
 * Class TypeProcessor
 */
abstract class TypeProcessor {

  /**
   * Generate HTML for report
   *
   * @param $xapiData
   *
   * @return string HTML as string
   */
  public function generateReport($xapiData) {

    // Grab description
    $description = $this->getDescription($xapiData);

    // Grab correct response pattern
    $crp = $this->getCRP($xapiData);

    // Grab extras
    $extras = $this->getExtras($xapiData);

    // No correct reponse patterns, use description
    if (empty($crp)) {
      return $description;
    }

    return $this->generateHTML(
      $description,
      $crp,
      $this->getResponse($xapiData),
      $extras
    );
  }

  /**
   * Decode extras from xAPI data.
   *
   * @param $xapiData
   *
   * @return mixed
   */
  protected function getExtras($xapiData) {
    if (!isset($xapiData['extras'])) {
      return null;
    }

    return json_decode($xapiData['extras']);
  }

  /**
   * Decode and retrieve 'en-US' description from xAPI data.
   *
   * @param $xapiData
   *
   * @return string Description as a string
   */
  protected function getDescription($xapiData) {
    return json_decode($xapiData['description']);
  }

  /**
   * Decode and retrieve Correct Responses Pattern from xAPI data.
   *
   * @param $xapiData
   *
   * @return array Correct responses pattern as an array
   */
  protected function getCRP($xapiData) {
    $decoded = json_decode($xapiData['correct_responses_pattern']);
    $crp     = (array) $decoded;
    return $crp;
  }

  /**
   * Decode and retrieve user response from xAPI data.
   *
   * @param $xapiData
   *
   * @return string User response
   */
  protected function getResponse($xapiData) {
    return json_decode($xapiData['response']);
  }

  /**
   * Processes xAPI data and returns a human readable HTML report
   *
   * @param string $description Description
   * @param array $crp Correct responses pattern
   * @param string $response User given answer
   * @param object $extras Additional data
   *
   * @return string HTML for the report
   */
  abstract function generateHTML($description, $crp, $response, $extras);
}
