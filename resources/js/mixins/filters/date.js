import moment from 'moment';

const dateTime = (value) => {
    return moment(value).utc().format("DD-MM-YYYY HH:mm")
};

export default {
    methods: {
        dateTime: dateTime,
    },
    filters: {
        dateTime: dateTime,
    },
};
