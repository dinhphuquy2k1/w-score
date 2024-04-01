<template>
    <div class="main-view flex1 flex-column">
        <div class="form-list flex-column flex1">
            <div class="flex-column flex1">
                <div class="flex-row title-box">
                    <div class="list-title flex1">Thiết lập đề</div>
                    <div class="flex-row mr-12">
                        <Button class="ms-button d-flex flex-row secondary btn has-tooltip mr-10" aria-label="Youtube"
                                @click="previewExam">
                            <div class="left eye"></div>
                            <span class="pl-0 text">Xem trước</span>
                        </Button>
                        <Button class="ms-button btn primary has-tooltip" aria-label="Youtube" @click="btnComplete">
                            <span class="px-3 text">Hoàn thành</span>
                        </Button>
                    </div>
                </div>
                <div class="box list-content flex1 flex-column">
                    <TabView @tab-change="tabViewIndex = $event.index">
                        <TabPanel header="Định dạng">
                            <div class="form-content flex-row" id="scrollToFormat">
                                <div class="right-content flex1">
                                    <div class="text-title flex-row form-group">
                                        <span class="mr-10">Thông tin sheet</span>
                                    </div>
                                    <div class="list-control">
                                        <div class="flex-row">
                                            <div class="flex1">
                                                <div class="form-group slide-detail">
                                                    <label class="top-label d-flex">
                                                        Sheet
                                                        <span class="required">*</span>
                                                    </label>
                                                    <div class="flex1">
                                                        <Dropdown v-model="Format.SheetIndex" optionLabel="sheetName"
                                                                  :class="{ 'error': invalidData[`sheetIndex${tabViewIndex}`] }"
                                                                  optionValue="sheetIndex" :options="optionSheet"
                                                                  showClear
                                                                  placeholder="Select a Sheet"/>
                                                    </div>
                                                    <div class="error-text"
                                                         v-if="invalidData[`sheetIndex${this.tabViewIndex}`]">
                                                        {{ invalidData[`sheetIndex${this.tabViewIndex}`] }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sp"></div>
                                            <div class="flex1">
                                                <div class="form-group slide-detail">
                                                    <label class="top-label d-flex">
                                                        Range
                                                        <span class="required">*</span>
                                                        <div class="icon16 icon-note has-tooltip"
                                                             v-tooltip.top="{ value: `Vùng dữ liệu hợp lệ A1 hoặc A1:C3. Vùng A1:XFD1 áp dụng cho toàn bộ trang tính`, escape: true, class: 'custom-error' }">
                                                        </div>
                                                    </label>
                                                    <div class="flex1">
                                                        <InputText v-model="Format.Range" class="heigth36"
                                                                   :class="{ 'error': invalidData[`range${tabViewIndex}`] }"
                                                                   placeholder="Enter your range"
                                                                   @keypress="validateInputRangeNoRef"/>
                                                    </div>
                                                    <div class="error-text"
                                                         v-if="invalidData[`range${this.tabViewIndex}`]">
                                                        {{ invalidData[`range${this.tabViewIndex}`] }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sp"></div>
                                            <div class="flex1"></div>
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
                            <div class="form-content flex-row">
                                <div class="right-content flex1">
                                    <Panel header="Font" toggleable>
                                        <div class="list-control flex-row">
                                            <div class="panel-left flex1">
                                                <div class="flex-row">
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Font
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <Dropdown v-model="Format.Property.Font.content"
                                                                          showClear
                                                                          editable
                                                                          :class="{ 'error': invalidData[`content${TypeProperty.Font}`] }"
                                                                          :options="configureExamData.Font"
                                                                          optionLabel="description" optionValue="value"
                                                                          placeholder="Select a Font"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`content${TypeProperty.Font}`]">
                                                                {{ invalidData[`content${TypeProperty.Font}`] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Point
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber v-model="Format.Property.Font.point"
                                                                             :class="{ 'error': invalidData[`point${TypeProperty.Font}`] }"
                                                                             :maxFractionDigits="5"
                                                                             placeholder="Enter your point"
                                                                             class="ms-point"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`point${TypeProperty.Font}`]">
                                                                {{ invalidData[`point${TypeProperty.Font}`] }}
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
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <Dropdown v-model="Format.Property.FontStyle.content"
                                                                          :options="configureExamData.FontStyle"
                                                                          :class="{ 'error': invalidData[`content${TypeProperty.FontStyle}`] }"
                                                                          optionLabel="description" optionValue="value"
                                                                          editable
                                                                          placeholder="Select a Font Style"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`content${TypeProperty.FontStyle}`]">
                                                                {{ invalidData[`content${TypeProperty.FontStyle}`] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Point
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber v-model="Format.Property.FontStyle.point"
                                                                             :class="{ 'error': invalidData[`point${TypeProperty.FontStyle}`] }"
                                                                             :maxFractionDigits="5"
                                                                             placeholder="Enter your point"
                                                                             class="ms-point"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`point${TypeProperty.FontStyle}`]">
                                                                {{ invalidData[`point${TypeProperty.FontStyle}`] }}
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
                                                                Font Color
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <Dropdown v-model="Format.Property.FontColor.content"
                                                                          :options="configureExamData.FontColor"
                                                                          :class="{ 'error': invalidData[`content${TypeProperty.FontColor}`] }"
                                                                          optionLabel="description"
                                                                          optionValue="description"
                                                                          editable placeholder="Select a Font Color"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`content${TypeProperty.FontColor}`]">
                                                                {{ invalidData[`content${TypeProperty.FontColor}`] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Point
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber v-model="Format.Property.FontColor.point"
                                                                             :class="{ 'error': invalidData[`point${TypeProperty.FontColor}`] }"
                                                                             :maxFractionDigits="5"
                                                                             placeholder="Enter your point"
                                                                             class="ms-point"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`point${TypeProperty.FontColor}`]">
                                                                {{ invalidData[`point${TypeProperty.FontColor}`] }}
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
                                                                Font size
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <Dropdown v-model="Format.Property.FontSize.content"
                                                                          :class="{ 'error': invalidData[`content${TypeProperty.FontSize}`] }"
                                                                          property-name="Font Size" class="ms-format"
                                                                          :options="Array(50).fill().map((_, index) => index + 1)"
                                                                          editable placeholder="Select a Font Size"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`content${TypeProperty.FontSize}`]">
                                                                {{ invalidData[`content${TypeProperty.FontSize}`] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Point
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber v-model="Format.Property.FontSize.point"
                                                                             :class="{ 'error': invalidData[`point${TypeProperty.FontSize}`] }"
                                                                             :maxFractionDigits="5"
                                                                             placeholder="Enter your point"
                                                                             class="ms-point"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`point${TypeProperty.FontSize}`]">
                                                                {{ invalidData[`point${TypeProperty.FontSize}`] }}
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
                                                                Font Underline
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <Dropdown :type-property="TypeProperty.FontUnderline"
                                                                          property-name="Font Underline"
                                                                          class="ms-format"
                                                                          :options="configureExamData.FontUnderline"
                                                                          optionLabel="description" optionValue="value"
                                                                          editable
                                                                          placeholder="Select a Font Underline"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`point${TypeProperty.FontUnderline}`]">
                                                                {{ invalidData[`point${TypeProperty.FontUnderline}`] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Point
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber placeholder="Enter your point"
                                                                             class="ms-point"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`point${TypeProperty.FontUnderline}`]">
                                                                {{ invalidData[`point${TypeProperty.FontUnderline}`] }}
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
                                                                Font Effect
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <Dropdown :type-property="TypeProperty.FontEffect"
                                                                          property-name="Font Effect" class="ms-format"
                                                                          :options="configureExamData.FontEffect"
                                                                          optionLabel="description" optionValue="value"
                                                                          editable
                                                                          placeholder="Select a Font Effect"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`point${TypeProperty.FontEffect}`]">
                                                                {{ invalidData[`point${TypeProperty.FontEffect}`] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Point
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber placeholder="Enter your point"
                                                                             class="ms-point"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`point${TypeProperty.FontEffect}`]">
                                                                {{ invalidData[`point${TypeProperty.FontEffect}`] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1"></div>
                                                </div>
                                            </div>

                                        </div>
                                    </Panel>
                                    <Panel header="Alignment" toggleable class="mt-10">
                                        <div class="list-control flex-row">
                                            <div class="panel-left flex1">
                                                <div class="flex-row">
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Horizontal
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <Dropdown v-model="Format.Property.Horizontal.content"
                                                                          property-name="Text Horizontal"
                                                                          class="ms-format"
                                                                          :options="configureExamData.Horizontal"
                                                                          optionLabel="description" optionValue="value"
                                                                          editable
                                                                          placeholder="Select a Horizontal"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`point${TypeProperty.Horizontal}`]">
                                                                {{ invalidData[`point${TypeProperty.Horizontal}`] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Point
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber v-model="Format.Property.Horizontal.point"
                                                                             :max-fraction-digits="5" :min="0"
                                                                             :max="100"
                                                                             placeholder="Enter your point"
                                                                             class="ms-point"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`point${TypeProperty.Horizontal}`]">
                                                                {{ invalidData[`point${TypeProperty.Horizontal}`] }}
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
                                                                Vertical
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <Dropdown v-model="Format.Property.Vertical.content"
                                                                          property-name="Text Vertical"
                                                                          class="ms-format"
                                                                          :options="configureExamData.Vertical"
                                                                          optionLabel="description" optionValue="value"
                                                                          editable
                                                                          placeholder="Select a Vertical"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`point${TypeProperty.Vertical}`]">
                                                                {{ invalidData[`point${TypeProperty.Vertical}`] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Point
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber v-model="Format.Property.Vertical.point"
                                                                             :min="0" :max="100"
                                                                             :max-fraction-digits="5"
                                                                             placeholder="Enter your point"
                                                                             class="ms-point"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`point${TypeProperty.Vertical}`]">
                                                                {{ invalidData[`point${TypeProperty.Vertical}`] }}
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
                                                                Text Orientation
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <Dropdown :options="configureExamData.TextOrientation"
                                                                          optionLabel="description" optionValue="value"
                                                                          editable
                                                                          placeholder="Select a Text Orientation"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`point${TypeProperty.TextOrientation}`]">
                                                                {{
                                                                    invalidData[`point${TypeProperty.TextOrientation}`]
                                                                }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Point
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber placeholder="Enter your point"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`point${TypeProperty.TextOrientation}`]">
                                                                {{
                                                                    invalidData[`point${TypeProperty.TextOrientation}`]
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
                                                                Text Control
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <Dropdown v-model="Format.Property.TextControl.content"
                                                                          :type-property="TypeProperty.TextControl"
                                                                          property-name="Text Control" class="ms-format"
                                                                          :options="configureExamData.TextControl"
                                                                          optionLabel="description" optionValue="value"
                                                                          editable
                                                                          placeholder="Select a Text Control"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`point${TypeProperty.TextControl}`]">
                                                                {{ invalidData[`point${TypeProperty.TextControl}`] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Point
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber v-model="Format.Property.TextControl.point"
                                                                             :max-fraction-digits="5" :min="0"
                                                                             :max="100"
                                                                             placeholder="Enter your point"
                                                                             class="ms-point"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`point${TypeProperty.TextControl}`]">
                                                                {{ invalidData[`point${TypeProperty.TextControl}`] }}
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
                                                                Text Direction
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <Dropdown :options="configureExamData.TextDirection"
                                                                          optionLabel="description" optionValue="value"
                                                                          editable
                                                                          placeholder="Select a Text Direction"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`point${TypeProperty.TextDirection}`]">
                                                                {{ invalidData[`point${TypeProperty.TextDirection}`] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Point
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber placeholder="Enter your point"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`point${TypeProperty.TextDirection}`]">
                                                                {{ invalidData[`point${TypeProperty.TextDirection}`] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1"></div>
                                                </div>
                                            </div>

                                        </div>
                                    </Panel>
                                    <Panel header="Number" toggleable class="mt-10">
                                        <div class="list-control">
                                            <div class="flex-row">
                                                <div class="flex1">
                                                    <div class="form-group slide-detail">
                                                        <label class="top-label d-flex">
                                                            Category
                                                            <span class="required">*</span>
                                                        </label>
                                                        <div class="flex1">
                                                            <Dropdown class="ms-format" :showClear="true"
                                                                      :class="{ 'error': invalidData[`content${TypeProperty.FormatNumber}`] }"
                                                                      v-model="Format.Property.FormatNumber.content"
                                                                      :options="configureExamData.FormatNumberLabel"
                                                                      placeholder="Select a Category"/>
                                                        </div>
                                                        <div class="error-text"
                                                             v-if="invalidData[`content${TypeProperty.FormatNumber}`]">
                                                            {{ invalidData[`content${TypeProperty.FormatNumber}`] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sp"></div>
                                                <div class="flex1">
                                                    <div class="form-group slide-detail"
                                                         v-if="Format.Property.FormatNumber.content == 'Currency' || Format.Property.FormatNumber.content == 'Accounting'">
                                                        <label class="top-label d-flex">
                                                            Symbol
                                                            <span class="required">*</span>
                                                        </label>
                                                        <div class="flex1">
                                                            <Dropdown v-model="Format.Property.FormatNumber.symbol"
                                                                      :options="[{ description: 'đ VietNamese', value: 'FORMAT_ACCOUNTING_VIETNAMESE' }]"
                                                                      :class="{ 'error': invalidData[`symbol`] }"
                                                                      optionLabel="description" optionValue="value"
                                                                      editable
                                                                      placeholder="Select a Category"/>
                                                        </div>
                                                        <div class="error-text" v-if="invalidData[`symbol`]">
                                                            {{ invalidData[`symbol`] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sp"></div>
                                                <div class="flex1">
                                                    <div class="form-group slide-detail"
                                                         v-if="Format.Property.FormatNumber.content == 'Currency' || Format.Property.FormatNumber.content == 'Accounting'">
                                                        <label class="top-label d-flex">
                                                            Decimal
                                                            <span class="required">*</span>
                                                        </label>
                                                        <div class="flex1">
                                                            <InputNumber v-model="Format.Property.FormatNumber.decimal"
                                                                         :class="{ 'error': invalidData['decimal'] }"
                                                                         :maxFractionDigits="5"
                                                                         placeholder="Enter your Deciaml"/>
                                                        </div>
                                                        <div class="error-text" v-if="invalidData['decimal']">
                                                            {{ invalidData['decimal'] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sp"></div>
                                                <div class="flex1">
                                                    <div class="form-group slide-detail"
                                                         v-if="Format.Property.FormatNumber.content">
                                                        <label class="top-label d-flex">
                                                            Point
                                                            <span class="required">*</span>
                                                        </label>
                                                        <div class="flex1">
                                                            <InputNumber v-model="Format.Property.FormatNumber.point"
                                                                         :class="{ 'error': invalidData[`point${TypeProperty.FormatNumber}`] }"
                                                                         :maxFractionDigits="5"
                                                                         placeholder="Enter your point"/>
                                                        </div>
                                                        <div class="error-text"
                                                             v-if="invalidData[`point${TypeProperty.FormatNumber}`]">
                                                            {{ invalidData[`point${TypeProperty.FormatNumber}`] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sp"></div>
                                                <div class="flex1"></div>
                                                <div class="col-sp"></div>
                                                <div class="flex1"></div>
                                            </div>
                                        </div>
                                    </Panel>
                                    <Panel header="Cell Size" toggleable class="mt-10">
                                        <div class="list-control flex-row">
                                            <div class="panel-left flex1">
                                                <div class="flex-row">
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Column Width
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber
                                                                    v-model="Format.Property.ColumnWidth.content"
                                                                    :max="100" :min="0" :max-fraction-digits="5"
                                                                    :class="{ 'error': invalidData[`content${TypeProperty.ColumnWidth}`] }"
                                                                    property-name="Column Width" class="ms-format"
                                                                    placeholder="Enter your Column Width"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`content${TypeProperty.ColumnWidth}`]">
                                                                {{ invalidData[`content${TypeProperty.ColumnWidth}`] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Point
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber v-model="Format.Property.ColumnWidth.point"
                                                                             :class="{ 'error': invalidData[`point${TypeProperty.ColumnWidth}`] }"
                                                                             :max="100" :min="0"
                                                                             :max-fraction-digits="5"
                                                                             placeholder="Enter your point"
                                                                             class="ms-point"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`point${TypeProperty.ColumnWidth}`]">
                                                                {{ invalidData[`point${TypeProperty.ColumnWidth}`] }}
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
                                                                Row Height
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber v-model="Format.Property.RowHeight.content"
                                                                             :class="{ 'error': invalidData[`content${TypeProperty.RowHeight}`] }"
                                                                             placeholder="Enter your Row Height"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`content${TypeProperty.RowHeight}`]">
                                                                {{ invalidData[`content${TypeProperty.RowHeight}`] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Point
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber v-model="Format.Property.RowHeight.point"
                                                                             :class="{ 'error': invalidData[`point${TypeProperty.RowHeight}`] }"
                                                                             :max="100" :min="0"
                                                                             :max-fraction-digits="5"
                                                                             placeholder="Enter your point"
                                                                             class="ms-point"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`point${TypeProperty.RowHeight}`]">
                                                                {{ invalidData[`point${TypeProperty.RowHeight}`] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1"></div>
                                                </div>
                                            </div>

                                        </div>
                                    </Panel>
                                    <Panel header="Table" toggleable class="mt-10">
                                        <div class="list-control flex-row">
                                            <div class="panel-left flex1">
                                                <div class="flex-row">
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Format as Table
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <Dropdown
                                                                    v-model="Format.Property.FormatAsTable.content"
                                                                    showClear
                                                                    :class="{ 'error': invalidData[`content${TypeProperty.FormatAsTable}`] }"
                                                                    :options="['Format as Table']"
                                                                    placeholder="Select a option"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`content${TypeProperty.FormatAsTable}`]">
                                                                {{
                                                                    invalidData[`content${TypeProperty.FormatAsTable}`]
                                                                }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Point
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber
                                                                    v-model="Format.Property.FormatAsTable.point"
                                                                    :max-fraction-digits="5" :min="0" :max="100"
                                                                    :class="{ 'error': invalidData[`point${TypeProperty.FormatAsTable}`] }"
                                                                    placeholder="Enter your point" class="ms-point"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`point${TypeProperty.FormatAsTable}`]">
                                                                {{ invalidData[`point${TypeProperty.FormatAsTable}`] }}
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
                                                                Table Name
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <InputText v-model="Format.Property.TableName.content"
                                                                           :class="{ 'error': invalidData[`content${TypeProperty.TableName}`] }"
                                                                           placeholder="Enter your Table Name"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`content${TypeProperty.TableName}`]">
                                                                {{ invalidData[`content${TypeProperty.TableName}`] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Point
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber v-model="Format.Property.TableName.point"
                                                                             :min="0" :max="100"
                                                                             :class="{ 'error': invalidData[`point${TypeProperty.TableName}`] }"
                                                                             placeholder="Enter your point"
                                                                             :maxFractionDigits="5"
                                                                             class="ms-point"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`point${TypeProperty.TableName}`]">
                                                                {{ invalidData[`point${TypeProperty.TableName}`] }}
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
                                                                Table Style
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <Dropdown v-model="Format.Property.TableStyle.content"
                                                                          :class="{ 'error': invalidData[`content${TypeProperty.TableStyle}`] }"
                                                                          :options="configureExamData.TableStyles"
                                                                          showClear
                                                                          optionLabel="description" optionValue="value"
                                                                          editable
                                                                          placeholder="Select a Background Color"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`content${TypeProperty.TableStyle}`]">
                                                                {{ invalidData[`content${TypeProperty.TableStyle}`] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Point
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber v-model="Format.Property.TableStyle.point"
                                                                             :min="0" :max="100"
                                                                             :class="{ 'error': invalidData[`point${TypeProperty.TableStyle}`] }"
                                                                             placeholder="Enter your point"
                                                                             :maxFractionDigits="5"/>
                                                            </div>
                                                            <div class="error-text"
                                                                 v-if="invalidData[`point${TypeProperty.TableStyle}`]">
                                                                {{ invalidData[`point${TypeProperty.TableStyle}`] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </Panel>
                                    <Panel header="Fill" toggleable class="mt-10">
                                        <div class="list-control flex-row">
                                            <div class="panel-left flex1">
                                                <div class="flex-row">
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Background Color
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <!--    :type-property="configureExamData.TypeProperty.FontColor.value"
                                                                    :property-name="configureExamData.TypeProperty.FontColor.description" -->
                                                                <Dropdown class="ms-format" v-model="Font"
                                                                          :options="configureExamData.Font"
                                                                          optionLabel="description" optionValue="value"
                                                                          editable
                                                                          placeholder="Select a Background Color"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Point
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber placeholder="Enter your point"
                                                                             :minFractionDigits="2"
                                                                             :maxFractionDigits="5"/>
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
                                                                Border Presets
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <!--    :type-property="configureExamData.TypeProperty.FontColor.value"
                                                                    :property-name="configureExamData.TypeProperty.FontColor.description" -->
                                                                <Dropdown class="ms-format" v-model="Font"
                                                                          :options="configureExamData.Font"
                                                                          optionLabel="description" optionValue="value"
                                                                          editable
                                                                          placeholder="Select a Background Color"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Point
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber placeholder="Enter your point"
                                                                             :minFractionDigits="2"
                                                                             :maxFractionDigits="5"/>
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
                                                                Fill Effects
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <!--   :type-property="configureExamData.TypeProperty.FontColor.value"
                                                                    :property-name="configureExamData.TypeProperty.FontColor.description" -->
                                                                <InputNumber class="ms-format"
                                                                             placeholder="Enter your Row Height"
                                                                             :minFractionDigits="2"
                                                                             :maxFractionDigits="5"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1">
                                                        <div class="form-group slide-detail">
                                                            <label class="top-label d-flex">
                                                                Point
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="flex1">
                                                                <InputNumber placeholder="Enter your point"
                                                                             :minFractionDigits="2"
                                                                             :maxFractionDigits="5"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sp"></div>
                                                    <div class="flex1"></div>
                                                </div>
                                            </div>

                                        </div>
                                    </Panel>
                                </div>
                            </div>
                        </TabPanel>
                        <TabPanel header="Chèn nội dung">
                            <div class="form-content flex-row">
                                <div class="right-content flex1">
                                    <Panel header="Sheet" toggleable class="mt-10">
                                        <div class="list-control">
                                            <div class="flex-row">
                                                <div class="flex1">
                                                    <div class="form-group slide-detail">
                                                        <label class="top-label d-flex">
                                                            Create a Sheet
                                                            <span class="required">*</span>
                                                        </label>
                                                        <div class="flex1">
                                                            <Dropdown v-model="InsertSheet.Content"
                                                                      :class="{ 'error': invalidData[`content${TypeProperty.InsertSheet}`] }"
                                                                      :options="[{ label: 'Choose a Option', value: 1 }, { label: 'Create a Sheet', value: 2 }]"
                                                                      optionLabel="label" optionValue="value" editable
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
                                                            Point
                                                            <span class="required">*</span>
                                                        </label>
                                                        <div class="flex1">
                                                            <InputText v-model="InsertSheet.Point"
                                                                       :class="{ 'error': invalidData[`point${TypeProperty.InsertSheet}`] }"
                                                                       class="heigth36" placeholder="Enter your Point"/>
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
                                    <Panel header="Text" toggleable class="mt-10">
                                        <div class="list-control">
                                            <div class="flex-row">
                                                <div class="flex1">
                                                    <div class="form-group slide-detail">
                                                        <label class="top-label d-flex">
                                                            Sheet
                                                            <span class="required">*</span>
                                                        </label>
                                                        <div class="flex1">
                                                            <Dropdown v-model="Text.SheetIndex" optionLabel="sheetName"
                                                                      :class="{ 'error': invalidData[`sheetIndex${TypeProperty.Text}`] }"
                                                                      :type-property="TypeProperty.Text"
                                                                      optionValue="sheetIndex"
                                                                      :options="optionSheet" editable
                                                                      placeholder="Select a Sheet"/>
                                                        </div>
                                                        <div class="error-text"
                                                             v-if="invalidData[`sheetIndex${TypeProperty.Text}`]">
                                                            {{ invalidData[`sheetIndex${TypeProperty.Text}`] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sp"></div>
                                                <div class="flex1">
                                                    <div class="form-group slide-detail">
                                                        <label class="top-label d-flex">
                                                            Range
                                                            <span class="required">*</span>
                                                        </label>
                                                        <div class="flex1">
                                                            <InputText v-model="Text.Range"
                                                                       :class="{ 'error': invalidData[`range${TypeProperty.Text}`] }"
                                                                       placeholder="Enter your Range"/>
                                                        </div>
                                                        <div class="error-text"
                                                             v-if="invalidData[`range${TypeProperty.Text}`]">
                                                            {{ invalidData[`range${TypeProperty.Text}`] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sp"></div>
                                                <div class="flex1">
                                                    <div class="form-group slide-detail">
                                                        <label class="top-label d-flex">
                                                            Content
                                                            <span class="required">*</span>
                                                        </label>
                                                        <div class="flex1">
                                                            <InputText v-model="Text.Content"
                                                                       :class="{ 'error': invalidData[`content${TypeProperty.Text}`] }"
                                                                       placeholder="Enter your Content"/>
                                                        </div>
                                                        <div class="error-text"
                                                             v-if="invalidData[`content${TypeProperty.Text}`]">
                                                            {{ invalidData[`content${TypeProperty.Text}`] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sp"></div>
                                                <div class="flex1">
                                                    <div class="form-group slide-detail">
                                                        <label class="top-label d-flex">
                                                            Point
                                                            <span class="required">*</span>
                                                        </label>
                                                        <div class="flex1">
                                                            <InputNumber v-model="Text.Point"
                                                                         :class="{ 'error': invalidData[`point${this.TypeProperty.Text}`] }"
                                                                         :maxFractionDigits="5" :min="0" :max="100"
                                                                         placeholder="Enter your point"/>
                                                        </div>
                                                        <div class="error-text"
                                                             v-if="invalidData[`point${this.TypeProperty.Text}`]">
                                                            {{ invalidData[`point${this.TypeProperty.Text}`] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sp"></div>
                                                <div class="flex1"></div>
                                            </div>
                                        </div>
                                    </Panel>
                                    <Panel header="Advanced Filter" toggleable class="mt-10">
                                        <div class="form-content flex-row">
                                            <div class="right-content flex1">
                                                <div class="text-title flex-row form-group">
                                                    <span class="mr-10">Thông tin sheet</span>
                                                </div>
                                                <div class="list-control">
                                                    <div class="flex-row">
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Sheet
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <Dropdown v-model="AdvancedFilter.SheetIndex"
                                                                              optionLabel="sheetName"
                                                                              optionValue="sheetIndex"
                                                                              :class="{ 'error': invalidData['SheetIndexAdvancedFilter'] }"
                                                                              :options="optionSheet" editable
                                                                              placeholder="Select a Sheet"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData['SheetIndexAdvancedFilter']">
                                                                    {{ invalidData['SheetIndexAdvancedFilter'] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Range
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputText v-model="AdvancedFilter.Range"
                                                                               :class="{ 'error': invalidData['RangeAdvancedFilter'] }"
                                                                               class="heigth36"
                                                                               placeholder="Enter your range"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData['RangeAdvancedFilter']">
                                                                    {{ invalidData['RangeAdvancedFilter'] }}
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
                                            </div>
                                        </div>
                                        <div class="form-content flex-row">
                                            <div class="right-content flex1">
                                                <div class="text-title flex-row form-group">
                                                    <span class="mr-10">Vùng dữ liệu</span>
                                                </div>
                                                <div class="list-control">
                                                    <div class="flex-row">
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Sheet
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <Dropdown v-model="AdvancedFilter.DataSheetIndex"
                                                                              :class="{ 'error': invalidData['DataSheetIndexAdvancedFilter'] }"
                                                                              optionLabel="sheetName"
                                                                              optionValue="sheetIndex"
                                                                              :options="optionSheet" editable
                                                                              placeholder="Select a Sheet"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData['DataSheetIndexAdvancedFilter']">
                                                                    {{ invalidData['DataSheetIndexAdvancedFilter'] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Range
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputText v-model="AdvancedFilter.DataRange"
                                                                               :class="{ 'error': invalidData['DataRangeAdvancedFilter'] }"
                                                                               @keypress="validateInputRangeNoRef"
                                                                               class="heigth36"
                                                                               placeholder="Enter your range"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData['DataRangeAdvancedFilter']">
                                                                    {{ invalidData['DataRangeAdvancedFilter'] }}
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
                                            </div>
                                        </div>
                                        <div class="form-content flex-row">
                                            <div class="right-content flex1">
                                                <div class="text-title flex-row form-group">
                                                    <span class="mr-10">Vùng điều kiện</span>
                                                </div>
                                                <div class="list-control" v-for="index in AdvancedFilter.countCriteria">
                                                    <div class="flex-row">
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Sheet
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <Dropdown
                                                                        v-model="AdvancedFilter.SheetIndexCriteria[index]"
                                                                        optionLabel="sheetName" optionValue="sheetIndex"
                                                                        :class="{ 'error': invalidData[`SheetIndexCriteria${index}`] }"
                                                                        :options="optionSheet" editable
                                                                        placeholder="Select a Sheet"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData[`SheetIndexCriteria${index}`]">
                                                                    {{ invalidData[`SheetIndexCriteria${index}`] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Title Range
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputText
                                                                        v-model="AdvancedFilter.TitleRange[index]"
                                                                        @keypress="validateInputRangeNoRef"
                                                                        :class="{ 'error': invalidData[`TitleRange${index}`] }"
                                                                        class="heigth36"
                                                                        placeholder="Enter your range"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData[`TitleRange${index}`]">
                                                                    {{ invalidData[`TitleRange${index}`] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Title Content
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputText
                                                                        v-model="AdvancedFilter.TitleContent[index]"
                                                                        :class="{ 'error': invalidData[`TitleContent${index}`] }"
                                                                        class="heigth36"
                                                                        placeholder="Enter your range"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData[`TitleContent${index}`]">
                                                                    {{ invalidData[`TitleContent${index}`] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Criteria Range
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputText
                                                                        v-model="AdvancedFilter.CriteriaRange[index]"
                                                                        :class="{ 'error': invalidData[`CriteriaRange${index}`] }"
                                                                        @keypress="validateInputRangeNoRef"
                                                                        class="heigth36"
                                                                        placeholder="Enter your range"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData[`CriteriaRange${index}`]">
                                                                    {{ invalidData[`CriteriaRange${index}`] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Criteria Content
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputText
                                                                        v-model="AdvancedFilter.CriteriaContent[index]"
                                                                        :class="{ 'error': invalidData[`CriteriaContent${index}`] }"
                                                                        class="heigth36"
                                                                        placeholder="Enter your range"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData[`CriteriaContent${index}`]">
                                                                    {{ invalidData[`CriteriaContent${index}`] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="list-control">
                                            <div class="flex-row">
                                                <div class="flex1">
                                                    <div class="form-group slide-detail">
                                                        <label class="top-label d-flex">
                                                            Point
                                                            <span class="required">*</span>
                                                        </label>
                                                        <div class="flex1">
                                                            <InputNumber v-model="AdvancedFilter.Point" :min="0"
                                                                         :max="100"
                                                                         :max-fraction-digits="5"
                                                                         :class="{ 'error': invalidData['PointAdvancedFilter'] }"
                                                                         placeholder="Enter your Content"/>
                                                        </div>
                                                        <div class="error-text"
                                                             v-if="invalidData['PointAdvancedFilter']">
                                                            {{ invalidData['PointAdvancedFilter'] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sp"></div>
                                                <div class="col-sp"></div>
                                                <div class="flex1"></div>
                                                <div class="col-sp"></div>
                                                <div class="flex1"></div>
                                                <div class="col-sp"></div>
                                                <div class="flex1"></div>
                                                <div class="col-sp"></div>
                                                <div class="flex1"></div>
                                            </div>
                                        </div>
                                    </Panel>
                                    <Panel header="Formula" toggleable class="mt-10">
                                        <div class="list-control" ref="scrollToFormula">
                                            <div class="flex-row">
                                                <div class="flex1">
                                                    <div class="form-group slide-detail">
                                                        <label class="top-label d-flex">
                                                            Sheet
                                                            <span class="required">*</span>
                                                        </label>
                                                        <div class="flex1">
                                                            <Dropdown v-model="Formula.SheetIndex"
                                                                      optionLabel="sheetName"
                                                                      showClear
                                                                      :class="{ 'error': invalidData['FormulaSheetIndex'] }"
                                                                      optionValue="sheetIndex" :options="optionSheet"
                                                                      placeholder="Select a Sheet"/>
                                                        </div>
                                                        <div class="error-text" v-if="invalidData['FormulaSheetIndex']">
                                                            {{ invalidData['FormulaSheetIndex'] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sp"></div>
                                                <div class="flex1">
                                                    <div class="form-group slide-detail">
                                                        <label class="top-label d-flex">
                                                            Range
                                                            <span class="required">*</span>
                                                        </label>
                                                        <div class="flex1">
                                                            <InputText v-model="Formula.Range"
                                                                       :class="{ 'error': invalidData['FormulaRange'] }"
                                                                       @change="validateInputRangeNoRef"
                                                                       placeholder="Enter your Range"/>
                                                        </div>
                                                        <div class="error-text" v-if="invalidData['FormulaRange']">
                                                            {{ invalidData['FormulaRange'] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sp"></div>
                                                <div class="flex1">
                                                    <div class="form-group slide-detail">
                                                        <label class="top-label d-flex">
                                                            Formula Type
                                                            <span class="required">*</span>
                                                        </label>
                                                        <div class="flex1">
                                                            <Dropdown v-model="Formula.FormulaType"
                                                                      :class="{ 'error': invalidData['FormulaType'] }"
                                                                      :options="configureExamData.FormulaType" showClear
                                                                      optionLabel="description" optionValue="value"
                                                                      placeholder="Choose a Option"/>
                                                        </div>
                                                        <div class="error-text" v-if="invalidData['FormulaType']">
                                                            {{ invalidData['FormulaType'] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sp"></div>
                                                <div class="flex1">
                                                    <div class="form-group slide-detail">
                                                        <label class="top-label d-flex">
                                                            Content
                                                            <span class="required">*</span>
                                                        </label>
                                                        <div class="flex1">
                                                            <InputText v-model="Formula.Content"
                                                                       :class="{ 'error': invalidData['FormulaContent'] }"
                                                                       placeholder="Enter your Content"/>
                                                        </div>
                                                        <div class="error-text" v-if="invalidData['FormulaContent']">
                                                            {{ invalidData['FormulaContent'] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sp"></div>
                                                <div class="flex1">
                                                    <div class="form-group slide-detail">
                                                        <label class="top-label d-flex">
                                                            Point
                                                            <span class="required">*</span>
                                                        </label>
                                                        <div class="flex1">
                                                            <InputNumber v-model="Formula.Point" :min="0" :max="100"
                                                                         :max-fraction-digits="5"
                                                                         :class="{ 'error': invalidData['FormulaPoint'] }"
                                                                         placeholder="Enter your Content"/>
                                                        </div>
                                                        <div class="error-text" v-if="invalidData['FormulaPoint']">
                                                            {{ invalidData['FormulaPoint'] }}
                                                        </div>
                                                    </div>
                                                </div>
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
                                            <div class="right-content flex1">
                                                <div class="text-title flex-row form-group">
                                                    <span class="mr-10">Thông tin sheet</span>
                                                </div>
                                                <div class="list-control">
                                                    <div class="flex-row">
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Sheet
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <Dropdown v-model="General.SheetIndex"
                                                                              :class="{ 'error': invalidData['sheetIndexGeneral'] }"
                                                                              optionLabel="sheetName"
                                                                              optionValue="sheetIndex"
                                                                              :options="optionSheet" editable
                                                                              placeholder="Select a Sheet"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData['sheetIndexGeneral']">
                                                                    {{ invalidData['sheetIndexGeneral'] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1"></div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1"></div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1"></div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1"></div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="list-control flex-row">
                                                <div class="panel-left flex1">
                                                    <div class="flex-row">
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Page Orientation
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <Dropdown
                                                                        v-model="General.Property.PageOrientation.Content"
                                                                        :options="configureExamData.PageOrientation"
                                                                        optionLabel="description" optionValue="value"
                                                                        :class="{ 'error': invalidData['contentPageOrientation'] }"
                                                                        editable
                                                                        placeholder="Select a Page Orientation"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData['contentPageOrientation']">
                                                                    {{ invalidData['contentPageOrientation'] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Point
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber :max-fraction-digits="5"
                                                                                 v-model="General.Property.PageOrientation.Point"
                                                                                 :class="{ 'error': invalidData['pointPageOrientation'] }"
                                                                                 placeholder="Enter your point"
                                                                                 class="ms-point"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData['pointPageOrientation']">
                                                                    {{ invalidData['pointPageOrientation'] }}
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
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <Dropdown
                                                                        v-model="General.Property.PageSize.Content"
                                                                        :options="configureExamData.PageSize"
                                                                        :class="{ 'error': invalidData['contentPageSize'] }"
                                                                        optionLabel="description" optionValue="value"
                                                                        editable placeholder="Select a Font Underline"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData['contentPageSize']">
                                                                    {{ invalidData['contentPageSize'] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Point
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber
                                                                        v-model="General.Property.PageSize.Point"
                                                                        :max-fraction-digits="5"
                                                                        :class="{ 'error': invalidData['pointPageSize'] }"
                                                                        placeholder="Enter your point"
                                                                        class="ms-point"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData['pointPageSize']">
                                                                    {{ invalidData['pointPageSize'] }}
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
                                                                    <span class="required">*</span>
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
                                                                    Point
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber placeholder="Enter your point"/>
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
                                                                    <span class="required">*</span>
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
                                                                    Point
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber placeholder="Enter your point"/>
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
                                                                    Margin
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <Dropdown class="ms-format"
                                                                              :options="configureExamData.PageOrientation"
                                                                              optionLabel="description"
                                                                              optionValue="value"
                                                                              editable placeholder="Select a Margin"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Point
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber placeholder="Enter your point"/>
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
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputText class="ms-format" type="text"
                                                                               placeholder="Enter your Margin Top"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Point
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber placeholder="Enter your point"/>
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
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputText class="ms-format" type="text"
                                                                               placeholder="Enter your Margin Left"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Point
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber placeholder="Enter your point"/>
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
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <!-- :type-property="configureExamData.TypeProperty.FontColor.value"
                                                                    :property-name="configureExamData.TypeProperty.FontColor.description" -->
                                                                    <InputText class="ms-format" type="text"
                                                                               placeholder="Enter your Margin Right"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Point
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber placeholder="Enter your point"/>
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
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <!--  :type-property="configureExamData.TypeProperty.FontColor.value"
                                                                    :property-name="configureExamData.TypeProperty.FontColor.description" -->
                                                                    <InputText class="ms-format" type="text"
                                                                               placeholder="Enter your Margin Bottom"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Point
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber placeholder="Enter your point"/>
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
                                                                    Margin Header
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <!-- :type-property="configureExamData.TypeProperty.FontColor.value"
                                                                    :property-name="configureExamData.TypeProperty.FontColor.description" -->
                                                                    <InputText class="ms-format" type="text"
                                                                               placeholder="Enter your Margin Header"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Point
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber placeholder="Enter your point"/>
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
                                                                    Margin Footer
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <!--  :type-property="configureExamData.TypeProperty.FontColor.value"
                                                                    :property-name="configureExamData.TypeProperty.FontColor.description" -->
                                                                    <InputText class="ms-format" type="text"
                                                                               placeholder="Enter your Margin Footer"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Point
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber placeholder="Enter your point"
                                                                                 :minFractionDigits="2"
                                                                                 :maxFractionDigits="5"/>
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
                                    <Panel header="Sheet" toggleable class="mt-10" id="scrollToFormatSheet">
                                        <div class="list-control">
                                            <div class="flex-row" v-for="item, index in optionSheet">
                                                <div class="flex1">
                                                    <div class="form-group slide-detail">
                                                        <label class="top-label d-flex">
                                                            Sheet
                                                            <span class="required">*</span>
                                                        </label>
                                                        <div class="flex1">
                                                            <Dropdown v-model="item.sheetIndex" optionLabel="sheetName"
                                                                      optionValue="sheetIndex" :options="[item]"
                                                                      placeholder="Select a Sheet"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sp"></div>
                                                <div class="flex1">
                                                    <div class="form-group slide-detail">
                                                        <label class="top-label d-flex">
                                                            Sheet Name
                                                            <span class="required">*</span>
                                                        </label>
                                                        <div class="flex1">
                                                            <Dropdown v-model="General.SheetName.Type[index]"
                                                                      :options="configureExamData.SheetName" showClear
                                                                      :class="{ 'error': invalidData[`typeSheetName${index}`] }"
                                                                      optionLabel="description" optionValue="value"
                                                                      placeholder="Select a Option Sheet Name"/>
                                                        </div>
                                                        <div class="error-text"
                                                             v-if="invalidData[`typeSheetName${index}`]">
                                                            {{ invalidData[`typeSheetName${index}`] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sp">
                                                </div>
                                                <div class="flex1"
                                                     v-if="General.SheetName.Type[index] && General.SheetName.Type[index] == 3">
                                                    <div class="form-group slide-detail">
                                                        <label class="top-label d-flex">
                                                            Content
                                                            <span class="required">*</span>
                                                        </label>
                                                        <div class="flex1">
                                                            <InputText v-model="General.SheetName.Content[index]"
                                                                       :class="{ 'error': invalidData[`contentSheetName${index}`] }"
                                                                       placeholder="Enter your Sheet Name"/>
                                                        </div>
                                                        <div class="error-text"
                                                             v-if="invalidData[`contentSheetName${index}`]">
                                                            {{ invalidData[`contentSheetName${index}`] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sp"></div>
                                                <div class="flex1">
                                                    <div class="form-group slide-detail">
                                                        <label class="top-label d-flex">
                                                            Point
                                                            <span class="required">*</span>
                                                        </label>
                                                        <div class="flex1">
                                                            <InputNumber v-model="General.SheetName.Point[index]"
                                                                         :min="0"
                                                                         :max="100" :max-fraction-digits="5"
                                                                         :class="{ 'error': invalidData[`pointSheetName${index}`] }"
                                                                         placeholder="Enter your Point"/>
                                                        </div>
                                                        <div class="error-text"
                                                             v-if="invalidData[`pointSheetName${index}`]">
                                                            {{ invalidData[`pointSheetName${index}`] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sp"
                                                     v-if="!General.SheetName.Type[index] || General.SheetName.Type[index] != 3">
                                                </div>
                                                <div class="flex1"
                                                     v-if="!General.SheetName.Type[index] || General.SheetName.Type[index] != 3">
                                                </div>
                                                <div class="col-sp"></div>
                                                <div class="flex1"></div>
                                                <div class="col-sp"></div>
                                                <div class="flex1"></div>
                                            </div>
                                        </div>
                                    </Panel>
                                    <Panel header="General" toggleable class="mt-10">
                                        <div class="flex-column">
                                            <div class="right-content flex1">
                                                <div class="list-control">
                                                    <div class="flex-row">
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    File Name
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputText
                                                                        v-model="General.Property.FileName.Content"
                                                                        :class="{ 'error': invalidData[`contentFileName`] }"
                                                                        placeholder="Enter your File Name"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData[`contentFileName`]">
                                                                    {{ invalidData[`contentFileName`] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Point
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber
                                                                        v-model="General.Property.FileName.Point"
                                                                        :class="{ 'error': invalidData[`pointFileName`] }"
                                                                        :maxFractionDigits="5" :min="0"
                                                                        placeholder="Enter your point"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData[`pointFileName`]">
                                                                    {{ invalidData[`pointFileName`] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1"></div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1"></div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1"></div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1"></div>
                                                    </div>
                                                    <div class="flex-row">
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Info
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <Dropdown v-model="General.Property.Info.Content"
                                                                              :options="configureExamData.SheetName"
                                                                              :class="{ 'error': invalidData[`contentInfo`] }"
                                                                              optionLabel="description"
                                                                              optionValue="value"
                                                                              placeholder="Select a Font Effect"/>
                                                                </div>
                                                                <div class="error-text"
                                                                     v-if="invalidData['contentInfo']">
                                                                    {{ invalidData['contentInfo'] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1">
                                                            <div class="form-group slide-detail">
                                                                <label class="top-label d-flex">
                                                                    Point
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <div class="flex1">
                                                                    <InputNumber v-model="General.Property.Info.Point"
                                                                                 :class="{ 'error': invalidData['pointInfo'] }"
                                                                                 :maxFractionDigits="5"
                                                                                 placeholder="Enter your point"/>
                                                                </div>
                                                                <div class="error-text" v-if="invalidData['pointInfo']">
                                                                    {{ invalidData['pointInfo'] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sp"></div>
                                                        <div class="flex1"></div>
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
                                <p>Tổng điểm: <b>{{ totalScore }}</b> điểm</p>
                            </template>
                        </TabPanel>
                    </TabView>
                    <div class="tab-footer">
                        <div class="flex-row">
                            <div class="flex1"></div>
                            <div class="flex-rtl">
                                <button class="ms-button btn primary has-tooltip" @click="saveCriteriaSettings">
                                    <div class="text">Thiết lập tiêu chí</div>
                                </button>
                            </div>
                        </div>
                    </div>
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
                           :value="isLoading ? Array.from({ length: 8 }, () => ({ ...{} })) : listCriteria"
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
                    <Column field="SheetId" header="Sheet">
                        <template #body="{ data, field, slotProps }">
                            <div v-if="!isLoading"> {{ data[field] }}</div>
                            <div v-else>
                                <Skeleton height="18px" class="mb-2"></Skeleton>
                            </div>
                        </template>
                    </Column>
                    <Column field="PropertyName" header="Tiêu chí">
                        <template #body="{ data, field, slotProps }">
                            <div v-if="!isLoading"> {{ data[field] }}</div>
                            <div v-else>
                                <Skeleton height="18px" class="mb-2"></Skeleton>
                            </div>
                        </template>
                    </Column>
                    <Column field="Range" dataKey="id" header="Vùng dữ liệu">
                        <template #body="{ data, field, slotProps }">
                            <div v-if="!isLoading"> {{ data[field] }}</div>
                            <div v-else>
                                <Skeleton height="18px" class="mb-2"></Skeleton>
                            </div>
                        </template>
                    </Column>
                    <Column field="Content" dataKey="id" header="Nội dung tiêu chí">
                        <template #body="{ data, field, slotProps }">
                            <div v-if="!isLoading"> {{ data[field] }}</div>
                            <div v-else>
                                <Skeleton height="18px" class="mb-2"></Skeleton>
                            </div>
                        </template>
                    </Column>
                    <Column field="Point" dataKey="id" header="Điểm">
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

export default {
    props: {
        selectedData: {
            default: null,
        }
    },
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

            Formula: {
                SheetIndex: null,
                Range: null,
                FormulaType: null,
                Content: null,
                Point: null,
                PropertyName: 'Formula',
            },

            Text: {
                SheetIndex: null,
                Range: null,
                Content: null,
                Point: null,
            },

            InsertSheet: {
                Content: null,
                Point: null,
            },

            Format: {
                SheetIndex: null,
                Range: null,
                Property: {
                    Font: {
                        content: null,
                        point: null,
                        propertyName: 'Font',
                    },

                    FontSize: {
                        content: null,
                        point: null,
                        propertyName: 'Font Size',
                    },

                    FontStyle: {
                        content: null,
                        point: null,
                        propertyName: 'Font Style',
                    },

                    FontColor: {
                        content: null,
                        point: null,
                        propertyName: 'Font Color',
                    },

                    FormatAsTable: {
                        content: null,
                        point: null,
                        propertyName: 'Format as Table',
                    },

                    TableStyle: {
                        content: null,
                        point: null,
                        propertyName: 'Table Style',
                    },

                    TableName: {
                        content: null,
                        point: null,
                        propertyName: 'Table Name',
                    },

                    ColumnWidth: {
                        content: null,
                        point: null,
                        propertyName: 'Column Width',
                    },

                    RowHeight: {
                        content: null,
                        point: null,
                        propertyName: 'Row Height',
                    },

                    FormatNumber: {
                        content: null,
                        point: null,
                        propertyName: 'Format Number',
                        decimal: 0,
                        symbol: null,
                    },

                    TextControl: {
                        content: null,
                        point: null,
                        propertyName: 'Text Control',
                    },

                    Horizontal: {
                        content: null,
                        point: null,
                        propertyName: 'Horizontal',
                    },

                    Vertical: {
                        content: null,
                        point: null,
                        propertyName: 'Vertical',
                    }
                },
                SheetName: {
                    SheetIndex: [],
                    Type: [],
                    Content: [],
                    Point: [],
                },
            },

            General: {
                SheetIndex: null,
                Property: {
                    FileName: {
                        Content: null,
                        Point: null,
                        type: 'Text',
                        propertyName: 'File Name',
                    },

                    SheetName: {
                        Content: null,
                        Point: null,
                        type: 'Text',
                        propertyName: 'File Name',
                    },

                    Info: {
                        Content: null,
                        Point: null,
                        type: 'Option',
                        propertyName: 'Info',
                    },

                    PageOrientation: {
                        Content: null,
                        Point: null,
                        type: 'Option',
                        propertyName: 'Page Orientation',
                    },

                    PageSize: {
                        Content: null,
                        Point: null,
                        type: 'Option',
                        propertyName: 'Page Size',
                    },
                },
                SheetName: {
                    SheetIndex: [],
                    Type: [],
                    Content: [],
                    Point: [],
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
                TitleContent: [],
                CriteriaRange: [],
                CriteriaContent: [],
                countCriteria: 1,
                Point: null,
            },

            //popup thông tin đã thiết lập
            isShowConfigureExam: false,
            TypeProperty: [],
            criteria: {
                SheetId: null,
                Range: null,
                ExamBankId: null,
                DataReference: null,
                Content: null,
                PropertyName: null,
                TypeProperty: null,
                Point: null
            },

            //dữ liệu thiết lập đề: enum,sheetIndex
            configureExamData: [],
            listCriteria: [],

            invalidData: [],
        }
    },

    methods: {
        ...mapActions('exambank', ['getConfigureExam']),
        /**
         * Click nút hoàn thành
         */
        btnComplete() {
            this.listCriteria = [];
            // window.localStorage.setItem("listCriteria", JSON.stringify(this.listCriteria));

            if (window.localStorage.getItem("listCriteria") != null) {
                this.listCriteria = JSON.parse(window.localStorage.getItem("listCriteria"));
            }
            saveCriteria([this.listCriteria, this.selectedData]).then(res => {
                window.localStorage.removeItem("listCriteria");
                console.log(res);
            }).catch(error => {
                console.log(error);
            });
        },

        /**
         * Lấy dữ liệu tiêu chí theo id đề thi
         */
        loadCriteriaByExamId() {
            this.isLoading = true;
            getCriteriaByExamBankId(this.selectedData).then(res => {
                this.listCriteria.unshift(...res);
            }).catch(error => {
                console.log(error);
            }).finally(() => {
                setTimeout(() => {
                    this.isLoading = false;
                }, 750);
            });
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

        rowDblClick(event) {
            console.log(event.data);
        },

        /**
         * Hiển thị toast message
         * @param {*} message
         */
        showToast(message, severity = 'success') {
            this.$toast.add({severity: severity, summary: 'Thông báo', detail: message, life: 3000});
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
         * Không cho phép nhập khoảng trắng và các kí tự
         * đặc biệt trừ kí tự '$', ':', ','
         * @param {*} event
         */
        validateInputRangeNoRef(event) {
            let pattern = /^[a-zA-Z0-9$\,\:]+$/;
            let res = event.key.match(pattern);
            if (!res) {
                event.preventDefault();
            }
        },

        /**
         * validate vùng chứa tên sheet
         * @param {*} range Vùng cần validate
         */
        validateRangeRef(range) {
            if (this.regex.REGEXP_RANGEREF.test(range)) {
                return true;
            }
            return false;
        },

        /**
         * validate chứa cell chứa tên sheet
         * @param {*} cell Cell cần validate
         */
        validateCellRef(cell) {
            if (this.regex.REGEXP_CELLREF.test(cell)) {
                return true;
            }
            return false;
        },

        /**
         * validate vùng ko chứa tên sheet
         * @param {*} range Vùng cần validate
         */
        validateRangeNoRef(range) {
            if (this.regex.REGEXP_RANGE_NO_REF.test(range)) {
                var ranges = Coordinate.splitRange(range)[0];
                let [rangeStart, rangeEnd] = ranges;
                let [startColumn, startRow] = Coordinate.coordinateFromStringT(rangeStart);
                let [endColumn, endRow] = Coordinate.coordinateFromStringT(rangeEnd);
                let startColumnIndex = Coordinate.columnIndexFromString(startColumn);
                let endColumnIndex = Coordinate.columnIndexFromString(endColumn);
                // Current data
                let currentRow = startRow;
                if (startColumnIndex > endColumnIndex || Number(currentRow) > Number(endRow)) {
                    return false;
                }
                return true;
            }
            return false;
        },

        /**
         * validate cell without a sheet reference
         * @param {*} cell Cell cần validate
         */
        validateCellNoRef(cell) {
            if (this.regex.REGEXP_CELL_NO_REF.test(cell)) {
                return true;
            }
            return false;
        },

        /**
         * kiểm tra địa chỉ có phải vùng, ko thì kiểm tra
         * có phải địa chỉ cell
         */
        validateRangeOrCell(range) {
            if (!this.validateRangeNoRef(range)) {
                if (!this.validateCellNoRef(range)) {
                    return false;
                }
            }
            return true;
        },

        validateRangeArea(range) {
            if (range != null) {
                var exploded = range.split(',');
                for (let index = 0; index < exploded.length; ++index) {
                    if (!this.validateRangeNoRef(exploded[index])) {
                        if (!this.validateCellNoRef(exploded[index])) {
                            this.invalidData[`range${this.tabViewIndex}`] = `Vùng dữ liệu chứa ${exploded[index]} không đúng định dạng`
                            return false;
                        }
                    }
                }
            } else return false;
            return true;
        },

        /**
         * Lưu xuống localStorage
         *
         */
        saveToLocalStorage() {
            var list = [...this.listCriteria];
            this.listCriteria = [];
            if (window.localStorage.getItem("listCriteria") != null) {
                this.listCriteria = JSON.parse(window.localStorage.getItem("listCriteria"));
                window.localStorage.removeItem("listCriteria");
            }
            this.listCriteria.push(...list);
            window.localStorage.setItem("listCriteria", JSON.stringify(this.listCriteria));
            this.listCriteria = [];
        },

        /**
         * Validate vùng điều kiện advanced
         */
        validateCriteriaAdvancedFilterEmpty() {
            var valid = true;
            for (let index = 1; index <= this.AdvancedFilter.countCriteria; index++) {
                if (this.AdvancedFilter.SheetIndex != null || this.AdvancedFilter.Point != null || this.AdvancedFilter.Range != null || this.AdvancedFilter.DataRange != null || this.AdvancedFilter.DataSheetIndex != null || this.AdvancedFilter.SheetIndexCriteria[index] != null || (String(this.AdvancedFilter.TitleRange[index]).trim() !== '' && this.AdvancedFilter.TitleRange[index] != null)
                    || (String(this.AdvancedFilter.TitleContent[index]).trim() != '' && this.AdvancedFilter.TitleContent[index] != null) || (String(this.AdvancedFilter.CriteriaRange[index]).trim() !== '' && this.AdvancedFilter.CriteriaRange[index] != null)
                    || (String(this.AdvancedFilter.CriteriaContent[index]).trim() != '' && this.AdvancedFilter.CriteriaContent[index] != null)) {
                    if (this.AdvancedFilter.SheetIndexCriteria[index] == null) {
                        this.invalidData[`SheetIndexCriteria${index}`] = 'Sheet không được để trống';
                        valid = false;
                    }
                    if ((String(this.AdvancedFilter.TitleRange[index]).trim() == '' || this.AdvancedFilter.TitleRange[index] == null)) {
                        this.invalidData[`TitleRange${index}`] = 'Tiêu đề không được để trống';
                        valid = false;
                    }
                    if ((String(this.AdvancedFilter.TitleContent[index]).trim() == '' || this.AdvancedFilter.TitleContent[index] == null)) {
                        this.invalidData[`TitleContent${index}`] = 'Nội dung không được để trống';
                        valid = false;
                    }
                    if ((String(this.AdvancedFilter.CriteriaRange[index]).trim() == '' || this.AdvancedFilter.CriteriaRange[index] == null)) {
                        this.invalidData[`CriteriaRange${index}`] = 'Tiêu đề không được để trống';
                        valid = false;
                    }
                    if ((String(this.AdvancedFilter.CriteriaContent[index]).trim() == '' || this.AdvancedFilter.CriteriaContent[index] == null)) {
                        this.invalidData[`CriteriaContent${index}`] = 'Nội dung không được để trống';
                        valid = false;
                    }
                    if (!this.validateCellNoRef(this.AdvancedFilter.TitleRange[index])) {
                        this.invalidData[`TitleRange${index}`] = 'Vùng không đúng định dạng';
                        valid = false;
                    }
                    if (!this.validateCellNoRef(this.AdvancedFilter.CriteriaRange[index])) {
                        this.invalidData[`CriteriaRange${index}`] = 'Vùng không đúng định dạng';
                        valid = false;
                    }
                }
            }
            return valid;
        },

        /**
         * Lưu tiêu chí
         */
        saveCriteriaSettings() {
            this.invalidData = [];
            //đang ở tab format
            if (this.tabViewIndex == 0) {
                if (this.Format.SheetIndex == null) {
                    this.invalidData[`sheetIndex${this.tabViewIndex}`] = "Sheet không được để trống";
                }

                if (this.Format.Range == null) {
                    this.invalidData[`range${this.tabViewIndex}`] = "Vùng dữ liệu không được để trống";
                }

                //validate vùng dữ liệu
                this.validateRangeArea(this.Format.Range);

                //dừng kiểm tra khi ko nhập vùng dữ liệu, sheet index
                if (Object.keys(this.invalidData).length > 0) {
                    this.scrollViewToId('scrollToFormat');
                    return;
                }

                for (var property in this.Format.Property) {
                    var invalidProperty = true;
                    var content = this.Format.Property[property].content;
                    if (this.Format.Property[property].content != null || this.Format.Property[property].point != null) {
                        if (this.Format.Property[property].content == null) {
                            this.invalidData[`content${this.TypeProperty[property]}`] = 'Nội dung không được để trống';
                            invalidProperty = false;
                        }
                        if (this.Format.Property[property].point == null) {
                            this.invalidData[`point${this.TypeProperty[property]}`] = 'Điểm tiêu chí không được để trống';
                            invalidProperty = false;
                        }

                        if (this.Format.Property[property].propertyName == 'Format Number' && this.Format.Property[property].content != null) {
                            var valueType = this.configureExamData.FormatNumberValue[this.Format.Property[property].content];
                            switch (valueType) {
                                case this.configureExamData.FormatNumberValue.Accounting:
                                case this.configureExamData.FormatNumberValue.Currency:
                                    if (this.Format.Property[property].decimal == null) {
                                        this.invalidData['decimal'] = 'Decimal không được để trống';
                                        invalidProperty = false;
                                    }
                                    if (this.Format.Property[property].symbol == null) {
                                        this.invalidData['symbol'] = 'Symbol không được để trống';
                                        invalidProperty = false;
                                    }
                                    content = JSON.stringify({
                                        type: 1,
                                        decimal: this.Format.Property.FormatNumber.decimal,
                                        symbol: this.Format.Property.FormatNumber.symbol,
                                        negativeNumbers: this.negativeNumbers,
                                    });
                                    break;
                                default:
                                    break;
                            }
                        }

                        if (!this.invalidData[`content${this.TypeProperty[property]}`] && !this.invalidData[`point${this.TypeProperty[property]}`] && invalidProperty) {
                            //add vào danh sách tiêu chí
                            this.listCriteria.push({
                                SheetId: this.Format.SheetIndex,
                                Range: this.Format.Range,
                                ExamBankId: this.selectedData.ExamBankId,
                                DataReference: null,
                                Content: content,
                                PropertyName: this.Format.Property[property].propertyName,
                                TypeProperty: this.TypeProperty[property],
                                Point: this.Format.Property[property].point
                            });
                            //clear giá trị
                            this.Format.Property[property].content = this.Format.Property[property].point = null;
                            this.showToast("Thiết lập tiêu chí thành công");
                            this.saveToLocalStorage();
                        }
                    }
                }
                console.log(this.invalidData);
            } else if (this.tabViewIndex == 1) {
                //insert text
                if (this.validateCellNoRef(this.Text.Range) && this.Text.SheetIndex != null && this.Text.Content != null && String(this.Text.Content).trim() != '' && this.Text.Point != null) {
                    //add vào danh sách tiêu chí
                    this.listCriteria.push({
                        SheetId: this.Text.SheetIndex,
                        Range: this.Text.Range,
                        ExamBankId: this.selectedData.ExamBankId,
                        DataReference: null,
                        Content: this.Text.Content,
                        PropertyName: 'Insert Text',
                        TypeProperty: this.TypeProperty['Text'],
                        Point: this.Text.Point
                    });
                    //clear giá trị
                    this.Text.Range = this.Text.SheetIndex = this.Text.Content = null;
                    this.showToast("Thiết lập tiêu chí thành công");
                    this.saveToLocalStorage();
                } else if (this.Text.Range != null || this.Text.SheetIndex != null || (this.Text.Content != null && String(this.Text.Content).trim() != '') || this.Text.Point != null) {
                    if (this.Text.SheetIndex == null) {
                        this.invalidData[`sheetIndex${this.TypeProperty.Text}`] = 'Sheet không được để trống';
                    }

                    if (this.Text.Range == null) {
                        this.invalidData[`range${this.TypeProperty.Text}`] = 'Vùng không được để trống';
                    } else if (!this.validateCellNoRef(this.Text.Range)) {
                        this.invalidData[`range${this.TypeProperty.Text}`] = 'Vùng không đúng định dạng';
                    }

                    if (this.Text.Content == null || String(this.Text.Content).trim() == '') {
                        this.invalidData[`content${this.TypeProperty.Text}`] = 'Nội dung không được để trống';
                    }

                    if (this.Text.Point == null) {
                        this.invalidData[`point${this.TypeProperty.Text}`] = 'Điểm không được để trống';
                    }

                    if (this.invalidData[`sheetIndex${this.TypeProperty.Text}`] && this.invalidData[`range${this.TypeProperty.Text}`] && this.invalidData[`content${this.TypeProperty.Text}`] && this.invalidData[`point${this.TypeProperty.Text}`]) {
                        alert(1);
                    }
                }

                //insert sheet
                if (this.InsertSheet.Content != null && this.InsertSheet.Point != null) {

                } else if (this.InsertSheet.Content != null || this.InsertSheet.Point != null) {
                    if (this.InsertSheet.Content == null) this.invalidData[`content${this.TypeProperty.InsertSheet}`] = 'Nội dung không được để trống';
                    if (this.InsertSheet.Point == null) this.invalidData[`point${this.TypeProperty.InsertSheet}`] = 'Điểm không được để trống';
                }

                //formula
                if (this.Formula.SheetIndex != null && (this.validateCellNoRef(this.Formula.Range) || this.validateRangeNoRef(this.Formula.Range)) && this.Formula.FormulaType != null && this.Formula.Content != null && this.Formula.Content != '' && this.Formula.Point) {
                    //add vào danh sách tiêu chí
                    this.listCriteria.push({
                        SheetId: this.Formula.SheetIndex,
                        Range: this.Formula.Range,
                        ExamBankId: this.selectedData.ExamBankId,
                        DataReference: null,
                        Content: JSON.stringify([
                            this.Formula.FormulaType,
                            this.Formula.Content,
                        ]),
                        PropertyName: 'Formula',
                        TypeProperty: this.TypeProperty['Formula'],
                        Point: this.Formula.Point
                    });
                    //clear giá trị
                    this.Formula.Content = this.Format.FormulaType = this.Formula.SheetIndex = null;
                    this.showToast("Thiết lập tiêu chí thành công");
                    this.saveToLocalStorage();
                } else if (this.Formula.SheetIndex != null || (this.validateCellNoRef(this.Formula.Range) || this.validateRangeNoRef(this.Formula.Range)) || this.Formula.FormulaType != null || (this.Formula.Content != null && this.Formula.Content != '') || this.Formula.Point) {
                    if (this.Formula.SheetIndex == null) {
                        this.invalidData['FormulaSheetIndex'] = 'Sheet không được để trống';
                    }

                    if (this.Formula.Range == null || String(this.Formula.Range).trim() == '') {
                        this.invalidData['FormulaRange'] = 'Vùng không được để trống';
                    } else {
                        if (!this.validateRangeNoRef(this.Formula.Range)) {
                            if (!this.validateCellNoRef(this.Formula.Range)) {
                                this.invalidData['FormulaRange'] = 'Vùng không đúng định dạng';
                            }
                        }
                    }

                    if (this.Formula.FormulaType == null) {
                        this.invalidData['FormulaType'] = 'Loại công thức không được để trống';
                    }

                    if (this.Formula.Content == null || String(this.Formula.Content).trim() == '') {
                        this.invalidData['FormulaContent'] = 'Công thức không được để trống';
                    }

                    if (this.Formula.Point == null) {
                        this.invalidData['FormulaPoint'] = 'Điểm không được để trống';
                    }

                }


                var valid = this.validateCriteriaAdvancedFilterEmpty();
                //insert advanced filter
                if (this.AdvancedFilter.SheetIndex != null && this.validateCellNoRef(this.AdvancedFilter.Range) && this.AdvancedFilter.Range != null && this.AdvancedFilter.Point != null && valid) {
                    var content = [];
                    for (let index = 1; index <= this.AdvancedFilter.countCriteria; index++) {
                        content.push(
                            {
                                SheetIndex: this.AdvancedFilter.SheetIndexCriteria[index],
                                TitleRange: this.AdvancedFilter.TitleRange[index],
                                TitleContent: this.AdvancedFilter.TitleContent[index],
                                CriteriaContent: this.AdvancedFilter.CriteriaContent[index],
                                CriteriaRange: this.AdvancedFilter.CriteriaRange[index],
                            }
                        );
                    }
                    //add vào danh sách tiêu chí
                    this.listCriteria.push({
                        SheetId: this.AdvancedFilter.SheetIndex,
                        Range: this.AdvancedFilter.Range,
                        ExamBankId: this.selectedData.ExamBankId,
                        DataReference: JSON.stringify(
                            {
                                sheetIndex: this.AdvancedFilter.DataSheetIndex,
                                range: this.AdvancedFilter.DataRange,
                            }
                        ),
                        Content: JSON.stringify(content),
                        PropertyName: 'AdvancedFilter',
                        TypeProperty: this.TypeProperty['AdvancedFilter'],
                        Point: this.AdvancedFilter.Point
                    });
                    //clear giá trị
                    this.Formula.Content = this.Format.FormulaType = this.Formula.SheetIndex = null;
                    this.showToast("Thiết lập tiêu chí thành công");
                    this.saveToLocalStorage();
                } else if (this.AdvancedFilter.SheetIndex != null || this.AdvancedFilter.Range != null || this.AdvancedFilter.Point != null || this.AdvancedFilter.DataRange != null || this.AdvancedFilter.DataSheetIndex != null) {

                    if (this.AdvancedFilter.SheetIndex == null) {
                        this.invalidData['SheetIndexAdvancedFilter'] = 'Sheet không được để trống';
                    }

                    if (this.AdvancedFilter.DataSheetIndex == null) {
                        this.invalidData['DataSheetIndexAdvancedFilter'] = 'Sheet không được để trống';
                    }

                    if (this.AdvancedFilter.DataRange == null) {
                        this.invalidData['DataRangeAdvancedFilter'] = 'Vùng không được để trống';
                    }

                    if (this.AdvancedFilter.Range == null) {
                        this.invalidData['RangeAdvancedFilter'] = 'Vùng không được để trống';
                    }
                    if (this.AdvancedFilter.Point == null) {
                        this.invalidData['PointAdvancedFilter'] = 'Điểm không được để trống';
                    }

                    if (this.AdvancedFilter.Range != null && this.validateCellNoRef(this.AdvancedFilter.Range)) {
                        this.invalidData['RangeAdvancedFilter'] = 'Vùng không đúng định dạng';
                    }

                    if (this.AdvancedFilter.DataRange != null && this.validateRangeOrCell(this.AdvancedFilter.DataRange)) {
                        this.invalidData['DataRangeAdvancedFilter'] = 'Vùng không đúng định dạng';
                    }

                }
            } else if (this.tabViewIndex == 2) {
                for (var property in this.General.Property) {
                    var validData = true;
                    if (property != 'Info' && property != 'FileName' && (this.General.Property[property].Content != null || this.General.Property[property].Point != null)) {
                        if (this.General.SheetIndex == null) {
                            this.invalidData['sheetIndexGeneral'] = 'Sheet không được để trống';
                            validData = false;
                        }
                    }
                    if (this.General.Property[property].Content != null || this.General.Property[property].Point != null) {
                        if ((this.General.Property[property].Content == null || (this.General.Property[property].type == 'Text' && this.General.Property[property].Content == ''))) {
                            this.invalidData[`content${property}`] = 'Nội dung không được để trống';
                            validData = false;
                        }
                        if (this.General.Property[property].Point == null) {
                            this.invalidData[`point${property}`] = 'Điểm không được để trống';
                            validData = false;
                        }
                    }
                    if (validData && this.General.Property[property].Content != null && this.General.Property[property].Point != null) {
                        //add vào danh sách tiêu chí
                        this.listCriteria.push({
                            SheetID: this.General.SheetIndex,
                            ExamBankId: this.selectedData.ExamBankId,
                            Content: this.General.Property[property].Content,
                            DataReference: null,
                            Range: null,
                            PropertyName: this.General.Property[property].propertyName,
                            TypeProperty: this.TypeProperty[property],
                            Point: this.General.Property[property].Point
                        });
                        //clear giá trị
                        this.General.Property[property].Content = this.General.Property[property].Point = null;
                        this.showToast("Thiết lập tiêu chí thành công");
                        this.saveToLocalStorage();
                    }
                }

                //tên sheet
                var sheetNameTypeOther = this.configureExamData['SheetName'].find(_item => _item.description == 'Other').value;
                for (var sheetIndex in this.optionSheet) {
                    validData = true;
                    if (this.General.SheetName.Type[sheetIndex] != null || this.General.SheetName.Point[sheetIndex] != null) {
                        if (this.General.SheetName.Type[sheetIndex] == null) {
                            validData = false;
                            this.invalidData[`typeSheetName${sheetIndex}`] = 'Loại Sheet Name không được để trống';
                        }

                        if (this.General.SheetName.Point[sheetIndex] == null) {
                            validData = false;
                            this.invalidData[`pointSheetName${sheetIndex}`] = 'Điểm không được để trống';
                        }
                    }
                    if (this.General.SheetName.Type[sheetIndex] != null && this.General.SheetName.Type[sheetIndex] == sheetNameTypeOther && this.General.SheetName.Content[sheetIndex] == null || String(this.General.SheetName.Content[sheetIndex]).trim() == '') {
                        this.invalidData[`contentSheetName${sheetIndex}`] = 'Tên sheet không được để trống';
                        validData = false;
                    }

                    if (this.General.SheetName.Type[sheetIndex] != null && this.General.SheetName.Point[sheetIndex] != null && validData) {
                        //add vào danh sách tiêu chí
                        this.listCriteria.push({
                            SheetID: sheetIndex,
                            ExamBankId: this.selectedData.ExamBankId,
                            Content: JSON.stringify({
                                type: this.General.SheetName.Type[sheetIndex],
                                content: this.General.SheetName.Content[sheetIndex],
                            }),
                            DataReference: null,
                            Range: null,
                            PropertyName: `Sheet Name ${sheetIndex}`,
                            TypeProperty: this.TypeProperty['SheetName'],
                            Point: this.General.SheetName.Point[sheetIndex]
                        });
                        //clear giá trị
                        this.General.SheetName.Type[sheetIndex] = this.General.SheetName.Content[sheetIndex] = this.General.SheetName.Point[sheetIndex] = null;
                        this.showToast("Thiết lập tiêu chí thành công");
                        this.saveToLocalStorage();
                    }

                    console.log(this.invalidData);
                }


            }
        },

        isFormula(formula) {
            var result = true;
            var comparisonOperators = {'>': true, '<': true, '=': true, '>=': true, '<=': true, '<>': true};
            var CALCULATION_OPERATORS = {
                '+': true, '-': true, '*': true, '/': true,
                '^': true, '&': true, '%': false, '~': false,
                '>': true, '<': true, '=': true, '>=': true,
                '<=': true, '<>': true, '∩': true, '∪': true,
                ':': true,
            };
            var operatorAssociativity = {
                '^': 0, //    Exponentiation
                '*': 0, '/': 0, //    Multiplication and Division
                '+': 0, '-': 0, //    Addition and Subtraction
                '&': 0, //    Concatenation
                '∪': 0, '∩': 0, ':': 0, //    Union, Intersect and Range
                '>': 0, '<': 0, '=': 0, '>=': 0, '<=': 0, '<>': 0, //    Comparison
            };
            var index = 0;
            var stack = [];
            var output = [];
            var expectingOperator = false; //    We use this test in syntax-checking the expression to determine when a
            //        - is a negation or + is a positive operator rather than an operation
            var expectingOperand = false; //    We use this test in syntax-checking the expression to determine whether an operand
            //        should be null in a function call

            //    The guts of the lexical parser
            //    Loop through the formula extracting each operator and operand in turn
            while (true) {
                var opCharacter = formula[index]; //    Get the first character of the value at the current index position
                // Check for two-character operators (e.g. >=, <=, <>)
                if (comparisonOperators[opCharacter] && formula.length > index && comparisonOperators[formula[index + 1]]) {
                    opCharacter += formula[++index];
                }
                var isOperandOrFunction = formula.substr(index).match(regex.regexpMatchString);
                var expectingOperatorCopy = expectingOperator;
                if (opCharacter === '-' && !expectingOperator) {                //    Is it a negation instead of a minus?
                    //    Put a negation on the stack
                    stack.push('Unary Operator', '~');
                    ++index; //        and drop the negation symbol
                } else if (opCharacter === '%' && expectingOperator) {
                    //    Put a percentage on the stack
                    stack.push('Unary Operator', '%');
                    ++index;
                } else if (opCharacter === '+' && !expectingOperator) {            //    Positive (unary plus rather than binary operator plus) can be discarded?
                    ++index; //    Drop the redundant plus symbol
                } else if (((opCharacter === '~') || (opCharacter === '∩') || (opCharacter === '∪')) && (!isOperandOrFunction)) {
                    //    We have to explicitly deny a tilde, union or intersect because they are legal
                    alert(1);
                    break;
                    // return $this -> raiseFormulaError("Formula Error: Illegal character '~'"); //        on the stack but not in the input expression
                }
                break;
            }
        },

        /**
         * Load dữ liệu thiết lập đề: enum, sheetIndex
         */
        async loadConfigExamData() {
            var me = this;
            await configureExam(this.selectedData.ExamBankId).then(res => {
                me.configureExamData = res;
                me.TypeProperty = res.TypeProperty;
            }).catch(error => {
                console.log(error);
            })
        },
    },

    async created() {
        console.log(this.selectedData.ExamBankId);
        this.optionSheet = JSON.parse(this.selectedData.SheetIndexReference)[0];
        await this.loadConfigExamData();
    },

    computed: {
        ...mapState('exambank', ['examBankData']),
        // ...mapState('exambank', ['configureExamData']),
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
