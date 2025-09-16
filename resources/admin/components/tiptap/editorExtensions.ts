import type { AnyExtension } from "@tiptap/core";
import StarterKit from "@tiptap/starter-kit";
import CharacterCount from "@tiptap/extension-character-count";
import { TextStyle } from "@tiptap/extension-text-style";
import Underline from "@tiptap/extension-underline";
import Superscript from "@tiptap/extension-superscript";
import Subscript from "@tiptap/extension-subscript";
import TaskList from "@tiptap/extension-task-list";
import TaskItem from "@tiptap/extension-task-item";
import Link from "@tiptap/extension-link";

// custom extensions
import { TextAlign } from "./extension/text-align";
import { FontSize } from "./extension/font-size";
import { Color } from "./extension/color";
import { BackgroundColor } from "./extension/background-color";
import { KeyboardShortcuts } from "./extension/short-keyboard";
import { ImageAdvanced } from "./extension/image-advanced";
import { Youtube } from "./extension/Youtube";
import ListExtended from "./extensions/listExtended";
import LinkExtended from "./extensions/linkExtended";

type BuildOptions = {
  enableCharacterCount?: boolean;
  linkHTMLAttributes?: Record<string, string>;
  additional?: AnyExtension[];
};

// Build a stable key using both name and type to avoid duplicate-name conflicts across types.
function extKey(ext: AnyExtension, fallback: string): string {
  const e = ext as any;
  const name = e?.name ?? e?.config?.name ?? fallback;
  const type = e?.type ?? e?.config?.type ?? "extension";
  return `${type}:${name}`;
}

// Dedupe by (type,name), keeping the last occurrence (user overrides win)
function dedupeExtensions(list: AnyExtension[]): AnyExtension[] {
  const seen = new Set<string>();
  const result: AnyExtension[] = [];
  for (let i = list.length - 1; i >= 0; i--) {
    const ext = list[i] as any;
    const key = extKey(ext, `__idx_${i}`);
    if (!seen.has(key)) {
      seen.add(key);
      result.unshift(ext);
    }
  }
  return result;
}

export function buildEditorExtensions(opts: BuildOptions = {}): AnyExtension[] {
  const {
    enableCharacterCount = true,
    linkHTMLAttributes = {
      rel: "noopener noreferrer",
      target: "_blank",
      class: "cursor-pointer rounded px-0.5",
    },
    additional = [],
  } = opts;

  // Pre-dedupe "additional" to minimize duplicates early.
  const additionalDeduped = dedupeExtensions(additional);

  // Snapshot of names present in additional to conditionally include built-ins.
  const additionalNames = new Set(
    additionalDeduped.map((e, i) => ((e as any)?.name ?? `__idx_${i}`))
  );

  const base: AnyExtension[] = [
    StarterKit.configure({
      listItem: false,
      bulletList: false,
      orderedList: false,
      link: false,
      underline: false,
    }),
    ListExtended,
    TextStyle,
    Superscript,
    Subscript,
    Underline,
    KeyboardShortcuts,
    FontSize,
    Color,
    BackgroundColor,
    TextAlign,
    LinkExtended,
    ImageAdvanced,
    Youtube,
  ];

  // Only include Underline/Link if user didn't supply them.
  if (!additionalNames.has("underline")) {
    base.push(Underline);
  }
  if (!additionalNames.has("link")) {
    base.push(
      Link.configure({
        openOnClick: false,
        HTMLAttributes: linkHTMLAttributes,
      })
    );
  }

  if (enableCharacterCount) {
    base.push(CharacterCount.configure({ limit: null }));
  }

  // Remove duplicates by (type,name); prefer user-provided "additional" versions.
  return dedupeExtensions([...base, ...additionalDeduped]);
}
