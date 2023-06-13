@extends('layouts.master')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/chart.js') }}"></script>

<div class="d-flex justify-content-start">
  <div class="card" style="width: 18rem;">
    <div class="card-body">
      <h5 class="card-title">Orders</h5>
      <p class="card-text">view and modify your orders.</p>
      <a href="{{ route('orders.index') }}" class="btn btn-primary">Show orders</a>  
    </div>
  </div>
</div>

<div class="d-flex justify-content-start">
  <div class="card" style="width: 18rem;">
    <div class="card-body">
      <h5 class="card-title">Top ten Products</h5>
      <p class="card-text">know Your best sellers</p>
      <a href="" class="btn btn-primary">Show orders</a>  
    </div>
  </div>
</div>

<div class="d-flex justify-content-start">
  <div class="card" style="width: 18rem;">
    <div class="card-body">
      <h5 class="card-title">Top ten Employees</h5>
      <p class="card-text">See your best employees</p>
      <a href="" class="btn btn-primary">Show orders</a>  
    </div>
  </div>
</div>


<div class="d-flex justify-content-start">
<canvas id="salesChart"></canvas>
</div>

<script>
    // Retrieve the sells data from the PHP variable
    var sells = {!! json_encode($sells) !!};

    // Get the chart canvas element
    var ctx = document.getElementById('salesChart').getContext('2d');

    // Prepare the data for the chart
    var labels = Object.keys(sells);
    var data = Object.values(sells);

    // Create the chart using Chart.js
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Sales',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
