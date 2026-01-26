<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function usersList()
    {
        $users = User::all();

        $pdf = Pdf::loadView('pdf.admin-users-list', compact('users'));

        return $pdf->stream('listado-usuarios.pdf');
    }

    public function userReport(User $user)
    {

        $user->load(['watchLater', 'role']);

        $pdf = Pdf::loadView('pdf.admin-user-report', compact('user'));

        return $pdf->stream('informe-usuario-' . $user->id . '.pdf');
    }
}
