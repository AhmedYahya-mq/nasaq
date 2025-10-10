<?php
namespace App\Contract\Actions;

use App\Contract\User\Request\MembershipAppRequest;
use App\Models\MembershipApplication;

interface MembershipRequestAction
{
    public function execute(MembershipAppRequest $request, MembershipApplication $application);
    public function resubmit(MembershipApplication $application);
}
