<?php

namespace Bs\Traits {
  trait JsonControllerTrait {

    private static function sendSuccess($data) {
      self::send('success', $data);
    }

    private static function sendError($code, $message, $data = []) {
      self::send('error', array_replace($data, ['error' => ['code' => $code, 'message' => $message]]));
    }

    private static function send($status, $data = []) {
      echo json_encode(array_replace($data, ['status' => $status]));
      exit();
    }
  }
}