<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\ReportModel;
use Framework\TemplateEngine;
use App\Services\ValidatorService;
use Framework\HTTP;

class ReportController
{
    private TemplateEngine $view;
    private ReportModel $reportModel;
    private ValidatorService $validatorService;

    public function __construct(TemplateEngine $view, ReportModel $reportModel, ValidatorService $validatorService)
    {
        $this->view = $view;
        $this->reportModel = $reportModel;
        $this->validatorService = $validatorService;
    }

    public function sendReport()
    {
        // Middlewares: AuthRequiredMiddleware

        $this->validatorService->validateReportRequest($_POST);

        $reporterId = $_SESSION['user'];

        $this->reportModel->sendReport($reporterId, (int)$_POST['id'], (string)$_POST['type'], (string)$_POST['message']);

        echo json_encode([
            'status' => 'success',
            'code' => HTTP::OK_STATUS_CODE,
        ]);
    }
}
