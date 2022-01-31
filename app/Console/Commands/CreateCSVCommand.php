<?php

namespace App\Console\Commands;

use App\CsvData;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use http\Client\Response;

class CreateCSVCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a CSV testing File';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $contacts = factory(CsvData::class, 10)->make();

        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment; filename=download.csv',
            'Expires' => '0',
            'Pragma' => 'public',
        ];

        if (!File::exists(base_path()."/csvFiles")) {
            File::makeDirectory(base_path()."/csvFiles");
        }

        $filename =  base_path("csvFiles/contacts.csv");
        $csvHandler = fopen($filename, 'w');

        foreach ($contacts as $contact) {
            fputcsv($csvHandler, [
                $contact->team_id,
                $contact->name,
                $contact->phone,
                $contact->email,
                $contact->sticky_phone_number_id,
                $contact->city,
                $contact->zip,
                $contact->country,
                $contact->currency,
            ]);

        }
        fclose($csvHandler);

        $this->info('CSV created!');

        response()->download($filename, 'contacts.csv', $headers);

        return 0;
    }
}
