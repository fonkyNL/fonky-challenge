const colors = [
    'rgba(255, 99, 132)',
    'rgba(54, 162, 235)',
    'rgba(255, 206, 86)',
    'rgba(75, 192, 192)',
    'rgba(153, 102, 255)',
    'rgba(255, 159, 64)'
];

let test = async () => {
    let response = await fetch('/api/products');
    let data = await response.json();
    data = data.orders;

    let ctx = document.getElementById('product-chart').getContext('2d');
    let chart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: data.map(x => x.name),
            datasets: [{
                label: 'Products',
                data: data.map(x => parseInt(x.product_count)),
                backgroundColor: data.map(x => colors[parseInt(x.product_id) % colors.length]),
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
}
test();