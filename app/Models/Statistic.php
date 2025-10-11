<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;
       protected $fillable = [
        'type',  // type: 'students', 'departments', 'courses', 'lecturers'
        'count' , // count: value for that statistic
        'icon',     // Font Awesome icon class (e.g. 'fa-building')
        'icon_color',
    ];

      public static function iconOptions()
    {
        return [
            'fa-building' => 'Building',
            'fa-book-open' => 'Book',
            'fa-chalkboard-teacher' => 'Teacher',
            'fa-users' => 'Users',
            'fa-graduation-cap' => 'Graduation',
            'fa-flask' => 'Lab',
            'fa-microscope' => 'Science',
            'fa-laptop-code' => 'Technology'
        ];
    }
    

      public static function colorOptions()
    {
        return [
            'primary' => 'Blue (Primary)',
            'success' => 'Green (Success)',
            'warning' => 'Yellow (Warning)',
            'danger' => 'Red (Danger)',
            'info' => 'Cyan (Info)',
            'secondary' => 'Gray (Secondary)'
        ];
    }

}
