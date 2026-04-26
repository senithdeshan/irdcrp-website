<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Vacancy extends Model
{
    protected $fillable = [
        'title',
        'description',
        'pdf_path',
        'deadline',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'date',
        ];
    }

    public function isOpenForPublic(): bool
    {
        if ($this->status !== 'open') {
            return false;
        }

        return Carbon::today()->lte($this->deadline);
    }
}
