/*
В данной задаче я предпочел использовать чистый JavaScript вместо дополнительных библиотек, таких как jQuery, по нескольким причинам.

Во-первых, моя задача, связанная со скрытием и отображением полей в зависимости от выбранного значения в списке select, относительно проста. Для этого использование нативного JavaScript достаточно эффективно и не требует дополнительных инструментов.

Кроме того, использование чистого JavaScript позволяет сократить объем загружаемых данных на странице. Без необходимости загружать дополнительные библиотеки, проект становится более легким и быстрым для пользователей, особенно если они не используются в других частях проекта.

Наконец, использование нативных средств JavaScript помогает мне лучше понимать принципы работы с DOM и улучшить навыки в программировании на языке JavaScript. Это также делает код более читаемым и обеспечивает большую гибкость при доработке проекта в будущем.

В целом, для этой конкретной задачи чистый JavaScript показался наиболее оптимальным выбором из-за своей простоты, эффективности и удобства.
*/

// Функция для скрытия всех полей input[type="text"], кроме выбранного
function hideAllFields(selectedValue) {
    document.querySelectorAll('input[type="text"]').forEach(function (input) {
        var name = input.getAttribute('name');
        if (name === 'input_' + selectedValue) {
            input.removeAttribute('style'); // Удаляем стили, если совпадает
        } else {
            input.style.display = 'none'; // Иначе скрываем стилем
        }
    });
}

// Функция для запуска основного скрипта
function runScript() {
    var typeValSelect = document.querySelector('select[name="type_val"]');

    // Обработчик изменения значения в select
    typeValSelect.addEventListener('change', function () {
        hideAllFields(this.value); // Скрываем все, кроме выбранного
    });

    hideAllFields(typeValSelect.value); // Изначально скрываем все, кроме выбранного
}

// Проверяем, выполнено ли событие DOMContentLoaded
if (document.readyState === 'loading') {
    // Если нет, добавляем обработчик
    document.addEventListener('DOMContentLoaded', runScript);
} else {
    // Если уже выполнено, запускаем скрипт сразу
    runScript();
}

