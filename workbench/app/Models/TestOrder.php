<?php

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property float $amount
 * @property string $status
 * @property string $reference
 * @method static \Illuminate\Database\Eloquent\Builder where(string $string, string $string1)
 * @method static \Illuminate\Database\Eloquent\Builder create(array $array)
 */
class TestOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'status',
        'reference',
    ];
}
