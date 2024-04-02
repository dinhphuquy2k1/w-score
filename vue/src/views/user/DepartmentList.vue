<template>
    <div class="form-list flex-grow-1 d-flex">
        <div class="d-flex flex-column flex-grow-1">
            <div class="d-flex flex-row title-box">
                <div class="list-title flex-grow-1 text-start">Danh sách phòng thi</div>
            </div>
            <div class="d-flex flex-row toolbar-box justify-content-between">
                <div class="left-toolbar d-flex flex-row">
                    <div class="m-search_form flex-row d-flex align-items-center d-flex">
                        <InputText type="search" v-model="value" class="ms-input_search w-100" placeholder="Tìm kiếm"/>
                        <div class="icon24 icon search-right search"></div>
                    </div>
                </div>
                <div class="right-toolbar d-flex flex-row">
                    <Button @click="isShowModal = !isShowModal"
                            class="ms-btn primary d-flex justify-content-center flex-grow-1 ms-btn_search ps-3 pe-3 gap-2">
                        <div class="icon24 icon-add-white"></div>
                        <div class="fw-semibold">Thêm phòng thi</div>
                    </Button>
                </div>
            </div>
            <div class="box list-content flex-grow-1 flex-row">
                <DataTable paginator :rows="10" :rowsPerPageOptions="[5, 10, 20, 50]" class="flex1 flex-column"
                           :class="{ 'loading': isLoading }" :loading="isLoading"
                           :value="isLoading ? Array.from({ length: 8 }, () => ({ ...this.department })) : data"
                           currentPageReportTemplate="{first} to {last} of {totalRecords}"
                           paginatorTemplate="FirstPageLink PrevPageLink flex1 CurrentPageReport NextPageLink LastPageLink RowsPerPageDropdown"
                           @rowDblclick="onRowSelect($event.data)" tableStyle="min-width: 100%" rowHover>
                    <template #paginatorstart>
                        <Button type="button" icon="pi pi-refresh" text/>
                    </template>
                    <template #paginatorend>
                        bản ghi/trang
                    </template>
                    <template #empty>
                        <div>
                            Không có dữ liệu
                        </div>
                    </template>
                    <Column header="STT" style="width: 100px;" class="text-center">
                        <template #body="slotProps">
                            <div v-if="!isLoading"> {{ slotProps.index + 1 }}</div>
                            <div v-else>
                                <Skeleton height="18px" class="mb-2"></Skeleton>
                            </div>
                        </template>
                    </Column>
                    <Column field="department_code" style="width: 30vw;" header="Mã phòng thi">
                        <template #body="{ data, field, slotProps }">
                            <div v-if="!isLoading"> {{ data[field] }}</div>
                            <div v-else>
                                <Skeleton height="18px" class="mb-2"></Skeleton>
                            </div>
                        </template>
                    </Column>
                    <Column field="department_name" dataKey="id" header="Tên phòng thi">
                        <template #body="{ data, field, slotProps }">
                            <div v-if="!isLoading"> {{ data[field] }}</div>
                            <div v-else>
                                <Skeleton height="18px" class="mb-2"></Skeleton>
                            </div>
                        </template>
                    </Column>
                    <Column dataKey="id" header="Trạng thái" style="width: 200px;">
                        <template #body="{ data, field, slotProps }">
                            <div v-if="!isLoading">
                                <div class="d-flex status-ctn max-content" v-if="data['is_exist']"
                                     style="background-color: rgb(229, 250, 237);">
                                    <div class="status-dot" style="background-color: rgb(0, 200, 83);"></div>
                                    <div class="status-text" style="color: rgb(0, 200, 83);">Đang sử dụng</div>
                                </div>
                                <div class="d-flex status-ctn max-content" v-else
                                     style="background-color: rgb(254, 243, 231);">
                                    <div class="status-dot" style="background-color: rgb(243, 141, 21);"></div>
                                    <div class="status-text" style="color: rgb(243, 141, 21);">Không sử dụng</div>
                                </div>
                            </div>
                            <div v-else>
                                <Skeleton height="18px" class="mb-2"></Skeleton>
                            </div>
                        </template>
                    </Column>
                    <Column alignFrozen="right" style="width: 100px; text-align: center;" frozen header="Thao tác">
                        <template #body="slotProps">
                            <div class="row-actions flex-row" v-if="!isLoading">
                                <div class="item" @click="onRowSelect(slotProps.data)">
                                    <div class="v-popover popover">
                                        <div class="trigger">
                                            <div class="icon24 edit"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item" @click="deleteRowSelect(slotProps.data)">
                                    <div class="v-popover popover">
                                        <div class="icon24 delete"></div>
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
    </div>
    <Dialog v-model:visible="isPopupDelete" modal closeOnEscape :style="{ width: '25vw', height: '20vh' }"
            header="Xóa đề thi">
        <div class="w-full flex flex-column">
            <span> Bạn có chắc chắn muốn xóa đề thi <b>{{ selectedData.ExamBankCode }}</b> không?</span>
        </div>
        <template #footer>
            <Button label="Không" class="ms-button btn detail-button secondary" @click="isPopupDelete = false"/>
            <Button label="Xóa đề thi" class="ms-button btn w-100 danger" @click="handlerDelete"/>
        </template>
    </Dialog>

    <Dialog v-model:visible="isShowModal" @keydown.enter.prevent="doSave" modal
            @afterHide="afterHideDialog"
            :header="modePopup == FormMode.INSERT ? 'Thêm phòng thi' : 'Sửa phòng thi'" :style="{ width: '30vw' }"
            closeOnEscape>
        <div class="w-full flex flex-column">
            <div class="form-group flex-row">
                <div class="flex1 mr-10">
                    <div class="group-form_box">
                        <div class="label">Tên phòng thi<span class="required">*</span></div>
                        <div class="mt-2">
                            <InputText v-model="department.department_name" placeholder="Tên phòng thi"
                                       :class="{ 'error': invalidData['department_name'] }"
                                       @input="handlerGenerateCode"></InputText>
                        </div>
                        <div class="ms-error-text" v-if="invalidData['department_name']">
                            {{ invalidData['department_name'] }}
                        </div>
                    </div>
                </div>
                <div class="flex1 mr-10">
                    <div class="ms-input ms-editor w-100">
                        <div class="group-form_box">
                            <div class="label">Mã phòng thi<span class="required">*</span></div>
                            <div class="mt-2">
                                <InputText v-model="department.department_code" placeholder="Mã phòng thi"
                                           :class="{ 'error': invalidData['department_code'] }"
                                           @keypress="handlerInputdepartment_code"
                                           @input="modeGenerate = department.department_code ? false : true;"></InputText>
                            </div>
                            <div class="ms-error-text" v-if="invalidData['department_code']">
                                {{ invalidData['department_code'] }}
                            </div>
                        </div>
                    </div>
                    <div class="flex1">
                        <div class="ms-input ms-editor w-100"></div>
                    </div>
                </div>
            </div>
        </div>
        <template #footer>
            <div class="d-flex flex-row">
                <div class="flex1"></div>
                <Button label="Đóng" class="ms-button btn detail-button secondary"
                        @click="isShowModal = false"/>
                <Button @click="doSave" @keyup.enter="doSave"
                        class="ms-btn primary blue d-flex justify-content-center flex-grow-1 ms-btn_search ps-3 pe-3 gap-2">
                    <div class="fw-semibold">Lưu</div>
                </Button>
            </div>

        </template>
    </Dialog>

    <Dialog v-model:visible="warningVisible" modal closeOnEscape :style="{ width: '25vw', height: '20vh' }"
            header="Thông báo">
        <div class="w-full flex flex-column">
            <span> Đề thi <b>{{ selectedData.ExamBankName }}</b> đang được sử dụng. Bạn không thể xóa.</span>
        </div>
        <template #footer>
            <Button label="Đóng" class="ms-button btn detail-button secondary" @click="warningVisible = false"/>
        </template>
    </Dialog>
    <ExamSetup :selectedData="selectedData" v-if="isconfigureExam"/>
</template>

<script>
import Skeleton from 'primevue/skeleton';
import InputText from 'primevue/inputtext';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import {generateCode} from '@/common/functions'
import {RESPONSE_STATUS} from "@/common/enums";
import {saveData, getDataDepartment, updateDepartment, deleteDepartment} from '/api/department';
import ExamSetup from "@/views/user/components/ExamSetup.vue";
import TheLoadingProgress from "@/components/LoadingProgress.vue";

export default {
    name: "DepartmentList",
    components: {
        TheLoadingProgress, ExamSetup,
        Dialog,
        Button,
        InputText,
        DataTable,
        Column,
        Skeleton,
    },

    data() {
        return {
            modePopup: this.FormMode.INSERT,
            department: {
                DepartmentId: null,
                department_name: null,
                department_code: null,
            },
            warningVisible: false,
            dataChanged: null,

            data: [],  // data table
            isShowModal: false,
            popupLoading: false,

            isLoading: false,

            isPopupDelete: false,

            invalidData: [],   //mảng chứa thông tin lỗi
            modeGenerate: true, //cho phép sinh mã theo tên
        }
    },
    methods: {

        /**
         * Xử lý hàm sinh mã theo tên
         */
        handlerGenerateCode() {
            if (this.modeGenerate) this.department.department_code = generateCode({value: this.department.department_name});
        },

        /**
         * Validate mã phòng thi
         * Ko cho phép nhập các kí tự đặc biệt
         * @param {*} event
         */
        handlerInputdepartment_code(event) {
            let pattern = /[\W_]/g;
            let res = event.key.match(pattern);
            if (res) {
                event.preventDefault();
            }
        },

        /**
         * Lưu phòng thi
         */
        doSave(event) {
            event.preventDefault();
            this.invalidData = [];
            if (this.validateData()) {
                switch (this.modePopup) {
                    case this.FormMode.INSERT:
                        saveData(this.department).then(res => {
                            this.department = {};
                            this.showToast('Thêm thành công');
                            this.isShowModal = false;
                            this.loadData();
                        }).catch(error => {
                            if (error.response.status === RESPONSE_STATUS.HTTP_UNPROCESSABLE_ENTITY) {
                                this.$store.dispatch('handleError');
                                for (const itemError in error.response.data.errors) {
                                    this.invalidData[itemError] = error.response.data.errors[itemError][0];
                                }
                            }
                        })
                        break;
                    case this.FormMode.UPDATE:
                        if (JSON.stringify(this.dataChanged) !== JSON.stringify(this.department)) {
                            updateDepartment(this.department).then(res => {
                                this.department = {};
                                this.isShowModal = false;
                                this.showToast('Cập nhật thành công');
                                this.loadData();
                            }).catch(error => {
                                if (error.response.status == 422) {
                                    for (var itemError in error.response.data.errors) {
                                        this.invalidData[itemError] = error.response.data.errors[itemError][0];
                                    }
                                }
                                return;
                            });
                        } else this.isShowModal = false;
                        break;
                    default:
                        break;
                }
            }
            this.modeGenerate = true;
        },

        /**
         * Click nút xóa phòng thi
         */
        handlerDelete() {
            deleteDepartment(this.department.DepartmentId).then(res => {
                this.isPopupDelete = false;
                this.showToast('Xóa thành công');
                this.loadData();
            }).catch(error => {
                console.log(error);
            })
        },

        /**
         * Hiển thị toast message
         * @param {*} message
         */
        showToast(message, severity = 'success') {
            this.$toast.add({severity: severity, summary: 'Thông báo', detail: message, life: 3000});
        },


        afterHideDialog() {
            this.department = {
                id: null,
                department_name: null,
                department_code: null,
            };
        },

        /**
         * Xóa phòng thi
         * @param {*} data
         */
        deleteRowSelect(data) {
            if (data.is_exist) {
                this.warningVisible = true;
            } else {
                this.isPopupDelete = true;
                this.department = data;
            }
        },

        /**
         * validate dữ liệu
         */
        validateData() {
            var invalid = true;
            if (this.department.department_name == null) {
                this.invalidData['department_name'] = "Tên phòng thi không được để trống";
                invalid = false;
            }
            if (this.department.department_code == null) {
                this.invalidData['department_code'] = "Mã phòng thi không được để trống";
                invalid = false;
            }
            return invalid;
        },

        /**
         * Lấy thông tin bản ghi
         * @param {*} data
         */
        onRowSelect(data) {
            this.modePopup = this.FormMode.UPDATE;
            this.department = {...data};
            this.dataChanged = data;
            this.isShowModal = true;
        },

        /**
         * Load dữ liệu
         */
        async loadData() {
            this.isLoading = true;
            // this.data = Array.from({ length: 5 }, () => ({ ...this.department }));
            await getDataDepartment().then(res => {
                this.data = res.data;
            }).catch(error => {
                console.log(error);
            })
                .finally(() => {
                    setTimeout(() => {
                        this.isLoading = false;
                    }, 750);
                });

            // console.log(this.data);
            // console.log(Array.from({ length: 10 }, () => ({ ...this.department })));
            // this.data = [
            //     { department_code: 1, department_name: 1 }
            // ]
            // debugger
        }
    },

    created() {
        this.loadData();
    },

    mounted() {
    }
}
</script>
