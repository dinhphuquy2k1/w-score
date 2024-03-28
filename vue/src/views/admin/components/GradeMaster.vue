<template>
    <div class="form-list flex-grow-1 d-flex">
        <div class="d-flex flex-column flex-grow-1">
            <div class="d-flex flex-row title-box">
                <div class="list-title flex-grow-1 text-start">Thực hiện chấm thi</div>
            </div>
            <div class="d-flex flex-row toolbar-box justify-content-between">
                <div class="left-toolbar d-flex flex-row">
                    <div class="m-search_form flex-row d-flex align-items-center d-flex d-none">
                        <InputText type="search" v-model="value" class="ms-input_search w-100" placeholder="Tìm kiếm"/>
                        <div class="icon24 icon search-right search"></div>
                    </div>
                </div>
                <div class="right-toolbar d-flex flex-row">
                    <Button

                        class="ms-btn blue d-flex justify-content-center flex-grow-1 ms-btn_search ps-3 pe-3 gap-2">
                        <div class="icon-only icon-simple_cart"></div>
                        <div class="fw-semibold">Chấm thi</div>
                    </Button>
                </div>
            </div>
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
                                <DataTable class="flex1 flex-column"
                                           :value="isLoading ? Array.from({ length: 2 }, () => ({ ...this.department })) : valuesFile"
                                           scrollable @rowDblclick="onRowSelect($event.data)"
                                           :class="{ 'loading': isLoading }" :loading="isLoading"
                                           tableStyle="min-width: 50rem" rowHover table-class="grid-group">
                                    <Column header="STT" style="width: 100px;" class="text-center">
                                        <template #body="slotProps">
                                            <div v-if="!isLoading"> {{ slotProps.index + 1 }}</div>
                                            <div v-else>
                                                <Skeleton height="18px" class="mb-2"></Skeleton>
                                            </div>
                                        </template>
                                    </Column>
                                    <Column field="Type" dataKey="id" header="Loại File" style="width: 450px;">
                                        <template #body="{ data, field, slotProps }">
                                            <div v-if="!isLoading"> {{ data[field] }}</div>
                                            <div v-else>
                                                <Skeleton height="18px" class="mb-2"></Skeleton>
                                            </div>
                                        </template>
                                    </Column>
                                    <Column field="Resource" dataKey="id" header="Tên File">
                                        <template #body="{ data, field, slotProps }">
                                            <div v-if="!isLoading">
                                                <div v-if="data.Empty">
                                                            <span class="error-text"> Chưa có file. Tải lên để thực hiện
                                                                chấm</span>
                                                </div>
                                                <div v-else>
                                                    {{ data.FileName }}
                                                </div>
                                            </div>
                                            <div v-else>
                                                <Skeleton height="18px" class="mb-2"></Skeleton>
                                            </div>
                                        </template>
                                    </Column>
                                    <Column alignFrozen="right" style="width: 180px;" frozen header="Thao tác">
                                        <template #body="slotProps">
                                            <div class="row-actions" v-if="!isLoading">
                                                <div class="position-relative">
                                                    <div class="item"
                                                         @click="onRowSelect(slotProps.data), isShowPopupUploadFile = !isShowPopupUploadFile, fileSelectedOnUpload = slotProps.data, headerUploadFile = slotProps.data.Type">
                                                        <div class="v-popover popover">
                                                            <div class="trigger">
                                                                <div class="icon24 upload"></div>
                                                            </div>
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
                                    <Column header="Số báo danh" field="CandidateNumber" style="width: 40px;"
                                            class="text-center">
                                        <template #body="{ data, field, slotProps }">
                                            <div v-if="!isLoading"> {{ data[field] }}</div>
                                            <div v-else>
                                                <Skeleton height="18px" class="mb-2"></Skeleton>
                                            </div>
                                        </template>
                                    </Column>
                                    <Column header="Họ và tên" field="StudentName" style="width: 80px;"
                                            class="text-left">
                                        <template #body="{ data, field, slotProps }">
                                            <div v-if="!isLoading"> {{ data[field] }}</div>
                                            <div v-else>
                                                <Skeleton height="18px" class="mb-2"></Skeleton>
                                            </div>
                                        </template>
                                    </Column>
                                    <Column header="Phòng thi" field="DepartmentName" style="width: 100px;"
                                            class="text-center">
                                        <template #body="{ data, field, slotProps }">
                                            <div v-if="!isLoading"> {{ data[field] }}</div>
                                            <div v-else>
                                                <Skeleton height="18px" class="mb-2"></Skeleton>
                                            </div>
                                        </template>
                                    </Column>
                                    <Column header="Mã sinh viên" field="StudentCode" style="width: 100px"
                                            class="text-center">
                                        <template #body="{ data, field, slotProps }">
                                            <div v-if="!isLoading"> {{ data[field] }}</div>
                                            <div v-else>
                                                <Skeleton height="18px" class="mb-2"></Skeleton>
                                            </div>
                                        </template>
                                    </Column>
                                    <Column header="Tổng điểm" field="TotalScore" style="width: 50px;"
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

                    <div class="content-body flex1 flex-column" v-if="tabItemSelected == 2">
                        <div class="grid-nodata-content flex-column">
                            <div class="img-nodata"></div>
                            <div class="description-nodata">Chưa có danh sách phân chia đề thi</div>
                            <div class="file-caution-center description-nodata">
                                Lưu ý <span style="color: red;">*</span>: Bạn vui lòng chọn thông tin kì thi
                                và tải lên danh sách thi
                                <br>của kì thi đó.
                            </div>
                            <Button class="ms-button btn detail-button primary" @click="getListExam">
                                <div class="text">
                                    Lấy danh sách
                                </div>
                            </Button>
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
import {get} from '/api/grade-master';

export default {
    components: {
        Button,
        InputText,
        Panel,
        Skeleton,
        DataTable,
        Dropdown,
        Column,
        FileUpload
    },
    data() {
        return {
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
        }
    },
    methods: {
        loadData() {
            get().then(res => {
                console.log(res)
            }).catch(error => {
                console.log(error)
            })
        }
    },
    created() {
        this.loadData()
    }
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
}

</style>
