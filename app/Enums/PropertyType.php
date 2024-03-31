<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PropertyType extends Enum
{
    const FONT =   0;
    const FONT_STYLE =   1;
    const FONT_SIZE = 2;
    const FONT_COLOR = 3;
    const SPACING_BEFORE = 4;
    const SPACING_AFTER = 5;
    const INDENTATION_LEFT = 6;
    const MODIFY_STYLE = 12;
    const STYLE  = 13;
    const STYLE_ALL = 14;
    const HEADER = 15;
    const HEADER_ALL = 16;
    const FOOTER_TYPE = 17;
    const FOOTER_TYPE_ALL = 18;
    const FOOTER = 19;
    const FOOTER_ALL = 20;
    const PAGE_SIZE = 21;
    const PAGE_SIZE_ALL = 22;

    const MERGE_LEFT_ALL = 23;
    const MERGE_RIGHT_ALL = 24;
    const MERGE_TOP_ALL = 25;
    const MERGE_BOTTOM_ALL = 26;
    const MERGE_LEFT = 27;
    const MERGE_RIGHT = 28;
    const MERGE_TOP = 29;
    const MERGE_BOTTOM = 30;

    const TITLE = 32;
    const AUTHOR = 33;
}
