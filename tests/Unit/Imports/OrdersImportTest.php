<?php

namespace Tests\Unit\Imports;

use App\Imports\OrdersImport;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class OrdersImportTest extends TestCase
{
    use DatabaseTransactions;

    protected OrdersImport $ordersImport;

    protected function setUp(): void
    {
        parent::setUp();

        $this->ordersImport = new OrdersImport();
    }

    public function testItPreparesTheValidation()
    {
        $data = [
            'id' => 82479,
            'koper' => 'S. Schippers',
            'datum_tijd' => '08/12/2020 18:43',
            'product' => 'D12,5',
            'vestiging_verkoper' => 'Nijmegen / Esther Oostland',
        ];

        $preparedData = $this->ordersImport->prepareForValidation($data);

        $this->assertEquals($preparedData['vestiging'], 'Nijmegen');
        $this->assertEquals($preparedData['verkoper'], 'Esther Oostland');
        $this->assertArrayNotHasKey('vestiging_verkoper', $preparedData);
    }

    public function testItValidatesTheId()
    {
        $rules = $this->ordersImport->rules();

        $data = [
            [
                'no_id' => 'It is required',
            ],
            [
                'id' => 'It is required',
            ],
            [
                'id' => 80085,
            ],
        ];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->errors()->has('0.id'));
        $this->assertTrue($validator->errors()->has('1.id'));
        $this->assertFalse($validator->errors()->has('2.id'));
    }

    public function testItValidatesTheBuyer()
    {
        $rules = $this->ordersImport->rules();
        $data = [
            [
                'no_koper' => 'It is required',
            ],
            [
                'koper' => 1,
            ],
            [
                'koper' => fake()->realTextBetween(256, 500),
            ],
            [
                'koper' => fake()->realTextBetween(1, 255),
            ],
        ];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->errors()->has('0.koper'));
        $this->assertTrue($validator->errors()->has('1.koper'));
        $this->assertTrue($validator->errors()->has('2.koper'));
        $this->assertFalse($validator->errors()->has('3.koper'));
    }

    public function testItValidatesTheDate()
    {
        $rules = $this->ordersImport->rules();
        $data = [
            [
                'no_datum_tijd' => 'It is required',
            ],
            [
                'datum_tijd' => 1,
            ],
            [
                'datum_tijd' => '01/01/1900 00:00',
            ],
            [
                'datum_tijd' => today()->addDay()->format('d/m/Y H:i'),
            ],
            [
                'datum_tijd' => '25/10/2000 12:23',
            ],
        ];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->errors()->has('0.datum_tijd'));
        $this->assertTrue($validator->errors()->has('1.datum_tijd'));
        $this->assertTrue($validator->errors()->has('2.datum_tijd'));
        $this->assertTrue($validator->errors()->has('3.datum_tijd'));
        $this->assertFalse($validator->errors()->has('4.datum_tijd'));
    }

    public function testItValidatesTheProduct()
    {
        $rules = $this->ordersImport->rules();
        $data = [
            [
                'no_product' => 'It is required',
            ],
            [
                'product' => 1,
            ],
            [
                'product' => fake()->realTextBetween(260, 500),
            ],
            [
                'product' => '25/10/2000 12:23',
            ],
        ];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->errors()->has('0.product'));
        $this->assertTrue($validator->errors()->has('1.product'));
        $this->assertTrue($validator->errors()->has('2.product'));
        $this->assertFalse($validator->errors()->has('3.product'));
    }

    public function testItValidatesTheBranch()
    {
        $rules = $this->ordersImport->rules();
        $data = [
            [
                'no_vestiging' => 'It is required',
            ],
            [
                'vestiging' => fake()->realTextBetween(260, 500),
            ],
            [
                'vestiging' => 'This is ok',
            ],
        ];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->errors()->has('0.vestiging'));
        $this->assertTrue($validator->errors()->has('1.vestiging'));
        $this->assertFalse($validator->errors()->has('2.vestiging'));
    }

    public function testItValidatesTheEmployee()
    {
        $rules = $this->ordersImport->rules();
        $data = [
            [
                'no_verkoper' => 'It is required',
            ],
            [
                'verkoper' => fake()->realTextBetween(260, 500),
            ],
            [
                'verkoper' => 'This is ok',
            ],
        ];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->errors()->has('0.verkoper'));
        $this->assertTrue($validator->errors()->has('1.verkoper'));
        $this->assertFalse($validator->errors()->has('2.verkoper'));
    }

    public function testItCanSplitTheBranchAndEmployee()
    {
        $branchAndName = 'Arnhem / Kevin Test';

        $this->assertEquals(
            ['Arnhem', 'Kevin Test'],
            $this->ordersImport->splitBranchAndName($branchAndName)
        );
    }

    public function testItCanImportTheData()
    {
        Excel::import(new OrdersImport, 'tests/stubs/orders.csv');

        $this->assertDatabaseCount('orders', 4);
    }
}
