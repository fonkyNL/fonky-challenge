@extends('layouts.master')
<table class="table">
  <thead>
    <tr>
      <th scope="col">Employee</th>
      <th scope="col">Number of sells</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($employees as $name => $number)
    <tr>
      <td>{{ $name }}</td>
      <td>{{ $number }}</td>
    </tr>
    @endforeach
  </tbody>
</table>