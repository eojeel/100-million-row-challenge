<?php
namespace App;

final class Parser
{
    public function parse(string $inputPath, string $outputPath): void
    {
        $file = fopen($inputPath, 'r');

        $data = [];

        while($line = fgets($file)) {

            [$uri, $date] = explode(',', trim($line));

            $path = parse_url($uri, PHP_URL_PATH);

            $dateformat = date('Y-m-d', strtotime($date));
            $data[$path][$dateformat] = ($data[$path][$dateformat] ?? 0) + 1;
        }

        foreach($data as &$uri)
        {
            ksort($uri);
        }

        fclose($file);

        file_put_contents($outputPath, json_encode($data, JSON_PRETTY_PRINT));
    }
}
