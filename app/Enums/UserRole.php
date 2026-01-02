<?php
namespace App\Enums;

enum UserRole: string {
    case ADMIN = 'admin';
    case MESERO = 'mesero';
    case COCINERO = 'cocinero';
}
