import request from '../api/utils/request'

/**
 *
 * @returns
 */
export function getExamBank() {
    return request({
        url: '/exam-banks',
        method: 'get'
    })
}

/**
 *
 * @returns
 */
export function getExamBankSetting() {
    return request({
        url: '/exam-banks/settings',
        method: 'get'
    })
}

/**
 * Lấy các tiêu chí của đề thi
 * @returns
 */
export function getCriteriaByExamBankId(data) {
    return request({
        url: 'api/exambank/getCriteriaByExambankId',
        method: 'post',
        data: data
    })
}

/**
 * Xóa tiêu chí
 * @returns
 */
export function deleteCriteria(data) {
    return request({
        url: 'api/exambank/deleteCriteria',
        method: 'post',
        data: data
    })
}

/**
 * Thêm mới đề thi
 * @returns
 */
export function insertExamBank(data) {
    return request({
        url: '/exam-banks',
        method: 'post',
        data: data
    })
}

/**
 * cập nhật đề thi
 * @returns
 */
export function updateExamBank(data) {
    return request({
        url: `/exam-banks/${data.id}`,
        method: 'PUT',
        data: data
    })
}

/**
 * cập nhật đề thi
 * @returns
 */
export function deleteExamBank(id) {
    return request({
        url: `exambank/${id}`,
        method: 'delete',
    })
}

/**
 * Thiết lập đề thi
 * @returns
 */
export function configureExam(id) {
    return request({
        url: `exambank/${id}`,
        method: 'get',
    })
}

/**
 * Thiết lập đề thi
 * @returns
 */
export function saveCriteria(data) {
    return request({
        url: `/api/saveCriteria`,
        method: 'POST',
        data: data
    })
}

/**
 * Thiết lập đề thi
 * @returns
 */
export function checkFormula(formula) {
    return request({
        url: `/api/saveCriteria`,
        method: 'POST',
        data: formula
    })
}
