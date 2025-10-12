import { Card } from "@/components/ui/card";
import { Skeleton } from "@/components/ui/skeleton";

export function AttendeeCardSkeleton() {
    return (
        <Card className="overflow-hidden">
            <div className="p-4 flex items-start gap-4">
                <Skeleton className="size-12 rounded-full" />
                <div className="flex-1 min-w-0 space-y-2">
                    <div className="flex gap-1">
                        <Skeleton className="w-1/4 h-5" />
                        <Skeleton className="w-1/6 h-5" />
                    </div>
                    <Skeleton className="w-1/3 h-5" />
                    <Skeleton className="w-1/3 h-5" />
                </div>
                <Skeleton className="w-8 h-4 rounded-full" />
            </div>
        </Card>
    );
}