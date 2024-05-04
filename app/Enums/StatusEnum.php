<?php

namespace App\Enums;

enum StatusEnum: String
{

    case DRAFT = 'draft';
    case REVIEWING = 'reviewing';
    case PUBLISH = 'publish';
}
