<?php 

namespace App\Interfaces;

use Illuminate\Http\Request;

interface CreateOperation {
    public function store(Request $request);
}
?>