<?php

namespace CustomBuilder\Database\Query\Grammars;

use Illuminate\Database\Query\Grammars\MySqlGrammar as BaseGrammar;

class MySqlGrammar extends BaseGrammar
{
    /**
     * Compile the query to get column difinitions
     *
     * @return string
     */
    public function compileColumnDefinitions($tableName)
    {
        return "show columns from {$this->wrapTable($tableName)}";
    }

}
