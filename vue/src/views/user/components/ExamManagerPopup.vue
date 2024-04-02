<template>
    <div class=" main-view-exam_manger">
        <div class="main-view flex1 flex-column">
            <div class="form-list flex-column flex1">
                <div class="flex-column flex1">
                    <div class="flex-center title-box">
                        <div class="icon24 back cursor-pointer mr-5" @click="closeExamManagerPopup"></div>
                        <div class="list-title flex1">{{ modeModal == FormMode.Insert ? 'Thêm' : 'Sửa' }} kì thi</div>
                    </div>
                    <div class="list-content flex1 flex-row">
                        <div class="w-full flex1 flex-row">
                            <div class="box left-box">
                                <div class="list-tab-menu">
                                    <div class="tab-item">
                                        <div class="tab-item-parent active">1. Thông tin kì thi</div>
                                    </div>
                                    <div class="tab-item">
                                        <div class="tab-item-parent">2. Thông tin ca thi</div>
                                    </div>
                                </div>
                            </div>
                            <div class="box list-content flex1 flex-column">
                                <div class="content-body flex1 flex-column">
                                    <div class="mb-20">
                                        <div class="title-1 flex1 flex-row">
                                            <span>1. Thông tin kì thi</span>
                                        </div>
                                        <div class="form-group flex-row">
                                            <div class="flex1 mr-10">
                                                <div class="form-group-label d-flex label-form">
                                                    Tên kì thi
                                                    <span class="required">*</span>
                                                </div>
                                                <div class="ms-input ms-editor w-100">
                                                    <InputText v-model="exam.ExamName"
                                                               :class="{ 'error': invalidExamManager['ExamName'] }"
                                                               @input="handlerGenerateCode('exam')"
                                                               placeholder="Nhập tên kì thi"/>
                                                    <div class="error-text" v-if="invalidExamManager['ExamName']">
                                                        {{ invalidExamManager['ExamName'] }}
                                                    </div>
                                                </div>
                                                <div class="flex1">
                                                    <div class="ms-input ms-editor w-100"></div>
                                                </div>
                                            </div>
                                            <div class="flex1 mr-10">
                                                <div class="form-group-label d-flex label-form">
                                                    Mã kì thi
                                                    <span class="required">*</span>
                                                </div>
                                                <div class="ms-input ms-editor w-100">
                                                    <InputText v-model="exam.ExamCode"
                                                               :class="{ 'error': invalidExamManager['ExamCode'] }"
                                                               placeholder="Nhập tên kì thi"
                                                               @keypress="handlerInputCode"/>
                                                    <div class="error-text" v-if="invalidExamManager['ExamCode']">
                                                        {{ invalidExamManager['ExamCode'] }}
                                                    </div>
                                                </div>
                                                <div class="flex1">
                                                    <div class="ms-input ms-editor w-100"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group flex-row">
                                            <div class="flex1 mr-10">
                                                <div class="form-group-label d-flex label-form">
                                                    Ngày bắt đầu
                                                    <span class="required">*</span>
                                                </div>
                                                <div class="ms-input ms-editor w-100">
                                                    <Calendar v-model="exam.ExamStartDate" dataType="string"
                                                              :class="{ 'error': invalidExamManager['ExamStartDate'] }"
                                                              locale="vi" dateFormat="dd/mm/yy" class="w-full"
                                                              id="calendar-24h"
                                                              showTime hourFormat="24" showIcon
                                                              placeholder="Chọn ngày bắt đầu kì thi"/>
                                                    <div class="error-text" v-if="invalidExamManager['ExamStartDate']">
                                                        {{ invalidExamManager['ExamStartDate'] }}
                                                    </div>
                                                </div>
                                                <div class="flex1">
                                                    <div class="ms-input ms-editor w-100"></div>
                                                </div>
                                            </div>
                                            <div class="flex1 mr-10">
                                                <div class="form-group-label d-flex label-form">
                                                    Ngày kết thúc
                                                    <span class="required">*</span>
                                                </div>
                                                <div class="ms-input ms-editor w-100">
                                                    <Calendar v-model="exam.ExamEndDate" dateFormat="dd/mm/yy"
                                                              @date-select="functionTest" dataType="string"
                                                              :class="{ 'error': invalidExamManager['ExamEndDate'] }"
                                                              :minDate="exam.ExamStartDate"
                                                              :disabled="exam.ExamStartDate == null"
                                                              class="w-full" id="calendar-24h"
                                                              placeholder="Chọn ngày kết thúc kì thi" showTime
                                                              hourFormat="24"
                                                              showIcon/>
                                                    <div class="error-text" v-if="invalidExamManager['ExamEndDate']">
                                                        {{ invalidExamManager['ExamEndDate'] }}
                                                    </div>
                                                </div>
                                                <div class="flex1">
                                                    <div class="ms-input ms-editor w-100"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group flex-row">
                                            <div class="flex1 mr-10">
                                                <div class="form-group-label d-flex label-form">
                                                    Mô tả
                                                    <span class="required">*</span>
                                                </div>
                                                <div class="ms-input ms-editor w-100">
                                                    <Textarea v-model="exam.Note" autoResize rows="5" cols="30"
                                                              placeholder="Nhập ghi chú"/>
                                                    <div class="error-text">
                                                    </div>
                                                </div>
                                                <div class="flex1">
                                                    <div class="ms-input ms-editor w-100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-20 flex-column flex1">
                                        <div class="title-1 w-100 flex-row">
                                            <span>2. Thông tin ca thi</span>
                                        </div>
                                        <div class="d-flex w-100 mb-10">
                                            <div class="flex1"><span class="error-text">{{
                                                    invalidExamManager['ExamShift']
                                                }}</span></div>
                                            <div class="flex-center custom-btn remain-focus-when-enter text-link"
                                                 @click="examShiftDialogVisible = true; invalidExamShift = []">
                                                <div class="icon24 w-16 add-blue"></div>
                                                <div class="btn-text">Thêm ca thi</div>
                                            </div>
                                        </div>
                                        <DataTable :value="listExamShift" class="flex1" rowHover
                                                   table-class="grid-group"
                                                   @rowDblclick="onRowSelectExamShift($event.data), modeExamShiftModal = FormMode.Update, showExamShiftDialogVisible()">
                                            <template #empty>
                                                <div>
                                                    Không có dữ liệu
                                                </div>
                                            </template>
                                            <Column field="ExamShiftName" dataKey="id" header="Tên ca thi"
                                                    style="min-width: 300px;">
                                                <template #body="{ data, field, slotProps, index }">
                                                    <div v-if="!isLoadingExamShift"> {{ data[field] }}</div>
                                                    <div v-else>
                                                        <Skeleton height="18px" class="mb-2"></Skeleton>
                                                    </div>
                                                </template>
                                            </Column>
                                            <Column field="ExamShiftCode" dataKey="id" header="Mã ca thi"
                                                    style="min-width: 160px;">
                                                <template #body="{ data, field }">
                                                    <div v-if="!isLoadingExamShift"> {{ data[field] }}</div>
                                                    <div v-else>
                                                        <Skeleton height="18px" class="mb-2"></Skeleton>
                                                    </div>
                                                </template>
                                            </Column>
                                            <Column field="DateTimeStart" dataKey="id" header="Ngày bắt đầu"
                                                    style="min-width: 180px;">
                                                <template #body="{ data, field }">
                                                    <div v-if="!isLoadingExamShift"> {{ data[field] }}</div>
                                                    <div v-else>
                                                        <Skeleton height="18px" class="mb-2"></Skeleton>
                                                    </div>
                                                </template>
                                            </Column>
                                            <Column field="DateTimeEnd" dataKey="id" header="Ngày kết thúc"
                                                    style="min-width: 180px;">
                                                <template #body="{ data, field }">
                                                    <div v-if="!isLoadingExamShift"> {{ data[field] }}</div>
                                                    <div v-else>
                                                        <Skeleton height="18px" class="mb-2"></Skeleton>
                                                    </div>
                                                </template>

                                            </Column>
                                            <Column field="DateTimeEnd" dataKey="id" header="Phòng thi"
                                                    style="min-width: 300px;">
                                                <template #body="{ data, field }">
                                                    <div v-if="!isLoadingExamShift"> {{ data[field] }}</div>
                                                    <div v-else>
                                                        <Skeleton height="18px" class="mb-2"></Skeleton>
                                                    </div>
                                                </template>
                                            </Column>
                                            <Column alignFrozen="right" style="width: 90px;" frozen header="Thao tác">
                                                <template #body="slotProps">
                                                    <div class="row-actions" style="width: 100%;"
                                                         v-if="!isLoadingExamShift">
                                                        <div class="position-relative">
                                                            <div class="item"
                                                                 @click="modeModal = FormMode.Update, onRowSelectExamShift(slotProps.data), showExamManager()">
                                                                <div class="v-popover popover">
                                                                    <div class="trigger">
                                                                        <div class="icon24 edit"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="item"
                                                                 @click="selectedExamShift = { ...slotProps.data }, btnRemoveExamShift(slotProps.index)">
                                                                <div class="v-popover popover">
                                                                    <div class="icon24 delete"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div v-else>
                                                        <Skeleton height="18px" class="mb-2"></Skeleton>
                                                    </div>
                                                </template>
                                            </Column>
                                        </DataTable>
                                    </div>
                                </div>
                                <div class="content-footer">
                                    <div class="flex-row">
                                        <div class="flex1"></div>
                                        <Button label="Đóng" class="ms-button btn detail-button secondary mr-10"
                                                @click="examShiftDialogVisible = false; invalidExamShift = []; closeExamManagerPopup()"/>
                                        <Button label="Lưu" class="ms-button btn detail-button primary"
                                                @click="saveExamManager"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Dialog v-model:visible="examShiftDialogVisible" modal @keydown.enter.prevent="saveExamShift"
            @afterHide="afterHideExamShiftDialog"
            :header="modeExamShiftModal == FormMode.Insert ? 'Thêm ca thi' : 'Sửa ca thi'"
            :style="{ width: '50vw' }">
        <TheLoadingProgress v-if="isLoadingPopupExamShift"/>
        <div class="w-full flex flex-column">
            <div class="form-group flex-row">
                <div class="flex1 mr-10">
                    <div class="form-group-label d-flex label-form">
                        Tên ca thi
                        <span class="required">*</span>
                    </div>
                    <div class="ms-input ms-editor w-100">
                        <InputText v-model="selectedExamShift.ExamShiftName" placeholder="Nhập tên ca thi"
                                   :class="{ 'error': invalidExamShift['ExamShiftName'] }"
                                   @input="handlerGenerateCode('examShift')"/>
                        <div class="error-text" v-if="invalidExamShift['ExamShiftName']">
                            {{ invalidExamShift['ExamShiftName'] }}
                        </div>
                    </div>
                    <div class="flex1">
                        <div class="ms-input ms-editor w-100"></div>
                    </div>
                </div>
                <div class="flex1 mr-10">
                    <div class="form-group-label d-flex label-form">
                        Mã ca thi
                        <span class="required">*</span>
                    </div>
                    <div class="ms-input ms-editor w-100">
                        <InputText v-model="selectedExamShift.ExamShiftCode" placeholder="Nhập mã ca thi"
                                   :class="{ 'error': invalidExamShift['ExamShiftCode'] }" @keypress="handlerInputCode"
                                   @input="modeGenerateExamShift = selectedExamShift.ExamShiftCode ? false : true;"/>
                        <div class="error-text" v-if="invalidExamShift['ExamShiftCode']">
                            {{ invalidExamShift['ExamShiftCode'] }}
                        </div>
                    </div>
                    <div class="flex1">
                        <div class="ms-input ms-editor w-100"></div>
                    </div>
                </div>
            </div>
            <div class="form-group flex-row">
                <div class="flex1 mr-10">
                    <div class="form-group-label d-flex label-form">
                        Ngày bắt đầu
                        <span class="required">*</span>
                    </div>
                    <div class="ms-input ms-editor w-100">
                        <Calendar locale="vi" dateFormat="dd/mm/yy"
                                  :class="{ 'error': invalidExamShift['DateTimeStart'] }"
                                  v-model="selectedExamShift.DateTimeStart" :min="exam.ExamStartDate"
                                  :max-date="exam.ExamEndDate"
                                  class="w-100" id="calendar-24h" showTime hourFormat="24" showIcon
                                  placeholder="Chọn ngày bắt đầu kì thi"/>
                        <div class="error-text" v-if="invalidExamShift['DateTimeStart']">
                            {{ invalidExamShift['DateTimeStart'] }}
                        </div>
                    </div>
                    <div class="flex1">
                        <div class="ms-input ms-editor w-100"></div>
                    </div>
                </div>
                <div class="flex1 mr-10">
                    <div class="form-group-label d-flex label-form">
                        Ngày kết thúc
                        <span class="required">*</span>
                    </div>
                    <div class="ms-input ms-editor w-100">
                        <Calendar dateFormat="dd/mm/yy" :class="{ 'error': invalidExamShift['DateTimeEnd'] }"
                                  :minDate="selectedExamShift.DateTimeStart" :max-date="exam.ExamEndDate" class="w-100"
                                  :disabled="selectedExamShift.DateTimeStart == null"
                                  v-model="selectedExamShift.DateTimeEnd"
                                  id="calendar-24h" placeholder="Chọn ngày kết thúc kì thi" showTime hourFormat="24"
                                  showIcon/>
                        <div class="error-text" v-if="invalidExamShift['DateTimeEnd']">
                            {{ invalidExamShift['DateTimeEnd'] }}
                        </div>
                    </div>
                    <div class="flex1">
                        <div class="ms-input ms-editor w-100"></div>
                    </div>
                </div>
                <div class="flex1 mr-10">
                    <div class="form-group-label d-flex label-form">
                        Phòng thi
                        <span class="required">*</span>
                    </div>
                    <div class="ms-input ms-editor w-100">
                        <MultiSelect v-model="selectedExamShift.Department"
                                     :class="{ 'error': invalidExamShift['Department'] }" :options="department"
                                     placeholder="Chọn phòng thi" optionLabel="DepartmentName"
                                     optionValue="DepartmentId"/>
                        <div class="error-text" v-if="invalidExamShift['Department']">
                            {{ invalidExamShift['Department'] }}
                        </div>
                    </div>
                    <div class="flex1">
                        <div class="ms-input ms-editor w-100"></div>
                    </div>
                </div>
                <div class="flex1 mr-10">
                    <div class="form-group-label d-flex label-form">
                        Đề thi
                        <span class="required">*</span>
                        <div class="icon16 icon-note has-tooltip"
                             v-tooltip.top="{ value: 'Thiết lập đề thi để sử dụng', escape: true, class: 'custom-error' }">
                        </div>
                    </div>
                    <div class="ms-input ms-editor w-100">
                        <MultiSelect v-model="selectedExamShift.ExamBankId" :options="examBankSetting"
                                     checkboxIcon="test"
                                     placeholder="Chọn đề thi" optionLabel="ExamBankName" optionValue="ExamBankId"
                                     :class="{ 'error': invalidExamShift['ExamBankId'] }"/>
                        <div class="error-text" v-if="invalidExamShift['ExamBankId']">
                            {{ invalidExamShift['ExamBankId'] }}
                        </div>
                    </div>
                    <div class="flex1">
                        <div class="ms-input ms-editor w-100"></div>
                    </div>
                </div>
            </div>
            <div class="form-group flex-row">
                <div class="flex1 mr-10">
                    <div class="form-group-label d-flex label-form">
                        Mô tả
                    </div>
                    <div class="ms-input ms-editor w-100">
                        <Textarea v-model="selectedExamShift.Note" autoResize rows="5" cols="30"
                                  placeholder="Nhập ghi chú cho ca thi"/>
                        <div class="error-text">
                        </div>
                    </div>
                    <div class="flex1">
                        <div class="ms-input ms-editor w-100"></div>
                    </div>
                </div>
            </div>

        </div>
        <template #footer>
            <Button label="Đóng" class="ms-button btn detail-button secondary" @click="examShiftDialogVisible = false"/>
            <Button label="Lưu" class="ms-button btn detail-button primary" @click="saveExamShift"/>
        </template>
    </Dialog>

    <Dialog v-model:visible="warningVisible" modal closeOnEscape :style="{ width: '25vw', height: '20vh' }"
            header="Thông báo">
        <div class="w-full flex flex-column">
            <span> Cập nhật thông tin đề thi, phòng thi sẽ làm mất dữ liệu kết quả bài thi. Bạn có chắc chắn muốn thay đổi
                không? </span>
        </div>
        <template #footer>
            <Button label="Không" class="ms-button btn detail-button secondary"
                    @click="isLoadingPopupExamShift = false; warningVisible = false"/>
            <Button label="Tiếp tục" class="ms-button btn detail-button primary" @click="updateExamShift(true)"/>
        </template>
    </Dialog>

    <Dialog v-model:visible="isPopupDelete" modal closeOnEscape :style="{ width: '25vw' }" header="Xóa kì thi">
        <TheLoadingProgress v-if="isLoadingDelete"/>
        <div class="w-full flex flex-column" style="line-height: 1.5;">
            <span>Ca thi <b>{{
                    selectedExamShift.ExamShiftCode
                }}</b> có thể liên quan đến kết quả các bài thi. Bạn có chắc chắn muốn
                xóa
                không?</span>
        </div>
        <template #footer>
            <Button label="Không" class="ms-button btn detail-button secondary" @click="isPopupDelete = false"/>
            <Button label="Xóa kì thi" class="ms-button btn w-100 danger" @click="handlerDelete"/>
        </template>
    </Dialog>
</template>

<script>
import Toast from 'primevue/toast';
import Textarea from 'primevue/textarea';
import Button from 'primevue/button';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Dropdown from 'primevue/dropdown';
import InputText from 'primevue/inputtext';
import MultiSelect from 'primevue/multiselect';
import Dialog from 'primevue/dialog';
import Skeleton from 'primevue/skeleton';
import Calendar from 'primevue/calendar';
import {mapState, mapActions} from 'vuex'
import {generateCode, convertTimezoneToDatetime, convertTime} from '@/common/functions';
import {saveData, getDataDepartment} from '/api/department';
import {
    saveExamManager,
    checkExamShiftCodeExits,
    updateExamShift,
    updateExamManager,
    insertExamShift,
    getExamShift,
    deleteExamShift
} from '/api/exam-manager';
import TheLoadingProgress from '@/components/LoadingProgress.vue';

export default {
    emits: ["showExamManager", "showToast", "loadExamManager"],
    props: {
        modeModal: {
            default: null
        },
        selectedData: {
            default: null
        }
    },
    components: {
        MultiSelect,
        InputText,
        Dropdown,
        DataTable,
        Column,
        Dialog,
        Skeleton,
        Button,
        Calendar,
        Textarea,
        Toast,
        TheLoadingProgress
    },
    data() {
        return {
            exam: {
                ExamId: null,
                ExamCode: null,
                ExamName: null,
                ExamStartDate: null,
                ExamEndDate: null,
                Note: null,
                listExamShift: [],
            },

            isPopupDelete: false,
            isLoadingPopupExamShift: false,
            isLoadingDelete: false,
            warningVisible: false,
            defaultExamShift: {
                ExamShiftId: null,
                ExamShiftCode: null,
                ExamShiftName: null,
                DateTimeStart: null,
                DateTimeEnd: null,
                Department: null,
                ExamBankId: null,
                Note: null
            },

            isLoadingExamShift: false,

            examshift: {
                ExamShiftId: null,
                ExamShiftCode: null,
                ExamShiftName: null,
                DateTimeStart: null,
                DateTimeEnd: null,
                Department: null,
                ExamBankId: null,
                Note: null
            },

            //chi tiết ca thi
            examshiftdetail: {
                ExamShiftDetailId: null,
                ExamShiftId: null,
                DepartmentId: null,
                ExamBankId: null,
            },

            selectedDataProp: {},

            selectedExamShift: {
                ExamShiftId: null,
                ExamShiftCode: null,
                ExamShiftName: null,
                DateTimeStart: null,
                DateTimeEnd: null,
                Department: null,
                ExamBankId: null,
                Note: null
            },

            selectedListExamShift: null,

            department: [],

            listExamShift: [],

            invalidExamShift: [],
            examShiftDialogVisible: false,

            invalidExamManager: [],

            modeGenerateExamManager: true, //cho phép sinh mã theo tên

            modeGenerateExamShift: true, //sinh mã ca thi

            modeExamShiftModal: this.FormMode.Insert,
        }
    },

    methods: {
        ...mapActions('exambank', ['getExamBankSetting']),
        /**
         * Validate mã phòng thi
         * Ko cho phép nhập các kí tự đặc biệt
         * @param {*} event
         */
        handlerInputDepartmentCode(event) {
            let pattern = /[\W_]/g;
            let res = event.key.match(pattern);
            if (res) {
                event.preventDefault();
            }
        },

        /**
         * Lưu ca thi
         */
        async saveExamShift() {
            if (await this.validateExamShift()) {
                this.isLoadingPopupExamShift = true;
                //trạng thái của form kì thi
                switch (this.modeModal) {
                    //thêm mới kì thi
                    case this.FormMode.Insert:
                        this.listExamShift.push({...this.selectedExamShift});
                        break;
                    //cập nhật kì thi
                    case this.FormMode.Update:
                        switch (this.modeExamShiftModal) {
                            //thêm mới ca thi với kì thi đã có
                            case this.FormMode.Insert:
                                var success = false;
                                insertExamShift({
                                    ...this.selectedExamShift,
                                    ExamId: this.selectedDataProp.ExamId
                                }).then(res => {
                                    success = true;
                                }).catch(error => {
                                    console.log(error);
                                }).finally(() => {
                                    this.isLoadingPopupExamShift = false;
                                    this.loadExamShift();
                                    this.examShiftDialogVisible = false;
                                    if (success) {
                                        console.log(this.selectedExamShift);
                                        this.$emit("showToast", "Thêm ca thi thành công");
                                    }
                                    this.examshift = {...this.defaultExamShift};
                                    this.selectedExamShift = {...this.defaultExamShift};
                                    this.examShiftDialogVisible = false;
                                })
                                break;
                            //cập nhật ca thi
                            case this.FormMode.Update:
                                var success = false;
                                if (JSON.stringify(this.selectedExamShift) != JSON.stringify(this.examshift)) {
                                    // this.warningVisible = true;
                                    //thay đổi đề thi hoặc phòng thi
                                    if (JSON.stringify(this.selectedExamShift.Department) != JSON.stringify(this.examshift.Department) || JSON.stringify(this.selectedExamShift.ExamBankId) != JSON.stringify(this.examshift.ExamBankId)) {
                                        this.warningVisible = true;
                                    } else {
                                        this.updateExamShift();
                                    }
                                } else {
                                    alert(2);
                                }
                                break;
                            default:
                                break;
                        }
                        break;
                    default:
                        break;
                }

            }
        },

        /**
         * Trước khi ẩn form ca thi
         */
        afterHideExamShiftDialog() {
            this.examshift = {...this.defaultExamShift};
            this.selectedExamShift = {...this.defaultExamShift};
            this.modeExamShiftModal = this.FormMode.Insert;
            this.isLoadingExamShift = false;
        },

        /**
         * Call api cập nhật ca thi
         * @param {*} flag true: xóa chi tiết ca thi, false: không xóa
         */
        async updateExamShift(flag = false) {
            var success = false;
            await updateExamShift({...this.selectedExamShift, ExamId: this.selectedDataProp.ExamId, Flag: flag})
                .then(res => {
                    success = true;
                }).catch(error => {

                }).finally(() => {
                    this.isLoadingPopupExamShift = false;
                    if (success) {
                        this.$emit("showToast", "Sửa ca thi thành công");
                    }
                    this.examshift = {...this.defaultExamShift};
                    this.selectedExamShift = {...this.defaultExamShift};
                    this.examShiftDialogVisible = false;
                    this.warningVisible = false;
                    this.loadExamShift();
                })
        },

        /**
         * Lấy danh sách ca thi
         */
        async loadExamShift() {
            this.isLoadingExamShift = true;
            this.listExamShift = [];
            await getExamShift(this.selectedData.ExamId).then(res => {
                if (res[0]) {
                    console.log(JSON.parse(res[0].objDE));
                    // danh sách phòng theo từng ca thi(lấy duy nhất vì 1 phòng sử dụng nhiều đề nên bị duplicate)
                    this.selectedExamShift.Department = this.getUniqueItems(JSON.parse(res[0].objDE), 'DepartmentId').map(_item => _item.DepartmentId);

                    //danh sách ca thi
                    this.selectedExamShift.ExamBankId = this.getUniqueItems(JSON.parse(res[0].objDE), 'ExamBankId').map(_item => _item.ExamBankId);
                }
                this.listExamShift = res;
            }).catch(error => {
                console.log(error);
            }).finally(() => {
                setTimeout(() => {
                    this.isLoadingExamShift = false;
                }, 750);
            })
        },

        /**
         * Ẩn/hiện form thêm ca thi
         */
        showExamShiftDialogVisible() {
            this.examShiftDialogVisible = !this.examShiftDialogVisible;
        },

        /**
         * click nút lọc
         * author: DPQuy(13/11/2022)
         * **/
        btnFilterOnClick() {
            //gọi hàm show filterbox
            this.showFilterBox();
        },

        /**
         * Sự kiện chọn item ca thi
         */
        onRowSelectExamShift(data) {
            //mảng giá trị selected
            this.selectedExamShift = {...data};
            //convert datetime
            this.selectedExamShift.DateTimeEnd = new Date(this.selectedExamShift.DateTimeEnd);
            this.selectedExamShift.DateTimeStart = new Date(this.selectedExamShift.DateTimeStart);

            //sử dụng khi cập nhật kì thi
            if (this.modeModal == this.FormMode.Update) {
                // danh sách phòng theo từng ca thi(lấy duy nhất vì 1 phòng sử dụng nhiều đề nên bị duplicate)
                this.selectedExamShift.Department = this.getUniqueItems(this.selectedListExamShift.filter(_item => this.selectedExamShift.ExamShiftId == _item.ExamShiftId), 'DepartmentId').map(_item => _item.DepartmentId);

                //danh sách ca thi
                this.selectedExamShift.ExamBankId = this.getUniqueItems(this.selectedListExamShift.filter(_item => this.selectedExamShift.ExamShiftId == _item.ExamShiftId), 'ExamBankId').map(_item => _item.ExamBankId);
            }
            this.examshift = {...this.selectedExamShift};
        },

        /**
         * Lấy danh sách phòng thi
         */
        async loadDepartment() {
            await getDataDepartment().then(res => {
                this.department = res;
            }).catch(error => {
                console.log(error);
            })
        },

        /**
         * Lấy ra các phần tử không trùng lặp trong mảng
         * @param {*} data Mảng
         * @param {*} propName Phần tử cần lấy
         */
        getUniqueItems(data, propName) {
            return data.reduce((acc, curr) => {
                if (!acc.some(item => item[propName] === curr[propName])) {
                    acc.push(curr);
                }
                return acc;
            }, []);
        },

        /**
         * Xử lý hàm sinh mã theo tên
         */
        handlerGenerateCode(name) {
            if (name == 'exam' && this.modeGenerateExamManager) this.exam.ExamCode = generateCode(this.exam.ExamName);
            if (name == 'examShift' && this.modeGenerateExamShift) {
                this.selectedExamShift.ExamShiftCode = generateCode(this.selectedExamShift.ExamShiftName);
            }
        },

        /**
         * Validate mã
         * Ko cho phép nhập các kí tự đặc biệt
         * @param {*} event
         */
        handlerInputCode(event) {
            let pattern = /[\W_]/g;
            let res = event.key.match(pattern);
            if (res) {
                event.preventDefault();
            }
        },

        /**
         * Xóa ca thi
         * @param {*} index
         */
        btnRemoveExamShift(index) {
            this.isPopupDelete = true;
        },

        /**
         * Click xóa ca thi
         */
        handlerDelete() {
            this.isLoadingDelete = true;
            switch (this.modeModal) {
                case this.FormMode.Insert:
                    // this.listExamShift.slice(index,)
                    break;
                case this.FormMode.Update:
                    var success = false;
                    deleteExamShift(this.selectedExamShift.ExamShiftId).then(res => {
                        console.log(res);
                        success = true;
                    }).catch(error => {

                    }).finally(() => {
                        this.loadExamShift();
                        this.examShiftDialogVisible = false;
                        this.isPopupDelete = false;
                        this.isLoadingDelete = false;
                        this.$emit("showToast", "Xóa ca thi thành công");
                    });
                    break;
                default:
                    break;
            }
        },

        /**
         * Đóng form
         */
        closeExamManagerPopup() {
            this.$emit('showExamManager');
            this.$emit("loadExamManager");
        },

        /**
         * Click nút lưu kì thi
         */
        async saveExamManager() {
            if (this.validateExamManager()) {
                try {
                    switch (this.modeModal) {
                        case this.FormMode.Insert:
                            this.exam.listExamShift = [];
                            this.exam.listExamShift = this.listExamShift;
                            this.$emit("showToast", 'Thêm thành công');
                            saveExamManager(this.exam).then(res => {
                                this.$emit("showExamManager");
                                this.$emit("loadExamManager");
                            }).catch(error => {
                                console.log(error);
                            });
                            break;
                        case this.FormMode.Update:
                            //kiểm tra dữ liệu có thay đổi hay không
                            //1.có thay đổi
                            if (JSON.stringify({
                                ExamCode: this.selectedDataProp.ExamCode,
                                ExamName: this.selectedDataProp.ExamName,
                                ExamStartDate: this.selectedDataProp.ExamStartDate,
                                ExamEndDate: this.selectedDataProp.ExamEndDate,
                                Note: this.selectedDataProp.Note,
                            }) != JSON.stringify({
                                ExamCode: this.exam.ExamCode,
                                ExamName: this.exam.ExamName,
                                ExamStartDate: this.exam.ExamStartDate,
                                ExamEndDate: this.exam.ExamEndDate,
                                Note: this.exam.Note,
                            })) {
                                await updateExamManager({
                                    ExamId: this.exam.ExamId,
                                    ExamCode: this.exam.ExamCode,
                                    ExamName: this.exam.ExamName,
                                    ExamStartDate: this.exam.ExamStartDate,
                                    ExamEndDate: this.exam.ExamEndDate,
                                    Note: this.exam.Note,
                                }).then(res => {
                                }).catch(error => {
                                    console.log(error);
                                });
                            }
                            this.$emit("showToast", 'Cập nhật thành công');
                            this.$emit("showExamManager");
                            this.$emit("loadExamManager");

                            break;
                        default:
                            break;
                    }
                } catch (error) {
                    console.log(error);
                }
            }
        },

        /**
         * Validate kì thi
         */
        validateExamManager() {
            this.invalidData = [];
            var invalid = true;

            if (this.exam.ExamCode == null || String(this.exam.ExamCode).trim() == '') {
                this.invalidExamManager['ExamCode'] = 'Mã kì thi không được để trống';
                invalid = false;
            }

            if (this.exam.ExamName == null || String(this.exam.ExamName).trim() == '') {
                this.invalidExamManager['ExamName'] = 'Tên kì thi không được để trống';
                invalid = false;
            }

            if (this.exam.ExamStartDate == null) {
                this.invalidExamManager['ExamStartDate'] = 'Ngày bắt đầu kì thi không được để trống';
                invalid = false;
            }

            if (this.exam.ExamEndDate == null) {
                this.invalidExamManager['ExamEndDate'] = 'Ngày kết thúc kì thi không được để trống';
                invalid = false;
            }

            if (this.exam.ExamEndDate != null && this.exam.ExamStartDate != null && this.exam.ExamEndDate.getTime() - this.exam.ExamStartDate.getTime() < 2 * 60 * 60 * 1000) {
                this.invalidExamManager['ExamEndDate'] = 'Thời gian thi tối thiểu phải lớn hơn 2h';
                invalid = false;
            }

            if (this.listExamShift.length == 0) {
                this.invalidExamManager['ExamShift'] = 'Ca thi không được để trống';
                invalid = false;
            }


            return invalid;
        },

        functionTest() {
            console.log(convertTimezoneToDatetime(this.exam.ExamEndDate.getTime()))
        },

        /**
         * Validate ca thi
         */
        async validateExamShift() {
            this.invalidExamShift = [];
            var invalid = true;
            if (this.selectedExamShift.ExamShiftCode == null || String(this.selectedExamShift.ExamShiftCode).trim() == '') {
                this.invalidExamShift['ExamShiftCode'] = 'Mã ca thi không được để trống';
                invalid = false;
            }

            if (this.selectedExamShift.ExamShiftName == null || String(this.selectedExamShift.ExamShiftName).trim() == '') {
                this.invalidExamShift['ExamShiftName'] = 'Tên ca thi không được để trống';
                invalid = false;
            }

            if (this.selectedExamShift.DateTimeStart == null) {
                this.invalidExamShift['DateTimeStart'] = 'Ngày bắt đầu không được để trống';
                invalid = false;
            }
            if (this.selectedExamShift.DateTimeEnd == null) {
                this.invalidExamShift['DateTimeEnd'] = 'Ngày kết thúc không được để trống';
                invalid = false;
            }

            if (this.selectedExamShift.DateTimeStart != null && this.selectedExamShift.DateTimeEnd != null && this.selectedExamShift.DateTimeEnd.getTime() - this.selectedExamShift.DateTimeStart.getTime() < 2 * 60 * 60 * 1000) {
                this.invalidExamShift['DateTimeEnd'] = 'Thời gian tối tiểu là 2h';
                invalid = false;
            }

            if (this.selectedExamShift.Department == null) {
                this.invalidExamShift['Department'] = 'Phòng thi không được để trống';
                invalid = false;
            }

            if (this.selectedExamShift.ExamBankId == null) {
                this.invalidExamShift['ExamBankId'] = 'Đề thi không được để trống';
                invalid = false;
            }

            var examShiftCode = this.selectedExamShift.ExamShiftCode;
            var valObj = this.listExamShift.filter(function (item) {
                if (item.ExamShiftCode == examShiftCode) return item;
            });
            if (valObj.length && this.modeExamShiftModal !== this.FormMode.Update) {
                this.invalidExamShift['ExamShiftCode'] = 'Mã ca thi đã tồn tại';
                invalid = false;
            } else if (this.selectedExamShift.ExamShiftCode != null || String(this.selectedExamShift.ExamShiftCode).trim() == '') {
                //gọi api kiểm tra mã
                await checkExamShiftCodeExits({
                    data: this.selectedExamShift,
                    mode: this.modeExamShiftModal
                }).then(res => {
                    if (res.result) {
                        this.invalidExamShift['ExamShiftCode'] = 'Mã ca thi đã tồn tại';
                        invalid = false;
                    }
                }).catch(error => {
                    console.log(error);
                });
            }
            return invalid;
        },

        /**
         * Event xử lý data selected
         */
        handlerPropData() {
            if (this.modeModal == this.FormMode.Update) {
                this.selectedDataProp = {...this.selectedData};

                // //kì thi
                this.exam = {...this.selectedDataProp};
                this.exam.ExamStartDate = new Date(this.selectedDataProp.ExamStartDate);
                this.exam.ExamEndDate = new Date(this.selectedDataProp.ExamEndDate);

                this.selectedDataProp = {...this.exam};
                this.selectedListExamShift = JSON.parse(this.exam.ExamShift);
                //ca thi
                this.listExamShift = this.getUniqueItems(this.selectedListExamShift, 'ExamShiftCode');
            }
        },

        /**
         * Sự kiện nhấn phím
         * @param {*} event
         */
        handleKeyDown(event) {
            if (event.keyCode === this.KeyCode.Enter) {
                //nếu form ca thi , form cảnh báo xóa, form cảnh báo thay đổi ko mở
                //thì gọi hàm lưu kì thi
                if (!this.examShiftDialogVisible && !this.isPopupDelete && !this.warningVisible) {
                    this.saveExamManager();
                }

                //hiển thị form cảnh báo thay đổi đề thi, phòng thi
                //gọi hàm cập nhật ca thi
                if (this.warningVisible) {
                    this.updateExamShift();
                }
            }

            if (event.keyCode === this.KeyCode.Esc) {
                //nếu form ca thi ko mở
                //đóng form kì thi
                if (!this.examShiftDialogVisible && !this.isPopupDelete) {
                    this.$emit("showExamManager");
                    this.$emit("loadExamManager");
                }
            }
        }
    },


    created() {
        //lấy danh sách phòng thi
        this.loadDepartment();
        //lấy danh sách đề thi
        this.getExamBankSetting();
        //thông tin cập nhật nếu ở trạng thái sửa
        this.handlerPropData();
        document.addEventListener('keydown', this.handleKeyDown);
    },


    beforeDestroy() {
        document.removeEventListener('keydown', this.handleKeyDown);
    },

    computed: {
        ...mapState('exambank', ['examBankSetting']),
    }

}
</script>
<style scoped>
.main-view-exam_manger {
    position: absolute;
    top: 0;
    background: #f4f5f8;
    z-index: 10;
    left: 0;
    flex: 1;
    width: 100%;
    height: 100%;
}

.left-box {
    width: 202px;
    margin-right: 18px;
    height: 100%;
}

.box,
.card {
    background-color: #fff;
    border-radius: 4px;
    box-shadow: 0 0 11px rgba(0, 0, 0, .08);
}

.list-tab-menu {
    padding: 33px 8px 0;
    overflow: auto;
    height: 100%;
    color: #707070;
}

.tab-item {
    margin-bottom: 15px;
    cursor: pointer;
}

.list-tab-menu .tab-item-parent.active {
    font-weight: 600;
    color: #ff6d00;
}

.list-tab-menu .tab-item-parent {
    height: 19px;
    margin-bottom: 4px;
    padding-left: 10px;
}

.content-body {
    padding: 17px 20px 12px 16px;
    overflow: auto;
}

.content-body .title-1 {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 15px;
    line-height: 26px;
    align-items: center;
}

.content-body .title-2 {
    font-size: 14px;
    font-weight: 700;
    line-height: 19px;
}

.content-footer {
    padding: 12px 24px;
    border-top: 1px solid #e0e0e0;
}
</style>
