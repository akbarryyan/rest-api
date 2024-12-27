<?php 

namespace App\Interfaces;

use Illuminate\Http\Request;

interface UpdateOperation {
    public function update(Request $request, $id);
}
?>