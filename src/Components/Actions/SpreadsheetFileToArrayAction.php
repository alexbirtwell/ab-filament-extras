<?php

namespace App\Actions;

use App\Services\CsvFileProcessor;
use Illuminate\Http\UploadedFile;
use Lorisleiva\Actions\Concerns\AsAction;

class SpreadsheetFileToArrayAction
{
    use AsAction;

    private CsvFileProcessor $csvFileProcessor;

    public function __construct(CsvFileProcessor $csvFileProcessor)
    {
        $this->csvFileProcessor = $csvFileProcessor;
    }

    public function handle(UploadedFile $file)
    {
        return $this->csvFileProcessor->read($file);
    }
}
