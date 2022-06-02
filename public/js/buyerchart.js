const colors = [
    'rgba(255, 99, 132)',
    'rgba(54, 162, 235)',
    'rgba(255, 206, 86)',
    'rgba(75, 192, 192)',
    'rgba(153, 102, 255)',
    'rgba(255, 159, 64)'
];

let start = async () => {
    let response = await fetch('/api/buyers');
    let data = await response.json();
    data = data.orders;

    let ctx = document.getElementById('buyer-chart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: data.map(x => x.name),
            datasets: [{
                label: 'Buyers',
                data: data.map(x => parseInt(x.buyer_count)),
                backgroundColor: data.map(x => colors[parseInt(x.buyer_id) % colors.length]),
                borderWidth: 1
            }]
        },
    });
}
start();
