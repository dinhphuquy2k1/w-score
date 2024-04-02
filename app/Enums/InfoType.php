<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class InfoType extends Enum
{
    const STUDENT_NAME =   0;
    const STUDENT_CODE =   1;
    const STUDENT_CODE_NAME =   2;
    const OTHER = 3;
}
