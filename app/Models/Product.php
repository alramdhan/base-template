<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
 
    protected $fillable = [
        'category_id',
        'name',
        'sku',
        'description',
        'price',
        'stock',
        'unit',
        'min_stock',
        'image',
        'is_active',
    ];
 
    protected $casts = [
        'price'     => 'integer',
        'stock'     => 'integer',
        'min_stock' => 'integer',
        'is_active' => 'boolean',
    ];
 
    // Relasi ke kategori
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
 
    // Scope: pencarian berdasarkan nama atau SKU
    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        if (!$keyword) {
            return $query;
        }
 
        return $query->where(function (Builder $q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
              ->orWhere('sku', 'like', "%{$keyword}%");
        });
    }
 
    // Scope: filter berdasarkan kategori
    public function scopeCategory(Builder $query, ?int $categoryId): Builder
    {
        return $categoryId ? $query->where('category_id', $categoryId) : $query;
    }
 
    // Scope: produk yang stoknya sudah menipis (untuk dashboard/reminder restock)
    public function scopeLowStock(Builder $query): Builder
    {
        return $query->whereColumn('stock', '<=', 'min_stock');
    }
 
    // Scope: hanya produk aktif (yang dijual)
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
 
    // Accessor kecil untuk format harga jika dibutuhkan di frontend
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp' . number_format($this->price, 0, ',', '.');
    }
}
