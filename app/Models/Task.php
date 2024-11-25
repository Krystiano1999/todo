<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string|null $description
 * @property string $priority
 * @property string $status
 * @property string $due_date
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property string $priority_color
 * @property string $status_color
 */
class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'priority',
        'status',
        'due_date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due_date' => 'date',
    ];

    /**
     * Get the user that owns the task.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the color associated with the priority.
     */
    public function getPriorityColorAttribute(): string
    {
        return match ($this->priority) {
            'low' => 'success',    
            'medium' => 'warning', 
            'high' => 'danger',   
            default => 'secondary' 
        };
    }

    /**
     * Get the color associated with the status.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'to-do' => 'info',         
            'in-progress' => 'primary', 
            'done' => 'success',      
            default => 'secondary'     
        };
    }
}
