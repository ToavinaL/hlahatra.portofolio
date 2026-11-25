<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ResumeController extends Controller
{
    public function __invoke(FilesystemFactory $filesystem): BinaryFileResponse
    {
        $path = Setting::get('resume.path');

        abort_unless(is_string($path) && $path !== '' && $filesystem->disk('public')->exists($path), 404);

        return response()->download($filesystem->disk('public')->path($path), 'cv-toavina-harentsoa.pdf', ['Content-Type' => 'application/pdf']);
    }
}
