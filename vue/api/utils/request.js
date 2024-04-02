import axios from 'axios'
import store from '../../src/store'
import {RESPONSE_STATUS} from "../../src/common/enums";
const service = axios.create({
    baseURL: "http://localhost:9000/api/", // uri = baseURL + apiFunction truyền tới
    timeout: 10000,
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
        if (error.response.status == RESPONSE_STATUS.HTTP_INTERNAL_SERVER_ERROR) {
            store.dispatch('handleInternalServerError');
        }
        return Promise.reject(error)
    }
)

export default service
