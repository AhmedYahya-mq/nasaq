<?php

namespace App\Actions\User;

use App\Contract\User\Request\MembershipAppRequest;
use App\Models\MembershipApplication;

class MembershipRequestAction implements \App\Contract\Actions\MembershipRequestAction
{
    public function resubmit(MembershipApplication $application)
    {
        $listener = new \App\Listeners\CreateMembershipDraft();
        $app = $listener->handle(new \App\Events\PaymentStatusChanged($application->payment));
        $application->update(['is_resubmit' => true]);
        return redirect()->route('client.membership.request', ['application' => $app]);
    }
    public function execute(MembershipAppRequest $request, MembershipApplication $application)
    {
        $application->update($request->all());
        $files = $request->input('file', []);
        if (!empty($files)) {
            $this->updateApplicationFiles($application, $files);
        }
        $userData = $request->only(['email', 'phone', 'job_title', 'employment_status', 'national_id', 'current_employer', 'scfhs_number']);
        $request->user()->update($userData);
        return view('request-success', compact('application'));
    }


    /**
     * تحويل الملفات المنقولة من stdClass إلى مصفوفة قابلة للـ createMany
     *
     * @param array $files كائنات الملفات من moveToPublic
     * @return array مصفوفة جاهزة للحفظ في قاعدة البيانات
     */
    protected function prepareForDatabase(array $files): array
    {
        return array_map(function ($file) {
            return [
                'file_name' => $file->file_name,
                'file_path' => $file->file_path,
                'file_type' => $file->file_type,
            ];
        }, $files);
    }


    /**
     * تحديث ملفات الطلب: حذف القديمة ثم إضافة الجديدة
     *
     * @param \Illuminate\Database\Eloquent\Model $application
     * @param array $files المصفوفة الناتجة من moveToPublic
     * @return void
     */
    protected function updateApplicationFiles($application, array $files): void
    {
        // حذف الملفات القديمة من القرص
        if ($application->files()->exists()) {
            $application->files()->delete();
        }

        // حفظ الملفات الجديدة إذا موجودة
        if (!empty($files)) {
            $application->files()->createMany($this->prepareForDatabase($files));
        }
    }
}
