<?php

namespace App\Enums;

enum OrderStatus: string
{
    case ANOTADO = 'Anotado';
    case EN_COCINA = 'En Cocina';
    case EN_PREPARACION = 'En Preparación';
    case LISTO = 'Listo';
    case SERVIDO = 'Servido';
    case ENTREGADO = 'Entregado';
    case CANCELADO = 'Cancelado';
}
