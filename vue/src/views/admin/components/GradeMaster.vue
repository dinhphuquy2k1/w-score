<template>
    <div class="form-list flex-grow-1 d-flex">
        <div class="d-flex flex-column flex-grow-1">
            <div class="d-flex flex-row title-box">
                <div class="list-title flex-grow-1 text-start">Thực hiện chấm thi</div>
                <div class="right-toolbar d-flex flex-row">
                    <Button
                        class="ms-btn blue d-flex justify-content-center flex-grow-1 ms-btn_search ps-3 pe-3 gap-2">
                        <div class="fw-semibold">Chấm thi</div>
                        <div class="icon-only icon-simple_cart"></div>
                    </Button>
                </div>
            </div>
            <!--            <div class="d-flex flex-row toolbar-box justify-content-between">-->
            <!--                <div class="left-toolbar d-flex flex-row">-->
            <!--                    <div class="m-search_form flex-row d-flex align-items-center d-flex d-none">-->
            <!--                        <InputText type="search" v-model="value" class="ms-input_search w-100" placeholder="Tìm kiếm"/>-->
            <!--                        <div class="icon24 icon search-right search"></div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--                <div class="right-toolbar d-flex flex-row">-->
            <!--                    <Button-->
            <!--                        class="ms-btn blue d-flex justify-content-center flex-grow-1 ms-btn_search ps-3 pe-3 gap-2">-->
            <!--                        <div class="icon-only icon-simple_cart"></div>-->
            <!--                        <div class="fw-semibold">Chấm thi</div>-->
            <!--                    </Button>-->
            <!--                </div>-->
            <!--            </div>-->
            <div class="flex-grow-1 flex-row row gx-0 gap-3">
                <div class="col-3 left-grade" :class="{'collage': isCollapsed}">
                    <div class="title text-start d-flex justify-content-between">
                        <div class="text">Thông tin kì thi</div>
                        <div class="btn-collapse icon-toggle icon24-only" @click="isCollapsed = true"></div>
                    </div>
                    <div class="w-100 h-100">
                        <div class="outer" @click="isCollapsed = false">
                            <div class="left-grade-content_collage inner rotate">
                                <div style="margin: auto;">Thông tin chấm thi</div>
                            </div>
                        </div>
                        <div class="left-grade-content">
                            <div class="group-form_box">
                                <div class="d-flex">
                                    <div class="label">Kì thi</div>
                                    <span class="required">*</span>
                                </div>
                                <div class="">
                                    <Dropdown v-model="selectedCity" :options="cities" optionLabel="name"
                                              placeholder="Kì thi"
                                              class="ms-category text-start"/>
                                </div>
                                <div class="ms-error-text"></div>
                            </div>
                            <div class="group-form_box mt-3">
                                <div class="d-flex">
                                    <div class="label">Ca thi</div>
                                    <span class="required">*</span>
                                </div>
                                <div class="">
                                    <Dropdown v-model="selectedCity" :options="cities" optionLabel="name"
                                              placeholder="Kì thi"
                                              class="ms-category text-start"/>
                                </div>
                                <div class="ms-error-text"></div>
                            </div>
                            <div class="group-form_box mt-3">
                                <div class="d-flex">
                                    <div class="label">Phòng thi thi</div>
                                    <span class="required">*</span>
                                </div>
                                <div class="">
                                    <Dropdown v-model="selectedCity" :options="cities" optionLabel="name"
                                              placeholder="Kì thi"
                                              class="ms-category text-start"/>
                                </div>
                                <div class="ms-error-text"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list-content flex1 flex-column right-grade">
                    <div class="content-body flex1 flex-column">
                        <div class="mb-20">
                            <Panel header="1. Thông tin file" :collapsed="examResult.length > 0" toggleable
                                   class="customPanel flex1" :toggle-button-props="{ 'aria-label': 'customPanel' }">
                                <Stepper linear :activeStep="activeStep">
                                    <StepperPanel header="File danh sách thi">
                                        <template #content="{ nextCallback }">
                                            <input type="file" hidden ref="file" accept=".xlsx" id="assetsFieldHandle"
                                                   @change="onChangeFile($event, valuesFile[0])">
                                            <div class="flex-grow-1 d-flex" @dragover="dragover" @dragleave="dragleave"
                                                 @drop="drop($event, valuesFile[0])">
                                                <label for="assetsFieldHandle" class="flex-grow-1 upload-wrapper">
                                                    <div class="d-flex flex-grow-1">
                                                        <div
                                                            class="upload-container flex-grow-1 d-flex justify-content-center align-items-center"
                                                            v-if="!fileSelected">
                                                            <div class="no-file d-flex file-xlsx">
                                                            </div>
                                                        </div>
                                                        <div class="import-attachment-container flex1"
                                                             v-if="fileSelected">
                                                            <div class="file-info d-flex">
                                                                <div class="d-flex text-truncate">
                                                                    <div class="file-icon text-left "
                                                                         style="width: 20px;"></div>
                                                                    <div class="file-name text-left">
                                                                        {{ fileSelected.name }}
                                                                    </div>
                                                                </div>
                                                                <div class="file-size text-left">
                                                                    {{ formatSize(fileSelected.size) }}
                                                                </div>
                                                                <div
                                                                    class="file-accepted text-left d-flex justify-content-between">
                                                                    <div class="icon-success" v-if="FileSuccess"></div>
                                                                    <div v-if="FileSuccess">Hợp lệ</div>
                                                                    <div class="icon-unsuccess"
                                                                         v-if="!FileSuccess"></div>
                                                                    <div v-if="!FileSuccess">Không hợp lệ</div>
                                                                </div>
                                                                <div
                                                                    class="change-file blue-text pointer text-left text-link mw-maxcontent justify-content-end">
                                                                    Đổi
                                                                    tệp khác
                                                                </div>
                                                            </div>
                                                            <div class="file-caution" v-if="FileSuccess">
                                                                <ProgressBar :value="progress" :showValue="false"
                                                                             v-if="isLoading"></ProgressBar>
                                                                <div class="file-caution-img">
                                                                </div>
                                                                <div class="file-caution-center mt-20 text-center">
                                                                    Lưu ý
                                                                    <span data-v-6d95cd2a="" data-v-30ce9692=""
                                                                          style="color: red;">*</span>
                                                                    : Bạn vui lòng chọn sheet muốn nhập khẩu và
                                                                    <br>
                                                                    dòng tiêu đề của sheet đó.
                                                                </div>

                                                            </div>
                                                            <div class="file-error" v-else>
                                                                <div class="file-error-title red-text"> Lý do không hợp
                                                                    lệ:
                                                                </div>
                                                                <div class="file-error-title red-text">- Dung lượng quá
                                                                    lớn
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="flex pt-4 justify-content-end" v-if="!isNextStepper">
                                                <Button label="Tiếp tục" icon="pi pi-arrow-right" iconPos="right"
                                                        :disabled="!fileSelected"
                                                        @click="fileSelectedOnUpload = valuesFile[0], uploadEvent()"/>
                                            </div>
                                            <div class="flex pt-4 justify-content-end" v-else>
                                                <Button label="Next" icon="pi pi-arrow-right" iconPos="right"
                                                        @click="fileSelectedOnUpload = valuesFile[0], nextCallback()"/>
                                            </div>
                                        </template>
                                    </StepperPanel>
                                    <StepperPanel header="File bài thi">
                                        <template #content="{ prevCallback, nextCallback }">
                                            <div class="flex flex-column h-12rem">
                                                <input type="file" hidden ref="file" accept=".zip"
                                                       id="assetsFieldHandle"
                                                       @change="onChangeFile($event, valuesFile[1])">
                                                <div class="flex1 d-flex" @dragover="dragover" @dragleave="dragleave"
                                                     @drop="drop($event, valuesFile[1])">
                                                    <label for="assetsFieldHandle" class="flex1 upload-wrapper">
                                                        <div class="d-flex flex-grow-1">
                                                            <div
                                                                class="upload-container flex-grow-1 d-flex justify-content-center align-items-center"
                                                                v-if="!fileSelected">
                                                                <div class="no-file d-flex file-zip">
                                                                </div>
                                                            </div>
                                                            <div class="import-attachment-container flex1"
                                                                 v-if="fileSelected">
                                                                <div class="file-info d-flex">
                                                                    <div class="d-flex text-truncate">
                                                                        <div class="file-icon text-left "
                                                                             style="width: 20px;"></div>
                                                                        <div class="file-name text-left">
                                                                            {{ fileSelected.name }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="file-size text-left">
                                                                        {{ formatSize(fileSelected.size) }}
                                                                    </div>
                                                                    <div class="file-accepted text-left d-flex">
                                                                        <div class="icon-success"
                                                                             v-if="FileSuccess"></div>
                                                                        <div v-if="FileSuccess">Hợp lệ</div>
                                                                        <div class="icon-unsuccess"
                                                                             v-if="!FileSuccess"></div>
                                                                        <div v-if="!FileSuccess">Không hợp lệ</div>
                                                                    </div>
                                                                    <div
                                                                        class="change-file blue-text pointer text-left text-link mw-maxcontent">
                                                                        Đổi
                                                                        tệp khác
                                                                    </div>
                                                                </div>
                                                                <div class="file-caution" v-if="FileSuccess">
                                                                    <ProgressBar :value="progress" :showValue="false"
                                                                                 v-if="isLoading"></ProgressBar>
                                                                    <div class="file-caution-img">
                                                                    </div>
                                                                    <div class="file-caution-center mt-20">
                                                                    </div>
                                                                </div>
                                                                <div class="file-error" v-else>
                                                                    <div class="file-error-title red-text"> Lý do không
                                                                        hợp
                                                                        lệ:
                                                                    </div>
                                                                    <div class="file-error-title red-text">- Dung lượng
                                                                        quá
                                                                        lớn
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="flex pt-4 justify-content-between">
                                                <Button label="Back" severity="secondary" icon="pi pi-arrow-left"
                                                        @click="prevCallback, this.activeStep= 0"/>
                                                <Button label="Tiếp tục" icon="pi pi-arrow-right" iconPos="right"
                                                        :disabled="!fileSelected"
                                                        @click="fileSelectedOnUpload = valuesFile[1], uploadEvent()"/>
                                            </div>
                                        </template>
                                    </StepperPanel>
                                    <StepperPanel header="Kiểm tra thông tin">
                                        <template #content="{ prevCallback, nextCallback }">
                                            <div class="flex flex-column h-12rem">
                                                <DataTable class="flex1 mt-10 flex-column" :class="{ 'loading': isLoading }"
                                                           :loading="isLoading" table-class="grid-group"
                                                           :value="isLoading ? Array.from({ length: 8 }, () => ({ ...this.department })) : fileInfoResponse.data"
                                                           tableStyle="min-width: 100%" rowHover>

                                                    <Column header="Số báo danh" field="studentName" style="width: 40px;"
                                                            class="text-center">
                                                        <template #body="{ data, field, slotProps }">
                                                            <div v-if="!isLoading"> {{ data[field] }}</div>
                                                            <div v-else>
                                                                <Skeleton height="18px" class="mb-2"></Skeleton>
                                                            </div>
                                                        </template>
                                                    </Column>
                                                    <Column header="Mã sinh viên" field="studentID" style="width: 100px"
                                                            class="text-center">
                                                        <template #body="{ data, field, slotProps }">
                                                            <div v-if="!isLoading"> {{ data[field] }}</div>
                                                            <div v-else>
                                                                <Skeleton height="18px" class="mb-2"></Skeleton>
                                                            </div>
                                                        </template>
                                                    </Column>
                                                    <Column header="Họ và tên" field="studentName" style="width: 80px;"
                                                            class="text-left">
                                                        <template #body="{ data, field, slotProps }">
                                                            <div v-if="!isLoading"> {{ data[field] }}</div>
                                                            <div v-else>
                                                                <Skeleton height="18px" class="mb-2"></Skeleton>
                                                            </div>
                                                        </template>
                                                    </Column>
                                                    <Column header="Phòng thi" field="studentName" style="width: 100px;"
                                                            class="text-center">
                                                        <template #body="{ data, field, slotProps }">
                                                            <div v-if="!isLoading"> {{ data[field] }}</div>
                                                            <div v-else>
                                                                <Skeleton height="18px" class="mb-2"></Skeleton>
                                                            </div>
                                                        </template>
                                                    </Column>
                                                    <Column header="Đề thi" field="studentName" style="width: 50px;"
                                                            class="text-center">
                                                        <template #body="{ data, field, slotProps }">
                                                            <div v-if="!isLoading"> {{ data[field] }}</div>
                                                            <div v-else>
                                                                <Skeleton height="18px" class="mb-2"></Skeleton>
                                                            </div>
                                                        </template>
                                                    </Column>
                                                </DataTable>
                                            </div>
                                            <div class="flex pt-4 justify-content-between">
                                                <Button label="Back" severity="secondary" icon="pi pi-arrow-left"
                                                        @click="prevCallback"/>
                                                <Button label="Next" icon="pi pi-arrow-right" iconPos="right"
                                                        @click="nextCallback"/>
                                            </div>
                                        </template>
                                    </StepperPanel>
                                    <StepperPanel header="Chấm thi">
                                        <template #content="{ prevCallback }">
                                            <div class="flex flex-column h-12rem">
                                                <div
                                                    class="border-2 border-dashed surface-border border-round surface-ground flex-auto flex justify-content-center align-items-center font-medium">
                                                    Content III
                                                </div>
                                            </div>
                                            <div class="flex pt-4 justify-content-start">
                                                <Button label="Back" severity="secondary" icon="pi pi-arrow-left"
                                                        @click="prevCallback"/>
                                                <Button label="Chấm thi" icon="pi pi-arrow-right"
                                                        @click="calculate"/>
                                            </div>
                                        </template>
                                    </StepperPanel>
                                </Stepper>
                            </Panel>
                        </div>
                        <div class="mb-20 flex-column flex1">
                            <Panel header="2. Kết quả chấm" toggleable :collapsed="examResult.length == 0"
                                   class="customPanel flex1" :toggle-button-props="{ 'aria-label': 'customPanel' }">
                                <div class="ms-panel-header">
                                    <div class="flex1"></div>
                                    <Button class="ms-button btn primary has-tooltip" aria-label="Youtube"
                                            v-if="examResult.length != 0" @click="exportExamResult">
                                        <!--                                        <img alt="logo"-->
                                        <!--                                             src="../../../../public/assets/icon/ic_export_excel.cd7bdef7.svg"-->
                                        <!--                                             class="export-excel" />-->
                                        <span class="px-3 text">Xuất kết quả</span>
                                    </Button>
                                </div>
                                <DataTable class="flex1 mt-10 flex-column" :class="{ 'loading': isLoading }"
                                           :loading="isLoading" table-class="grid-group"
                                           :value="isLoading ? Array.from({ length: 8 }, () => ({ ...this.department })) : examResult"
                                           tableStyle="min-width: 100%" rowHover>

                                    <Column header="STT" style="width: 40px;" class="text-center">
                                        <template #body="slotProps">
                                            <div v-if="!isLoading"> {{ slotProps.index + 1 }}</div>
                                            <div v-else>
                                                <Skeleton height="18px" class="mb-2"></Skeleton>
                                            </div>
                                        </template>
                                    </Column>
                                    <Column header="Số báo danh" field="studentId" style="width: 40px;"
                                            class="text-center">
                                        <template #body="{ data, field, slotProps }">
                                            <div v-if="!isLoading"> {{ data[field] }}</div>
                                            <div v-else>
                                                <Skeleton height="18px" class="mb-2"></Skeleton>
                                            </div>
                                        </template>
                                    </Column>
                                    <Column header="Họ và tên" field="studentName" style="width: 80px;"
                                            class="text-left">
                                        <template #body="{ data, field, slotProps }">
                                            <div v-if="!isLoading"> {{ data[field] }}</div>
                                            <div v-else>
                                                <Skeleton height="18px" class="mb-2"></Skeleton>
                                            </div>
                                        </template>
                                    </Column>
                                    <Column header="Phòng thi" field="departmentName" style="width: 100px;"
                                            class="text-center">
                                        <template #body="{ data, field, slotProps }">
                                            <div v-if="!isLoading"> {{ data[field] }}</div>
                                            <div v-else>
                                                <Skeleton height="18px" class="mb-2"></Skeleton>
                                            </div>
                                        </template>
                                    </Column>
                                    <Column header="Tổng điểm" field="totalPoint" style="width: 50px;"
                                            class="text-center">
                                        <template #body="{ data, field, slotProps }">
                                            <div v-if="!isLoading"> {{ data[field] }}</div>
                                            <div v-else>
                                                <Skeleton height="18px" class="mb-2"></Skeleton>
                                            </div>
                                        </template>
                                    </Column>
                                    <Column alignFrozen="right" style="width: 80px;" frozen header="Thao tác">
                                        <template #body="slotProps">
                                            <div class="row-actions" v-if="!isLoading">
                                                <div class="text-link"
                                                     @click="onRowSelect(slotProps.data), selectedResult = slotProps.data, loadExamResultDetail()">
                                                    <div>Xem chi tiết</div>
                                                </div>
                                            </div>
                                            <div v-else>
                                                <Skeleton height="18px" class="mb-2"></Skeleton>
                                            </div>
                                        </template>
                                    </Column>
                                </DataTable>
                            </Panel>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import Skeleton from 'primevue/skeleton';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Dropdown from 'primevue/dropdown';
import Panel from 'primevue/panel';
import FileUpload from 'primevue/fileupload';
import Stepper from 'primevue/stepper';
import StepperPanel from 'primevue/stepperpanel';
import Resumable from 'resumablejs';
import ProgressBar from 'primevue/progressbar';
import {FILE_TYPE} from "@/common/enums";

import {get, calculate} from '/api/grade-master';

export default {
    components: {
        Button,
        InputText,
        Panel,
        Skeleton,
        DataTable,
        Dropdown,
        ProgressBar,
        Column,
        FileUpload,
        Stepper,
        StepperPanel
    },
    data() {
        return {
            valuesFile: [
                {
                    STT: 1,
                    Type: 'File danh sách thi',
                    Resource: 'Chưa có file danh sách thi. Tải lên để thực hiện chấm',
                    Empty: true,
                    FileSelected: null,
                    ResourcePath: null,
                    FileName: null,
                    FileType: FILE_TYPE.LIST,
                    FileAccept: '.xlsx',
                    MaxFileSize: 30 * 1024 * 1024
                },
                {
                    STT: 2,
                    Type: 'File bài thi',
                    Resource: 'Chưa có file bài thi. Tải lên để thực hiện chấm',
                    Empty: true,
                    FileSelected: null,
                    ResourcePath: null,
                    FileName: null,
                    FileType: FILE_TYPE.EXAM,
                    FileAccept: '.zip',
                    MaxFileSize: 800 * 1024 * 1024
                },
            ],
            isNextStepper: false,
            columnsFile: [
                {field: 'STT', header: 'STT'},
                {field: 'Type', header: 'Loại file'},
                {field: 'Resource', header: 'Tên File'},
            ],
            isCollapsed: false,
            isLoading: false,
            data: [],
            selectedCity: null,
            examResult: [],
            cities: [
                {name: 'New York', code: 'NY'},
                {name: 'Rome', code: 'RM'},
                {name: 'London', code: 'LDN'},
                {name: 'Istanbul', code: 'IST'},
                {name: 'Paris', code: 'PRS'}
            ],
            headerUploadFile: 'Tải file',
            fileSelectedOnUpload: null,
            gradingType: false, //loại chấm điểm
            isShowGradingType: false,
            gradingTypeVisible: false,
            deductedPoint: 50, //điểm bị trừ
            invalidDeductedPoint: null,

            fileSelected: null,
            isShowPopupUploadFile: false,
            File: null,
            FileSuccess: false,
            isUpload: false,
            totalSize: 0,
            dialogVisible: false,
            totalSizePercent: 0,
            activeStep: 0,
            fileInfoResponse: [],

            resultDetail: [],
            visibleExamResultDetail: false,
            selectedResult: null,
            objCheckSelectedResult: null,


            isLoadingComponent: false,

            modeFile: null,
            fileXlsxSelected: null,
            fileZipSelected: null,

            resumable: null,
            progress: 0,

            examManager: [],
            selectedManager: null,
            examShift: [],
            selectedExamShift: null,
            department: [],
            selectedDepartment: null,

        }
    },
    methods: {
        onRowSelect(data) {
            // console.log(data);
        },

        async btnEvaluator(flag) {
            //thực hiện chấm
            if (flag) {
                this.gradingTypeVisible = false;
                this.deductedPoint = 50;
                this.isLoadingComponent = true;
                this.isShowGradingType = false;
                var data = this.examManager.find(_item => this.selectedManager == _item.ExamId);
                data = JSON.parse(data.ExamShift).filter(_item => _item.ExamShiftId == this.selectedExamShift && _item.DepartmentId == this.selectedDepartment && _item.ExamShiftId == this.selectedExamShift);
                await excuteEvaluator({
                    data: data,
                    gradingType: this.gradingType,
                    deductedPoint: this.deductedPoint
                }).then(res => {
                    this.loadExamResult();
                }).catch(error => {
                    console.log(error);
                }).finally(() => {
                    setTimeout(() => {
                        this.isLoadingComponent = false;
                    }, 300);
                });
            }
        },

        /**
         * Hiển thị toast message
         * @param {*} message
         */
        showToast(message, severity = 'success') {
            this.$toast.add({severity: severity, summary: 'Thông báo', detail: message, life: 3000});
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
         * Sự kiện chọn kì thi
         */
        onChangeExamManager() {
            this.isLoading = true;
            this.valuesFile[1].FileName = this.valuesFile[0].FileName = null;
            this.valuesFile[1].Empty = this.valuesFile[0].Empty = true;
            //dữ liệu kì thi

            this.selectedFirst();
            this.loadExamResult();
        },

        /**
         * Sự kiện chọn ca thi
         */
        onChangeExamShift() {
            this.valuesFile[1].FileName = this.valuesFile[0].FileName = null;
            this.valuesFile[1].Empty = this.valuesFile[0].Empty = true;

            //dữ liệu kì thi
            var data = this.examManager.find(_item => this.selectedManager == _item.ExamId);
            data = JSON.parse(data.ExamShift);
            //dữ liệu ca thi
            var result = data.filter(_item => _item.ExamShiftId == this.selectedExamShift);
            //Mảng dữ liệu phòng thi
            this.department = this.getUniqueItems(result, 'DepartmentId');
            //auto focus giá trị đầu
            this.selectedDepartment = this.department[0].DepartmentId;

            //file danh sách
            if (this.department[0].ResourcePathFileList != null) {
                this.valuesFile[0].FileName = this.department[0].ResourcePathFileList.substring(3);
                this.valuesFile[0].Empty = false;
            }

            if (this.department[0].ResourcePathFileAssignment != null) {
                this.valuesFile[1].FileName = this.department[0].ResourcePathFileAssignment.substring(3);
                this.valuesFile[1].Empty = false;
            }
            this.loadExamResult();
        },

        /**
         * Sự kiện chọn phòng thi
         */
        onChangeDepartment() {
            this.examResult = []; //kết quả thi
            this.valuesFile[1].FileName = this.valuesFile[0].FileName = null;
            this.valuesFile[1].Empty = this.valuesFile[0].Empty = true;

            var data = this.examManager.find(_item => this.selectedManager == _item.ExamId);
            data = JSON.parse(data.ExamShift);
            var result = data.find(_item => this.selectedDepartment == _item.DepartmentId && this.selectedExamShift == _item.ExamShiftId);
            try {
                if (result.ResourcePathFileList != null) {
                    this.valuesFile[0].FileName = String(result.ResourcePathFileList).substring(3);
                    this.valuesFile[0].Empty = false;
                }

                if (result.ResourcePathFileAssignment != null) {
                    this.valuesFile[1].FileName = String(result.ResourcePathFileAssignment).substring(3);
                    this.valuesFile[1].Empty = false;
                }
            } catch (error) {
                console.log(result, this.selectedDepartment, this.department, this.selectedExamShift, data);
            }
            this.loadExamResult();
        },

        /**
         *
         * @param {*} arr
         */
        selectedFirst() {
            try {
                var data = this.examManager.find(_item => this.selectedManager == _item.ExamId).ExamShift;
                var data = JSON.parse(data);
                this.examShift = this.getUniqueItems(data, 'ExamShiftCode');
                this.department = this.getUniqueItems(data, 'DepartmentId');
                if (!this.examShift.find(_item => _item.ExamShiftId == this.selectedExamShift)) {
                    this.selectedExamShift = this.examShift[0].ExamShiftId;
                }

                var index = this.department.findIndex(_item => _item.DepartmentId == this.selectedDepartment);
                if (index == -1) {
                    this.selectedDepartment = this.department[0].DepartmentId;
                }

                if (this.department[index] != null && this.department[index].ResourcePathFileList != null) {
                    this.valuesFile[0].FileName = this.department[index].ResourcePathFileList.substring(3);
                    this.valuesFile[0].Empty = false;
                }

                if (this.department[index] != null && this.department[index].ResourcePathFileAssignment != null) {
                    this.valuesFile[1].FileName = this.department[index].ResourcePathFileAssignment.substring(3);
                    this.valuesFile[1].Empty = false;
                }
            } catch (error) {
                console.log(error);
            }
        },

        /**
         * Cập nhật thông tin file
         */
        updateFileInformation() {
            try {
                this.valuesFile[1].FileName = this.valuesFile[0].FileName = null;
                this.valuesFile[1].Empty = this.valuesFile[0].Empty = true;
                //dữ liệu kì thi
                var data = this.examManager.find(_item => this.selectedManager == _item.ExamId);
                data = JSON.parse(data.ExamShift);
                //dữ liệu ca thi
                var result = data.filter(_item => _item.ExamShiftId == this.selectedExamShift);
                //Mảng dữ liệu phòng thi
                this.department = this.getUniqueItems(result, 'DepartmentId');

                var index = this.department.findIndex(_item => _item.DepartmentId == this.selectedDepartment);
                if (this.department[index] != null && this.department[index].ResourcePathFileList != null) {
                    this.valuesFile[0].FileName = this.department[index].ResourcePathFileList.substring(3);
                    this.valuesFile[0].Empty = false;
                }

                if (this.department[index] != null && this.department[index].ResourcePathFileAssignment != null) {
                    this.valuesFile[1].FileName = this.department[index].ResourcePathFileAssignment.substring(3);
                    this.valuesFile[1].Empty = false;
                }
            } catch (error) {
                console.log(error);
            }
        },

        /**
         * Sự kiện kéo thả file
         * @param {*} event
         * @param data
         */
        drop(event, data) {
            event.preventDefault();
            this.$refs.file.files = event.dataTransfer.files;
            this.onChangeFile(event, data); // Trigger the onChange event manually
            // Clean up
            event.currentTarget.classList.add('bg-gray-100');
            event.currentTarget.classList.remove('bg-green-300');
        },

        /**
         * Sự kiện kéo file vào
         * @param {*} event
         */
        dragover(event) {
            event.preventDefault();
            // Add some visual fluff to show the user can drop its files
            if (!event.currentTarget.classList.contains('bg-green-300')) {
                event.currentTarget.classList.remove('bg-gray-100');
                event.currentTarget.classList.add('bg-green-300');
            }
        },

        /**
         * Sự kiện kéo file ra
         * @param {*} event
         */
        dragleave(event) {
            // Clean up
            event.currentTarget.classList.add('bg-gray-100');
            event.currentTarget.classList.remove('bg-green-300');
        },

        /**
         * Lấy danh sách đã phân chia đề thi
         */
        getListExam() {
            if (this.selectedDepartment == null) {
                this.showToast("Chưa chọn thông tin kì thi", 'error');
                return;
            }

            if (this.selectedManager == null) {
                this.showToast("Chưa chọn thông tin kì thi", 'error');
                return;
            }

            if (this.selectedExamShift == null) {
                this.showToast("Chưa chọn thông tin kì thi", 'error');
                return;
            }

            if (this.valuesFile[0].FileName == null) {
                this.showToast("Chưa tải lên file danh sách thi", 'error');
                return;
            }

            this.isLoadingComponent = true;
            //dữ liệu kì thi
            var data = this.examManager.find(_item => this.selectedManager == _item.ExamId);
            data = JSON.parse(data.ExamShift);
            //dữ liệu ca thi
            var result = data.filter(_item => _item.ExamShiftId == this.selectedExamShift);
            //Mảng dữ liệu phòng thi
            this.department = this.getUniqueItems(result, 'DepartmentId');

            var index = this.department.findIndex(_item => _item.DepartmentId == this.selectedDepartment);
            data = data.filter(_item => _item.ExamShiftId == this.selectedExamShift && _item.DepartmentId == this.selectedDepartment && _item.ExamShiftId == this.selectedExamShift);
            exportExamList({fileInfo: this.department[index], exam: data}).then(res => {
                var filename = this.department.find(_item => _item.DepartmentId == this.selectedDepartment).DepartmentName;
                const url = window.URL.createObjectURL(new Blob([res]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', `Danh sách phân chia đề thi ${filename}.xlsx`);
                document.body.appendChild(link);
                link.click();
            }).catch(error => {

            }).finally(() => {
                setTimeout(() => {
                    this.isLoadingComponent = false;
                }, 750);
            });

            console.log(this.department[index]);

        },

        /**
         * Thông tin kì thi
         */
        async loadExamManager() {
            await getDetailExamManager().then(res => {
                this.examManager = res;
            }).catch(error => {
                console.log(error);
            });
        },


        /**
         * Xuất kết quả
         */
        exportExamResult() {
            if (this.selectedDepartment != null && this.selectedExamShift != null && this.selectedManager != null && this.examResult.length > 0) {
                this.isLoadingComponent = true;
                exportExamResult({data: this.examResult}).then(res => {
                    var filename = this.department.find(_item => _item.DepartmentId == this.selectedDepartment).DepartmentName;
                    const url = window.URL.createObjectURL(new Blob([res]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', `Kết quả chấm ${filename}.xlsx`);
                    document.body.appendChild(link);
                    link.click();
                }).catch(error => {
                    this.showToast("Đã xảy ra lỗi, vui lòng liên hệ với nhà phát triển", 'error');
                    console.log(error);
                }).finally(() => {
                    setTimeout(() => {
                        this.isLoadingComponent = false;
                    }, 750);
                });
            }
        },

        /**
         * Sự kiện thay đổi file
         */
        onChangeFile(event, data) {
            event.preventDefault();
            // if (this.selectedDepartment == null || this.selectedExamShift == null || this.selectedManager == null) {
            //     this.showToast("Chọn thông tin kì thi để thực hiện tải", 'error');
            //     return;
            // }
            if (this.$refs.file.files[0]) {
                // if (this.$r  efs.file.files[0].size > this.fileSelectedOnUpload.MaxFileSize) {
                //     return;
                // }

                // if (this.$refs.file.files[0].size > this.fileSelectedOnUpload.MaxFileSize) {
                //     console.log(1);
                //     return;
                // }
                //xlsx
                if (data.FileType === FILE_TYPE.LIST) {
                    var validExts = new Array(".xlsx", ".xls");
                    var fileExt = this.$refs.file.files[0].name;
                    fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
                    if (validExts.indexOf(fileExt) < 0) {
                        this.contentDialog = ' File danh sách thi chỉ hỗ trợ định dạng *.xlsx';
                        this.dialogVisible = true;
                        return;
                    }
                }
                //zip
                else {
                    var validExts = new Array(".zip");
                    var fileExt = this.$refs.file.files[0].name;
                    fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
                    if (validExts.indexOf(fileExt) < 0) {
                        this.contentDialog = ' File bài thi chỉ hỗ trợ định dạng *.zip';
                        this.dialogVisible = true;
                        return;
                    }
                }
                this.FileSuccess = true;
                this.fileSelected = this.$refs.file.files[0];
            }
        },

        /**
         * Click nút upload
         */
        uploadEvent() {
            try {
                this.progress = 0;
                this.isLoading = true;
                //tên kì thi
                // this.resumable.opts.query.ExamName = this.examManager.find(_item => _item.ExamId == this.selectedManager).ExamName;
                // cập nhật param
                this.resumable.opts.query.departmentId = 1;
                this.resumable.opts.query.examId = 2;
                this.resumable.opts.query.examShiftId = 3;
                this.resumable.opts.query.fileType = this.fileSelectedOnUpload.FileType;
                this.resumable.addFile(this.fileSelected);
            } catch (error) {

            }
        },

        /**
         * click button chấm thi
         */
        calculate() {
            calculate(this.fileInfoResponse).then(res => {
                this.examResult = res.data;
            }).catch(error => {
                console.log(error)
            });
        },

        /**
         * Lấy kết quả chấm
         */
        async loadExamResult() {
            this.isLoading = true;
            this.examResult = [];
            if (this.selectedDepartment == null || this.selectedExamShift == null || this.selectedManager == null) {
                return;
            }
            await getExamResult({
                ExamId: this.selectedManager,
                DepartmentId: this.selectedDepartment,
                ExamShiftId: this.selectedExamShift
            }).then(res => {
                this.examResult = res;
            }).catch(error => {
                this.showToast("Đã xảy ra lỗi, vui lòng liên hệ với nhà phát triển");
                console.log(error);
            }).finally(() => {
                setTimeout(() => {
                    this.isLoading = false;
                }, 750);
            });
            var department = this.department.find(_department => _department.DepartmentId == this.selectedDepartment);

            if (department != null && department.ResourcePathFileList != null) {
                this.valuesFile[0].FileName = department.ResourcePathFileList.substring(3);
                this.valuesFile[0].Empty = false;
            }

            if (department != null && department.ResourcePathFileAssignment != null) {
                this.valuesFile[1].FileName = department.ResourcePathFileAssignment.substring(3);
                this.valuesFile[1].Empty = false;
            }
        },

        /**
         * Khởi tạo Resumable upload file
         */
        createResumable() {
            this.resumable = new Resumable({
                target: 'http://localhost:9000/api/word/upload-file',
                method: 'POST',
                query: {},
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
         * Thêm file
         * @param {*} file
         */
        onFileAdded(file) {
            this.progress = 0;
            this.resumable.upload();
        },

        /**
         *
         * @param {*} file
         */
        onFileProgress(file) {
            this.progress = Math.floor(file.progress() * 100);
        },

        /**
         *
         * @param {*} file
         * @param {*} response
         */
        async onFileSuccess(file, response) {
            this.progress = 100;
            this.isLoading = false;
            try {
                this.fileInfoResponse = JSON.parse(response).data;
            }catch (error) {
                console.log(error)
            }
            console.log(this.fileInfoResponse)
            this.activeStep++;
            this.showToast('Tải file thành công');
            //cập nhật lại thông tin file trên view
            this.resumable.removeFile(file);
            this.fileSelected = null

        },

        onFileError(file, message) {
            console.log('File error:', file, message);
        },

        /**
         * Lấy thông tin chi tiết điểm của sinh viên
         */
        async loadExamResultDetail() {
            if (JSON.stringify(this.selectedResult) != JSON.stringify(this.objCheckSelectedResult)) {
                this.resultDetail = [];
                await getExamResultDetail(this.selectedResult.StudentCode).then(res => {
                    this.visibleExamResultDetail = true;
                    this.resultDetail = res;
                    console.log(res);
                }).catch(error => {
                    this.showToast("Đã xảy ra lỗi, vui lòng liên hệ với nhà phát triển");
                    console.log(error);
                });
            } else {
                this.visibleExamResultDetail = true;
            }
            this.objCheckSelectedResult = {...this.selectedResult}
        },

        /**
         * Sự kiện trước khi ẩn popup upload file
         */
        afterHideUploadFile() {
            if (this.resumable.isUploading()) {
                this.resumable.cancel();
                this.showToast("File đang được tải lên, bạn có chắc chắn muốn thoát không?");
                return;
            }
            this.progress = 0;
            this.fileSelectedOnUpload = null;
            this.fileSelected = null;
            this.isShowPopupUploadFile = false;
            this.fileSelected = null
        },

        /**
         * Format file size
         * @param {*} bytes Dung lượng cần format
         */
        formatSize(bytes) {
            if (bytes === 0) return "0 B";
            const k = 1024;
            const sizes = ["B", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i];
        },
    },
    created() {
    },

    mounted() {
        this.createResumable();
    },
}
</script>

<style lang="scss">
.left-grade {

    background: #fff;
    border: 1px solid rgb(221, 221, 221);
    border-bottom-right-radius: 4px;
    border-top-right-radius: 4px;
    height: 100%;

    .title {
        height: 50px;
        width: 100%;
        padding: 18px 12px 15px 15px;
        align-items: center;
        border-bottom: 1px solid rgb(221, 221, 221);

        .text {
            font-weight: 600;
        }

        .btn-collapse {
            cursor: pointer;
            transform: rotate(0deg);
            transition-duration: 0.4s;
        }
    }

    .outer {
        position: relative;
        display: none;
        width: 100%;
        cursor: pointer;
        margin: auto;

        .inner {
            width: 100vh;
            height: 45px;
            font-size: 16px;
            font-weight: 600;
            position: absolute;
            display: flex;
            left: 50%;
            top: 36vh;
        }

        .rotate {
            transform: translateX(-50%) translateY(-50%) rotate(-90deg);
        }
    }

    &.collage {
        width: 56px;

        .title {
            .text {
                display: none;
            }

            .btn-collapse {
                transform: rotate(180deg);
            }
        }

        .left-grade-content {
            display: none;
        }

        .outer {
            position: relative;
            display: inline-block;
            width: 100%;
            cursor: pointer;
            margin: auto;
        }
    }

    .left-grade-content {
        overflow: auto;
        height: 100%;
        padding: 16px;
    }
}

.right-grade {
    border: 1px solid rgb(221, 221, 221);
    border-radius: 4px;
    background: #fff;

    .p-panel-header {
        background: #fff !important;
        border: none !important;
    }

    .p-panel.customPanel .p-panel-header .p-panel-title {
        font-size: 16px;
        font-weight: 700;
    }

    button.p-panel-toggler[aria-label='customPanel'] span {
        width: max-content;
        display: flex;
        align-items: center;
    }

    button.p-panel-toggler[aria-label='customPanel'] span::before {
        margin-right: 4px;
        content: "";
        height: 16px !important;
        width: 16px !important;
    }


    button.p-panel-toggler[aria-label='customPanel'] span::after {
        width: max-content;
        color: #2979ff !important;
        cursor: pointer;
        border: none !important;
        font-weight: 400 !important;
        font-size: 14px;
    }


    .upload-container .info-file {
        padding: 20px;
    }

    .info-file .icon-zip {
        width: 40px;
        height: 40px;
        background: url('@public/assets/icons/zip.svg') no-repeat;
        margin-right: 10px;
        background-position: center;
        background-size: 100%;
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
        padding: 25px 8px 0;
        overflow: auto;
        height: 100%;
        color: #707070;
    }

    .p-panel {
        &.customPanel {
            .p-panel-content {
                border: unset;
            }
        }
    }

    .tab-item {
        margin-bottom: 15px;
        cursor: pointer;
    }

    .list-tab-menu .tab-item-parent.active {
        font-weight: 600;
        color: #ff6d00;
    }

    .list-tab-menu .tab-item-parent:hover {
        border-radius: 4px;
        background-color: #fbe9e7;
        color: #ff6d00;
    }

    .grid-nodata-content {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        width: 100%;
        background-color: #fff;
        border-radius: 4px;
    }

    .grid-nodata-content .img-nodata {
        background-image: url('@public/assets/icons/ic_empty_grid.681d1e47.svg');
        height: 160px;
        width: 260px;
        background-position: 50%;
    }

    .description-nodata {
        text-align: center;
        font-size: 14px;
        color: #182d4b;
        padding-bottom: 8px;
    }

    .grid-nodata-content .description-nodata {
        color: #9e9fab;
        padding-bottom: 8px;
    }

    .list-tab-menu .tab-item-parent {
        height: 36px;
        padding-left: 10px;
        padding-bottom: 10px;
        padding-top: 10px;
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

    /* .content-footer {
        background-color: #fbfbfe;
        padding: 12px 24px;
    } */
    .p-button-label {
        padding: 0 16px;
    }

    .tab-item-child {
        padding: 10px 0 0px 20px;
    }

    .tab-item .tab-item-child:not(:first-child) {
        padding-top: 0;
    }

    .box.left-box {
        width: 13vw;
    }

    .p-button .export-excel {
        display: inline-block;
        margin: -7px 7px -7px 12px;
    }

    .export-excel {
        width: 20px;
        height: 20px;
    }


    .p-button .export-excel ~ .text {
        padding-right: 16px;
        padding-left: 0;
    }

    .customPanel.p-panel.p-panel-toggleable .p-panel-header {
        padding: 0px 14px 14px 0 !important;
    }

    .upload-container .no-file.file-xlsx {
        background: url('@public/assets/icons/add_attachment.c604b695.svg') no-repeat;
        width: 334px;
        height: 110px;
        margin-top: 20px;
        background-size: contain;
        background-position: center;
        margin-bottom: 20px;
    }

    .upload-wrapper {
        border: 1px dashed #ddd;
        border-radius: 4px;
        display: flex;
        height: 329px;
        justify-content: center;
    }

    .import-attachment-container {
        border-radius: 4px;
        height: 329px;
        cursor: pointer;

        .file-info {
            width: 100%;
            height: 48px;
            align-items: center;
            padding: 0 16px;
            border-bottom: 1px dashed #ddd;

            .file-icon {
                width: 16px;
                height: 16px;
                background: transparent url('@public/assets/icons/ic_file_gray.84c03213.svg') no-repeat -2px 0;
                margin-right: 8px;
            }

            .file-name, .main-content .file-info .file-size {
                text-overflow: ellipsis;
                padding-right: 16px;
                overflow: hidden;
                white-space: nowrap;
            }

            .file-size {
                width: 95px;
                text-overflow: ellipsis;
                padding-right: 16px;
                overflow: hidden;
                white-space: nowrap;
            }

            .file-accepted {
                padding-right: 16px;
                white-space: nowrap;
            }

            .icon-success {
                width: 16px;
                height: 16px;
                background: transparent url('@public/assets/icons/ic_check_green.d1ac113b.svg') no-repeat;
                margin-right: 8px;
            }

            .change-file {
                width: 100px;
                overflow: hidden;
                white-space: nowrap;

                &.text-link {
                    color: #2979ff !important;
                    cursor: pointer;
                    border: none !important;
                    font-weight: 400 !important;
                }
            }
        }

        .file-caution {
            width: 100%;
            height: calc(100% - 48px);
        }

        .file-caution-img {
            width: 100%;
            height: calc(100% - 74px);
            background: url('@public/assets/icons/img_import.7804e3d3.svg') no-repeat 50%;
        }
    }

    .file-zip {
        background: url('@public/assets/icons/upload-zip.svg') no-repeat;
        width: 334px;
        height: 110px;
        margin-top: 20px;
        background-size: contain;
        background-position: center;
        margin-bottom: 20px;
    }
}

</style>
