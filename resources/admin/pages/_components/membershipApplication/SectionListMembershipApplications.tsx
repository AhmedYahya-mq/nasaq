import { JSX, useState, useEffect } from "react";
import { useTableMembershipApplications } from "@/hooks/table/useTableMembershipApplications";
import { columns } from "@/data/membershipApplication/tableData";
import { EmailList } from "./MailList";
import { Email, mockEmails } from "@/types/model/membershipApplication";
import { EmailDetail } from "./EmailDetail";

// Hook للتحقق من حجم الشاشة
function useIsMobile() {
    const [isMobile, setIsMobile] = useState(false);
    useEffect(() => {
        const check = () => setIsMobile(window.innerWidth < 1115); // <1024 px = mobile/tablet
        check();
        window.addEventListener("resize", check);
        return () => window.removeEventListener("resize", check);
    }, []);
    return isMobile;
}

export default function SectionListMemberships(): JSX.Element {
    const initHook = useTableMembershipApplications({ applications: [], columns }) as any;
    const [selectedFolder, setSelectedFolder] = useState("inbox");
    const [selectedEmail, setSelectedEmail] = useState<Email | null>(null);
    const [searchQuery, setSearchQuery] = useState("");
    const [emails, setEmails] = useState(mockEmails);
    const isMobile = useIsMobile();

    const filteredEmails = emails.filter((email) => {
        const matchesFolder = email.folder === selectedFolder;
        const matchesSearch =
            searchQuery === "" ||
            email.subject.toLowerCase().includes(searchQuery.toLowerCase()) ||
            email.sender.toLowerCase().includes(searchQuery.toLowerCase()) ||
            email.content.toLowerCase().includes(searchQuery.toLowerCase());
        return matchesFolder && matchesSearch;
    });

    const handleEmailSelect = (email: Email) => {
        scrollTo(0, 0);
        setSelectedEmail(email);
        if (!email.read) {
            setEmails((prev) => prev.map((e) => (e.id === email.id ? { ...e, read: true } : e)));
        }
    };

    const handleMarkAsRead = (emailId: string, read: boolean) => {
        setEmails((prev) => prev.map((e) => (e.id === emailId ? { ...e, read } : e)));
    };

    const handleDeleteEmail = (emailId: string) => {
        setEmails((prev) =>
            prev.map((e) => (e.id === emailId ? { ...e, folder: "trash" } : e))
        );
        if (selectedEmail?.id === emailId) {
            setSelectedEmail(null);
        }
    };

    // Desktop: side-by-side | Mobile: list OR detail
    if (isMobile) {
        return (
            <div className="flex flex-1 h-full">
                {!selectedEmail ? (
                    <EmailList
                        emails={filteredEmails}
                        selectedEmail={selectedEmail}
                        onEmailSelect={handleEmailSelect}
                        searchQuery={searchQuery}
                        onSearchChange={setSearchQuery}
                    />
                ) : (
                    <div className="flex-1 flex flex-col">

                        <EmailDetail
                            email={selectedEmail}
                            onMarkAsRead={handleMarkAsRead}
                            onDelete={handleDeleteEmail}
                            onBack={() => {
                                setSelectedEmail(null);
                            }}
                        />
                    </div>
                )}
            </div>
        );
    }

    // Desktop
    return (
        <div className="grid grid-cols-[24rem_1fr] h-full">
            <div className="">
                <EmailList
                    emails={filteredEmails}
                    selectedEmail={selectedEmail}
                    onEmailSelect={handleEmailSelect}
                    searchQuery={searchQuery}
                    onSearchChange={setSearchQuery}

                />
            </div>
            <EmailDetail
                email={selectedEmail}
                onMarkAsRead={handleMarkAsRead}
                onDelete={handleDeleteEmail}
            />
        </div>
    );
}
