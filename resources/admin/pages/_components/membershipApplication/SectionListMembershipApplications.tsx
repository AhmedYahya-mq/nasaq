import { JSX, useState } from "react";
import { EmailList } from "./MailList";
import { EmailDetail } from "./EmailDetail";
import { MembershipApplication } from "@/types/model/membershipApplication";
 // hook للتحقق من حجم الشاشة
import { useMembershipApplications } from "@/hooks/useMembershipApplications"; // hook لجلب البيانات وإدارة البحث والفلترة
import { useIsMobile } from "@/hooks/use-mobile";


interface SectionListMembershipsProps {
  alawysMobile?: boolean;
  member_id?: number | string;
}

export default function SectionListMemberships({
  alawysMobile = false,
  member_id,
}: SectionListMembershipsProps): JSX.Element {
  const [selectedApplication, setSelectedApplication] =
    useState<MembershipApplication | null>(null);

  // استخدم custom breakpoint 1115px
  const isMobile = useIsMobile(1115);

  // استخدام custom hook لإدارة البيانات
  const {
    pagination,
    loading,
    searchQuery,
    setSearchQuery,
    selectedFolder,
    setSelectedFolder,
    handlePageChange,
  } = useMembershipApplications({ member_id });
  
  const handleAppSelect = (application: MembershipApplication) => {
    scrollTo(0, 0);
    setSelectedApplication(application);
  };

  // نسخة mobile/tablet
  if (isMobile || alawysMobile) {
    return (
      <div className="flex flex-1 h-full">
        {!selectedApplication ? (
          <EmailList
            pagination={pagination}
            selectedApplication={selectedApplication}
            onApplicationSelect={handleAppSelect}
            searchQuery={searchQuery}
            onSearchChange={setSearchQuery}
            onPageChange={handlePageChange}
            selectedFolder={selectedFolder}
            onFolderChange={setSelectedFolder}
            loading={loading}
          />
        ) : (
          <div className="flex-1 flex flex-col">
            <EmailDetail
              application={selectedApplication}
              onApplicationSelect={handleAppSelect}
              onBack={() => setSelectedApplication(null)}
            />
          </div>
        )}
      </div>
    );
  }

  // نسخة desktop
  return (
    <div className="grid grid-cols-[24rem_1fr] h-full">
      <div className="">
        <EmailList
          pagination={pagination}
          selectedApplication={selectedApplication}
          onApplicationSelect={handleAppSelect}
          searchQuery={searchQuery}
          onSearchChange={setSearchQuery}
          onPageChange={handlePageChange}
          selectedFolder={selectedFolder}
          onFolderChange={setSelectedFolder}
          loading={loading}
        />
      </div>
      <EmailDetail
        application={selectedApplication}
        onApplicationSelect={handleAppSelect}
      />
    </div>
  );
}
