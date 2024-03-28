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
                <DataTable paginator :rows="10" :rowsPerPageOptions="[5, 10, 20, 50]"
                           class="flex1 col-9 flex-column right-grade ms-content--table"
                           :class="{ 'loading': isLoading }" :loading="isLoading"
                           scrollable
                           :value="isLoading ? Array.from({ length: 8 }, () => ({ ...this.department })) : data"
                           currentPageReportTemplate="{first} to {last} of {totalRecords}"
                           paginatorTemplate="FirstPageLink PrevPageLink flex1 CurrentPageReport NextPageLink LastPageLink RowsPerPageDropdown"
                           @rowDblclick="onRowSelect($event.data)" tableStyle="min-width: 100%" rowHover
                           table-class="grid-group">
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
</template>

<script>
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import Skeleton from 'primevue/skeleton';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Dropdown from 'primevue/dropdown';

export default {
    components: {
        Button,
        InputText,
        Skeleton,
        DataTable,
        Dropdown,
        Column
    },
    data() {
        return {
            isCollapsed: false,
            isLoading: false,
            data: [],
            selectedCity: null,
            cities: [
                {name: 'New York', code: 'NY'},
                {name: 'Rome', code: 'RM'},
                {name: 'London', code: 'LDN'},
                {name: 'Istanbul', code: 'IST'},
                {name: 'Paris', code: 'PRS'}
            ],
        }
    },
    methods: {}
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
}

</style>
