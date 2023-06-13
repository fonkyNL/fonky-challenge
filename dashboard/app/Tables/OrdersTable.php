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
    public string $productName;
    public string $employeeName;

    protected function table(): Table
    {
        $table = Table::make()
            ->model(Order::class)
            ->headAction(new CreateHeadAction(route('orders.create')))
            ->rowActions(fn(Order $order) => [
                new ShowRowAction(route('orders.show', $order)),
                new EditRowAction(route('orders.edit', $order)),
                new DestroyAction('orders/destroy'.$order)
            ]);

        if(isset($this->productName)){
            $table->query(fn(Builder $query) => $query->where('product', $this->productName));
        }

        else if(isset($this->employeeName)){
            $table->query(fn(Builder $query) => $query->where('koper', $this->employeeName));
        }

        return $table;
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
                ->sortable()
                ->searchable(),
            Column::make('vestiging')
                ->title('vestiging')
                ->sortable()
                ->searchable(),
            Column::make('verkoper')
                ->title('verkoper')
                ->sortable()
                ->searchable(),
            Column::make('created_at')
                ->title('created_at')
                ->sortable()
                ->searchable()
        ];
    }
    
}
