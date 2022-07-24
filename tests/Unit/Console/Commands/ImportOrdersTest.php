<?php

namespace Tests\Unit\Console\Commands;

use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class ImportOrdersTest extends TestCase
{
    public function testItCanStartTheImport()
    {
        Excel::fake();

        $this->artisan('orders:import tests/stubs/orders.csv')
            ->assertSuccessful();

        Excel::assertImported('tests/stubs/orders.csv');
    }

    public function testItThrowsAnErrorWhenTheFileCanNotBeFound()
    {
        $this->artisan('orders:import unknowfile.idontexist')
            ->expectsOutput('Could not find the given file')
            ->assertFailed();
    }
}
