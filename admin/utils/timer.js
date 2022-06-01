import moment from 'moment'

class Timer {
    //记录时间
    record(name) {
        window.localStorage.setItem(name, dayjs())
    }

    //取时间差
    diffNow(name, timeout = 60) {
        const time = window.localStorage.getItem(name)
        return Math.round(
            moment(time)
                .add(timeout, 'seconds')
                .diff(moment(), 'second')
        )
    }
}

export default new Timer()