<?php

namespace App\Handler\Book;


use Illuminate\Support\Facades\Log;

class MoveImage extends AbstractHandler
{
    private $destDir;

    /**
     * MoveFile constructor.
     * @param $destDir
     */
    public function __construct($destDir)
    {
        $this->destDir = $destDir;
    }

    public function handle($jsonFile)
    {
        $bookId = microtime();
        $json = json_decode(file_get_contents($jsonFile));
        $imageName = basename($json[0]);

        $sourceDir = dirname($jsonFile) . '/' . $imageName;
        $destDir = $this->destDir . date('Y-m-d') . '/books/' . $bookId;
        if (!file_exists($destDir)) {
            mkdir($destDir, 0777, true);
        }
        try {
            copy($sourceDir, $destDir . '/' . $imageName);

            parent::handle(['json_file' => $jsonFile, 'image' => '/files/' . str_replace($this->destDir, '', $destDir) . '/' . $imageName]);
        } catch (\Exception $e) {
            Log::warning($this->destDir);
            Log::warning($destDir);
            Log::error($e->getMessage());
        }
    }

}