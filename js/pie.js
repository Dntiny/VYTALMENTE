const data = {
    labels: ['Ayuda Psicológica', 'Ayuda Nutricional'],
    datasets: [{
        data: [<?php echo $avg_psicologica; ?>, <?php echo $avg_nutricion; ?>],
        backgroundColor: ['gold', 'lightskyblue'],
    }]
};

const config = {
    type: 'pie',
    data: data,
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Promedio de Edad por Tipo de Ayuda'
            }
        }
    },
};

const myPieChart = new Chart(
    document.getElementById('myPieChart'),
    config
);