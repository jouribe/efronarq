const MONTH_NAMES = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
const DAYS = ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']

function datePicker() {
    return {
        showDatepicker: false,
        datepickerValue: '',

        month: '',
        year: '',
        no_of_days: [],
        blankdays: [],
        days: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],

        initDate() {
            let today = new Date()
            this.month = today.getMonth()
            this.year = today.getFullYear()
            this.datepickerValue = new Date(this.year, this.month, today.getDate()).toDateString()
        },

        isToday(date) {
            const today = new Date()
            const d = new Date(this.year, this.month, date)

            return today.toDateString() === d.toDateString()
        },

        getDateValue(date) {
            let selectedDate = new Date(this.year, this.month, date)
            this.datepickerValue = selectedDate.toDateString()

            this.$refs.date.value = selectedDate.getFullYear() + '-' + ('0' + selectedDate.getMonth()).slice(-2) + '-' + ('0' + selectedDate.getDate()).slice(-2)

            console.log(this.$refs.date.value)

            this.showDatepicker = false
        },

        getNoOfDays() {
            let daysInMonth = new Date(this.year, this.month + 1, 0).getDate()

            // find where to start calendar day of week
            let dayOfWeek = new Date(this.year, this.month).getDay()
            let blankdaysArray = []
            for (let i = 1; i <= dayOfWeek; i++) {
                blankdaysArray.push(i)
            }

            let daysArray = []
            for (let i = 1; i <= daysInMonth; i++) {
                daysArray.push(i)
            }

            this.blankdays = blankdaysArray
            this.no_of_days = daysArray
        },
    }
}
