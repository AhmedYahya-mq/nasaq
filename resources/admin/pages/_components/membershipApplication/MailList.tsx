import { Search, Clock, Mail } from "lucide-react";
import { Input } from "@/components/ui/input";
import { Card } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { cn } from "@/lib/utils";
import { Email } from "@/types/model/membershipApplication";

interface EmailListProps {
  emails: Email[];
  selectedEmail: Email | null;
  onEmailSelect: (email: Email) => void;
  searchQuery: string;
  onSearchChange: (query: string) => void;
    className?: string;
}

export function EmailList({
  emails,
  selectedEmail,
  onEmailSelect,
  searchQuery,
  onSearchChange,
  className
}: EmailListProps) {
  const formatDate = (date: Date) => {
    const now = new Date();
    const diffInHours = (now.getTime() - date.getTime()) / (1000 * 60 * 60);

    if (diffInHours < 24) {
      return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    } else if (diffInHours < 24 * 7) {
      return date.toLocaleDateString([], { weekday: 'short' });
    } else {
      return date.toLocaleDateString([], { month: 'short', day: 'numeric' });
    }
  };

  return (
    <div className={cn([className,"border-r w-full border-border bg-background flex flex-col"])} >
      {/* Search */}
      <div className="p-4 border-b border-border">
        <div className="relative">
          <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
          <Input
            placeholder="Search emails..."
            value={searchQuery}
            onChange={(e) => onSearchChange(e.target.value)}
            className="pl-10 bg-muted/50 border-muted"
          />
        </div>
      </div>

      {/* Email List */}
      <div className="flex-1 min-[1115px]:max-h-screen scrollbar">
        <div className="p-2">
          {emails.length === 0 ? (
            <div className="text-center py-8 text-muted-foreground">
              <Mail className="h-8 w-8 mx-auto mb-2 opacity-50" />
              <p>No emails found</p>
            </div>
          ) : (
            <div className="space-y-1">
              {emails.map((email) => (
                <Card
                  key={email.id}
                  className={cn(
                    "p-4 cursor-pointer border transition-all duration-200 hover:shadow-email",
                    selectedEmail?.id === email.id
                      ? "bg-card/45 border-1 border-primary shadow"
                      : "hover:bg-muted/50 border-transparent",
                    !email.read && "border-l-4 border-l-primary"
                  )}
                  onClick={() => onEmailSelect(email)}
                >
                  <div className="flex items-start justify-between mb-2">
                    <div className="flex items-center gap-2 min-w-0 flex-1">
                      <span className={cn(
                        "font-medium truncate",
                        !email.read ? "text-foreground" : "text-muted-foreground"
                      )}>
                        {email.sender}
                      </span>
                      {!email.read && (
                        <div className="w-2 h-2 bg-primary rounded-full flex-shrink-0" />
                      )}
                    </div>
                    <div className="flex items-center gap-1 text-xs text-muted-foreground flex-shrink-0">
                      <Clock className="h-3 w-3" />
                      {formatDate(email.timestamp)}
                    </div>
                  </div>

                  <h3 className={cn(
                    "text-sm mb-1 truncate",
                    !email.read ? "font-semibold text-foreground" : "font-medium text-muted-foreground"
                  )}>
                    {email.subject}
                  </h3>

                  <p className="text-xs text-muted-foreground line-clamp-2">
                    {email.preview}
                  </p>

                  {email.attachments && email.attachments.length > 0 && (
                    <div className="mt-2">
                      <Badge variant="outline" className="text-xs">
                        📎 {email.attachments.length} attachment{email.attachments.length > 1 ? 's' : ''}
                      </Badge>
                    </div>
                  )}
                </Card>
              ))}
            </div>
          )}
        </div>
      </div>
    </div>
  );
}
