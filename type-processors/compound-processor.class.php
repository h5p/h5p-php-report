<?php

/**
 * Class FillInProcessor
 * Processes and generates HTML report for 'fill-in' interaction type.
 */
class CompoundProcessor extends TypeProcessor {

  /**
   * Determines options for interaction and generates a human readable HTML
   * report.
   *
   * @inheritdoc
   */
  public function generateHTML($description, $crp, $response, $extras, $scoreSettings = NULL) {
    // We need some style for our report
    $this->setStyle('styles/compound.css');

    $H5PReport = H5PReport::getInstance();
    $reports = '';

    if (!empty($extras->children)) {

      // Generate a grading container if gradable content types exist
      $reports .= $H5PReport->generateGradableReports($extras->children);

      // Do not render gradable content types in their own containers
      $extras->children = $H5PReport->stripGradableChildren($extras->children);

      foreach ($extras->children as $childData) {
        $rep = $H5PReport->generateReport($childData, null, $this->disableScoring);
        if ($rep) {
          $reports .=
            '<div class="h5p-result">' .
            $rep .
            '</div>';
        }
      }
    }

    // Do not display description when children is empty
    if (!empty($reports) && !empty($description)) {
      $reports =
          '<p class="h5p-reporting-description h5p-compound-task-description">' .
            $description .
          '</p>' .
          $reports;
    }

    if (empty($reports)) {
      return '';
    }
    else {
      return '<div class="h5p-reporting-container h5p-compound-container">' .
               $reports .
             '</div>';
    }
  }
}
