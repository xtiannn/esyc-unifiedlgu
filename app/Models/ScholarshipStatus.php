<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarshipStatus extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't match the default convention
    protected $table = 'scholarship_status';

    // Define the fillable attributes
    protected $fillable = ['status'];

    // Define the default attributes
    protected $attributes = [
        'status' => 'open',
    ];

    /**
     * Check if the scholarship is open.
     *
     * @return bool
     */
    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    /**
     * Check if the scholarship is closed.
     *
     * @return bool
     */
    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }
}
