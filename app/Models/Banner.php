<?php
// app\Models\Banner.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{

    protected $table = 'scholarship_banners'; // Specify the table name if different
    use HasFactory;

    protected $fillable = ['image_path'];
}
