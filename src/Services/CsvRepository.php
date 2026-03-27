<?php

namespace GameLib\Services;

use GameLib\Models\Game;

/**
 * CSV Repository - Loads games from CSV file
 *
 * @package GameLib\Services
 * @author ESGI Project Team
 * @version 1.0.0
 */
class CsvRepository
{
    private string $csvPath;

    /**
     * Constructor
     */
    public function __construct(string $csvPath)
    {
        $this->csvPath = $csvPath;
    }

    /**
     * Load all games from CSV
     */
    public function loadAll(): array
    {
        $games = [];

        if (!file_exists($this->csvPath)) {
            return $games;
        }

        $file = fopen($this->csvPath, 'r');
        $headers = fgetcsv($file);

        if (!$headers) {
            fclose($file);
            return $games;
        }

        while (($row = fgetcsv($file)) !== false) {
            // Skip empty rows
            if (empty(array_filter($row)) || count($row) !== count($headers)) {
                continue;
            }

            $data = array_combine($headers, $row);
            if ($data !== false) {
                $games[] = new Game($data);
            }
        }

        fclose($file);
        return $games;
    }
}
