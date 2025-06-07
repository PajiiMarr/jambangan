import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';

document.addEventListener('DOMContentLoaded', function() {
    let bookedRanges = window.bookedRanges || [];
    var calendarEl = document.getElementById('public-bookings-calendar');
    var calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin],
        initialView: 'dayGridMonth',
        selectable: true,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth'
        },
        height: 'auto',
        selectAllow: function(selectInfo) {
            const today = new Date();
            today.setHours(0,0,0,0);
            if (new Date(selectInfo.startStr) < today) {
                return false;
            }
            function toDateString(date) {
                return date.toISOString().slice(0, 10);
            }
            let selStart = new Date(selectInfo.startStr);
            let selEnd = new Date(selectInfo.endStr);
            selEnd.setDate(selEnd.getDate() - 1);
            let selectedDays = [];
            let d = new Date(selStart);
            while (d <= selEnd) {
                selectedDays.push(toDateString(d));
                d.setDate(d.getDate() + 1);
            }
            for (let range of bookedRanges) {
                let bookedStart = new Date(range.start);
                let bookedEnd = new Date(range.end);
                let currentDay = new Date(bookedStart);
                while (currentDay <= bookedEnd) {
                    if (selectedDays.includes(toDateString(currentDay))) {
                        return false;
                    }
                    currentDay.setDate(currentDay.getDate() + 1);
                }
            }
            return true;
        },
        dayCellDidMount: function(info) {
            const cellDate = new Date(info.date);
            cellDate.setHours(0, 0, 0, 0);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const dayNumberEl = info.el.querySelector('.fc-daygrid-day-number');
            
            // Base styling for calendar cells
            info.el.classList.add(
                'transition-all', 
                'duration-200', 
                'ease-in-out',
                'dark:bg-[#1a1a1a]',
                'bg-white'
            );

            if (cellDate < today) {
                info.el.classList.add(
                    'bg-gray-100', 
                    'dark:bg-gray-900', 
                    'cursor-not-allowed',
                    'opacity-50'
                );
                if (dayNumberEl) dayNumberEl.classList.add(
                    'text-gray-400', 
                    'dark:text-gray-600'
                );
                return;
            }
            let isBooked = false;
            for (const range of bookedRanges) {
                const startDate = new Date(range.start);
                startDate.setHours(0,0,0,0);
                const endDate = new Date(range.end);
                endDate.setHours(0,0,0,0);
                if (cellDate >= startDate && cellDate <= endDate) {
                    isBooked = true;
                    break;
                }
            }
            if (isBooked) {
                info.el.classList.add(
                    'bg-red-100', 
                    'dark:bg-red-900/30', 
                    'cursor-not-allowed', 
                    'opacity-75'
                );
                if (dayNumberEl) dayNumberEl.classList.add(
                    'text-red-500', 
                    'dark:text-red-300'
                );
            } else {
                info.el.classList.add(
                    'hover:bg-yellow-50', 
                    'dark:hover:bg-yellow-900/20', 
                    'cursor-pointer'
                );
            }
        },
        select: function(info) {
            document.getElementById('modal_booking_start_date').value = info.startStr;
            
            let endDate = new Date(info.endStr);
            endDate.setDate(endDate.getDate() - 1);
            document.getElementById('modal_booking_end_date').value = endDate.toISOString().slice(0, 10);
            
            document.getElementById('modal_booking_start_date').dispatchEvent(new Event('input'));
            document.getElementById('modal_booking_end_date').dispatchEvent(new Event('input'));
        },
        viewClassNames: function(view) {
            return [
                'dark:bg-[#121212]',
                'dark:text-gray-200',
                'text-gray-900'
            ];
        }
    });
    calendar.render();

    document.addEventListener('input', function(e) {
        if (e.target && e.target.id === 'modal_booking_start_date') {
            var startDate = e.target.value;
            var endDateInput = document.getElementById('modal_booking_end_date');
            if (!endDateInput.value || endDateInput.value < startDate) {
                endDateInput.value = startDate;
                endDateInput.dispatchEvent(new Event('input'));
            }
        }
    });
});