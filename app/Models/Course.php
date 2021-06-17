<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;

    /**
     * @var string
     */

    protected $table = 'courses';

    /**
     * @var array
     */

    protected $fillable = [
        'name','description','featured','menu','image',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'featured' => 'boolean',
        'menu' => 'boolean',
    ];

    /**
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function categories(){
        return $this->belongsToMany(Category::class,'category_course','course_id', 'category_id');
    }

    public function videos(){
        return $this->belongsToMany(Video::class, 'course_video','course_id','video_id');
    }

}
