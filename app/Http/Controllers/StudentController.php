<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function updatePhoto(Request $request)
    {
        // Validasi request
        $request->validate([
            'name'  => 'required|string',
            'nisn'  => 'required|string',
            'photo' => 'required|image|mimes:jpg,jpeg|max:10240',
        ]);

        $name = $request->name;
        $nisn = $request->nisn;

        // filename final
        $filename = "{$name}_{$nisn}.jpg";

        // folder penyimpanan
        $directory = 'public/students';

        // cek apakah file lama ada
        if (Storage::exists("$directory/$filename")) {
            Storage::delete("$directory/$filename");
        }

        // simpan file baru
        $path = $request->file('photo')->storeAs($directory, $filename);

        return response()->json([
            'status' => true,
            'message' => 'Photo updated successfully',
            'filename' => $filename,
            'url' => Storage::url($path),
        ]);
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:10240',
        ]);
        $file = $request->file('image');
        $filename = $file->getClientOriginalName();
        $path = $file->storeAs('public/students', $filename);
        return response()->json([
            'status' => 'success',
            'filename' => $filename,
            'url' => url('images/' . $filename),
        ]);
    }

    public function deletePhoto(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'nisn' => 'required|string',
        ]);

        $name = $request->name;
        $nisn = $request->nisn;

        $filename = "{$name}_{$nisn}.jpg";
        $path = "public/students/{$filename}";

        if (Storage::exists($path)) {
            Storage::delete($path);

            return response()->json([
                'status' => true,
                'message' => 'Photo deleted successfully',
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Photo not found',
        ], 404);
    }

    public function deleteMultiplePhotos(Request $request)
    {
        $request->validate([
            'students' => 'required|array',
            'students.*.name' => 'required|string',
            'students.*.nisn' => 'required|string',
        ]);

        $deleted = [];
        $notFound = [];

        foreach ($request->students as $student) {
            $filename = "{$student['name']}_{$student['nisn']}.jpg";
            $path = "public/students/{$filename}";

            if (Storage::exists($path)) {
                Storage::delete($path);
                $deleted[] = $filename;
            } else {
                $notFound[] = $filename;
            }
        }

        return response()->json([
            'status' => true,
            'deleted' => $deleted,
            'not_found' => $notFound,
        ]);
    }
}
