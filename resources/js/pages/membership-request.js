import fileUploadComponent from "@client/components/file-upload";
import selectComponent from "@client/components/selectComponent";



document.addEventListener('alpine:init', () => {
    Alpine.data('fileUploadComponent', fileUploadComponent);
    Alpine.data('selectComponent', selectComponent);
});
