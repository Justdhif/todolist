<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',       // Nama tugas
        'description', // Deskripsi tugas (jika ada)
        'status',      // Status selesai/belum
        'due_date',    // Tanggal deadline
        'color',       // Warna tugas
        'user_id',     // ID user terkait
    ];
}
