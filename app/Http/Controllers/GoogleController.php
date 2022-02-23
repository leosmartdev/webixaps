<?php

namespace App\Http\Controllers;

use App\ClickEvent;
use DateTimeZone;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
  public function exportConversions()
  {
    $fileName = "conv.csv";

    $respHeader = ['Google Click ID', 'Conversion Name', 'Conversion Time', 'Conversion Value', 'Conversion Currency'];
    $clickEvents = ClickEvent::getClickEventsConversions();

    $file = fopen($fileName, 'w');
    fputcsv($file, ['Parameters:TimeZone=Europe/Copenhagen;']);
    fputcsv($file, $respHeader);

    foreach ($clickEvents as $clickEvent) {

      $parsedUrl = parse_url($clickEvent->id);
      if (!isset($parsedUrl['query'])) {
        continue;
      }

      parse_str($parsedUrl['query'], $queryParams);
      if (!isset($queryParams['gclid'])) {
        continue;
      }
      $date = new \DateTime($clickEvent->created_at, new DateTimeZone('Europe/Copenhagen'));
      fputcsv(
        $file,
        [
          $queryParams['gclid'],
          'Affiliatesale',
          $date->format('m/d/Y H:i:s'),
          number_format($clickEvent->payout, 0),
          $clickEvent->currency,
        ]
      );
    }
    fclose($file);

    $headers = [
      "Content-type" => "text/csv",
    ];

    return response()->download($fileName, $fileName, $headers);
  }
}
