import request from '../api/utils/request'

/**
 * Lấy thông tin kì thi, ca thi, phòng thi
 * @returns
 */
export function get() {
    return request({
        url: 'users',
        method: 'GET',
    })
}

/**
 * Lấy thông tin kì thi, ca thi, phòng thi
 * @returns
 */
export function calculate(data) {
    return request({
        url: 'word/calculate',
        method: 'POST',
        data: data
    })
}
