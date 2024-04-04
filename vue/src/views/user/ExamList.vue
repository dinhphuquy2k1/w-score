<template>
    <div class="form-list flex-grow-1 d-flex">
        <div class="d-flex flex-column flex-grow-1">
            <div class="d-flex flex-row title-box">
                <div class="list-title flex-grow-1 text-start">Danh sách đề thi</div>
            </div>
            <div class="d-flex flex-row toolbar-box justify-content-between">
                <div class="left-toolbar d-flex flex-row">
                    <div class="m-search_form flex-row d-flex align-items-center d-flex">
                        <InputText type="search" v-model="search" class="ms-input_search w-100" placeholder="Tìm kiếm"/>
                        <div class="icon24 icon search-right search"></div>
                    </div>
                </div>
                <div class="right-toolbar d-flex flex-row">
                    <Button
                        @click="isShowModal = !isShowModal, modeGenerate = true, modeModal = FormMode.INSERT"
                        class="ms-btn primary d-flex justify-content-center flex-grow-1 ms-btn_search ps-3 pe-3 gap-2">
                        <div class="icon24 icon-add-white"></div>
                        <div class="fw-semibold">Thêm đề thi</div>
                    </Button>
                </div>
            </div>
            <div class="box list-content flex-grow-1 flex-row">
                <DataTable paginator :rows="10" :rowsPerPageOptions="[5, 10, 20, 50]" class="flex1 flex-column"
                           :class="{ 'loading': isLoading }" :loading="isLoading"
                           :value="isLoading ? Array.from({ length: 8 }, () => ({ ...objectLoading })) : examBankData"
                           currentPageReportTemplate="{first} to {last} of {totalRecords}"
                           paginatorTemplate="FirstPageLink PrevPageLink flex1 CurrentPageReport NextPageLink LastPageLink RowsPerPageDropdown"
                           @rowDblclick="onRowSelect($event.data), isShowModal = true" tableStyle="min-width: 100%"
                           rowHover>
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
                    <Column field="exam_bank_name" style="width: 30vw;" header="Tên đề thi">
                        <template #body="{ data, field, slotProps }">
                            <div v-if="!isLoading"> {{ data[field] }}</div>
                            <div v-else>
                                <Skeleton height="18px" class="mb-2"></Skeleton>
                            </div>
                        </template>
                    </Column>
                    <Column field="exam_bank_code" dataKey="id" header="Mã đề thi">
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
    <Dialog v-model:visible="isPopupDelete" modal closeOnEscape :style="{ width: '25vw' }" header="Xóa kì thi">
        <TheLoadingProgress v-if="isLoadingDelete"/>
        <div class="w-full flex flex-column" style="line-height: 1.5;">
            <span> Bạn có chắc chắn muốn xóa đề thi <b>{{ selectedData.exam_bank_code }}</b> không?</span>
        </div>
        <template #footer>
            <Button label="Không" class="ms-button btn detail-button secondary" @click="isPopupDelete = false"/>
            <Button label="Xóa phòng thi" class="ms-button btn w-100 danger" @click="handlerDelete"/>
        </template>
    </Dialog>

    <Dialog v-model:visible="isShowModal" @keydown.enter.prevent="doSave" modal
            :header="modeModal == FormMode.INSERT ? 'Thêm đề thi' : 'Sửa đề thi'" @afterHide="afterHide"
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
                        <InputText v-model="selectedData.exam_bank_name"
                                   :class="{ 'error': invalidData['exam_bank_name'] }"
                                   @input="handlerGenerateCode"
                                   placeholder="Nhập tên đề thi"/>
                        <div class="error-text" v-if="invalidData['exam_bank_name']">
                            {{ invalidData['exam_bank_name'] }}
                        </div>
                    </div>
                </div>
                <div class="flex1 mr-10">
                    <div class="form-group-label d-flex label-form">
                        Mã đề thi
                        <span class="required">*</span>
                    </div>
                    <div class="ms-input ms-editor w-100">
                        <InputText v-model="selectedData.exam_bank_code"
                                   :class="{ 'error': invalidData['exam_bank_code'] }"
                                   @keypress="handlerInputCode"
                                   @input="modeGenerate = selectedData.exam_bank_code ? false : true"
                                   placeholder="Nhập mã đề thi"/>
                        <div class="error-text" v-if="invalidData['exam_bank_code']">
                            {{ invalidData['exam_bank_code'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <template #footer>
            <div class="d-flex flex-row">
                <div class="flex1"></div>
                <Button
                    @click="isShowModal = false, selectedData = defaultData"
                    class="ms-btn secondary blue me-3 d-flex justify-content-center ms-btn_search ps-3 pe-3 gap-2">
                    <div class="">Đóng</div>
                </Button>
                <Button @click="doSave" @keyup.enter="doSave"
                        class="ms-btn primary blue d-flex justify-content-center ms-btn_search ps-3 pe-3 gap-2">
                    <div class="">Lưu</div>
                </Button>
            </div>
        </template>
    </Dialog>

    <Dialog v-model:visible="warningVisible" modal closeOnEscape :style="{ width: '25vw', height: '20vh' }"
            header="Thông báo">
        <div class="w-full flex flex-column">
            <span> Đề thi <b>{{ selectedData.exam_bank_name }}</b> đang được sử dụng. Bạn không thể xóa.</span>
        </div>
        <template #footer>
            <Button label="Đóng" class="ms-button btn detail-button secondary" @click="warningVisible = false"/>
        </template>
    </Dialog>
    <ExamSetup :selectedData="selectedData" v-if="isconfigureExam"/>
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
import {deleteExamBank, getExamBank, insertExamBank, updateExamBank} from '/api/exam-bank';
import {MESSAGE, RESPONSE_STATUS} from "@/common/enums";

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
            search: null,
            selectedData: {
                id: null,
                exam_bank_code: null,
                exam_bank_name: null,
            },

            objSelectedData: {},
            objFileSelected: null,

            isLoadingDelete: false,
            popupLoading: false,

            warningVisible: false,

            defaultData: {
                id: null,
                exam_bank_code: null,
                exam_bank_name: null,
            },

            invalidData: {
                exam_bank_code: null,
                exam_bank_name: null,
                SheetIndexReference: null,
                RowReference: null,
                FileData: null
            },
            modeModal: this.FormMode.INSERT,
            modeGenerate: true,
            examBankData: [],
            isShowModal: false,
            isShowActions: false,
            isLoading: false,
            isPopupDelete: false,
            objectLoading: {},
            top: 0,
            left: 0,
            isconfigureExam: false,
        }
    },
    methods: {
        /**
         * Ẩn / hiện model thêm mới
         */
        showModal() {
            this.isShowModal = !this.isShowModal;
        },

        async doSave() {
            try {
                if (this.validateExamBank()) {
                    this.popupLoading = true;
                    switch (this.modeModal) {
                        case this.FormMode.INSERT:
                            insertExamBank(this.selectedData).then(res => {
                                this.loadExamBank()
                                this.showModal();
                                this.$store.dispatch('handleSuccess', 'Thêm đề thi thành công');
                            }).catch(error => {
                                if (error.response.status === RESPONSE_STATUS.HTTP_UNPROCESSABLE_ENTITY) {
                                    for (var itemError in error.response.data.errors) {
                                        console.log(error.response.data.errors);
                                        this.invalidData[itemError] = error.response.data.errors[itemError][0];
                                    }
                                }
                            }).finally(() => {
                                this.popupLoading = false;
                            })
                            break;
                        case this.FormMode.UPDATE:
                            if (JSON.stringify(this.selectedData) !== JSON.stringify(this.objSelectedData)) {
                                updateExamBank(this.selectedData).then(res=>{
                                    this.showModal();
                                    this.$store.dispatch('handleSuccess', 'Cập nhật đề thi thành công');
                                    this.loadExamBank();
                                }).catch(error => {
                                    if (error.response.status === RESPONSE_STATUS.HTTP_UNPROCESSABLE_ENTITY) {
                                        for (var itemError in error.response.data.errors) {
                                            console.log(error.response.data.errors);
                                            this.invalidData[itemError] = error.response.data.errors[itemError][0];
                                        }
                                    }
                                    console.log(error)
                                }).finally(() => {
                                    this.popupLoading = false;
                                })
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
        }
        ,

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
        }
        ,

        /**
         * Xử lý hàm sinh mã theo tên
         */
        handlerGenerateCode() {
            if (this.modeGenerate) this.selectedData.exam_bank_code = generateCode({value: this.selectedData.exam_bank_name});
        }
        ,

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
                this.examBankData = res.data;
            }).catch(error => {

            }).finally(() => {
                setTimeout(() => {
                    this.isLoading = false;
                }, 750);
            });
        },

        /**
         * Click nút xóa phòng thi
         */
        handlerDelete() {
            this.isLoadingDelete = true;
            deleteExamBank(this.selectedData.id).then(res => {
                this.isPopupDelete = false;
                this.$store.dispatch('handleSuccess', MESSAGE.HTTP_DELETE_OK);
                this.loadExamBank();
            }).catch(error => {

            }).finally(() => {
                setTimeout(() => {
                    this.isLoadingDelete = false;
                }, 300);
            })
        },

        /**
         * Ẩn form
         */
        afterHide() {
            this.selectedData = {...this.defaultData};
            this.invalidData = [];
            this.exambank = {};
        },

        /**
         *  Validate dữ liệu
         *  @return bool
         */
        validateExamBank() {
            let invalid = true;
            this.invalidData = [];
            if (this.selectedData.exam_bank_code == null || this.selectedData.exam_bank_code === '') {
                invalid = false;
                this.invalidData.exam_bank_code = 'Mã đề thi không được để trống';
            } else {
                this.invalidData.exam_bank_code = null;
            }
            if (this.selectedData.exam_bank_name == null || this.selectedData.exam_bank_name === '') {
                invalid = false;
                this.invalidData.exam_bank_name = 'Tên đề thi không được để trống';
            } else {
                this.invalidData.exam_bank_name = null;
            }
            return invalid;
        },

        /**
         * Cập nhật đề thi
         */
        onRowUpdate() {
            //object để kiểm tra xem bản ghi có thay đối hay ko
            this.objSelectedData = {...this.selectedData};

            this.showModal(this.FormMode.UPDATE);
        },

        deleteRowSelect(data) {
            this.selectedData = {...data};
            this.isPopupDelete = true;
        },

        /**
         *
         */
        onRowSelect(data) {
            this.modeModal = this.FormMode.UPDATE;
            this.objSelectedData = {...data};
            this.selectedData = {...data};
        }
    },
    async created() {
        await this.loadExamBank();
    },
}
</script>
