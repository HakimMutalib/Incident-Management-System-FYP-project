<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Contracts\Permission as PermissionContract;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Guard;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\RefreshesPermissionCache;

class Ticket extends Model
{
    use HasRoles;
    use RefreshesPermissionCache;



    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
    'category',
    'name',
    'email',
    'description',
    'status',
    'assignee',
    'priority',
    'category',
    ];

    protected $casts = [
        'created_at' => 'datetime:d-M-Y'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
