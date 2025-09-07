import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// fullcalendar
document.addEventListener('DOMContentLoaded', function () {
  const calendarEl = document.getElementById('calendar')

  const calendar = new Calendar(calendarEl, {
    plugins: [dayGridPlugin],
    initialView: 'dayGridMonth',

    headerToolbar: {
      left: 'title',
      center: 'prev,next today',
      right: 'dayGridMonth,dayGridWeek' // ← 月と週を切り替え
    }
  })

  calendar.render()
})
