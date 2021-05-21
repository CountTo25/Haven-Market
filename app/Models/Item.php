<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @property int $id
 * @property int $haven_id
 * @property int $quality
 * @property int $amount
 * @property int $shop_id
 * @property string $comment
 * @property boolean $on_sale
 */
class Item extends Model
{
    use HasFactory;

    protected $table = 'items';
    protected $casts = [
        'on_sale' => 'boolean'
    ];

    public function haven(): BelongsTo
    {
        return $this->belongsTo(HavenItem::class, 'haven_id');
    }
}
