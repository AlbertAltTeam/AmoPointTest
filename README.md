# Тестовое задание на вакансию разработчика(База)

3 Скрипт для отработки в консоле сайта


// Функция для отправки данных на сервер
function sendData(data) {
    fetch('https://albert.dev.alt-team.com/AmoPointTest/task_03/api/', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(data),
    })
    .then(response => {
      if (response.ok) {
        console.log('Данные успешно отправлены на сервер');
      } else {
        console.error('Ошибка отправки данных на сервер');
      }
    })
    .catch(error => {
      console.error('Ошибка отправки данных на сервер:', error);
    });
  }
  
  // Функция для получения информации о посетителе и отправки на сервер
  function trackVisit() {
    fetch('https://api.ipify.org?format=json')
      .then(response => response.json())
      .then(ipData => {
        const ip = ipData.ip;
        const userAgent = navigator.userAgent;
        let deviceType = 'Неизвестно';
  
        if (/Mobile/.test(userAgent) || /Android/.test(userAgent)) {
          deviceType = 'Смартфон';
        } else if (/Tablet/.test(userAgent) || /iPad/.test(userAgent)) {
          deviceType = 'Планшет';
        } else {
          deviceType = 'Компьютер';
        }
  
        sendData({ ip, device: deviceType });
      })
      .catch(error => {
        console.error('Ошибка получения IP-адреса:', error);
      });
  }
  
  // Вызов функции для отслеживания посещений при загрузке страницы
  trackVisit();




