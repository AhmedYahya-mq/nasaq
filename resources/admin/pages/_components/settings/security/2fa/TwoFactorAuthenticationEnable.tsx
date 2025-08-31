
import HeadingSmall from '@/components/heading-small';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { CardDescription, CardFooter, CardTitle } from '@/components/ui/card';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { enable } from '@/routes/admin/two-factor';
import { Form } from '@inertiajs/react';
import { useRef } from 'react';
export default function TwoFactorAuthenticationEnable() {
    const passwordInput = useRef<HTMLInputElement>(null);
    return (
        <>
            <CardFooter className="flex justify-end">
                <Dialog>
                    <DialogTrigger asChild>
                        <Button >تفعيل المصادقه الثنائية</Button>
                    </DialogTrigger>
                    <DialogContent>
                        <DialogTitle>تفعيل المصادقة الثنائية</DialogTitle>
                        <DialogDescription>
                            لتفعيل المصادقة الثنائية وحماية حسابك، يرجى إدخال كلمة المرور الخاصة بك لتأكيد هويتك.
                        </DialogDescription>

                        <Form
                            {...enable.form()}
                            options={{
                                preserveScroll: true,
                            }}
                            onError={
                                (errors) => {
                                    console.log(errors);
                                }
                            }
                            resetOnSuccess
                            className="space-y-6"
                        >
                            {({ resetAndClearErrors, processing, errors }) => (
                                <>
                                    <div className="grid gap-2">
                                        <Label htmlFor="password" className="sr-only">
                                            Password
                                        </Label>

                                        <Input
                                            id="password"
                                            type="password"
                                            name="password"
                                            ref={passwordInput}
                                            placeholder="Password"
                                            autoComplete="current-password"
                                        />

                                        <InputError message={errors.password} />
                                    </div>

                                    <DialogFooter className="gap-2">
                                        <DialogClose asChild>
                                            <Button variant="secondary" onClick={() => resetAndClearErrors()}>
                                                Cancel
                                            </Button>
                                        </DialogClose>

                                        <Button disabled={processing} asChild>
                                            <button type="submit">تفعيل</button>
                                        </Button>
                                    </DialogFooter>
                                </>
                            )}
                        </Form>
                    </DialogContent>
                </Dialog>
            </CardFooter>
        </>
    );
}
