import axios from 'axios'
import store from '../../src/store'
import {RESPONSE_STATUS} from "../../src/common/enums";
const service = axios.create({
    baseURL: "http://localhost:9000/", // uri = baseURL + apiFunction truyền tới
    timeout: 10000,
    withCredentials: true,
    headers: { // Request Headers
        'content-type': 'application/json',
        'Accept': 'application/json'
    }
})

service.interceptors.request.use(
    config => {
        console.log(store.getters.getToken)
        if (store.getters.getToken) {
            config.headers['X-Token'] = store.getters.getToken
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
        if (error.response && error.response.status === RESPONSE_STATUS.HTTP_INTERNAL_SERVER_ERROR) {
            store.dispatch('handleServerError');
        }
        return Promise.reject(error)
    }
)

export default service
