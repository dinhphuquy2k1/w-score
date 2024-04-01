<template>
    <div class="main-view flex1 flex-column" v-if="!isconfigureExam">
        <div class="form-list flex-column flex1">
            <div class="flex-column flex1">
                <div class="flex-row title-box">
                    <div class="list-title flex1">Ngân hàng đề thi</div>
                </div>
                <div class="flex-row toolbar-box">
                    <div class="left-toolbar flex-row">
                        <div class="ms-input ms-editor w-100 search-box mr-2">
                            <div class="flex-row border flex1">
                                <input type="text" class="ms-input-item flex1" placeholder="Tìm kiếm...">
                                <div class="icon24 error error-icon" style="display: none;"></div>
                                <div class="icon24 icon search-right search"></div>
                            </div>
                        </div>
                    </div>
                    <div class="right-toolbar flex-row">
                        <button class="ms-button btn primary" @click="showModal(FormMode.Insert)">
                            <div class="icon24 icon left add-white"></div>
                            <div class="text pl-0">Thêm đề thi</div>
                        </button>
                    </div>
                </div>
                <div class="box list-content flex1 flex-row">
                    <DataTable paginator :rows="10" :rowsPerPageOptions="[5, 10, 20, 50]" class="flex1 flex-column"
                               currentPageReportTemplate="{first} to {last} of {totalRecords}"
                               @rowDblclick="onRowSelect($event.data), onRowUpdate()" :loading="isLoading"
                               paginatorTemplate="FirstPageLink PrevPageLink flex1 CurrentPageReport NextPageLink LastPageLink RowsPerPageDropdown"
                               :value="examBankData" scrollable contextMenu tableStyle="min-width: 100%" rowHover>
                        <template #empty>
                            <div>
                                Không có dữ liệu
                            </div>
                        </template>
                        <template #paginatorstart>
                            <Button type="button" icon="pi pi-refresh" text/>
                        </template>
                        <template #paginatorend>
                            bản ghi/trang
                        </template>
                        <Column header="STT" style="width: 100px;" class="text-center">
                            <template #body="slotProps">
                                <div v-if="!isLoading"> {{ slotProps.index + 1 }}</div>
                                <div v-else>
                                    <Skeleton height="18px" class="mb-2"></Skeleton>
                                </div>
                            </template>
                        </Column>
                        <Column field="ExamBankCode" dataKey="id" header="Mã đề thi">
                            <template #body="{ data, field, slotProps }">
                                <div v-if="!isLoading"> {{ data[field] }}</div>
                                <div v-else>
                                    <Skeleton height="18px" class="mb-2"></Skeleton>
                                </div>
                            </template>
                        </Column>
                        <Column field="ExamBankName" dataKey="id" header="Tên đề thi">
                            <template #body="{ data, field, slotProps }">
                                <div v-if="!isLoading"> {{ data[field] }}</div>
                                <div v-else>
                                    <Skeleton height="18px" class="mb-2"></Skeleton>
                                </div>
                            </template>
                        </Column>
                        <Column field="ResourceFile" dataKey="id" header="File tư liệu">
                            <template #body="{ data, field, slotProps }">
                                <div v-if="!isLoading"> {{ data[field] }}</div>
                                <div v-else>
                                    <Skeleton height="18px" class="mb-2"></Skeleton>
                                </div>
                            </template>
                        </Column>
                        <Column field="RowReference" dataKey="id" header="Dòng tiêu đề">
                            <template #body="{ data, field, slotProps }">
                                <div v-if="!isLoading"> {{ data[field] }}</div>
                                <div v-else>
                                    <Skeleton height="18px" class="mb-2"></Skeleton>
                                </div>
                            </template>
                        </Column>
                        <Column dataKey="id" header="Trạng thái đề thi" style="width: 200px;">
                            <template #body="{ data, field, slotProps }">
                                <div v-if="!isLoading" class="flex-row">
                                    <div class="d-flex status-ctn max-content" v-if="data['isUse']"
                                         style="background-color: rgb(229, 250, 237);">
                                        <div class="status-dot" style="background-color: rgb(0, 200, 83);"></div>
                                        <div class="status-text" style="color: rgb(0, 200, 83);">Đã thiết lập</div>
                                    </div>
                                    <div class="d-flex status-ctn max-content" v-else
                                         style="background-color: rgb(254, 243, 231);">
                                        <div class="status-dot" style="background-color: rgb(243, 141, 21);"></div>
                                        <div class="status-text" style="color: rgb(243, 141, 21);">Chưa thiết lập</div>
                                    </div>
                                </div>
                                <div v-else>
                                    <Skeleton height="18px" class="mb-2"></Skeleton>
                                </div>
                            </template>
                        </Column>
                        <Column dataKey="id" header="Trạng thái sử dụng" style="width: 200px;">
                            <template #body="{ data, field, slotProps }">
                                <div v-if="!isLoading" class="flex-row">
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
                        <Column style="width: 100px;" header="Thao tác" frozen="" alignFrozen="right">
                            <template #body="{ slotProps, index, data }">
                                <div class="row-actions" :ref="`busstop${index}`" @dblclick.stop="unDbl"
                                     v-if="!isLoading">
                                    <div class="position-relative flex-row">
                                        <div class="item" @click="onRowSelect(data), onRowUpdate()">
                                            <div class="v-popover popover">
                                                <div class="trigger">
                                                    <div class="icon24 edit"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item" @click="showActions(index, data)">
                                            <div class="v-popover popover">
                                                <div class="icon24 more"></div>
                                            </div>
                                        </div>
                                        <ul class="v-context" :style="{ top: `${top}px`, left: `${left}px` }"
                                            v-if="isShowActions" v-click-outside="() => isShowActions = false"
                                            @mouseleave="isShowActions = false" @mouseover="">
                                            <!-- toggleConfigureExam(data.ExamBankId) -->
                                            <li class="li-active" @click="isconfigureExam = true">
                                                <div class="action-menu menu-item">
                                                    <div>Thiết lập đề</div>
                                                </div>
                                            </li>
                                            <li class="li-Delete" @click="onRowDelete()">
                                                <div class="action-menu menu-item text-danger">
                                                    <div>Xóa</div>
                                                </div>
                                            </li>
                                        </ul>
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
import vClickOutside from 'click-outside-vue3'
import InputText from 'primevue/inputtext';
import ExamPopup from '@/views/user/components/ExamPopup.vue';
import ExamSetup from '@/views/user/components/ExamSetup.vue';
import DataTable from 'primevue/datatable';
import Dialog from 'primevue/dialog';
import Column from 'primevue/column';
import InputNumber from 'primevue/inputnumber';
import Dropdown from 'primevue/dropdown';
import * as XLSX from 'xlsx';
import Skeleton from 'primevue/skeleton';
import {generateCode} from '@/common/functions'
import Resumable from 'resumablejs';
import TheLoadingProgress from '@/components/LoadingProgress.vue'
import Button from 'primevue/button';
import {deleteExamBank, getExamBank, updateExamBank} from '/api/exam-bank';

export default {
    directives: {
        clickOutside: vClickOutside.directive
    },
    components: {
        ExamPopup,
        ExamSetup,
        DataTable,
        Column,
        Button,
        Dropdown,
        InputText,
        Dialog,
        InputNumber,
        TheLoadingProgress,
        Skeleton,
    },
    data() {
        return {
            selectedData: {
                ExamBankId: null,
                ExamBankCode: null,
                ExamBankName: null,
                SheetIndexReference: null,
                DataReference: null,
                RowReference: null,
                ResourceFile: null,
                ResourcePath: null,
            },

            objSelectedData: {},
            objFileSelected: null,

            popupLoading: false,

            warningVisible: false,

            defaultData: {
                ExamBankId: null,
                ExamBankCode: null,
                ExamBankName: null,
                SheetIndexReference: null,
                DataReference: null,
                RowReference: null,
                ResourceFile: null,
                ResourcePath: null,
            },

            invalidData: {
                ExamBankCode: null,
                ExamBankName: null,
                SheetIndexReference: null,
                RowReference: null,
                FileData: null
            },


            sheetOptions: [],
            selectedSheet: {},
            File: {
                FileName: null,
                FileSize: null,
                Success: true,
                SheetCount: 1,
            },

            defaultFile: {
                FileName: null,
                FileSize: null,
                Success: true,
                SheetCount: 1,
            },

            defaultResumable: null,

            FileName: null,
            modeModal: this.FormMode.Insert,
            modeGenerate: true,
            examBankData: [],

            selectedFile: null,
            resumable: null,
            isShowModal: false,
            isShowActions: false,
            isLoading: false,
            isPopupDelete: false,
            url: '/selectedData',
            top: 0,
            left: 0,
            isconfigureExam: false,
        }
    },
    methods: {
        /**
         * Ẩn / hiện model thêm mới
         */
        showModal(modeModal) {
            this.modeModal = modeModal;
            this.isShowModal = !this.isShowModal;
        },

        async doSave() {
            try {
                if (this.validateExamBank()) {
                    this.popupLoading = true;
                    var data = {...this.selectedData};
                    delete data['DataReference'];
                    delete data['created_at'];
                    delete data['updated_at'];
                    this.resumable.opts.query.FileInfo = this.File.FileSize;
                    this.resumable.opts.query.param = JSON.stringify(data);
                    var me = this;
                    switch (this.modeModal) {
                        case this.FormMode.Insert:
                            this.resumable.opts.target = 'exambank';
                            this.resumable.addFile(this.selectedFile);
                            break;
                        case this.FormMode.Update:
                            if (JSON.stringify(this.selectedData) != JSON.stringify(this.objSelectedData) || JSON.stringify(this.File) != JSON.stringify(this.objFileSelected)) {
                                //update file tư liệu
                                if (this.selectedFile) {
                                    this.resumable.opts.target = 'api/exambank/updateExambank';
                                    this.resumable.addFile(this.selectedFile);
                                }
                                //update tên, mã, dòng, sheet
                                else {
                                    await updateExamBank(data).then(res => {
                                        this.showToast("Cập nhật đề thi thành công");
                                        this.loadExamBank();
                                    }).catch(error => {
                                        if (error.response.status == 422) {
                                            for (var itemError in error.response.data.errors) {
                                                this.invalidData[itemError] = error.response.data.errors[itemError][0];
                                            }
                                        } else {
                                            this.showToast("Có lỗi xảy ra, vui lòng liên hệ nhà phát triển", 'error');
                                        }
                                    }).finally(() => this.showModal(), this.popupLoading = false);
                                }
                            } else {
                                this.popupLoading = false;
                                this.showModal();
                            }
                            break;
                        default:
                            break;
                    }
                }
            } catch (error) {
                console.log(error);
            }
        },

        /**
         * Click nút xóa
         */
        onRowDelete() {
            //đề thi đang được sử dụng
            if (this.selectedData.is_exist) {
                this.warningVisible = true;
            }
            //không sử dụng
            else {
                this.isPopupDelete = true;
            }
        },

        /**
         * Xử lý hàm sinh mã theo tên
         */
        handlerGenerateCode() {
            if (this.modeGenerate) this.selectedData.ExamBankCode = generateCode(this.selectedData.ExamBankName);
        },

        /**
         * Validate mã phòng thi
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
         * Ẩn hiện action row
         * @param {*} index
         * @param {*} data
         */
        showActions(index, data) {
            this.isShowActions = !this.isShowActions;
            this.selectedData = data;
            var position = this.$refs[`busstop${index}`].getBoundingClientRect();
            this.top = position.y + position.height;
            this.left = position.x - position.width / 2;
        },

        /**
         * Load dữ liệu ngân hàng đề thi
         */
        async loadExamBank() {
            this.isLoading = true;
            await getExamBank().then(res => {
                this.examBankData = res;
            }).catch(error => {

            });
            setTimeout(() => {
                this.isLoading = false;
            }, 750);
        },

        /**
         * Click nút xóa phòng thi
         */
        handlerDelete() {
            deleteExamBank(this.selectedData.ExamBankId).then(res => {
                this.isPopupDelete = false;
                this.showToast('Xóa thành công');
                this.loadExamBank();
            }).catch(error => {

                console.log(error);
            })
        },

        /**
         * Ẩn form
         */
        afterHide() {
            this.selectedData = {...this.defaultData};
            this.selectedFile = null;
            this.File = {...this.defaultFile};
            this.sheetOptions = [];
            this.invalidData = [];
            this.selectedSheet = {};
            this.exambank = {};
        },

        /**
         *  Validate dữ liệu
         *  @return bool
         */
        validateExamBank() {
            var invalid = true;
            this.invalidData = [];
            if (this.selectedData.ExamBankCode == null || this.selectedData.ExamBankCode == '') {
                invalid = false;
                this.invalidData.ExamBankCode = 'Mã đề thi không được để trống';
            } else {
                this.invalidData.ExamBankCode = null;
            }
            if (this.selectedData.ExamBankName == null || this.selectedData.ExamBankName == '') {
                invalid = false;
                this.invalidData.ExamBankName = 'Tên đề thi không được để trống';
            } else {
                this.invalidData.ExamBankName = null;
            }
            if (this.selectedData.RowReference == null || this.selectedData.RowReference == '') {
                invalid = false;
                this.invalidData.RowReference = 'Dòng tiêu đề không được để trống';
            } else {
                this.invalidData.RowReference = null;
            }
            if (this.selectedData.SheetIndexReference == null) {
                invalid = false;
                this.invalidData.SheetIndexReference = 'Sheet tư liệu không được để trống';
            } else {
                this.invalidData.SheetIndexReference = null;
            }
            if (!this.File.Success) {
                invalid = false;
            }
            return invalid;
        },

        /**
         * Hiển thị toast message
         * @param {*} message
         */
        showToast(message, severity = 'success') {
            this.$toast.add({severity: severity, summary: 'Thông báo', detail: message, life: 3000});
        },

        /**
         * Sự kiện thay đổi file
         * @param {*} ref ref input
         *
         */
        onFileChange(ref) {
            if (this.$refs[ref].files[0].type === "application/vnd.ms-excel" || this.$refs[ref].files[0].type === "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
                this.selectedFile = this.$refs[ref].files[0];
                this.sheetOptions = [];
                var _size = this.selectedFile.size;
                var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
                    i = 0;
                while (_size > 900) {
                    _size /= 1024;
                    i++;
                }
                this.File.FileSize = (Math.round(_size * 100) / 100) + ' ' + fSExt[i];
                this.File.FileName = this.selectedFile.name;
                //kiểm tra dung lượng file
                if (this.$refs[ref].files[0].size > 30 * 1024 * 1024) {
                    this.File.Success = false;
                    this.sheetOptions = [];
                    this.selectedData.RowReference = null;
                } else {
                    this.File.Success = true;
                    //đọc file upload lấy ra danh sách tên các sheet
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        /* Parse data */
                        const bstr = e.target.result;
                        const workbook = XLSX.read(bstr, {type: 'binary'});
                        //gán sheet mặc định là sheet đầu tiên
                        this.nameSheet = workbook.SheetNames[0];
                        //duyệt các sheet
                        for (let index = 0; index < workbook.SheetNames.length; index++) {
                            this.sheetOptions.push({
                                sheetIndex: index,
                                sheetName: workbook.SheetNames[index]
                            });
                        }
                        this.File.SheetCount = workbook.SheetNames.length;
                        this.selectedSheet = this.sheetOptions[0];
                    }
                    reader.readAsBinaryString(this.selectedFile);
                }
            } else {
                this.contentDialog = ' File tư liệu chỉ hỗ trợ định dạng *.xlsx';
                this.dialogVisible = true;
            }
        },

        /**
         * Thêm file
         * @param {*} file
         */
        onFileAdded(file) {
            this.resumable.upload();
        },


        /**
         * Tiến trình tải
         * @param {*} file
         */
        onFileProgress(file) {

        },

        /**
         * Upload thành công
         * @param {*} file
         * @param {*} response
         */
        onFileSuccess(file, response) {
            this.resumable.removeFile(file);
            this.popupLoading = false;
            this.showModal();
            var message = this.modeModal == this.FormMode.Insert ? "Thêm đề thi thành công" : "Cập nhật đề thi thành công";
            this.showToast(message);
            this.loadExamBank();
        },

        /**
         * Cập nhật đề thi
         */
        onRowUpdate() {
            var dataReference = JSON.parse(this.selectedData.DataReference);
            var sheetIndexReference = JSON.parse(this.selectedData.SheetIndexReference);
            this.selectedData.SheetIndexReference = sheetIndexReference[1];
            this.sheetOptions = sheetIndexReference[0];
            this.File.FileSize = this.selectedData.FileInfo;
            this.File.FileName = this.selectedData.ResourceFile;

            //object để kiểm tra xem bản ghi có thay đối hay ko
            this.objSelectedData = {...this.selectedData};
            this.objFileSelected = {...this.File};

            this.showModal(this.FormMode.Update);
        },

        /**
         * Upload thất bại
         * @param {*} file
         * @param {*} message
         */
        onFileError(file, message) {
            try {
                this.popupLoading = false;
                this.resumable.removeFile(file);
                message = JSON.parse(message);
                if (message.errorCode == 422) {
                    for (var error in message.errors) {
                        this.invalidData[error] = message.errors[error][0];
                    }
                } else {
                }
            } catch (error) {
                console.log(error);
            }
        },

        /**
         * Khởi tạo Resumable upload file
         */
        createResumable() {
            this.resumable = new Resumable({
                target: 'exambank',
                method: 'POST',
                query: {
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // Thêm CSRF token để tránh lỗi 419
                },
                headers: {
                    'Accept': 'application/json',
                    'Content-Disposition': 'form-data; name="title"',
                },
                testChunks: false,
                throttleProgressCallbacks: 1,
                simultaneousUploads: 4,
            });
            this.resumable.on('fileAdded', this.onFileAdded);
            this.resumable.on('fileProgress', this.onFileProgress);
            this.resumable.on('fileSuccess', this.onFileSuccess);
            this.resumable.on('fileError', this.onFileError);
        },


        /**
         *
         */
        onRowSelect(data) {
            this.selectedData = {...data};
        }
    },
    async created() {
        this.loadExamBank();
    },

    mounted() {
        this.createResumable();
    },
}
</script>
