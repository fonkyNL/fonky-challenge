@extends('layouts.master')
<table class="table">
  <thead>
    <tr>
      <th scope="col">Employee</th>
      <th scope="col">Number of sells</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($employees as $name => $number)
    <tr>
      <td>{{ $name }}</td>
      <td>{{ $number }}</td>
      <td>
        <a href="{{ route('orders.show-employee-orders' , ['employee' => $name]) }}" class="fa-solid fa-eye fa-fw"></a>  
      </td>
    </tr>
    @endforeach
  </tbody>
</table>