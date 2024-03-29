import axios from 'axios'
import store from '../../src/store'
const service = axios.create({
    baseURL: "http://localhost:9000/api/", // uri = baseURL + apiFunction truyền tới
    timeout: 5000,
    headers: { // Request Headers
        'content-type': 'application/json',
        'Accept': 'application/json'
    }
})

service.interceptors.request.use(
    config => {
        if (store.getters.token) {
            config.headers['X-Token'] = getToken()
        }
        return config
    },
    error => {
        console.log('error', error)
    }
)

service.interceptors.response.use(
    response => {
        const res = response.data
        return res
    },
    error => {
        return Promise.reject(error)
    }
)

export default service
