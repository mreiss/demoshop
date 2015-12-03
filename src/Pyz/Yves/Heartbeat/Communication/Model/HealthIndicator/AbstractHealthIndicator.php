<?php

namespace Pyz\Yves\Heartbeat\Communication\Model\HealthIndicator;

use Generated\Shared\Transfer\HealthReportTransfer;
use Generated\Shared\Transfer\HealthDetailTransfer;
use Generated\Shared\Transfer\HealthIndicatorReportTransfer;
use SprykerFeature\Shared\Heartbeat\Code\HealthIndicatorInterface;

abstract class AbstractHealthIndicator implements HealthIndicatorInterface
{

    /**
     * @var HealthReportTransfer
     */
    private $healthIndicatorReport;

    /**
     * @param HealthReportTransfer $healthReport
     */
    public function writeHealthReport(HealthReportTransfer $healthReport)
    {
        $healthReport->addHealthIndicatorReport($this->getHealthIndicatorReport());
    }

    /**
     * @param string $message
     */
    protected function addFailure($message)
    {
        $healthIndicatorReport = $this->getHealthIndicatorReport();
        $healthIndicatorReport->setStatus(false);

        $healthDetail = new HealthDetailTransfer();
        $healthDetail->setMessage($message);

        $healthIndicatorReport->addHealthDetail($healthDetail);
    }

    /**
     * @return HealthIndicatorReportTransfer
     */
    private function getHealthIndicatorReport()
    {
        if (!$this->healthIndicatorReport) {
            $this->healthIndicatorReport = new HealthIndicatorReportTransfer();
            $this->healthIndicatorReport->setName(get_class($this));
            $this->healthIndicatorReport->setStatus(true);
        }

        return $this->healthIndicatorReport;
    }

}
