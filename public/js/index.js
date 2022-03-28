var Labels = new Array();
var Amounts = new Array();

$(function () {
    $.get("/orders/chart",
        function (response) {
            console.log(response);
            response.forEach(data => {
                Labels.push(data.product);
                Amounts.push(data.amount);
            });
            
            const ctx = document.getElementById('canvas').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: Labels,
                    datasets: [{
                        label: 'Aantal Producten Verkocht',
                        data: Amounts,
                        borderWidth: 1,
                    }]
                }
            })
        }
    );
});