<?php

namespace App\Controller;

use App\Model\Log;

class LogController {
    private $log;

    public function __construct(Log $model) {
        $this->log = $model;
    }

    public function read() {
        $result = $this->log->getAllLogs();

        http_response_code(200);;
        echo json_encode($result);
    }
}