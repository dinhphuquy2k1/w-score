import request from '../api/utils/request'

/**
 * Thêm mới phòng thi
 * @returns
 */
export function saveData(data) {
    return request({
        url: 'department',
        method: 'POST',
        data: data
    })
}

/**
 * Thêm mới phòng thi
 * @returns
 */
export function updateDepartment(data) {
    return request({
        url: `department/${data.id}`,
        method: 'PUT',
        data: data
    })
}

/**
 * Thêm mới phòng thi
 * @returns
 */
export function deleteDepartment(id) {
    return request({
        url: `department/${id}`,
        method: 'DELETE',
    })
}

/**
 * Load data
 * @returns
 */
export function getDataDepartment() {
    return request({
        url: 'department',
        method: 'get'
    })
}

