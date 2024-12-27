<?php 

namespace App\Interfaces;

use Illuminate\Http\Request;

interface CrudOperations {
    public function store(Request $request);
    public function show($id);
    public function signup(Request $request);
    public function login(Request $request);
    public function update(Request $request, $id);
    public function destroy($id);
}