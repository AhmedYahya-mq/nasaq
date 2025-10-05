// confirm-dialog-store.ts
import { create } from "zustand";

export type ConfirmOptions = {
  title: string;
  message?: string;
};

type ConfirmState = {
  open: boolean;
  options?: ConfirmOptions;
  resolve?: (result: boolean) => void;
  confirm: (opts: ConfirmOptions) => Promise<boolean>;
  close: () => void;
};

export const useConfirmDialog = create<ConfirmState>((set) => ({
  open: false,
  options: undefined,
  resolve: undefined,
  confirm: (options) =>
    new Promise<boolean>((resolve) => {
      set({ open: true, options, resolve });
    }),
  close: () => set({ open: false, options: undefined, resolve: undefined }),
}));

export const confirm = (options: ConfirmOptions) =>
  useConfirmDialog.getState().confirm(options);
