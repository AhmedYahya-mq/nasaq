import * as FilePond from 'filepond';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';

import 'filepond/dist/filepond.min.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';


import { revert, process, remove, restore } from '@client/routes/client/filepond';

FilePond.registerPlugin(
    FilePondPluginFileValidateType,
    FilePondPluginFileValidateSize,
    FilePondPluginImagePreview
);

export default function fileUploadComponent(options) {
    return {
        pond: null,

        init() {
            this.pond = FilePond.create(this.$refs.filepondInput, {
                name: options.multiple ? `file[]` : 'file',
                required: options.required,
                allowMultiple: options.multiple,
                maxFileSize: options.maxSize,
                acceptedFileTypes: options.accepted.split(','),
                maxFiles: options.maxFiles || null,
                credits: false,
                server: {
                    process: {
                        ...process(),
                        headers: { 'X-CSRF-TOKEN': options.csrf },
                    },
                    revert: {
                        ...revert(),
                        headers: { 'X-CSRF-TOKEN': options.csrf },
                    },
                    restore: (uniqueFileId, load, error, progress, abort, headers) => {
                        axios.get(restore(uniqueFileId), {
                            responseType: 'blob',
                            headers: { 'X-CSRF-TOKEN': options.csrf },
                        })
                            .then(res => {
                                load(res.data);
                            })
                            .catch(() => error('Restore failed'));
                    },
                    remove: {
                        ...remove(),
                        headers: { 'X-CSRF-TOKEN': options.csrf },
                    },
                },
                labelIdle: options.labelIdle,
                labelFileProcessing: options.labelFileProcessing,
                labelFileProcessingComplete: options.labelFileProcessingComplete,
                labelTapToUndo: options.labelTapToUndo,
                labelTapToCancel: options.labelTapToCancel,
            });
        },
    };
}
