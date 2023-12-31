<?php
session_start();

// Проверяем, если пользователь не авторизован, перенаправляем на страницу входа
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Страница просмотра статистики</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Стили для контейнера с графиками */
        .charts-container {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        /* Стили для каждого графика */
        .chart {
            width: 45%;
            /* Ширина каждого графика */
        }

        /* Стили для верхней панели */
        .top-panel {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f0f0f0;
            padding: 10px 20px;
        }

        .logout-btn {
            padding: 8px 15px;
            background-color: #ff0000;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="top-panel">
        <?php
            // Проверяем, если пользователь залогинен, отображаем его имя и кнопку разлогина
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                echo '<div>Вы залогинены как ' . $_SESSION['username'] . '</div>';
                echo '<button class="logout-btn" onclick="logout()">Разлогиниться</button>';
            }
        ?>
    </div>
    <h1>Статистика посещений</h1>
    <div class="charts-container">
        <div class="chart">
            <canvas id="visitsByHourChart" width="400" height="300"></canvas>
        </div>
        <div class="chart">
            <canvas id="visitsByCityChart" width="400" height="300"></canvas>
        </div>
    </div>

    <script>
        function logout() {
            // Очистить данные сессии и перенаправить на страницу входа
            fetch('logout.php')
                .then(() => {
                    window.location.href = 'login.php';
                })
                .catch(error => {
                    console.error('Ошибка разлогина:', error);
                });
        }

 // Получение данных из PHP через AJAX
 fetch('get_visits_data.php')
            .then(response => response.json())
            .then(dataForJS => {
                let visitsByHourData = dataForJS['visitsByHour'];
                let visitsByCityData = dataForJS['visitsByCity'];

                let labelsHour = visitsByHourData.map(data => data.hour);
                let valuesHour = visitsByHourData.map(data => data.visits);
                let labelsCity = Object.keys(visitsByCityData);
                let valuesCity = Object.values(visitsByCityData);

                // Создание графика посещений по часам
                let ctxHour = document.getElementById('visitsByHourChart').getContext('2d');
                let visitsByHourChart = new Chart(ctxHour, {
                    type: 'line',
                    data: {
                        labels: labelsHour,
                        datasets: [{
                            label: 'Уникальные посещения за час',
                            data: valuesHour,
                            borderColor: 'blue',
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

                // Создание круговой диаграммы посещений по городам
                let ctxCity = document.getElementById('visitsByCityChart').getContext('2d');
                let visitsByCityChart = new Chart(ctxCity, {
                    type: 'doughnut',
                    data: {
                        labels: labelsCity,
                        datasets: [{
                            data: valuesCity,
                            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4CAF50', '#E91E63', '#9C27B0', '#03A9F4', '#FF5722', '#795548']
                        }]
                    }
                });
            })
            .catch(error => {
                console.error('Ошибка получения данных:', error);
            });
    </script>

</body>

</html>
