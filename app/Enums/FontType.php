<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class FontType extends Enum
{
    const CAMBRIA = 0;
    const CALIBRI = 1;
    const ARIAL =  'Arial';
    const TIME_NEW_ROMAN = 'Times New Roman';
    const TAHOMA = 5;
}
