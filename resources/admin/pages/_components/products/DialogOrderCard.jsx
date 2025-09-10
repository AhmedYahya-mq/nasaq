import { Dialog, DialogContent, DialogHeader, DialogTitle } from "@/components/ui/dialog";

export default function DialogOrderCard({ selectedRow, setSelectedRow })
{
    return (
        <Dialog open={!!selectedRow} onOpenChange={() => setSelectedRow(null)}>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>تفاصيل</DialogTitle>
                </DialogHeader>
                <div className="max-h-[70vh] scrollbar">
                    <div className="mt-4">
                        <pre>{JSON.stringify(selectedRow, null, 2)}</pre>
                    </div>
                </div>
            </DialogContent>
        </Dialog>
    );
}
