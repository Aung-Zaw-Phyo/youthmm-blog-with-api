<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'category_id',
        'thumbnail',
        'user_id',
        'reg_id',
        'token'
    ];

    public function scopeFilter ($query, $filter) {
        
        $query->when($filter['search'] ?? false, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                            $query->where('visible', true)
                                  ->where('title','LIKE', '%'.$search.'%')
                                  ->orWhere('body', 'LIKE', '%'.$search.'%');
                        });
            });
        
            $query->when($filter['category'] ?? false, function ($query, $token) {
                $query->whereHas('category', function ($query) use ($token) {
                    $query->where('visible', true)->where('token', $token);
                });
            });

    }

    public function user () {
        return $this->belongsTo(User::class);
    }

    public function category () {
        return $this->belongsTo(Category::class);
    }

    public function comments () {
        return $this->hasMany(Comment::class);
    }
}
