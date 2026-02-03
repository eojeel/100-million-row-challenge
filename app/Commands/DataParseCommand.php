<?php

namespace App\Commands;

use App\Parser;
use Tempest\Console\ConsoleCommand;
use Tempest\Console\HasConsole;
use function Tempest\env;

final class DataParseCommand
{
    use HasConsole;

    #[ConsoleCommand]
    public function __invoke(
        string $inputPath = __DIR__ . '/../../data/data.csv',
        string $outputPath = __DIR__ . '/../../data/data.json',
    ): void {
        $startTime = microtime(true);

        new Parser()->parse($inputPath, $outputPath);

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        $branchName = exec('git branch --show-current');

        $leaderBoardEntry = time() . ';' . $branchName . ';' . $executionTime;
        $leaderBoardFile = fopen(__DIR__ . '/../../leaderboard.csv', 'a');
        fwrite($leaderBoardFile, $leaderBoardEntry . PHP_EOL);
        fclose($leaderBoardFile);

        $this->success($leaderBoardEntry);
    }
}