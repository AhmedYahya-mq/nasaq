export default function chunkedUpload(options = {}) {
    return {
        file: null,
        isUploading: false,
        isDone: false,
        progress: 0,
        uploadedChunks: [],
        missingChunks: [],
        uploadId: null,
        finalPath: null,
        errorMessage: null,
        chunkSize: options.chunkSize || 5 * 1024 * 1024,

        async fingerprint(file) {
            const text = [file.name, file.size, file.type || '', file.lastModified || 0].join('|');
            const encoded = new TextEncoder().encode(text);
            const digest = await crypto.subtle.digest('SHA-256', encoded);
            return Array.from(new Uint8Array(digest))
                .map((byte) => byte.toString(16).padStart(2, '0'))
                .join('');
        },

        async refreshProgress(file) {
            const uploadHash = await this.fingerprint(file);
            const response = await axios.get(options.progressUrl, {
                params: {
                    filename: file.name,
                    total: Math.ceil(file.size / this.chunkSize),
                    file_size: file.size,
                    upload_hash: uploadHash,
                },
                headers: {
                    'X-CSRF-TOKEN': options.csrf,
                },
            });

            const payload = response.data || {};
            this.uploadId = payload.upload_id || uploadHash;
            this.finalPath = payload.final_path || null;
            this.uploadedChunks = payload.uploaded_chunks || [];
            this.missingChunks = payload.missing_chunks || [];
            this.progress = payload.progress || 0;
            this.isDone = Boolean(payload.done);

            return { uploadHash, payload };
        },

        async start(file) {
            if (!file || this.isUploading) {
                return;
            }

            this.file = file;
            this.isUploading = true;
            this.isDone = false;
            this.progress = 0;
            this.errorMessage = null;

            try {
                const { uploadHash, payload } = await this.refreshProgress(file);
                const totalChunks = Math.ceil(file.size / this.chunkSize);
                const uploaded = new Set((payload.uploaded_chunks || []).map((value) => Number(value)));

                for (let index = 0; index < totalChunks; index += 1) {
                    if (uploaded.has(index)) {
                        continue;
                    }

                    const start = index * this.chunkSize;
                    const end = Math.min(start + this.chunkSize, file.size);
                    const chunk = file.slice(start, end);
                    const formData = new FormData();
                    formData.append('file', chunk, file.name);
                    formData.append('index', index);
                    formData.append('total', totalChunks);
                    formData.append('filename', file.name);
                    formData.append('file_size', file.size);
                    formData.append('upload_hash', uploadHash);

                    const response = await axios.post(options.uploadUrl, formData, {
                        headers: {
                            'X-CSRF-TOKEN': options.csrf,
                            'Content-Type': 'multipart/form-data',
                        },
                    });

                    const body = response.data || {};
                    this.uploadId = body.upload_id || this.uploadId;
                    this.finalPath = body.final_path || this.finalPath;
                    this.uploadedChunks = body.uploaded_chunks || this.uploadedChunks;
                    this.missingChunks = body.missing_chunks || [];
                    this.progress = body.progress || Math.round(((index + 1) / totalChunks) * 100);

                    if (body.done) {
                        this.isDone = true;
                        this.progress = 100;
                        this.finalPath = body.final_path || this.finalPath;
                        break;
                    }
                }

                if (!this.isDone) {
                    const latest = await this.refreshProgress(file);
                    this.isDone = Boolean(latest.payload.done);
                    this.finalPath = latest.payload.final_path || this.finalPath;
                    this.progress = latest.payload.progress || this.progress;
                }
            } catch (error) {
                this.errorMessage = error?.response?.data?.message || error?.message || 'Upload failed';
            } finally {
                this.isUploading = false;
            }
        },
    };
}
