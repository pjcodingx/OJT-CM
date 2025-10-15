<?php

namespace App\Models;


use App\Models\Faculty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'photo', 'address', 'location', 'faculty_id', 'working_days','default_start_date', 'username'

    ];

      public function isWorkingDay(\Carbon\Carbon $date)
        {
            $dayName = $date->format('l'); // Monday, Tuesday, etc.

            // Check if the day is overridden as no work
            $override = $this->overrides()->where('date', $date->toDateString())->first();
            if ($override && $override->is_no_work) {
                return false;
            }

            // Check default working days
            $workingDays = json_decode($this->working_days ?? '["Monday","Tuesday","Wednesday","Thursday","Friday"]');
            return in_array($dayName, $workingDays);
        }

        public function attendanceWindowForDate($date)
        {
            $override = $this->overrides()->where('date', $date)->first();

            if ($override && !$override->is_no_work) {
                return [
                    'time_in_start'  => $override->time_in_start,
                    'time_in_end'    => $override->time_in_end,
                    'time_out_start' => $override->time_out_start,
                    'time_out_end'   => $override->time_out_end,
                ];
            }

            return [
                'time_in_start'  => $this->allowed_time_in_start ?? '08:00:00',
                'time_in_end'    => $this->allowed_time_in_end ?? '12:00:00',
                'time_out_start' => $this->allowed_time_out_start ?? '13:00:00',
                'time_out_end'   => $this->allowed_time_out_end ?? '17:00:00',
            ];
        }


        public function faculty()
        {
            return $this->belongsTo(Faculty::class, 'faculty_id');
        }


        public function students(){
            return $this->hasMany(Student::class, 'company_id', 'id');
        }


        public function overrides() {
            return $this->hasMany(CompanyTimeOverride::class);
        }

        public function ratings()
        {
            return $this->hasMany(StudentRating::class);
        }

        public function overtimeRequests()
        {
            return $this->hasMany(OvertimeRequest::class);
        }








}
