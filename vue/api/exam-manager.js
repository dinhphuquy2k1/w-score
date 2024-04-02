import request from '../api/utils/request'

/**
 * Thêm mới kì thi
 * @returns
 */
export function saveExamManager(data) {
    return request({
        url: 'api/exam-manager',
        method: 'POST',
        data: data,
    })
}

/**
 * Thêm mới kì thi
 * @returns
 */
export function updateExamManager(data) {
    return request({
        url: 'api/exam-manager/update-exammanager',
        method: 'POST',
        data: data,
    })
}

/**
 * Thêm mới kì thi
 * @returns
 */
export function deleteExamManager(id) {
    return request({
        url: `api/exam-manager/${id}`,
        method: 'DELETE',
    })
}

/**
 * Thêm mới kì thi
 * @returns
 */
export function getExamManager() {
    return request({
        url: 'api/exam-manager',
        method: 'GET',
    })
}

export function checkExamShiftCodeExits(data) {
    return request({
        url: 'api/exam-manager/checkExamShiftCodeExits',
        method: 'POST',
        data: data,
    })
}


/**
 * Cập nhật ca thi
 * @param {*} data
 * @returns
 */
export function updateExamShift(data) {
    return request({
        url: 'api/exam-manager/update-examshift',
        method: 'POST',
        data: data,
    })
}

/**
 * Lấy thông tin ca thi
 * @param {*} data
 * @returns
 */
export function getExamShift(id) {
    return request({
        url: `api/exam-manager/get-examshift/${id}`,
        method: 'GET',
    })
}

/**
 * Lấy thông tin ca thi
 * @param {*} data
 * @returns
 */
export function deleteExamShift(id) {
    return request({
        url: `api/exam-manager/delete-examshift/${id}`,
        method: 'GET',
    })
}

/**
 * Thêm mới ca thi
 * @param {*} data
 * @returns
 */
export function insertExamShift(data) {
    return request({
        url: 'api/exam-manager/insert-examshift',
        method: 'POST',
        data: data,
    })
}
