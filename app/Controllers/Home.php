<?php

namespace App\Controllers;

use App\Models\SharedModel;  // Pastikan Anda menambahkan model SharedModel
use CodeIgniter\Controller;

class Home extends BaseController
{
    protected $sharedModel;

    public function __construct()
    {
        // Inisialisasi model
        $this->sharedModel = new SharedModel();
    }
}


