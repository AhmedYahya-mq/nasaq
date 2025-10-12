import { Card } from "@/components/ui/card";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Badge } from "@/components/ui/badge";
import { Mail, CheckCircle2, XCircle, User } from "lucide-react";
import { EventRegistration } from "@/types/model/events";


interface AttendeeCardProps {
    registration: EventRegistration;
    onAttendanceToggle: (registrationId: number, isAttended: boolean) => void;
}

export function AttendeeCard({ registration, onAttendanceToggle }: AttendeeCardProps) {
    const { user, joined_at } = registration;
    const initials = user.name
        .split(" ")
        .map((n) => n[0])
        .join("")
        .toUpperCase()
        .slice(0, 2);

    return (
        <Card className="overflow-hidden transition-all hover:shadow-card-hover">
            <div className="p-4">
                <div className="flex items-start justify-between gap-4">
                    <div className="flex items-start gap-3 flex-1 min-w-0">
                        <Avatar className="h-12 w-12 ring-2 ring-primary/10">
                            <AvatarImage src={user.profile_photo_url} alt={user.name} />
                            <AvatarFallback className="bg-gradient-primary text-primary-foreground">
                                {initials}
                            </AvatarFallback>
                        </Avatar>

                        <div className="flex-1 min-w-0">
                            <div className="flex items-center gap-2 flex-wrap">
                                <h3 className="font-semibold text-base truncate">{user.name}</h3>
                                {user.membership && (
                                    <Badge variant="outline" className="text-xs">
                                        {user.membership}
                                    </Badge>
                                )}
                            </div>

                            <div className="flex items-center gap-1.5 mt-1.5 text-sm text-muted-foreground">
                                <Mail className="h-3.5 w-3.5 flex-shrink-0" />
                                <span className="truncate">{user.email}</span>
                            </div>

                            {user.member_id && (
                                <div className="flex items-center gap-1.5 mt-1 text-xs text-muted-foreground">
                                    <User className="h-3 w-3 flex-shrink-0" />
                                    <span>#{user.member_id}</span>
                                </div>
                            )}
                        </div>
                    </div>

                    <div className="flex-shrink-0">
                        {registration.is_attended ? (
                            <Badge
                                className="gap-1.5 bg-success-light text-success border-success/20 cursor-pointer hover:opacity-80 transition-opacity"
                                onClick={() => onAttendanceToggle(registration.id, false)}
                            >
                                <CheckCircle2 className="h-3.5 w-3.5" />
                                حضر
                            </Badge>
                        ) : (
                            <Badge
                                className="gap-1.5 bg-muted text-muted-foreground border-border cursor-pointer hover:opacity-80 transition-opacity"
                                onClick={() => onAttendanceToggle(registration.id, true)}
                            >
                                <XCircle className="h-3.5 w-3.5" />
                                لم يحضر
                            </Badge>
                        )}
                    </div>
                </div>
            </div>
        </Card>
    );
}


