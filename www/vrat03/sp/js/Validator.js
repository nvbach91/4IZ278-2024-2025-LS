export default class Validator {

    constructor(fields) {
        this.errors = {};
        this.inputs = {};
        this.fields = fields;
        this.submiButton = document.getElementById('submitButton');

        this.fields.forEach(fieldObj => {
            var input = document.getElementById(fieldObj.inputId)
            this.inputs[fieldObj.inputId+'Input'] = input;
            input.addEventListener('input', () => this.validateField(fieldObj));
        });
    }

    addCheckbox(containerId, name) {
        const container = document.getElementById(containerId);
        const checkboxes = document.querySelectorAll('input[type="checkbox"][name="' + name + '[]"]');
        container.addEventListener('change', (e) => this.checkIfAnyChecked(checkboxes, name));
    }

    checkIfAnyChecked(checkboxes, name) {
        const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
        console.log('anyChecked', anyChecked);
        const errorId = 'alert' + name[0].charAt(0).toUpperCase() + name.slice(1);
        if (!anyChecked) {
            this.errors[name] = `At least one ${name} must be selected.`;
            this.showError(errorId, this.errors[name]);
        } else {
            delete this.errors[name];
            this.showError(errorId, '');
        }

    }

    validateField(fieldObj) {
        this.errors = {};
        fieldObj.validate();
        const errorMsg = this.errors[fieldObj.inputId] || '';
        this.showError(fieldObj.errorId, errorMsg); 
    };

    showError(errorId, message) {
        const errorDiv = document.getElementById(errorId);
        if (errorDiv) {
            errorDiv.textContent = message;
            if (message) {
                errorDiv.style.display = 'block';
                this.submitButtonHandler('disable');
            }else {
                errorDiv.style.display = 'none';
                this.submitButtonHandler('enable');
            }
        }
    };

    submitButtonHandler(state) {
        switch (state) {
            case 'enable':
                this.submiButton.disabled = false;
                this.submiButton.classList.remove('disabled');
                break;
            case 'disable':
                this.submiButton.disabled = true;
                this.submiButton.classList.add('disabled');
                break;
            default:
        }
    }

    validateRequired(field, value) {
        if (!value || value.toString().trim() === '') {
            this.errors[field] = `Field '${field}' must be filled.`;
            return false;
        }
        return true;
    }

    validateEmailFormat(field, value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            this.errors[field] = `Invalid ${field} format.`;
            return false;
        }
        return true;
    }

    validatePhoneFormat(field, value) {
        if (value && !/^(\+\d{1,3} )?([0-9] ?){9}$/.test(value)) {
            this.errors[field] = `Invalid ${field} number format.`;
            return false;
        }
        return true;
    }

    validateMatch(field, value1, value2) {
        if (value1 !== value2) {
            this.errors[field] = `${field} do not match`;
            return false;
        }
        return true;
    }

    validateNumber(field, value) {
        if (!(Number(value) > 0)) {
            this.errors[field] = `${field} must be a positive number`;
            return false;
        }
        return true;
    }

    validateMinLength(field, minLength, value) {
        if (value.length < minLength) {
            this.errors[field] = `${field} must be at least ${minLength} characters long.`;
            return false;
        }
        return true;
    }

    validateURL(field, value) {
        try {
            new URL(value);
            return true;
        } catch {
            this.errors[field] = `Invalid ${field} URL format.`;
            return false;
        }
    }

    validateRequiredField(field, value) {
        this.validateRequired(field, value);
    }

    validateEmail(field, value) {
        this.validateRequired(field, value) &&
        this.validateEmailFormat(field, value);
    }

    validatePassword(field, value1, value2, minLength = 8) {
        this.validateRequired(field, value1) &&
        this.validateMinLength(field, minLength, value1) &&
        this.validateRequired(field + '2', value2) &&
        this.validateMatch(field + '2', value1, value2);
    }

    validatePhone(field, value) {
        this.validatePhoneFormat(field, value);
    }

    validateNumberField(field, value) {
        this.validateRequired(field, value) &&
        this.validateNumber(field, value);
    }

    validateURLField(field, value) {
        this.validateRequired(field, value) &&
        this.validateURL(field, value);
    }

    getErrors() {
        return this.errors;
    }

    hasErrors() {
        return Object.keys(this.errors).length > 0;
    }
}
