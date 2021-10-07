<?php

namespace App\Models;

use App\Transformers\CategoryTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    public CategoryTransformer | string $transformer = CategoryTransformer::class;
    protected $fillable = [
        'name',
        'description'
    ];

    protected $hidden = ['pivot'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
