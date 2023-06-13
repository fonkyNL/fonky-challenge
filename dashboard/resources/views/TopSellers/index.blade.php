@extends('layouts.master')
<table class="table">
  <thead>
    <tr>
      <th scope="col">Product</th>
      <th scope="col">Number of sells</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($products as $name => $number)
    <tr>
      <td>{{ $name }}</td>
      <td>{{ $number }}</td>
    </tr>
    @endforeach
  </tbody>
</table>