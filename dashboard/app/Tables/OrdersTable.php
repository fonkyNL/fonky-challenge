<?php

namespace App\Tables;

use App\Models\Order;
use App\Tables\RowActions\DestroyAction;
use Okipa\LaravelTable\Table;
use Okipa\LaravelTable\Column;
use Okipa\LaravelTable\RowActions\EditRowAction;
use Okipa\LaravelTable\RowActions\ShowRowAction;
use Okipa\LaravelTable\RowActions\DestroyRowAction;
use Okipa\LaravelTable\HeadActions\CreateHeadAction;
use Illuminate\Database\Eloquent\Builder;
use Okipa\LaravelTable\Abstracts\AbstractTableConfiguration;

class OrdersTable extends AbstractTableConfiguration
{
    protected function table(): Table
    {
        return Table::make()
            ->model(Order::class)
            ->headAction(new CreateHeadAction(route('orders.create')))
            ->rowActions(fn(Order $order) => [
                new ShowRowAction(route('orders.show', $order)),
                new EditRowAction(route('orders.edit', $order)),
                new DestroyAction('orders/destroy'.$order)
            ]);
    }

    protected function columns(): array
    {
        return [
            Column::make('id')
                ->title('ID')
                ->sortable(),
            Column::make('koper')
                ->title('koper')
                ->searchable()
                ->sortable(),
            Column::make('product')
                ->title('product')
                ->searchable(),
            Column::make('vestiging')
                ->title('vestiging'),
            Column::make('verkoper')
                ->title('verkoper'),
            Column::make('created_at')
                ->title('created_at')
                ->sortable()
        ];
    }
    
}
