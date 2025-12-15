<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postman extends Model
{
    use HasFactory;

    protected $table = 'postmen';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'nic',
        'mobile',
        'paysheet_id',
        'location_id',
        'created_by',
        'updated_by',
        'status',
        'postman_type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the location that owns the postman.
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the user who created this postman.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this postman.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope a query to only include postmen for a specific location.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $locationId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForLocation($query, $locationId)
    {
        return $query->where('location_id', $locationId);
    }

    /**
     * Scope a query to only include active postmen.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to filter by postman type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('postman_type', $type);
    }

    /**
     * Check if the postman is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Check if the postman is permanent.
     *
     * @return bool
     */
    public function isPermanent()
    {
        return $this->postman_type === 'permanent';
    }

    /**
     * Check if the postman is temporary.
     *
     * @return bool
     */
    public function isTemporary()
    {
        return $this->postman_type === 'temporary';
    }

    /**
     * Check if the postman is a substitute.
     *
     * @return bool
     */
    public function isSubstitute()
    {
        return $this->postman_type === 'substitute';
    }
}