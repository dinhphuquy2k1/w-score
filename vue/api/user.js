import request from '../api/utils/request'

/**
 * Lấy thông tin kì thi, ca thi, phòng thi
 * @returns
 */
export function login(data) {
    return request({
        url: 'api/user/login',
        method: 'POST',
        data: data
    })
}

/**
 * Lấy thông tin kì thi, ca thi, phòng thi
 * @returns
 */
export function logout() {
    return request({
        url: 'api/user/logout',
        method: 'POST',
    })
}


/**
 * Lấy thông tin kì thi, ca thi, phòng thi
 * @returns
 */
export function getUsers() {
    return request({
        url: 'api/user',
        method: 'GET',
    })
}

/**
 * Lấy thông tin kì thi, ca thi, phòng thi
 * @returns
 */
export function saveUser(data) {
    return request({
        url: 'api/user',
        method: 'POST',
        data: data,
    })
}

/**
 * Lấy thông tin kì thi, ca thi, phòng thi
 * @returns
 */
export function updateUser(data) {
    return request({
        url: 'api/user/1',
        method: 'PUT',
        data: data,
    })
}


/**
 * Lấy thông tin kì thi, ca thi, phòng thi
 * @returns
 */
export function deleteUser(data) {
    return request({
        url: 'api/user/1',
        method: 'DELETE',
        data: data,
    })
}

/**
 * Kiểm tra password
 * @returns
 */
export function checkPassword(data) {
    return request({
        url: 'api/user/checkpassword',
        method: 'POST',
        data: data
    })
}

/**
 * Kiểm tra password
 * @returns
 */
export function sendEmailVerify() {
    return request({
        url: 'api/user/sendEmailVerify',
        method: 'POST',
    })
}

/**
 * Kiểm tra password
 * @returns
 */
export function checkEmailExits(data) {
    return request({
        url: 'api/user/checkEmailExits',
        method: 'POST',
        data: data
    })
}



