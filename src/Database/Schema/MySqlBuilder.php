<?php

namespace CustomBuilder\Database\Schema;

use Illuminate\Database\Schema\MySqlBuilder as BaseBuilder;

class MySqlBuilder extends BaseBuilder
{
    // \Schema::XXXXXX()関数の形式 -------------------------------------------

    /**
     * Get database version.
     *
     * @return void
     */
    public function getVersion()
    {
        $results = $this->connection->selectFromWriteConnection($this->grammar->compileGetVersion());

        return $this->connection->getPostProcessor()->processGetVersion($results);
    }

    /**
     * Get the table listing
     *
     * @return array
     */
    public function getTableListing()
    {
        $results = $this->connection->selectFromWriteConnection($this->grammar->compileGetTableListing());

        return $this->connection->getPostProcessor()->processTableListing($results);
    }

    /**
     * Get column difinitions
     *
     * @return array
     */
    public function getColumnDefinitions($table)
    {
        $baseTable = $table;
        $table = $this->connection->getTablePrefix().$table;
        $results = $this->connection->selectFromWriteConnection($this->grammar->compileColumnDefinitions($table));

        return $this->connection->getPostProcessor()->processColumnDefinitions($baseTable, $results);
    }
}
