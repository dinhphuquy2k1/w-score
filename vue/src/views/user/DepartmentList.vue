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
                    <Button
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
                    <Column field="DepartmentCode" style="width: 30vw;" header="Mã phòng thi">
                        <template #body="{ data, field, slotProps }">
                            <div v-if="!isLoading"> {{ data[field] }}</div>
                            <div v-else>
                                <Skeleton height="18px" class="mb-2"></Skeleton>
                            </div>
                        </template>
                    </Column>
                    <Column field="DepartmentName" dataKey="id" header="Tên phòng thi">
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
            :header="modeModal == FormMode.Insert ? 'Thêm đề thi' : 'Sửa đề thi'" @afterHide="afterHide"
            :style="{ width: '35vw' }" closeOnEscape>
        <TheLoadingProgress v-if="popupLoading"/>
        <div class="w-full flex flex-column">
            <div class="form-group flex-row">
                <div class="flex1 mr-10">
                    <div class="form-group-label d-flex label-form">
                        Tên đề thi
                        <span class="required">*</span>
                    </div>
                    <div class="ms-input ms-editor w-100">
                        <InputText v-model="selectedData.ExamBankName" type="text" class="ms-input-item flex1"
                                   :class="{ 'error': invalidData['ExamBankName'] }" placeholder="Nhập tên phòng thi"
                                   @input="handlerGenerateCode"/>
                        <div class="error-text" v-if="invalidData['ExamBankName']">
                            {{ invalidData['ExamBankName'] }}
                        </div>
                    </div>
                    <div class="flex1">
                        <div class="ms-input ms-editor w-100"></div>
                    </div>
                </div>
                <div class="flex1 mr-10">
                    <div class="form-group-label d-flex label-form">
                        Mã phòng thi
                        <span class="required">*</span>
                    </div>
                    <div class="ms-input ms-editor w-100">
                        <InputText v-model="selectedData.ExamBankCode" type="text" class="ms-input-item flex1"
                                   :class="{ 'error': invalidData['ExamBankCode'] }" placeholder="Nhập mã phòng thi"
                                   @keypress="handlerInputCode"
                                   @input="modeGenerate = selectedData.DepartmentCode ? false : true;"/>
                        <div class="error-text" v-if="invalidData['ExamBankCode']">
                            {{ invalidData['ExamBankCode'] }}
                        </div>
                    </div>
                    <div class="flex1">
                        <div class="ms-input ms-editor w-100"></div>
                    </div>
                </div>
            </div>
            <div class="form-group flex-row">
                <div class="flex1 mr-10">
                    <div class="content-step d-flex">
                        <div class="upload-container flex1 flex-center" v-if="!File.FileName"
                             @click="$refs.fileInput.click()">
                            <div class="no-file d-flex">
                                <input type="file" id="fileInput" ref="fileInput" @change="onFileChange('fileInput')"
                                       accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                       hidden>
                            </div>
                        </div>
                        <div class="import-attachment-container flex1" v-else>
                            <div class="file-info d-flex">
                                <div class="d-flex flex1">
                                    <div class="file-icon text-left"></div>
                                    <div class="file-name flex text-left">{{ File.FileName }}</div>
                                </div>
                                <div class="file-size text-left flex1"> {{ File.FileSize }}</div>
                                <div class="file-accepted text-left d-flex flex1">
                                    <div class="icon-success" v-if="File.Success"></div>
                                    <div v-if="File.Success">Hợp lệ</div>
                                    <div class="icon-unsuccess" v-if="!File.Success"></div>
                                    <div v-if="!File.Success">Không hợp lệ</div>
                                </div>
                                <input type="file" ref="fileInput1" hidden @change="onFileChange('fileInput1')"
                                       accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                <div class="change-file blue-text pointer flex1 text-right text-link"
                                     @click="$refs.fileInput1.click()"> Đổi tệp khác
                                </div>
                            </div>
                            <div class="file-caution" v-if="File.Success">
                                <div class="file-caution-img"></div>
                                <div class="file-caution-center mt-20">
                                    Lưu ý <span style="color: red;">*</span>: Bạn vui lòng chọn sheet tư
                                    liệu và dòng tiêu đề
                                    <br>của sheet đó.
                                </div>
                            </div>
                            <div class="file-error" v-if="!File.Success">
                                <div class="file-error-title red-text"> Lý do không hợp lệ:</div>
                                <div class="file-error-title red-text">- Dung lượng quá lớn</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group flex-row">
                <div class="flex1 mr-10">
                    <div class="form-group-label d-flex label-form">
                        Sheet tư liệu
                        <span class="required">*</span>
                    </div>
                    <div class="ms-input ms-editor w-100">
                        <Dropdown :options="sheetOptions" optionLabel="sheetName" optionValue="sheetIndex"
                                  :class="{ 'error': invalidData['SheetIndexReference'] }"
                                  v-model="selectedData.SheetIndexReference"
                                  dropdownIcon="icon-combo--dropdown dropdown-list"/>
                        <div class="error-text" v-if="invalidData['SheetIndexReference']">
                            {{ invalidData['SheetIndexReference'] }}
                        </div>
                    </div>
                    <div class="flex1">
                        <div class="ms-input ms-editor w-100"></div>
                    </div>
                </div>
                <div class="flex1 mr-10">
                    <div class="form-group-label d-flex label-form">
                        Dòng tiêu đề
                        <span class="required">*</span>
                    </div>
                    <div class="ms-input ms-editor w-100">
                        <InputNumber v-model="selectedData.RowReference" ref="RowReference" showButtons :min="1"
                                     :class="{ 'error': invalidData['RowReference'] }" :max-fraction-digits="5"
                                     :max="100"/>
                        <div class="error-text" v-if="invalidData['RowReference']">
                            {{ invalidData['RowReference'] }}
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
                        @click="isShowModal = false, selectedData = defaultData"/>
                <Button label="Lưu" class="ms-button btn detail-button primary" @click="doSave" @keyup.enter="doSave"/>
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
    <Toast/>
</template>

<script>
import Toast from 'primevue/toast';
import Skeleton from 'primevue/skeleton';
import InputText from 'primevue/inputtext';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import {generateCode} from '@/common/functions'
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
        Toast,
        DataTable,
        Column,
        Skeleton,
    },

    data() {
        return {
            departmentPopupVisible: false,
            modePopup: this.FormMode.Insert,
            department: {
                DepartmentId: null,
                DepartmentName: null,
                DepartmentCode: null,
            },
            warningVisible: false,
            dataChanged: null,

            data: [],  // data table

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
            if (this.modeGenerate) this.department.DepartmentCode = generateCode({value: this.department.DepartmentName});
        },

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
         * Lưu phòng thi
         */
        doSave(event) {
            event.preventDefault();
            this.invalidData = [];
            if (this.validateData()) {
                switch (this.modePopup) {
                    case this.FormMode.Insert:
                        saveData(this.department).then(res => {
                            this.department = {};
                            this.showToast('Thêm thành công');
                            this.departmentPopupVisible = false;
                        }).catch(error => {
                            if (error.response.status == 422) {
                                for (var itemError in error.response.data.errors) {
                                    // console.log(error.response.data.errors);
                                    this.invalidData[itemError] = error.response.data.errors[itemError][0];
                                }
                            }
                            return;
                        })
                        break;
                    case this.FormMode.Update:
                        if (JSON.stringify(this.dataChanged) !== JSON.stringify(this.department)) {
                            updateDepartment(this.department).then(res => {
                                this.department = {};
                                this.departmentPopupVisible = false;
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
                        } else this.departmentPopupVisible = false;
                        break;
                    default:
                        break;
                }
            }
            this.modeGenerate = true;
            this.loadData();
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
            if (this.department.DepartmentName == null) {
                this.invalidData['DepartmentName'] = "Tên phòng thi không được để trống";
                invalid = false;
            }
            if (this.department.DepartmentCode == null) {
                this.invalidData['DepartmentCode'] = "Mã phòng thi không được để trống";
                invalid = false;
            }
            return invalid;
        },

        /**
         * Lấy thông tin bản ghi
         * @param {*} data
         */
        onRowSelect(data) {
            this.modePopup = this.FormMode.Update;
            this.department = {...data};
            this.dataChanged = data;
            this.departmentPopupVisible = true;
        },

        /**
         * Click nút thêm phòng thi
         */
        btnInsertDepartment() {
            //set form mode
            this.modePopup = this.FormMode.Insert;
            //mở popup
            this.departmentPopupVisible = true;
            this.department = {};

        },

        /**
         * Load dữ liệu
         */
        async loadData() {
            this.isLoading = true;
            // this.data = Array.from({ length: 5 }, () => ({ ...this.department }));
            await getDataDepartment().then(res => {
                this.data = res;
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
            //     { DepartmentCode: 1, DepartmentName: 1 }
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
