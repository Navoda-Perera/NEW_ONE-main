<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Company extends Model
{
    protected $fillable = [
        'name',
        'telephone',
        'address',
        'email',
        'type',
        'status',
        'assign_postoffice',
        'balance',
        'created_by',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function assignedPostoffice(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'assign_postoffice');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class);
    }

    public function deposits(): HasMany
    {
        return $this->hasMany(Deposit::class);
    }

    public function withdraws(): HasMany
    {
        return $this->hasMany(Withdraw::class);
    }

    // Balance Management Methods
    public function addBalance($amount)
    {
        $this->increment('balance', $amount);
        
        // Create a deposit record
        Deposit::create([
            'company_id' => $this->id,
            'amount' => $amount,
            'location_id' => $this->assign_postoffice,
            'created_by' => Auth::guard('pm')->user()?->id ?? Auth::user()?->id ?? 1,
        ]);
        
        return $this;
    }

    public function deductBalance($amount)
    {
        if ($this->balance < $amount) {
            throw new \Exception('Insufficient balance');
        }
        
        $this->decrement('balance', $amount);
        
        // Create a withdraw record
        Withdraw::create([
            'company_id' => $this->id,
            'amount' => $amount,
            'location_id' => $this->assign_postoffice,
            'created_by' => Auth::guard('pm')->user()?->id ?? Auth::user()?->id ?? 1,
        ]);
        
        return $this;
    }

    public function hasBalance($amount)
    {
        return $this->balance >= $amount;
    }

    /**
     * Check if this company can add balance
     */
    public function canAddBalance()
    {
        return $this->type === 'prepaid';
    }

    /**
     * Check if this company can deduct a specific amount
     */
    public function canDeductBalance($amount)
    {
        return $this->type === 'prepaid' && ($this->balance ?? 0) >= $amount;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'ACTIVE');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
