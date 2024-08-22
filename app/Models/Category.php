<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use PhpParser\Node\Expr\FuncCall;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function category_to(){
        return $this->hasMany(Product::class,'category_id', 'id');
    }
}
