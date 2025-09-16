
/**
 *check if password and confirmPassword are the same
 * @param {string} password
 * @param {string} confirmPassword
 * @returns {boolean}
 */
function confirmPassword(password, confirmPassword) {
    return password === confirmPassword;
}

/**
 * Check if password is strong
 * @param {string|null|undefined} password
 * @returns {{valid: boolean, messages: string[]}} - valid: true if password is strong, messages: array of error messages
 */
function strongPassword(password) {
    const messages = [];

    if (!password || typeof password !== "string") {
        messages.push("كلمة المرور مطلوبة");
        return { valid: false, messages };
    }

    if (password.length < 8) {
        messages.push("كلمة المرور يجب أن تكون 8 أحرف على الأقل");
    }
    if (!/[a-z]/.test(password)) {
        messages.push("يجب أن تحتوي على حرف صغير واحد على الأقل");
    }
    if (!/[A-Z]/.test(password)) {
        messages.push("يجب أن تحتوي على حرف كبير واحد على الأقل");
    }
    if (!/[0-9]/.test(password)) {
        messages.push("يجب أن تحتوي على رقم واحد على الأقل");
    }
    if (!/[@$!%*?&]/.test(password)) {
        messages.push("يجب أن تحتوي على رمز خاص واحد على الأقل (@$!%*?&)");
    }

    return {
        valid: messages.length === 0,
        messages
    };
}

/**
 * Validate photo file type and size
 * @param {File} files
 * @param {number} maxSizeMB - default 2MB
 * @param {Array} allowedTypes - default ['image/jpeg', 'image/png', 'image/gif', 'image/webp']
 * @returns {Object} {valid: boolean, message: string}
 */
function photoValidation(files, maxSizeMB = 2, allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp']) {
    const maxSize = maxSizeMB * 1024 * 1024;
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        if (!allowedTypes.includes(file.type)) {
            return { valid: false, message: 'Invalid file type. Only JPG, PNG, GIF, and WEBP are allowed.' };
        }
        if (file.size > maxSize) {
            return { valid: false, message: 'File size exceeds the 2MB limit.' };
        }
    }
    return { valid: true, message: 'All files are valid.' };
}

function validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}
/**
 * Validate phone number in E.164 format
 * @param {string} phone
 * @returns {boolean}
 */
function validatePhoneNumber(phone) {
    const regex = /^\+?[1-9]\d{1,14}$/; // E.164 format
    return regex.test(phone);
}

/**
 * Validate username
 * @param {string} username
 * @returns {boolean}
 */
function validateUsername(username) {
    const regex = /^[a-zA-Z0-9._-]{3,20}$/; // Alphanumeric, dots, underscores, hyphens, 3-20 characters
    return regex.test(username);
}

/**
 * Validate files type and size
 * @param {File} files
 * @param {number} maxSizeMB - default 5MB
 * @param {Array} allowedTypes - default ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']
 * @returns {Object} {valid: boolean, message: string}
 */
function filesValidation(files, maxSizeMB = 5, allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']) {
    const maxSize = maxSizeMB * 1024 * 1024;
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        if (!allowedTypes.includes(file.type)) {
            return { valid: false, message: 'Invalid file type. Only JPG, PNG, GIF, WEBP, PDF, and DOCX are allowed.' };
        }
        if (file.size > maxSize) {
            return { valid: false, message: `File size exceeds the ${maxSizeMB}MB limit.` };
        }
    }
    return { valid: true, message: 'All files are valid.' };
}


export {
    confirmPassword,
    strongPassword,
    photoValidation,
    validateEmail,
    validatePhoneNumber,
    validateUsername,
    filesValidation
};
