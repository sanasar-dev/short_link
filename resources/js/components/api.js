import axios from 'axios';

const axiosApi = axios.create({
    baseURL: '/api/'
});

export const generateShortUrl = (data) => {
    return axiosApi.post('create_short_link', data);
}
