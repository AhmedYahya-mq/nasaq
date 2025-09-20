import { Reply, Forward, Trash2, MoreHorizontal, Download, Star, ArrowLeft } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Card } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import { Email } from "@/types/model/membershipApplication";

interface EmailDetailProps {
  email: Email | null;
  onMarkAsRead: (emailId: string, read: boolean) => void;
  onDelete: (emailId: string) => void;
  onBack?: () => void; // زر الرجوع للشاشات الصغيرة
}

export function EmailDetail({ email, onMarkAsRead, onDelete, onBack }: EmailDetailProps) {
  // إذا لم توجد رسالة محددة
  if (!email) {
    return (
      <div className="flex-1 flex items-center justify-center bg-muted/10">
        <div className="text-center text-muted-foreground w-full">
          {/* زر رجوع يظهر فقط إذا كان onBack موجود (شاشات صغيرة) */}
          {onBack && (
            <button
              className="absolute left-4 top-4 flex items-center gap-2 text-muted-foreground hover:text-foreground transition"
              onClick={onBack}
            >
              <ArrowLeft className="h-5 w-5" />
              <span>Back</span>
            </button>
          )}
          <div className="w-16 h-16 mx-auto mb-4 bg-muted rounded-full flex items-center justify-center">
            📧
          </div>
          <h3 className="text-lg font-medium mb-2">No email selected</h3>
          <p className="text-sm">Choose an email from the list to view its contents</p>
        </div>
      </div>
    );
  }

  const formatFullDate = (date: Date) => {
    return date.toLocaleDateString([], {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit'
    });
  };

  return (
    <div className="flex-1 flex flex-col bg-background relative">
      {/* زر رجوع أعلى الصفحة على الشاشات الصغيرة فقط */}
      {onBack && (
        <div className="p-4 border-b border-border bg-card flex items-center">
          <button
            className="flex items-center gap-2 text-muted-foreground hover:text-foreground transition"
            onClick={onBack}
          >
            <ArrowLeft className="h-5 w-5" />
            <span>Back</span>
          </button>
        </div>
      )}
      {/* Header */}
      <div className={`p-6 border-b border-border bg-card ${onBack ? "pt-2" : ""}`}>
        <div className="flex items-center justify-between mb-4">
          <div className="flex items-center gap-3">
            <h1 className="text-xl font-semibold text-foreground">{email.subject}</h1>
            {!email.read && (
              <Badge variant="secondary" className="bg-email-unread text-email-unread-foreground">
                Unread
              </Badge>
            )}
          </div>
        </div>

        {/* Email Meta */}
        <div className="space-y-2 text-sm">
          <div className="flex items-center justify-between">
            <div className="flex items-center gap-2">
              <span className="font-medium text-foreground">From:</span>
              <span className="text-muted-foreground">{email.sender}</span>
            </div>
            <span className="text-muted-foreground">{formatFullDate(email.timestamp)}</span>
          </div>
        </div>
      </div>

      {/* Content */}
      <div className="flex-1 scrollbar">
        <div className="p-6">
          <Card className="p-6 shadow-card">
            <div
              className="prose prose-sm max-w-none text-foreground"
              dangerouslySetInnerHTML={{ __html: email.content.replace(/\n/g, '<br>') }}
            />
          </Card>

          {/* Attachments */}
          {email.attachments && email.attachments.length > 0 && (
            <Card className="mt-4 p-4 shadow-card">
              <h3 className="font-medium text-foreground mb-3">Attachments ({email.attachments.length})</h3>
              <div className="space-y-2">
                {email.attachments.map((attachment, index) => (
                  <div key={index} className="flex items-center justify-between p-2 bg-muted/50 rounded-md">
                    <span className="text-sm text-foreground">{attachment}</span>
                    <Button variant="ghost" size="sm" className="gap-2">
                      <Download className="h-4 w-4" />
                      Download
                    </Button>
                  </div>
                ))}
              </div>
            </Card>
          )}
        </div>
      </div>
    </div>
  );
}
