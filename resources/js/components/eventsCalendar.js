
import { calender } from "@client/routes/client/events";
import axios from "axios";

export default function eventsCalendar(serverData, trans, startDate, endDate) {
    console.log(trans);
    
    return {
        startDate: new Date(startDate),
        endDate: new Date(endDate),
        currentStartDate: null,
        currentEndDate: null,
        weekDays: [],
        dayNames: trans.dayNames,
        monthNames: trans.monthNames,
        weekTitle: '',
        modalTitle: '',
        selectedDate: null,
        selectedEvents: [], // يجب أن تكون مصفوفة فارغة
        showModal: false,
        isPrevDisabled: false,
        isNextDisabled: false,
        trans: { no_events: trans.no_events, events_for: trans.events_for },
        serverDates: serverData.dates || {},
        isLoading: false,
        init() {
            let today = new Date(this.startDate);
            this.setWeek(today);
        },

        setWeek(date) {
            let day = date.getDay();
            let startOfWeek = new Date(date);
            startOfWeek.setDate(date.getDate() - day);

            if (startOfWeek < this.startDate) startOfWeek = new Date(this.startDate);

            this.weekDays = [];
            for (let i = 0; i < 7; i++) {
                let d = new Date(startOfWeek);
                d.setDate(startOfWeek.getDate() + i);
                if (d > this.endDate) break;

                let iso = d.toISOString().split('T')[0];
                let eventsCount = this.serverDates[iso] || 0;

                this.weekDays.push({
                    date: d,
                    iso,
                    dayName: this.dayNames[d.getDay()],
                    month: d.getMonth(),
                    year: d.getFullYear(),
                    eventsCount
                });
            }

            this.currentStartDate = this.weekDays.length ? this.weekDays[0].iso : null;
            this.currentEndDate = this.weekDays.length ? this.weekDays[this.weekDays.length - 1].iso : null;

            if (this.weekDays.length) {
                let first = this.weekDays[0];
                this.weekTitle = `${this.monthNames[first.month]} ${first.year}`;
            } else {
                this.weekTitle = '';
            }

            this.isPrevDisabled = (this.weekDays.length && this.weekDays[0].iso === this.startDate.toISOString().split('T')[0]);
            this.isNextDisabled = (this.weekDays.length && this.weekDays[this.weekDays.length - 1].iso === this.endDate.toISOString().split('T')[0]);
        },

        prev() {
            if (this.isPrevDisabled) return;
            let firstDay = new Date(this.weekDays[0].date);
            firstDay.setDate(firstDay.getDate() - 7);
            if (firstDay < this.startDate) firstDay = new Date(this.startDate);
            this.setWeek(firstDay);
        },

        next() {
            if (this.isNextDisabled) return;
            let lastDay = new Date(this.weekDays[this.weekDays.length - 1].date);
            lastDay.setDate(lastDay.getDate() + 1);
            if (lastDay > this.endDate) return;
            this.setWeek(lastDay);
        },

        async openDay(day) {
            this.selectedDate = day.date;
            this.modalTitle = `${this.trans.events_for} ${day.dayName}, ${day.date.getDate()} ${this.monthNames[day.month]}`;
            this.selectedEvents = [];

            try {
                this.isLoading = true;
                const response=await axios.get(calender().url, { params: { date: day.iso } });
                console.log(response.data);
                
                if (response.status === 200 && Array.isArray(response.data.event)) {
                    this.selectedEvents = response.data.event;
                    this.showModal = true;
                } else {
                    this.selectedEvents = [];
                }
            } catch (error) {
                console.error(error);
                this.selectedEvents = [];
            }finally{
                this.isLoading = false;
            }

        },

        isSelected(day) {
            return this.showModal && this.selectedDate && day.date.toISOString() === this.selectedDate.toISOString();
        }
    }
}