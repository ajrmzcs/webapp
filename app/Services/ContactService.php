<?php

namespace App\Services;

use App\Contact;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ContactService
{
    public static function store(array $contacts, array $columns): array
    {
        try {
            DB::beginTransaction();
            $mappedColumns = self::mapColumns($columns);

            $records = self::buildRecordSets($contacts, $mappedColumns);

            // Insert new contacts and their custom attributes
            $totalRecords = 0;
            $totalCustoms = 0;
            foreach ($records as $record) {
                $newContact = Contact::create($record['main']);
                $totalRecords++;

                foreach ($record['custom'] as $key => $value) {
                    $newContact->customAttributes()->create([
                        'key' => $key,
                        'value' => $value,
                    ]);
                    $totalCustoms++;
                }
            }
            DB::commit();

            return [
                'success' => true,
                'totalNewContacts' => $totalRecords,
                'totalNewCustoms' => $totalCustoms,
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    private static function mapColumns(array $columns): array
    {
        // Map DB columns (main) without timeStamps
        $timestampColumns = [
            'created_at',
            'updated_at',
        ];

        $dbColumns = array_filter(Schema::getColumnListing('contacts'), function ($dbColumn) use ($timestampColumns) {
            return !in_array($dbColumn, $timestampColumns);
        });

        // Map main and custom attributes
        $result = [
            'main' => [],
            'custom' => [],
        ];
        foreach ($columns as $key => $value) {
            if (in_array($value, $dbColumns)) {
                $result['main'][$key] = $value;
                continue;
            }
            $result['custom'][$key] = $value;
        }

        // @TODO: Similar approach, we could test which one is more efficient
//        $main = array_filter($columns, function ($column) use ($dbColumns) {
//            return in_array($column, $dbColumns);
//        });
//
//        $custom = array_filter($columns, function ($column) use ($main) {
//            return !in_array($column, $main);
//        });

        return $result;
    }

    private static function buildRecordSets(array $contacts, array $mappedColumns): array
    {
        $records = [];
        foreach ($contacts as $contact) {
            $mainAttrs = [];
            $customAttrs = [];
            foreach ($contact as $key => $value) {
                if (in_array($key, array_keys($mappedColumns['main']))) {
                    $mainAttrs[$mappedColumns['main'][$key]] = $value;
                } elseif(isset($mappedColumns['custom'][$key])) {
                    $customAttrs[$mappedColumns['custom'][$key]] = $value;
                }
            }
            $records[] = [
                'main' => $mainAttrs,
                'custom' => $customAttrs,
            ];
        }
        return $records;
    }
}
