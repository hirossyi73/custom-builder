<?php

namespace CustomBuilder\Tests\Unit;

use Tests\TestCase;

class Test extends TestCase
{
    public function testCanConnection()
    {
        $this->assertTrue(\DB::canConnection());
    }

    public function testGetVersion()
    {
        $version = \DB::getVersion();

        $this->assertTrue(boolval(preg_match('/5\.7\.*/i', $version)));
        $this->assertFalse(boolval(preg_match('/5\.8\.*/i', $version)));
    }

    public function testColumnDefinitions()
    {
        $columns = \Schema::getColumnDefinitions('users');
        $this->_testColumnDefinitions($columns);
    }

    public function testColumnDefinitions2()
    {
        $columns = \DB::table('users')->getColumnDefinitions();
        $this->_testColumnDefinitions($columns);
    }

    public function testColumnDefinitions3()
    {
        $columns = \App\User::getColumnDefinitions();
        $this->_testColumnDefinitions($columns);
    }

    protected function _testColumnDefinitions($columns)
    {
        $result = true;

        if(!is_array($columns)){
            $result = false;
        }
        else{
            $anticipationColumns = [
                'id', 
                'name', 
                'email', 
                'password', 
                'remember_token', 
                'created_at', 
                'updated_at', 
            ];
            foreach($columns as $column){
                if(!in_array($column['column_name'], $anticipationColumns)){
                    $result = false;
                    break;
                }
            }   
        }

        $this->assertTrue($result);
    }
}
