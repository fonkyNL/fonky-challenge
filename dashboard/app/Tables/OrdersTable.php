<?php

namespace App\Tables;

use App\Models\Order;
use Okipa\LaravelTable\Table;
use Okipa\LaravelTable\Column;

use Illuminate\Database\Eloquent\Builder;
use Okipa\LaravelTable\Abstracts\AbstractTableConfiguration;

class OrdersTable extends AbstractTableConfiguration
{
    protected function table(): Table
    {
        return Table::make()
            ->model(Order::class);
    }  

    protected function columns(): array
    {
        return [
            Column::make('id')->sortable(),
            Column::make('koper')->searchable()->sortable(),
            Column::make('created_at')->sortable(),
            Column::make('product'),
            Column::make('vestiging'),
            Column::make('verkoper'),
        ];
    }
}
