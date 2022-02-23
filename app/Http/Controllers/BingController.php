<?php

namespace App\Http\Controllers;

use App\ClickEvent;
use DateTimeZone;
use Illuminate\Http\Request;

class BingController extends Controller
{
  public function exportConversions()
  {
    $fileName = "bing_conv.csv";

    $respHeader = ['Microsoft Click ID', 'Conversion Name', 'Conversion Time', 'Conversion Value', 'Conversion Currency'];
    $clickEvents = ClickEvent::getClickEventsConversions();

    $file = fopen($fileName, 'w');
    fputcsv($file, ['### INSTRUCTIONS ###']);
    fputcsv($file, ['# Important: Remember to change the TimeZone value (GMT offset) in the "parameters" row']);
    fputcsv($file, ['# TimeZone values should be entered in HHMM format (e.g. New York is -0500 and Berlin is +0100. If you use Greenwich Mean Time, simply enter +0000).']);
    fputcsv($file, ['# Make sure you do not include additional columns. For more instructions on how to use this tempate, visit https://aka.ms/dk8o1y']);
    fputcsv($file, ['### TEMPLATE ###']);
    fputcsv($file, ['Parameters:TimeZone=+0100;']);
    fputcsv($file, $respHeader);

    foreach ($clickEvents as $clickEvent) {

      $parsedUrl = parse_url($clickEvent->id);
      if (!isset($parsedUrl['query'])) {
        continue;
      }

      $parsedUrl = parse_url($clickEvent->id);
      if (!isset($parsedUrl['query'])) {
        continue;
      }

      parse_str($parsedUrl['query'], $queryParams);
      if (!isset($queryParams['msclkid'])) {
        continue;
      }
      $date = new \DateTime($clickEvent->created_at, new DateTimeZone('Europe/Copenhagen'));
      fputcsv(
        $file,
        [
          $queryParams['msclkid'],
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
