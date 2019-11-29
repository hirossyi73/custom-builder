<?php

namespace CustomBuilder\Database\Query\Processors;

use Illuminate\Database\Query\Processors\MySqlProcessor as BaseMySqlProcessor;

class MySqlProcessor extends BaseMySqlProcessor
{
    /**
     * Process the results of a get version.
     *
     * @param  array  $results
     * @return array
     */
    public function processGetVersion($results)
    {
        $versionArray = $this->versionAray($results);

        return $versionArray[0];
    }

    protected function versionAray($results)
    {
        $version = collect(collect($results)->first())->first();
        return explode('-', $version);
    }

    /**
     * Process the results of a table listing query.
     *
     * @param  array  $results
     * @return array
     */
    public function processTableListing($results)
    {
        return array_map(function ($result) {
            return collect((object) $result)->first();
        }, $results);
    }
    
    /**
     * Process the results of a Column Definitions query.
     *
     * @param  array  $results
     * @return array
     */
    public function processColumnDefinitions($tableName, $results)
    {
        return collect($results)->map(function ($result) use ($tableName) {
            return [
                'table_name' => $tableName,
                'column_name' => $result->Field,
                'type' => $result->Type,
                'nullable' => boolval($result->Null),
                'virtual' => strtoupper($result->Extra) == 'VIRTUAL GENERATED',
            ];
        })->toArray();
    }
    
}
