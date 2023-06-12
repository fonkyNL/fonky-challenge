@extends('layouts.master')
@livewireStyles
@livewireScripts
  <body> 
    <livewire:table :config="App\Tables\OrdersTable::class"/>
  </body>