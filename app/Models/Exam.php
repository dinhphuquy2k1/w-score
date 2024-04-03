<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany as HasManyAlias;

/**
 * @method static insert(array $attribute)
 */
class Exam extends Model
{
    use HasFactory;

    /**
     * @return HasManyAlias
     */
    public function examShifts(): HasManyAlias
    {
        return $this->hasMany(ExamShift::class);
    }
}
