@extends('layouts.master')
@livewireStyles
@livewireScripts
<body> 
  @if(isset($product))
    <livewire:table :config="App\Tables\OrdersTable::class" :configParams="['productName' => $product]"/>
  @elseif(isset($employee))
    <livewire:table :config="App\Tables\OrdersTable::class" :configParams="['employeeName' => $employee]"/>
    employee
  @else
    <livewire:table :config="App\Tables\OrdersTable::class"/>
  @endif
</body>