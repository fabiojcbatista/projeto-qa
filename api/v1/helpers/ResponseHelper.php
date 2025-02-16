<?php
class ResponseHelper {
    protected function response($data, $statusCode = 200) {
        http_response_code($statusCode);
        echo json_encode(['data' => $data], JSON_UNESCAPED_UNICODE);
        exit;
    }

    protected function responseFail($data, $statusCode = 400) {
        http_response_code($statusCode);
        echo json_encode(['error' => $data], JSON_UNESCAPED_UNICODE);
        exit;
    }
}
