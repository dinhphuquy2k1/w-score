import request from '../api/utils/request'

export function getExamResultDetail(data) {
    return request({
        url: `api/exam-results`,
        method: 'POST',
        data: data,
    })
}
