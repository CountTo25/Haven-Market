<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $has_quality
 */

class HavenItem extends Model
{
    use HasFactory;

    protected $table = 'haven_items';
}
