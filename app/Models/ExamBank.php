<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static insert(array $attribute)
 */
class ExamBank extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'exam_bank_name',
        'exam_bank_code',
    ];

    public function criterias()
    {
        return $this->hasMany(Criteria::class, 'exam_bank_id');
    }

}
