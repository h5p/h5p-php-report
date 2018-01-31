<?php

/**
 * Class H5PReport
 * @property  fillInProcessor
 */
class H5PReport {

  private static $processorMap = array(
    'compound' => 'CompoundProcessor',
    'fill-in' => 'FillInProcessor',
    'true-false' => 'TrueFalseProcessor',
    'matching' => 'MatchingProcessor',
    'choice' => 'ChoiceProcessor',
    'long-choice' => 'LongChoiceProcessor',
  );

  private static $contentTypeExtension = 'https://h5p.org/x-api/h5p-machine-name';

  public static $contentTypeProcessors = array(
    'H5P.DocumentationTool' => 'DocumentationToolProcessor',
    'H5P.GoalsPage' => 'GoalsPageProcessor',
    'H5P.GoalsAssessmentPage' => 'GoalsAssessmentPageProcessor',
    'H5P.StandardPage' => 'StandardPageProcessor',
  );

  private $processors = array();

  /**
   * Generate the proper report depending on xAPI data.
   *
   * @param object $xapiData
   * @param string $forcedProcessor Force a processor type
   * @param bool $disableScoring Disables scoring for the report
   *
   * @return string A report
   */
  public function generateReport($xapiData, $forcedProcessor = null, $disableScoring = false) {
    $interactionType = $xapiData->interaction_type;

    $contentTypeProcessor = self::getContentTypeProcessor($xapiData);
    if (isset($contentTypeProcessor)) {
      $interactionType = $contentTypeProcessor;
    }

    if (isset($forcedProcessor)) {
      $interactionType = $forcedProcessor;
    }

    if (!isset(self::$processorMap[$interactionType]) && !isset(self::$contentTypeProcessors[$interactionType])) {
      return ''; // No processor found
    }

    if (!isset($this->processors[$interactionType])) {
      // Not used before. Initialize new processor
      if (array_key_exists($interactionType, self::$contentTypeProcessors)) {
        $this->processors[$interactionType] = new self::$contentTypeProcessors[$interactionType]();
      }
      else {
        $this->processors[$interactionType] = new self::$processorMap[$interactionType]();
      }
    }

    // Generate and return report from xAPI data
    return $this->processors[$interactionType]
      ->generateReport($xapiData, $disableScoring);
  }

  /**
   * List of CSS stylesheets used by the processors when rendering the report.
   *
   * @return array
   */
  public function getStylesUsed() {
    $styles = array(
      'styles/shared-styles.css'
    );

    // Fetch style used by each report processor
    foreach ($this->processors as $processor) {
      $style = $processor->getStyle();
      if (!empty($style)) {
        $styles[] = $style;
      }
    }

    return $styles;
  }

  /**
   * Caches instance of report generator.
   * @return \H5PReport
   */
  public static function getInstance() {
    static $instance;

    if (!$instance) {
      $instance = new H5PReport();
    }

    return $instance;
  }

  /**
   * Attempts to retrieve content type processor from xapi data
   * @param object $xapiData
   *
   * @return string|null Content type processor
   */
  private static function getContentTypeProcessor($xapiData) {
    if (!isset($xapiData->additionals)) {
      return null;
    }

    $extras = json_decode($xapiData->additionals);

    if (!isset($extras->extensions) || !isset($extras->extensions->{self::$contentTypeExtension})) {
      return null;
    }

    $processor = $extras->extensions->{self::$contentTypeExtension};
    if (!array_key_exists($processor, self::$contentTypeProcessors)) {
      return null;
    }

    return $processor;
  }
}
