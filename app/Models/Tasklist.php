<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasklist extends Model
{
    use HasFactory;
    
    protected $table = 'tasks';
    
    protected $fillable = ['content', 'status'];
    
    // このタスクとステータスを所有するユーザ（Userモデルとの関係を定義）
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
