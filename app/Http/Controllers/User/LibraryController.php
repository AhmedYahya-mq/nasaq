<?php

namespace App\Http\Controllers\User;

use App\Contract\Actions\FileLibraryDownload;
use App\Contract\Actions\FileLibraryHandler;
use App\Contract\User\Request\LibraryRequest;
use App\Contract\User\Response\LibraryResponse;
use App\Http\Controllers\Controller;
use App\Models\Library;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LibraryController extends Controller
{
    public function index()
    {
        return app(LibraryResponse::class);
    }

    public function store(LibraryRequest $request)
    {
        $data = $request->all();
        $res = Library::create($data);
        $res->updateTranslations($data['translations'] ?? [], $request->header('X-Locale', config('app.locale')));
        // حافظ على نفس سلوك التحديث باستخدام syncPhotosById
        $posterId = $request->input('poster');
        $res->syncPhotosById($posterId ? [$posterId] : []);
        return app(LibraryResponse::class, ['resource' => $res])->toResponseResource();
    }

    public function update(LibraryRequest $request, Library $res)
    {
        $data = $request->all();
        $res->update($data);
        $res->updateTranslations($data['translations'] ?? [], $request->header('X-Locale', config('app.locale')));
        if (array_key_exists('poster', $data) && $data['poster'] !== null && $data['poster'] !== $res->photo?->id) {
            $res->syncPhotosById($request->input('poster', null));
        }
        $res->save();
        return app(LibraryResponse::class, ['resource' => $res])->toResponseResource();
    }

    public function updateTranslation(LibraryRequest $request, Library $res)
    {
        $data = $request->all();
        $res->updateTranslations($data['translations'], $request->header('X-Locale', config('app.locale')));
        $res->save();
        return app(LibraryResponse::class, ['resource' => $res])->toResponseResource();
    }

    public function uploadFile(Request $request)
    {
        // تحقق من الملف وانه اصغر من 255
        $request->validate([
            'file' => 'required|file|max:261120', // 255 ميجابايت
        ], [
            'file.max' => 'حجم الملف يجب أن لا يتجاوز 255 ميجابايت.',
        ]);
        // انقل الى private/storage/library
        $path = $request->file('file')->store('library', 'local');
        return response()->json(['path' => $path], 200);
    }

    public function deleteFile(Request $request)
    {
        $request->validate([
            'file_path' => ['required', 'string', new \App\Rules\LibraryRole()],
        ]);
        // حذف الملف من التخزين
        Storage::disk('local')->delete($request->input('file_path'));
        return response()->json(['message' => 'File deleted successfully'], 200);
    }

    public function destroy(Library $res)
    {
        if ($res->path && Storage::disk('local')->exists($res->path)) {
            Storage::disk('local')->delete($res->path);
        }
        $res->delete();
        return response()->json(['message' => 'تم حذف العنصر من المكتبة بنجاح.'], 200);
    }

    public function download(Library $res, FileLibraryDownload $downloader)
    {
        try {
            return $downloader->download($res);
        } catch (\Exception $e) {
            Log::error('Error downloading file: ' . $e->getMessage());
            return response()->json(['message' => 'حدث خطأ أثناء تنزيل الملف.'], 500);
        }
    }

    public function uploadChunk(Request $request, FileLibraryHandler $handler)
    {
        try {
            $result = $handler->uploadChunk($request);
            return response()->json($result, 200);
        } catch (\Exception $e) {
            Log::error('Error uploading chunk: ' . $e->getMessage());
            return response()->json(['message' => 'حدث خطأ أثناء رفع الجزء.'], 500);
        }
    }

    public function checkUploadedChunks(Request $request,  FileLibraryHandler $handler)
    {
        try {
            $result = $handler->checkUploadedChunks($request);
            return response()->json($result, 200);
        } catch (\Exception $th) {
            Log::error('Error checking uploaded chunks: ' . $th->getMessage());
            return response()->json(['message' => 'حدث خطأ أثناء التحقق من الأجزاء المرفوعة.'], 500);
        }
    }

    public function saved(Library $res)
    {
        $user = auth()->user();
        $is_saved = $res->savedUser($user->id);
        $message = $is_saved
            ? "لقد تم حفظ {$res->title} في قائمتك ويمكنك الوصول إليه من خلال صفحة المكتبة الخاصة بك في البروفايل."
            : "لم يتم حفظ {$res->title}. حاول مرة أخرى.";
        $type = $is_saved ? 'success' : 'error';
        $redirectTo = url()->previous() !== url()->current()
            ? back()
            : redirect()->route('client.library', $res->id);
        return $redirectTo->with([$type => $message]);
    }
}
