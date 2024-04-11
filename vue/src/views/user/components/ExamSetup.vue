<template>
    <div class="main-view flex1 flex-column">
        <div class="form-list flex-column flex1">
            <div class="flex-column flex1">
                <div class="flex-row title-box">
                    <div class="list-title flex1">Thiết lập đề</div>
                    <div class="flex-row mr-12">
                        <Button @click="previewExam"
                                class="ms-btn secondary d-flex justify-content-center flex-grow-1 ms-btn_search ps-3 pe-3 gap-2">
                            <div class="">Xem trước</div>
                        </Button>
                        <Button @click="saveCriteriaSettings"
                                class="ms-btn primary ms-3 d-flex justify-content-center flex-grow-1 ms-btn_search ps-3 pe-3 gap-2">
                            <div class="">Hoàn thành</div>
                        </Button>
                    </div>
                </div>
                <div class="box list-content flex1 flex-column">
                    <TheLoadingProgress v-if="isLoadingSaveCritera"/>
                    <TabView @tab-change="tabViewIndex = $event.index">
                        <TabPanel header="Định dạng">
                            <div class="form-content flex-row">
                                <div class="right-content flex1">
                                    <Panel header="Hiệu chỉnh" toggleable class="mt-4">
                                        <div class="list-control flex-row">
                                            <div class="panel-left flex1">
                                                <div class="flex-row">
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Style format
                                                            </label>
                                                            <div class="flex1">
                                                                <Dropdown
                                                                    v-model="formats.properties.MODIFY_STYLE.content"
                                                                    class="ms-format"
                                                                    showClear
                                                                    :class="{ 'error': invalidData[`c-MODIFY_STYLE`] }"
                                                                    :options="configureExamData.style"
                                                                    optionLabel="description" optionValue="value"
                                                                    :placeholder="MESSAGE.DROPDOWN_PLACEHOLDER_SETUP"
                                                                />
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData['c-MODIFY_STYLE']">
                                                                {{ invalidData['c-MODIFY_STYLE'] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-control flex-row"
                                             v-if="formats.properties.MODIFY_STYLE.content">
                                            <div class="panel-left flex1">
                                                <div class="flex-row">
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Font
                                                            </label>
                                                            <div class="flex1">
                                                                <Dropdown
                                                                    showClear
                                                                    v-model="formats.properties.MODIFY_STYLE.properties.FONT.content"
                                                                    class="ms-format"
                                                                    :class="{ 'error': invalidData[`c-MODIFY_STYLE-FONT`] }"
                                                                    :options="configureExamData.fontType"
                                                                    optionLabel="description" optionValue="value"
                                                                    :placeholder="MESSAGE.DROPDOWN_PLACEHOLDER_SETUP"
                                                                />
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData['c-MODIFY_STYLE-FONT']">
                                                                {{ invalidData['c-MODIFY_STYLE-FONT'] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Điểm
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber
                                                                    v-model="formats.properties.MODIFY_STYLE.properties.FONT.point"
                                                                    :max-fraction-digits="5" :min="0"
                                                                    :max="100"
                                                                    :class="{ 'error': invalidData[`p-MODIFY_STYLE-FONT`] }"
                                                                    :placeholder="MESSAGE.INPUT_NUMBER_PLACEHOLDER_SETUP"
                                                                    class="ms-point"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`p-MODIFY_STYLE-FONT`]">
                                                                {{ invalidData[`p-MODIFY_STYLE-FONT`] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1"></div>
                                                </div>
                                                <div class="flex-row">
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Font Size
                                                            </label>
                                                            <div class="flex1">
                                                                <Dropdown
                                                                    showClear
                                                                    v-model="formats.properties.MODIFY_STYLE.properties.FONT_SIZE.content"
                                                                    property-name="Text Vertical"
                                                                    class="ms-format"
                                                                    :class="{ 'error': invalidData[`c-MODIFY_STYLE-FONT_SIZE`] }"
                                                                    :options="Array(50).fill().map((_, index) => index + 1)"
                                                                    :placeholder="MESSAGE.DROPDOWN_PLACEHOLDER_SETUP"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`c-MODIFY_STYLE-FONT_SIZE`]">
                                                                {{ invalidData[`c-MODIFY_STYLE-FONT_SIZE`] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Điểm
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber
                                                                    v-model="formats.properties.MODIFY_STYLE.properties.FONT_SIZE.point"
                                                                    :min="0" :max="100"
                                                                    :max-fraction-digits="5"
                                                                    :class="{ 'error': invalidData[`p-MODIFY_STYLE-FONT_SIZE`] }"
                                                                    :placeholder="MESSAGE.INPUT_NUMBER_PLACEHOLDER_SETUP"
                                                                    class="ms-point"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`p-MODIFY_STYLE-FONT_SIZE`]">
                                                                {{ invalidData[`p-MODIFY_STYLE-FONT_SIZE`] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1"></div>
                                                </div>
                                                <div class="flex-row">
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Font Style
                                                            </label>
                                                            <div class="flex1">
                                                                <Dropdown
                                                                    v-model="formats.properties.MODIFY_STYLE.properties.FONT_STYLE.content"
                                                                    :options="configureExamData.fontStyling"
                                                                    :class="{ 'error': invalidData[`c-MODIFY_STYLE-FONT_STYLE`] }"
                                                                    showClear
                                                                    optionLabel="description" optionValue="value"
                                                                    :placeholder="MESSAGE.DROPDOWN_PLACEHOLDER_SETUP"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`c-MODIFY_STYLE-FONT_STYLE`]">
                                                                {{
                                                                    invalidData[`c-MODIFY_STYLE-FONT_STYLE`]
                                                                }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Điểm
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber
                                                                    v-model="formats.properties.MODIFY_STYLE.properties.FONT_STYLE.point"
                                                                    :min="0" :max="100"
                                                                    :max-fraction-digits="5"
                                                                    :class="{ 'error': invalidData[`p-MODIFY_STYLE-FONT_STYLE`] }"
                                                                    :placeholder="MESSAGE.INPUT_NUMBER_PLACEHOLDER_SETUP"
                                                                    class="ms-point"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`p-MODIFY_STYLE-FONT_STYLE`]">
                                                                {{
                                                                    invalidData[`p-MODIFY_STYLE-FONT_STYLE`]
                                                                }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1"></div>
                                                </div>
                                                <div class="flex-row">
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Number
                                                            </label>
                                                            <div class="flex1">
                                                                <Dropdown
                                                                    v-model="formats.properties.MODIFY_STYLE.properties.NUMBERING.content"
                                                                    :options="configureExamData.numberType"
                                                                    :class="{ 'error': invalidData[`c-MODIFY_STYLE-NUMBERING`] }"
                                                                    showClear
                                                                    optionLabel="description" optionValue="value"
                                                                    :placeholder="MESSAGE.DROPDOWN_PLACEHOLDER_SETUP"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`c-MODIFY_STYLE-NUMBERING`]">
                                                                {{
                                                                    invalidData[`c-MODIFY_STYLE-NUMBERING`]
                                                                }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Điểm
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber
                                                                    v-model="formats.properties.MODIFY_STYLE.properties.NUMBERING.point"
                                                                    :min="0" :max="100"
                                                                    :max-fraction-digits="5"
                                                                    :class="{ 'error': invalidData[`p-MODIFY_STYLE-NUMBERING`] }"
                                                                    :placeholder="MESSAGE.INPUT_NUMBER_PLACEHOLDER_SETUP"
                                                                    class="ms-point"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`p-MODIFY_STYLE-NUMBERING`]">
                                                                {{
                                                                    invalidData[`p-MODIFY_STYLE-NUMBERING`]
                                                                }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1"></div>
                                                </div>
                                            </div>
                                            <div class="panel-right flex1">
                                                <div class="flex-row">
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Font Color
                                                            </label>
                                                            <div class="flex1">
                                                                <Dropdown
                                                                    v-model="formats.properties.MODIFY_STYLE.properties.FONT_COLOR.content"
                                                                    :type-property="TypeProperty.TextControl"
                                                                    property-name="Text Control" class="ms-format"
                                                                    :class="{ 'error': invalidData[`c-MODIFY_STYLE-FONT_COLOR`] }"
                                                                    :options="configureExamData.fontColor"
                                                                    optionLabel="description" optionValue="value"
                                                                    showClear
                                                                    :placeholder="MESSAGE.INPUT_PLACEHOLDER_SETUP"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`c-MODIFY_STYLE-FONT_COLOR`]">
                                                                {{ invalidData[`c-MODIFY_STYLE-FONT_COLOR`] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Điểm
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber
                                                                    v-model="formats.properties.MODIFY_STYLE.properties.FONT_COLOR.point"
                                                                    :max-fraction-digits="5" :min="0"
                                                                    :max="100"
                                                                    :class="{ 'error': invalidData[`p-MODIFY_STYLE-FONT_COLOR`] }"
                                                                    :placeholder="MESSAGE.INPUT_NUMBER_PLACEHOLDER_SETUP"
                                                                    class="ms-point"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`p-MODIFY_STYLE-FONT_COLOR`]">
                                                                {{ invalidData[`p-MODIFY_STYLE-FONT_COLOR`] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1"></div>
                                                </div>
                                                <div class="flex-row">
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Margin Left
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber
                                                                    v-model="formats.properties.MODIFY_STYLE.properties.MARGIN_LEFT.content"
                                                                    :max-fraction-digits="5"
                                                                    :min="0"
                                                                    :max="100"
                                                                    :class="{ 'error': invalidData[`c-MODIFY_STYLE-MARGIN_LEFT`] }"
                                                                    :placeholder="MESSAGE.INPUT_PLACEHOLDER_SETUP"
                                                                    class="ms-point"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`c-MODIFY_STYLE-MARGIN_LEFT`]">
                                                                {{ invalidData[`c-MODIFY_STYLE-MARGIN_LEFT`] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Điểm
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber
                                                                    v-model="formats.properties.MODIFY_STYLE.properties.MARGIN_LEFT.point"
                                                                    :max-fraction-digits="5"
                                                                    :min="0"
                                                                    :max="100"
                                                                    :class="{ 'error': invalidData[`p-MODIFY_STYLE-MARGIN_LEFT`] }"
                                                                    :placeholder="MESSAGE.INPUT_NUMBER_PLACEHOLDER_SETUP"
                                                                    class="ms-point"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`p-MODIFY_STYLE-MARGIN_LEFT`]">
                                                                {{ invalidData[`p-MODIFY_STYLE-MARGIN_LEFT`] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1"></div>
                                                </div>
                                                <div class="flex-row">
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Margin Right
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber
                                                                    v-model="formats.properties.MODIFY_STYLE.properties.MARGIN_RIGHT.content"
                                                                    :max-fraction-digits="5" :min="0"
                                                                    :max="100"
                                                                    :class="{ 'error': invalidData[`c-MODIFY_STYLE-MARGIN_RIGHT`] }"
                                                                    :placeholder="MESSAGE.INPUT_PLACEHOLDER_SETUP"
                                                                    class="ms-point"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData['c-MODIFY_STYLE-MARGIN_RIGHT']">
                                                                {{ invalidData['c-MODIFY_STYLE-MARGIN_RIGHT'] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Điểm

                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber
                                                                    v-model="formats.properties.MODIFY_STYLE.properties.MARGIN_RIGHT.point"
                                                                    :max-fraction-digits="5" :min="0"
                                                                    :max="100"
                                                                    :class="{ 'error': invalidData[`p-MODIFY_STYLE-MARGIN_RIGHT`] }"
                                                                    :placeholder="MESSAGE.INPUT_NUMBER_PLACEHOLDER_SETUP"
                                                                    class="ms-point"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`p-MODIFY_STYLE-MARGIN_RIGHT`]">
                                                                {{ invalidData[`p-MODIFY_STYLE-MARGIN_RIGHT`] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </Panel>
                                    <Panel header="Áp dụng style" toggleable class="mt-4">
                                        <div class="list-control">
                                            <div class="flex-row">
                                                <div class="flex1">
                                                    <div class="form-group slide-detail">
                                                        <label class="top-label d-flex">
                                                            Loại áp dụng
                                                        </label>
                                                        <div class="flex1">
                                                            <Dropdown class="ms-format" :showClear="true"
                                                                      :class="{ 'error': invalidData[`c-APPLY_STYLE`] }"
                                                                      v-model="formats.properties.APPLY_STYLE.content"
                                                                      :options="configureExamData.applyStyle"
                                                                      @change="changeApplyStyle"
                                                                      optionLabel="description" optionValue="value"
                                                                      :placeholder="MESSAGE.DROPDOWN_PLACEHOLDER_SETUP"/>
                                                        </div>
                                                        <div class="error-text"
                                                             v-if="invalidData[`c-APPLY_STYLE`]">
                                                            {{ invalidData[`c-APPLY_STYLE`] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sp"></div>
                                                <div class="flex1">
                                                    <div class="form-group slide-detail">
                                                        <label class="top-label d-flex">
                                                            Loại style áp dụng
                                                        </label>
                                                        <div class="flex1">
                                                            <Dropdown class="ms-format" :showClear="true"
                                                                      :class="{ 'error': invalidData[`k-APPLY_STYLE`] }"
                                                                      v-model="formats.properties.APPLY_STYLE.property.key"
                                                                      :options="configureExamData.style"
                                                                      optionLabel="description" optionValue="value"
                                                                      :placeholder="MESSAGE.DROPDOWN_PLACEHOLDER_SETUP"/>
                                                        </div>
                                                        <div class="error-text"
                                                             v-if="invalidData[`k-APPLY_STYLE`]">
                                                            {{ invalidData[`k-APPLY_STYLE`] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sp"></div>
                                                <div class="flex1"
                                                     v-if=" configureExamData.applyStyleEnum && configureExamData.applyStyleEnum['PARAGRAPH'].value === formats.properties.APPLY_STYLE.content">
                                                    <div class="form-group slide-detail">
                                                        <label class="top-label d-flex">
                                                            Đoạn văn áp dụng
                                                        </label>
                                                        <div class="flex1">
                                                            <MultiSelect class="ms-format" :showClear="true"
                                                                         :class="{ 'error': invalidData[`c-APPLY_STYLE-content`] }"
                                                                         v-model="formats.properties.APPLY_STYLE.property.content"
                                                                         :options="configureExamData.paragraphsEllipsis"
                                                                         :placeholder="MESSAGE.DROPDOWN_PLACEHOLDER_SETUP"/>
                                                        </div>
                                                        <div class="error-text"
                                                             v-if="invalidData[`c-APPLY_STYLE-content`]">
                                                            {{ invalidData[`c-APPLY_STYLE-content`] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex1"
                                                     v-if=" configureExamData.applyStyleEnum && configureExamData.applyStyleEnum['OTHER'].value === formats.properties.APPLY_STYLE.content">
                                                    <div class="form-group slide-detail">
                                                        <label class="top-label d-flex">
                                                            Đoạn văn áp dụng
                                                        </label>
                                                        <div class="flex1">
                                                            <InputText
                                                                v-model="formats.properties.APPLY_STYLE.property.value"
                                                                :class="{ 'error': invalidData[`c-APPLY_STYLE-value`] }"
                                                                class="heigth36" placeholder="Nhập nội dung"/>
                                                        </div>
                                                        <div class="error-text"
                                                             v-if="invalidData[`c-APPLY_STYLE-value`]">
                                                            {{ invalidData[`c-APPLY_STYLE-value`] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sp"></div>
                                                <div class="flex1">
                                                    <div class="form-group slide-detail">
                                                        <label class="top-label d-flex">
                                                            Điểm
                                                        </label>
                                                        <div class="flex1">
                                                            <InputNumber
                                                                v-model="formats.properties.APPLY_STYLE.point"
                                                                :max-fraction-digits="5" :min="0"
                                                                :max="100"
                                                                :class="{ 'error': invalidData[`p-APPLY_STYLE`] }"
                                                                :placeholder="MESSAGE.INPUT_NUMBER_PLACEHOLDER_SETUP"
                                                                class="ms-point"/>
                                                        </div>
                                                        <div class="error-text"
                                                             v-if="invalidData[`p-APPLY_STYLE`]">
                                                            {{ invalidData[`p-APPLY_STYLE`] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex1"></div>
                                                <div class="col-sp"></div>
                                                <div class="flex1"></div>
                                                <div class="col-sp"></div>
                                                <div class="flex1"></div>
                                                <div class="col-sp"></div>
                                            </div>
                                        </div>
                                    </Panel>
                                </div>
                            </div>
                        </TabPanel>
                        <TabPanel header="Chèn nội dung">
                            <div class="form-content flex-row">
                                <div class="right-content flex1">
                                    <Panel header="Hình ảnh" toggleable class="mt-10">
                                        <div class="list-control">
                                            <div class="flex-row">
                                                <div class="flex1">
                                                    <div class="form-group slide-detail">
                                                        <label class="top-label d-flex">
                                                            Create a Sheet

                                                        </label>
                                                        <div class="flex1">
                                                            <Dropdown v-model="InsertSheet.content"
                                                                      :class="{ 'error': invalidData[`content${TypeProperty.InsertSheet}`] }"
                                                                      :options="[{ label: 'Choose a Option', value: 1 }, { label: 'Create a Sheet', value: 2 }]"
                                                                      optionLabel="label" optionValue="value"
                                                                      placeholder="Choose a Option"/>
                                                        </div>
                                                        <div class="error-text"
                                                             v-if="invalidData[`content${TypeProperty.InsertSheet}`]">
                                                            {{ invalidData[`content${TypeProperty.InsertSheet}`] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sp"></div>
                                                <div class="flex1">
                                                    <div class="form-group slide-detail">
                                                        <label class="top-label d-flex">
                                                            point

                                                        </label>
                                                        <div class="flex1">
                                                            <InputText v-model="InsertSheet.point"
                                                                       :class="{ 'error': invalidData[`point${TypeProperty.InsertSheet}`] }"
                                                                       class="heigth36"
                                                                       :placeholder="MESSAGE.INPUT_NUMBER_PLACEHOLDER_SETUP"/>
                                                        </div>
                                                        <div class="error-text"
                                                             v-if="invalidData[`point${TypeProperty.InsertSheet}`]">
                                                            {{ invalidData[`point${TypeProperty.InsertSheet}`] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sp"></div>
                                                <div class="flex1"></div>
                                                <div class="col-sp"></div>
                                                <div class="flex1"></div>
                                                <div class="col-sp"></div>
                                                <div class="flex1"></div>
                                            </div>
                                        </div>
                                    </Panel>
                                </div>
                            </div>
                        </TabPanel>
                        <TabPanel header="Thiết lập chung">
                            <div class="form-content flex-row">
                                <div class="right-content flex1">
                                    <Panel header="Page Layout" toggleable class="mt-10">
                                        <div class="flex-column">
                                            <div class="list-control flex-row">
                                                <div class="panel-left flex1">
                                                    <div class="flex-row">
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Page Orientation
                                                                </label>
                                                                <div class="flex1">
                                                                    <Dropdown
                                                                        v-model="generals.properties.pageOrientation.content"
                                                                        :options="configureExamData.pageOrientation"
                                                                        optionLabel="description" optionValue="value"
                                                                        :class="{ 'error': invalidData['contentpageOrientation'] }"

                                                                        placeholder="Select a Page Orientation"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData['contentpageOrientation']">
                                                                    {{ invalidData['contentpageOrientation'] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    point
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber :max-fraction-digits="5"
                                                                                 v-model="generals.properties.pageOrientation.point"
                                                                                 :class="{ 'error': invalidData['pointpageOrientation'] }"
                                                                                 :placeholder="MESSAGE.INPUT_NUMBER_PLACEHOLDER_SETUP"
                                                                                 class="ms-point"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData['pointpageOrientation']">
                                                                    {{ invalidData['pointpageOrientation'] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1"></div>
                                                    </div>
                                                    <div class="flex-row">
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Page Size
                                                                </label>
                                                                <div class="flex1">
                                                                    <Dropdown
                                                                        v-model="generals.properties.PAGE_SIZE.content"
                                                                        :options="configureExamData.pageSize"
                                                                        :class="{ 'error': invalidData['c-PAGE_SIZE'] }"
                                                                        optionLabel="description" optionValue="value"
                                                                        showClear
                                                                        :placeholder="MESSAGE.DROPDOWN_PLACEHOLDER_SETUP"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData['c-PAGE_SIZE']">
                                                                    {{ invalidData['c-PAGE_SIZE'] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Điểm
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber
                                                                        v-model="generals.properties.PAGE_SIZE.point"
                                                                        :max-fraction-digits="5"
                                                                        :class="{ 'error': invalidData['p-PAGE_SIZE'] }"
                                                                        :placeholder="MESSAGE.INPUT_NUMBER_PLACEHOLDER_SETUP"
                                                                        class="ms-point"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData['p-PAGE_SIZE']">
                                                                    {{ invalidData['p-PAGE_SIZE'] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1"></div>
                                                    </div>
                                                    <div class="flex-row">
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Center on page
                                                                </label>
                                                                <div class="flex1">
                                                                    <Dropdown class="ms-format"
                                                                              :options="['sheet1', 'sheet2', 'sheet3']"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    point
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber
                                                                        :placeholder="MESSAGE.INPUT_NUMBER_PLACEHOLDER_SETUP"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1"></div>
                                                    </div>
                                                    <div class="flex-row">
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Page Effect
                                                                </label>
                                                                <div class="flex1">
                                                                    <Dropdown class="ms-format"
                                                                              :options="['sheet1', 'sheet2', 'sheet3']"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    point
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber
                                                                        :placeholder="MESSAGE.INPUT_NUMBER_PLACEHOLDER_SETUP"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1"></div>
                                                    </div>
                                                </div>
                                                <div class="panel-right flex1">
                                                    <div class="flex-row">
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Margin Top
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber
                                                                        v-model="generals.properties.MARGIN_TOP_ALL.content"
                                                                        :min="0"
                                                                        :max="100" :max-fraction-digits="5"
                                                                        :class="{ 'error': invalidData[`c-MARGIN_TOP_ALL`] }"
                                                                        placeholder="Nhập nội dung"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData[`c-MARGIN_TOP_ALL`]">
                                                                    {{ invalidData[`c-MARGIN_TOP_ALL`] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Điểm
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber
                                                                        v-model="generals.properties.MARGIN_TOP_ALL.point"
                                                                        :min="0"
                                                                        :max="100" :max-fraction-digits="5"
                                                                        :class="{ 'error': invalidData[`p-MARGIN_TOP_ALL`] }"
                                                                        :placeholder="MESSAGE.INPUT_NUMBER_PLACEHOLDER_SETUP"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData[`p-MARGIN_TOP_ALL`]">
                                                                    {{ invalidData[`p-MARGIN_TOP_ALL`] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1"></div>
                                                    </div>
                                                    <div class="flex-row">
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Margin Left
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber
                                                                        v-model="generals.properties.MARGIN_LEFT_ALL.content"
                                                                        :min="0"
                                                                        :max="100" :max-fraction-digits="5"
                                                                        :class="{ 'error': invalidData[`c-MARGIN_LEFT_ALL`] }"
                                                                        placeholder="Nhập nội dung"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData[`c-MARGIN_LEFT_ALL`]">
                                                                    {{ invalidData[`c-MARGIN_LEFT_ALL`] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Điểm
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber
                                                                        v-model="generals.properties.MARGIN_LEFT_ALL.point"
                                                                        :min="0"
                                                                        :max="100" :max-fraction-digits="5"
                                                                        :class="{ 'error': invalidData[`p-MARGIN_LEFT_ALL`] }"
                                                                        :placeholder="MESSAGE.INPUT_NUMBER_PLACEHOLDER_SETUP"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData[`p-MARGIN_LEFT_ALL`]">
                                                                    {{ invalidData[`p-MARGIN_LEFT_ALL`] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1"></div>
                                                    </div>
                                                    <div class="flex-row">
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Margin Right
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber
                                                                        v-model="generals.properties.MARGIN_RIGHT_ALL.content"
                                                                        :min="0"
                                                                        :max="100" :max-fraction-digits="5"
                                                                        :class="{ 'error': invalidData[`c-MARGIN_RIGHT_ALL`] }"
                                                                        placeholder="Nhập nội dung"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData[`c-MARGIN_RIGHT_ALL`]">
                                                                    {{ invalidData[`c-MARGIN_RIGHT_ALL`] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Điểm
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber
                                                                        v-model="generals.properties.MARGIN_RIGHT_ALL.point"
                                                                        :min="0"
                                                                        :max="100" :max-fraction-digits="5"
                                                                        :class="{ 'error': invalidData[`p-MARGIN_RIGHT_ALL`] }"
                                                                        :placeholder="MESSAGE.INPUT_NUMBER_PLACEHOLDER_SETUP"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData[`p-MARGIN_RIGHT_ALL`]">
                                                                    {{ invalidData[`p-MARGIN_RIGHT_ALL`] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1"></div>
                                                    </div>
                                                    <div class="flex-row">
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Margin Bottom
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber
                                                                        v-model="generals.properties.MARGIN_BOTTOM_ALL.content"
                                                                        :min="0"
                                                                        :max="100" :max-fraction-digits="5"
                                                                        :class="{ 'error': invalidData[`c-MARGIN_BOTTOM_ALL`] }"
                                                                        placeholder="Nhập nội dung"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData[`c-MARGIN_BOTTOM_ALL`]">
                                                                    {{ invalidData[`c-MARGIN_BOTTOM_ALL`] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Điểm
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber
                                                                        v-model="generals.properties.MARGIN_BOTTOM_ALL.point"
                                                                        :min="0"
                                                                        :max="100" :max-fraction-digits="5"
                                                                        :class="{ 'error': invalidData[`p-MARGIN_BOTTOM_ALL`] }"
                                                                        :placeholder="MESSAGE.INPUT_NUMBER_PLACEHOLDER_SETUP"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData[`p-MARGIN_BOTTOM_ALL`]">
                                                                    {{ invalidData[`p-MARGIN_BOTTOM_ALL`] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1"></div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </Panel>
                                    <Panel header="Thông tin chung" toggleable class="mt-4">
                                        <div class="flex-column">
                                            <div class="right-content flex1">
                                                <div class="list-control">
                                                    <div class="flex-row">
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    File name
                                                                </label>
                                                                <div class="flex1">
                                                                    <Dropdown
                                                                        v-model="generals.properties.FILE_NAME.content"
                                                                        :options="configureExamData.infoType"
                                                                        optionLabel="description" optionValue="value"
                                                                        :class="{ 'error': invalidData['c-FILE_NAME'] }"
                                                                        showClear
                                                                        placeholder="Vui lòng chọn một hạng mục"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData[`c-FILE_NAME`]">
                                                                    {{ invalidData[`c-FILE_NAME`] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1"
                                                             v-if="configureExamData.infoTypeEnums && generals.properties.FILE_NAME.content === configureExamData.infoTypeEnums['OTHER'].value">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Nội dung
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputText
                                                                        v-model="generals.properties.FILE_NAME.value"
                                                                        :class="{ 'error': invalidData[`v-FILE_NAME`] }"
                                                                        class="heigth36" placeholder="Nhập nội dung"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData[`v-FILE_NAME`]">
                                                                    {{ invalidData[`v-FILE_NAME`] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"
                                                             v-if="configureExamData.infoTypeEnums && generals.properties.FILE_NAME.content === configureExamData.infoTypeEnums['OTHER'].value"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Điểm
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber
                                                                        v-model="generals.properties.FILE_NAME.point"
                                                                        :class="{ 'error': invalidData[`p-FILE_NAME`] }"
                                                                        :max="10"
                                                                        :min="0" :maxFractionDigits="5"
                                                                        :placeholder="MESSAGE.INPUT_NUMBER_PLACEHOLDER_SETUP"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData[`p-FILE_NAME`]">
                                                                    {{ invalidData[`p-FILE_NAME`] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="flex1"
                                                             v-if="configureExamData.infoTypeEnums && generals.properties.FILE_NAME.content !== configureExamData.infoTypeEnums['OTHER'].value"></div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Author
                                                                </label>
                                                                <div class="flex1">
                                                                    <Dropdown
                                                                        v-model="generals.properties.AUTHOR.content"
                                                                        :options="configureExamData.infoType"
                                                                        optionLabel="description" optionValue="value"
                                                                        :class="{ 'error': invalidData['c-AUTHOR'] }"
                                                                        showClear
                                                                        placeholder="Vui lòng chọn một hạng mục"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData[`c-AUTHOR`]">
                                                                    {{ invalidData[`c-AUTHOR`] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"
                                                             v-if="configureExamData.infoTypeEnums && generals.properties.AUTHOR.content === configureExamData.infoTypeEnums['OTHER'].value"></div>
                                                        <div class="flex1"
                                                             v-if="configureExamData.infoTypeEnums && generals.properties.AUTHOR.content === configureExamData.infoTypeEnums['OTHER'].value">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Nội dung
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputText
                                                                        v-model="generals.properties.AUTHOR.value"
                                                                        :class="{ 'error': invalidData[`v-AUTHOR`] }"
                                                                        class="heigth36" placeholder="Nhập nội dung"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData[`v-AUTHOR`]">
                                                                    {{ invalidData[`v-AUTHOR`] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"
                                                             v-if="configureExamData.infoTypeEnums && generals.properties.AUTHOR.content !== configureExamData.infoTypeEnums['OTHER'].value"></div>
                                                        <div class="col-sp"
                                                             v-if="configureExamData.infoTypeEnums && generals.properties.AUTHOR.content === configureExamData.infoTypeEnums['OTHER'].value"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Điểm
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber
                                                                        v-model="generals.properties.AUTHOR.point"
                                                                        :class="{ 'error': invalidData[`p-AUTHOR`] }"
                                                                        :max="10"
                                                                        :min="0" :maxFractionDigits="5"
                                                                        :placeholder="MESSAGE.INPUT_NUMBER_PLACEHOLDER_SETUP"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData[`p-AUTHOR`]">
                                                                    {{ invalidData[`p-AUTHOR`] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"
                                                             v-if="configureExamData.infoTypeEnums && generals.properties.AUTHOR.content !== configureExamData.infoTypeEnums['OTHER'].value"></div>
                                                        <div class="flex1"
                                                             v-if="configureExamData.infoTypeEnums && generals.properties.AUTHOR.content !== configureExamData.infoTypeEnums['OTHER'].value"></div>
                                                        <div class="col-sp"></div>
                                                    </div>
                                                    <div class="flex-row">
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Info title
                                                                </label>
                                                                <div class="flex1">
                                                                    <Dropdown
                                                                        v-model="generals.properties.TITLE.content"
                                                                        :options="configureExamData.infoType"
                                                                        optionLabel="description" optionValue="value"
                                                                        :class="{ 'error': invalidData[`c-TITLE`] }"
                                                                        showClear
                                                                        placeholder="Vui lòng chọn một hạng mục"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData['c-TITLE']">
                                                                    {{ invalidData['c-TITLE'] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"
                                                             v-if="configureExamData.infoTypeEnums && generals.properties.TITLE.content === configureExamData.infoTypeEnums['OTHER'].value"></div>
                                                        <div class="flex1"
                                                             v-if="configureExamData.infoTypeEnums && generals.properties.TITLE.content === configureExamData.infoTypeEnums['OTHER'].value">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Nội dung
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputText
                                                                        v-model="generals.properties.TITLE.value"
                                                                        :class="{ 'error': invalidData['v-TITLE'] }"
                                                                        class="heigth36" placeholder="Nhập nội dung"/>
                                                                </div>
                                                                <div class="error-text" v-if="invalidData['v-TITLE']">
                                                                    {{ invalidData['v-TITLE'] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"
                                                             v-if="configureExamData.infoTypeEnums && generals.properties.TITLE.content !== configureExamData.infoTypeEnums['OTHER'].content"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Điểm

                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber
                                                                        v-model="generals.properties.TITLE.point"
                                                                        :class="{ 'error': invalidData['p-TITLE'] }"
                                                                        :max="10"
                                                                        :min="0"
                                                                        :placeholder="MESSAGE.INPUT_NUMBER_PLACEHOLDER_SETUP"/>
                                                                </div>
                                                                <div class="error-text" v-if="invalidData['p-TITLE']">
                                                                    {{ invalidData['p-TITLE'] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1"
                                                             v-if="configureExamData.infoTypeEnums && generals.properties.TITLE.content !== configureExamData.infoTypeEnums['OTHER'].value"></div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1"></div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1"></div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </Panel>
                                </div>
                            </div>

                        </TabPanel>
                        <TabPanel headerClass="totalScore" :disabled="true">
                            <template #header>
                                <span>Tổng điểm: <b>{{ totalScore }}</b> điểm</span>
                            </template>
                        </TabPanel>
                    </TabView>
                </div>
            </div>
        </div>
    </div>

    <Dialog v-model:visible="isShowConfigureExam" header="Thông tin thiết lập" :modal="true" :draggable="false"
            :position="'top'" :style="{ width: '60vw', height: '100vh' }" content-class="d-flex unscroller">
        <div class="ms-grid-viewer flex1 flex-box flex-column">
            <div class="ms-content--table flex-column flex1">
                <DataTable paginator :rows="10" :rowsPerPageOptions="[5, 10, 20, 50]" class="flex1 flex-column"
                           :class="{ 'loading': isLoading }" :loading="isLoading"
                           :value="isLoading ? Array.from({ length: 8 }, () => ({ ...{} })) : listCriteriaExam"
                           table-class="grid-group"
                           currentPageReportTemplate="{first} to {last} of {totalRecords}"
                           paginatorTemplate="FirstPageLink PrevPageLink flex1 CurrentPageReport NextPageLink LastPageLink RowsPerPageDropdown"
                           @rowDblclick="onRowSelect($event.data)" tableStyle="min-width: 100%" rowHover>
                    <Column header="STT" style="width: 100px;" class="text-center">
                        <template #body="slotProps">
                            <div v-if="!isLoading"> {{ slotProps.index + 1 }}</div>
                            <div v-else>
                                <Skeleton height="18px" class="mb-2"></Skeleton>
                            </div>
                        </template>
                    </Column>
                    <Column field="property_name" header="Tiêu chí">
                        <template #body="{ data, field, slotProps }">
                            <div v-if="!isLoading"> {{ data[field] }}</div>
                            <div v-else>
                                <Skeleton height="18px" class="mb-2"></Skeleton>
                            </div>
                        </template>
                    </Column>
                    <Column field="content" dataKey="id" header="Nội dung tiêu chí">
                        <template #body="{ data, field, slotProps }">
                            <div v-if="!isLoading"> {{ data[field] }}</div>
                            <div v-else>
                                <Skeleton height="18px" class="mb-2"></Skeleton>
                            </div>
                        </template>
                    </Column>
                    <Column field="point" dataKey="id" header="Điểm">
                        <template #body="{ data, field, slotProps }">
                            <div v-if="!isLoading"> {{ data[field] }}</div>
                            <div v-else>
                                <Skeleton height="18px" class="mb-2"></Skeleton>
                            </div>
                        </template>
                    </Column>
                    <Column alignFrozen="right" style="width: 100px; text-align: center;" frozen header="Thao tác">
                        <template #body="slotProps, index">
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
        <template #footer>
            <Button label="Đóng" class="ms-button mt-10 btn w-100" @click="isShowConfigureExam = false"/>
        </template>
    </Dialog>
    <Dialog v-model:visible="isPopupDelete" modal closeOnEscape :style="{ width: '25vw', height: '20vh' }"
            header="Xóa đề thi">
        <TheLoadingProgress v-if="popupLoading"/>
        <div class="w-full flex flex-column">
            <span> Bạn có chắc chắn muốn xóa tiêu chí <b>{{ deletedItem.PropertyName }}</b> không?</span>
        </div>
        <template #footer>
            <Button label="Không" class="ms-button btn detail-button secondary" @click="isPopupDelete = false"/>
            <Button label="Xóa đề thi" class="ms-button btn w-100 danger" @click="handleDeleteCriteria"/>
        </template>
    </Dialog>
    <Toast/>
</template>

<script>
import Toast from 'primevue/toast';
import Skeleton from 'primevue/skeleton';
import Dropdown from 'primevue/dropdown';
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import Button from 'primevue/button';
import InputNumber from 'primevue/inputnumber';
import Panel from 'primevue/panel';
import SplitterPanel from 'primevue/splitterpanel';
import InputText from 'primevue/inputtext';
import Dialog from 'primevue/dialog';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import {mapState, mapActions} from 'vuex'
import {configureExam, saveCriteria, getCriteriaByExamBankId, deleteCriteria} from '/api/exam-bank'
import TheLoadingProgress from '@/components/LoadingProgress.vue';
import {MESSAGE, RESPONSE_STATUS} from "@/common/enums";
import MultiSelect from 'primevue/multiselect';

export default {
    components: {
        TabView,
        TabPanel,
        Dropdown,
        Panel,
        Toast,
        Skeleton,
        SplitterPanel,
        InputText,
        InputNumber,
        Button,
        Dialog,
        DataTable,
        Column,
        MultiSelect,
        TheLoadingProgress
    },
    data() {
        return {
            optionSheet: [],
            Font: null,
            totalScore: 0,
            isLoading: false,
            visible: true,
            popupLoading: false,
            tabViewIndex: 0,

            isPopupDelete: false,
            deletedItem: null,
            selectedData: null,

            Formula: {
                SheetIndex: null,
                Range: null,
                FormulaType: null,
                content: null,
                point: null,
                PropertyName: 'Formula',
            },

            Text: {
                SheetIndex: null,
                Range: null,
                content: null,
                point: null,
            },

            InsertSheet: {
                content: null,
                point: null,
            },

            formats: {
                SheetIndex: null,
                Range: null,
                properties: {
                    MODIFY_STYLE: {
                        properties: {
                            FONT: {
                                content: null,
                                point: null,
                                propertyName: 'Font',
                            },
                            FONT_SIZE: {
                                content: null,
                                point: null,
                                propertyName: 'Font size',
                            },
                            FONT_STYLE: {
                                content: null,
                                point: null,
                                propertyName: 'Font style',
                            },
                            FONT_COLOR: {
                                content: null,
                                point: null,
                                propertyName: 'Font color',
                            },
                            MARGIN_LEFT: {
                                content: null,
                                point: null,
                                propertyName: 'Margin left',
                            },
                            MARGIN_RIGHT: {
                                content: null,
                                point: null,
                                propertyName: 'Margin right',
                            },
                            NUMBERING: {
                                content: null,
                                point: null,
                                propertyName: 'Numbering type',
                            }
                        },
                        required: true,
                        content: null,
                        point: null,
                        propertyName: 'Modify Style',
                    },

                    APPLY_STYLE: {
                        content: null,
                        point: null,
                        propertyName: 'Apply Style',
                        property: {
                            key: null,
                            content: null,
                            value: null,
                        }
                    },

                    FontSize: {
                        content: null,
                        point: null,
                        required: true,
                        propertyName: 'Font Size',
                    },

                    FontStyle: {
                        content: null,
                        point: null,
                        required: true,
                        propertyName: 'Font Style',
                    },

                    FontColor: {
                        content: null,
                        point: null,
                        required: true,
                        propertyName: 'Font Color',
                    },

                    FormatAsTable: {
                        content: null,
                        point: null,
                        required: true,
                        propertyName: 'formats as Table',
                    },

                    TableStyle: {
                        content: null,
                        point: null,
                        required: true,
                        propertyName: 'Table Style',
                    },

                    TableName: {
                        content: null,
                        point: null,
                        required: true,
                        propertyName: 'Table Name',
                    },

                    ColumnWidth: {
                        content: null,
                        point: null,
                        required: true,
                        propertyName: 'Column Width',
                    },

                    RowHeight: {
                        content: null,
                        point: null,
                        required: true,
                        propertyName: 'Row Height',
                    },

                    FormatNumber: {
                        content: null,
                        point: null,
                        required: true,
                        propertyName: 'formats Number',
                        decimal: 0,
                        symbol: null,
                    },

                    TextControl: {
                        content: null,
                        point: null,
                        required: true,
                        propertyName: 'Text Control',
                    },

                    Horizontal: {
                        content: null,
                        point: null,
                        required: true,
                        propertyName: 'Horizontal',
                    },

                    Vertical: {
                        content: null,
                        point: null,
                        required: true,
                        propertyName: 'Vertical',
                    }
                },
                SheetName: {
                    SheetIndex: [],
                    Type: [],
                    content: [],
                    point: [],
                },
            },

            generals: {
                properties: {
                    FILE_NAME: {
                        content: null,
                        point: null,
                        type: 'Text',
                        value: null,
                        propertyName: 'File Name',
                    },

                    pageOrientation: {
                        content: null,
                        point: null,
                        type: 'Option',
                        propertyName: 'Page Orientation',
                    },

                    PAGE_SIZE: {
                        content: null,
                        point: null,
                        type: 'Option',
                        propertyName: 'Page Size',
                    },

                    MARGIN_TOP_ALL: {
                        content: null,
                        point: null,
                        type: 'Option',
                        propertyName: 'Margin top all',
                    },

                    MARGIN_LEFT_ALL: {
                        content: null,
                        point: null,
                        type: 'Option',
                        propertyName: 'Margin left all',
                    },

                    MARGIN_RIGHT_ALL: {
                        content: null,
                        point: null,
                        type: 'Option',
                        propertyName: 'Margin right all',
                    },

                    MARGIN_BOTTOM_ALL: {
                        content: null,
                        point: null,
                        type: 'Option',
                        propertyName: 'Margin bottom all',
                    },

                    AUTHOR: {
                        content: null,
                        point: null,
                        type: 'Text',
                        value: null,
                        propertyName: 'Author',
                    },

                    TITLE: {
                        content: null,
                        point: null,
                        type: 'Text',
                        value: null,
                        propertyName: 'Title',
                    },
                },
                SheetName: {
                    SheetIndex: [],
                    Type: [],
                    content: [],
                    point: [],
                },
            },

            AdvancedFilter: {
                SheetIndex: null,
                Range: null,   //vùng đặt tiêu chí
                DataSheetIndex: null,
                DataRange: null, //vùng dữ liệu
                SheetIndexRange: null,
                SheetIndexCriteria: [],
                TitleRange: [],
                Titlecontent: [],
                CriteriaRange: [],
                Criteriacontent: [],
                countCriteria: 1,
                point: null,
            },

            //popup thông tin đã thiết lập
            isShowConfigureExam: false,
            TypeProperty: [],
            criteria: {
                SheetId: null,
                Range: null,
                ExamBankId: null,
                DataReference: null,
                content: null,
                PropertyName: null,
                TypeProperty: null,
                point: null
            },

            //dữ liệu thiết lập đề: enum,sheetIndex
            configureExamData: [],
            listCriteria: [],
            listCriteriaExam: [],
            examBankId: null,
            isLoadingSaveCritera: false,

            invalidData: [],
        }
    },

    methods: {
        /**
         * Lấy dữ liệu tiêu chí theo id đề thi
         */
        loadCriteriaByExamId() {
            this.isLoading = true;
            getCriteriaByExamBankId(this.selectedData).then(res => {
                this.listCriteriaExam = res.data;
            }).catch(error => {
                console.log(error);
            }).finally(() => {
                setTimeout(() => {
                    5
                    this.isLoading = false;
                }, 300);
            });
        },

        /**
         * Nếu văn bản quá dài nối đoạn đầu và đoạn cuối bằng dấu ...
         * Ví dụ: Nếu văn bản quá dài nối đoạn đầu và đoạn cuối bằng dấu ... => Nếu văn bản ... cuối bằng dấu
         * @param paragraphs
         * @returns {(string|string)[]}
         */
        textWithEllipsis(paragraphs) {
            const formattedText = [];
            // Lặp qua mỗi đoạn văn bản trong mảng paragraphs
            for (let index in paragraphs) {
                if (paragraphs[index].length > 30) {
                    // Tách thành từng từ
                    const words = paragraphs[index].split(" ");
                    // Lấy 5 từ đầu
                    const firstFiveWords = words.slice(0, 5).join(" ");
                    // Lấy 4 từ cuối
                    const lastFourWords = words.slice(-4).join(" ");
                    // Nối 5 từ đầu và 4 từ cuối với nhau bằng dấu "..."
                    const result = firstFiveWords + " ..." + lastFourWords;
                    // Trả về mảng các đoạn văn bản với đoạn cuối đã được thêm dấu "..."
                    formattedText.push(result);
                } else {
                    formattedText.push(paragraphs[index])
                }
            }
            return formattedText;
        },

        /**
         *  Click xem trước
         */
        previewExam() {
            this.isShowConfigureExam = !this.isShowConfigureExam;
            this.loadCriteriaByExamId();
        },

        /**
         * Click nút xóa tiêu chí
         * @param {C} data
         */
        deleteRowSelect(data) {
            this.deletedItem = data;
            this.isPopupDelete = !this.isPopupDelete;
        },

        /**
         * Chấp nhận xóa tiêu chí
         */
        handleDeleteCriteria() {
            this.popupLoading = true;
            deleteCriteria(this.deletedItem).then(res => {
                this.isLoading = true;
                this.showToast('Xóa tiêu chí thành công');
                this.listCriteria.splice(this.listCriteria.findIndex(record => record.CriteriaId === this.deletedItem.CriteriaId), 1);
                console.log(res);
            }).catch(error => {
                console.log(error);
            }).finally(() => {
                setTimeout(() => {
                    this.popupLoading = false;
                    this.isPopupDelete = false;
                    this.isLoading = false;
                }, 750);
            });
        },

        onRowSelect(data) {
            this.isShowConfigureExam = false;
            const el = document.getElementById('scrollToFormatSheet');

            el.scrollIntoView({behavior: 'smooth'});
        },

        /**
         * Scroll tới vị trí id
         * @param {*} id
         */
        scrollViewToId(id) {
            const el = document.getElementById(id);
            el.scrollIntoView({behavior: 'smooth'});
        },

        /**
         * Xoá các value của apply style
         */
        changeApplyStyle() {
            this.formats.properties.APPLY_STYLE.property.key = this.formats.properties.APPLY_STYLE.property.content = this.formats.properties.APPLY_STYLE.property.value = null;
        },

        /**
         * Lưu tiêu chí
         */
        saveCriteriaSettings() {
            this.invalidData = [];
            this.listCriteria = [];
            let validData = true;
            let data = [];
            //đang ở tab format
            if (this.tabViewIndex === 0) {
                for (let property in this.formats.properties) {
                    let isHasChilds = false; // có nhiều thuộc tính con
                    let isHasChild = false; // có 1 thuộc tính con
                    let dataChild = [];
                    let content = this.formats.properties[property].content;
                    let point = this.formats.properties[property].point;
                    let propertyType = this.TypeProperty[property];
                    let propertyName = this.formats.properties[property].propertyName;
                    let required = this.formats.properties[property].required;
                    for (let child in this.formats.properties[property]?.properties) {
                        let invalidProperty = true;
                        isHasChilds = true;
                        let contentChild = this.formats.properties[property].properties[child].content;
                        let pointChild = this.formats.properties[property].properties[child].point;
                        let keyChild = `${property}-${child}`;
                        if (required && content === null) {
                            continue;
                        }
                        if (contentChild != null || pointChild != null) {
                            if (contentChild == null) {
                                this.invalidData[`c-${keyChild}`] = MESSAGE.INVALID_CONTENT_SETUP;
                                invalidProperty = false;
                                validData = false;
                            }
                            if (pointChild == null) {
                                this.invalidData[`p-${keyChild}`] = MESSAGE.INVALID_POINT_SETUP;
                                invalidProperty = false;
                                validData = false;
                            }
                        }
                        if (invalidProperty && contentChild != null && pointChild != null) {
                            point += pointChild;
                            dataChild.push({
                                'key': this.TypeProperty[child],
                                'value': contentChild,
                                'point': pointChild,
                            })
                        }
                    }

                    for (let child in this.formats.properties[property]?.property) {
                        isHasChild = true;
                        let invalidProperty = true;
                        let contentChild = this.formats.properties[property].property.content ?? [];
                        let point = this.formats.properties[property].point;
                        let keyChild = `${property}-${child}`;
                        let key = null;
                        if (propertyType === this.TypeProperty['APPLY_STYLE']) {
                            key = this.formats.properties[property].property.key;
                            if (content != null || point != null || key != null) {
                                if (content == null) {
                                    this.invalidData[`c-${property}`] = MESSAGE.INVALID_CONTENT_SETUP;
                                    invalidProperty = false;
                                    validData = false;
                                }
                                if (point == null) {
                                    this.invalidData[`p-${property}`] = MESSAGE.INVALID_POINT_SETUP;
                                    invalidProperty = false;
                                    validData = false;
                                }
                                if (key == null) {
                                    this.invalidData[`k-${property}`] = MESSAGE.INVALID_CONTENT_SETUP;
                                    invalidProperty = false;
                                    validData = false;
                                }
                            }
                            switch (content) {
                                case this.configureExamData.applyStyleEnum['PARAGRAPH'].value:
                                    if (contentChild === null) {
                                        this.invalidData[`c-${keyChild}`] = MESSAGE.INVALID_CONTENT_SETUP;
                                        invalidProperty = false;
                                        validData = false;
                                    } else {
                                        let selectedValue = contentChild;
                                        contentChild = [];
                                        for(let index in selectedValue) {
                                            contentChild.push(this.configureExamData.paragraphs[index]);
                                        }
                                        contentChild = contentChild.join(this.configureExamData.separator)
                                    }
                                    break;
                                case this.configureExamData.applyStyleEnum['OTHER'].value:
                                    let valueChild = this.formats.properties[property].property.value;
                                    if (valueChild === null) {
                                        this.invalidData[`c-${keyChild}`] = MESSAGE.INVALID_CONTENT_SETUP;
                                        invalidProperty = false;
                                        validData = false;
                                    }
                                    contentChild = valueChild;
                                    break;
                                case this.configureExamData.applyStyleEnum['ALL'].value:
                                    propertyType = this.TypeProperty['APPLY_STYLE_ALL'];
                                    propertyName = 'Apply Style All';
                                    break;
                            }
                        }

                        if (invalidProperty && content != null && point != null) {
                            dataChild = {
                                'key': key,
                                'value': contentChild,
                            };
                        }

                    }
                    // có các thuộc tính con
                    if (isHasChilds) {
                        if (content != null && dataChild.length > 0) {
                            content = JSON.stringify({
                                'key': content,
                                'value': dataChild
                            })
                        } else if (content != null && dataChild.length === 0) {
                            validData = false;
                            this.invalidData[`c-${property}`] = MESSAGE.INVALID_CONTENT_CHILD_SETUP;
                        }
                    }
                    // có 1 thuộc tính con
                    else if (isHasChild) {
                        if (content != null && dataChild != null) {
                            content = dataChild;
                        }
                    }

                    // dữ liệu hợp lệ
                    if (validData && content != null && point != null) {
                        data.push({
                            exam_bank_id: this.examBankId,
                            content: content,
                            page: 0,
                            paragraph: null,
                            property_name: propertyName,
                            property_type: propertyType,
                            point: point,
                            priority: 0,
                        });
                    }
                }
            } else if (this.tabViewIndex === 1) {

            } else if (this.tabViewIndex === 2) {
                for (let property in this.generals.properties) {
                    let invalidProperty = true;
                    let content = this.generals.properties[property].content;
                    if (this.generals.properties[property].content != null || this.generals.properties[property].point != null) {
                        if ((this.generals.properties[property].content == null || (this.generals.properties[property].type === 'Text' && this.generals.properties[property].content === ''))) {
                            this.invalidData[`c-${property}`] = 'Nội dung không được để trống';
                            invalidProperty = false;
                            validData = false;
                        }
                        if (this.generals.properties[property].point == null) {
                            this.invalidData[`p-${property}`] = 'Điểm không được để trống';
                            invalidProperty = false;
                            validData = false;
                        }
                        if (this.generals.properties[property].content === this.configureExamData.infoTypeEnums['OTHER'].value && this.generals.properties[property]?.value !== undefined && this.generals.properties[property]?.value === null) {
                            this.invalidData[`v-${property}`] = 'Nội dung không được để trống';
                            invalidProperty = false;
                            validData = false;
                        }
                    }
                    if (invalidProperty && this.generals.properties[property].content != null && this.generals.properties[property].point != null) {
                        if (this.generals.properties[property]?.value !== undefined) {
                            content = JSON.stringify({
                                'key': this.generals.properties[property].content,
                                'value': this.generals.properties[property].value,
                            });
                        }
                        //add vào danh sách tiêu chí
                        data.push({
                            exam_bank_id: this.examBankId,
                            content: content,
                            page: 0,
                            paragraph: null,
                            property_name: this.generals.properties[property].propertyName,
                            property_type: this.TypeProperty[property],
                            point: this.generals.properties[property].point,
                            priority: 0,
                        });
                    }
                }
            }

            // ko có tiêu chí lỗi
            if (validData) {
                this.listCriteria = data;
                //clear giá trị
                for (let property in this.generals.properties) {
                    this.generals.properties[property].content = this.generals.properties[property].point = this.generals.properties[property].value = null;
                }
                for (let property in this.formats.properties) {
                    this.formats.properties[property].content = this.formats.properties[property].point = null
                    for (let child in this.formats.properties[property]?.properties) {
                        this.formats.properties[property].properties[child].content = this.formats.properties[property].properties[child].point = null;
                    }
                }
            } else return;
            if (this.listCriteria.length > 0) {
                this.isLoadingSaveCritera = true;
                saveCriteria([this.listCriteria, this.selectedData]).then(res => {
                    this.listCriteria = [];
                    this.$store.dispatch('handleSuccess', 'Thiết lập tiêu chí thành công');
                }).catch(error => {
                    if (error.request.status === RESPONSE_STATUS.HTTP_UNPROCESSABLE_ENTITY) {
                        this.$store.dispatch('handleServerError');
                    }
                    console.log(error);
                }).finally(() => {
                    setTimeout(() => {
                        this.isLoadingSaveCritera = false;
                    }, 300);
                })
            } else if (Object.keys(this.invalidData).length === 0) {
                this.$store.dispatch('handleError', 'Chưa thiết lập tiêu chí');
            }
        },

        /**
         * Load dữ liệu thiết lập đề: enum, sheetIndex
         */
        async loadConfigExamData() {
            this.examBankId = this.$route.params.id;
            var me = this;
            await configureExam(this.examBankId).then(res => {
                me.configureExamData = res.data;
                me.configureExamData.paragraphsEllipsis = this.textWithEllipsis(res.data.paragraphs)
                me.configureExamData.paragraphs = res.data.paragraphs
                me.totalScore = res.data.data.criterias_sum_point ?? 0;
                me.selectedData = res.data.data;
                me.TypeProperty = res.data.typeProperty;
            }).catch(error => {
                console.log(error);
            })
        },
    },

    async created() {
        await this.loadConfigExamData();
    },

    mounted() {
    },

    computed: {
        MESSAGE() {
            return MESSAGE
        }
    }
}
</script>

<style scoped>
.form-content {
    align-items: center;
    justify-content: center;
}

.form-group:not(.top) {
    margin-bottom: 16px;
}

.right-content .text-title {
    font-size: 15px;
    margin-bottom: 15px;
    color: #212121;
    position: relative;
    font-weight: 700;
}

.form-group:last-child {
    margin-bottom: 20px;
}

.form-group label.top-label {
    padding: 0;
    color: #666;
    font-size: 14px;
    font-weight: 400 !important;
    margin-bottom: 8px;
}

.right-content .list-control .col-sp {
    width: 12px;
}

/* .box.list-content {
    overflow: auto;
} */

/* .box.list-content .p-tabview.p-component {
    flex: 1;
    overflow: auto;
} */
.flex-rtl {
    display: flex;
    flex-direction: rtl;
    direction: rtl;
    justify-content: flex-end;
}

.box.list-content .p-tabview-nav-content .p-tabview-nav .totalScore {
    position: absolute;
    right: 0;
}

.totalScore b {
    color: #212121;
    font-size: 15px;
    font-weight: 700;
}

.form-list .p-button:enabled:hover {
    border-color: #e0e0e0 !important;
}

.box.list-content .p-tabview-nav-content .p-tabview-nav .totalScore.p-disabled,
.p-component:disabled {
    /* opacity: 1 !important; */
    font-size: 20px;
}
</style>
