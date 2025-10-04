<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyTimeOverride extends Model
{
    protected $casts = [
    'is_no_work' => 'integer',
];

      protected $fillable = [
        'company_id',
        'date',
        'time_in_start',
        'time_in_end',
        'time_out_start',
        'time_out_end',
        'is_no_work'
    ];


        public function company()
        {
            return $this->belongsTo(Company::class);
        }

}
