<?php

/**
 * Class H5PReport
 * @property  fillInProcessor
 */
class H5PReport {

  private static $processorMap = array(
    'fill-in' => 'FillInProcessor',
    'true-false' => 'TrueFalseProcessor',
    'matching' => 'MatchingProcessor'
  );

  private $processors = array();

  /**
   * Generate the proper report depending on xAPI data.
   *
   * @param $xapiData
   *
   * @return string A report
   */
  public function generateReport($xapiData) {
    $interactionType = json_decode($xapiData['interaction_type']);

    if (!isset(self::$processorMap[$interactionType])) {
      return ''; // No processor found
    }

    if (!isset($this->processors[$interactionType])) {
      // Not used before. Initialize new processor
      $this->processors[$interactionType] = new self::$processorMap[$interactionType]();
    }

    // Generate and return report from xAPI data
    return $this->processors[$interactionType]->generateReport($xapiData);
  }
}
