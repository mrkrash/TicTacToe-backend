<?php
declare(strict_types=1);

namespace Mrkrash\TicTacToe;

use Throwable;

/**
 * @return mixed[]
 */
function exception_to_array(Throwable $exception): array
{
    $singleToArray = function (Throwable $exception) {
        return [
          'message' => $exception->getMessage(),
          'code' => $exception->getCode(),
          'type' => get_class($exception),
          'file' => $exception->getFile(),
          'line' => $exception->getLine(),
          'trace' => explode("\n", $exception->getTraceAsString()),
          'previous' => [],
        ];
    };

    $result = $singleToArray($exception);
    $last = $exception;

    while ($last = $last->getPrevious()) {
        $result['previous'][] = $singleToArray($last);
    }

    return $result;
}
