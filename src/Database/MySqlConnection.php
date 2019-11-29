<?php

namespace CustomBuilder\Database;

use CustomBuilder\Database\Query\Grammars\MySqlGrammar as QueryGrammar;
use CustomBuilder\Database\Schema\Grammars\MySqlGrammar as SchemaGrammar;
use CustomBuilder\Database\Schema\MySqlBuilder;
use CustomBuilder\Database\Query\MySqlBuilder as QueryBuilder;
use CustomBuilder\Database\Eloquent\MySqlBuilder as EloquentBuilder;
use CustomBuilder\Database\Query\Processors\MySqlProcessor;
use Illuminate\Database\MySqlConnection as BaseConnection;

class MySqlConnection extends BaseConnection
{
    /**
     * Get a schema builder instance for the connection.
     *
     * @return Builder
     */
    public function getSchemaBuilder()
    {
        if (is_null($this->schemaGrammar)) {
            $this->useDefaultSchemaGrammar();
        }

        return new MySqlBuilder($this);
    }

    /**
     * Get the default schema grammar instance.
     *
     * @return MySqlGrammar
     */
    protected function getDefaultSchemaGrammar()
    {
        return $this->withTablePrefix(new SchemaGrammar);
    }
    
    /**
     * Get the default query grammar instance.
     *
     * @return QueryGrammar
     */
    protected function getDefaultQueryGrammar()
    {
        return $this->withTablePrefix(new QueryGrammar);
    }

    /**
     * Get the default post processor instance.
     *
     * @return MySqlProcessor
     */
    protected function getDefaultPostProcessor()
    {
        return new MySqlProcessor;
    }

    /**
     * Get a new query builder instance.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return new QueryBuilder(
            $this, $this->getQueryGrammar(), $this->getPostProcessor()
        );
    }

    /**
     * Get a new eloquent query builder instance.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function eloquentBuilder($query)
    {
        return new EloquentBuilder($query);
    }

    
    // \DB::XXXXXX()関数はここで記載 -------------------------------------------
    public function canConnection()
    {
        try {
            $this->getSchemaBuilder()->getTableListing();
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }
    
    /**
     * Get database version.
     *
     * @return void
     */
    public function getVersion()
    {
        return $this->getSchemaBuilder()->getVersion();
    }
}
