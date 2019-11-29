<?php

namespace CustomBuilder\Database\Eloquent;

use Illuminate\Database\Eloquent\Builder as BaseBuilder;

class MySqlBuilder extends BaseBuilder
{
    // \User::XXXXXX()関数の形式 -------------------------------------------
    
    /**
     * Get column difinitions
     *
     * @return array
     */
    public function getColumnDefinitions()
    {
        $table = $this->model->getTable();
        $connection = $this->query->connection;

        $results = $connection->selectFromWriteConnection($connection->getQueryGrammar()->compileColumnDefinitions($table));
        return $connection->getPostProcessor()->processColumnDefinitions($table, $results);
    }

}
