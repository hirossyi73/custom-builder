<?php

namespace CustomBuilder\Database\Query;

use Illuminate\Database\Query\Builder as BaseBuilder;

class MySqlBuilder extends BaseBuilder
{
    // \DB::table('user')::XXXXXX()関数の形式 -------------------------------------------
    
    /**
     * Get column difinitions
     *
     * @return array
     */
    public function getColumnDefinitions()
    {
        $results = $this->connection->selectFromWriteConnection($this->grammar->compileColumnDefinitions($this->from));

        return $this->connection->getPostProcessor()->processColumnDefinitions($this->from, $results);
    }

}
