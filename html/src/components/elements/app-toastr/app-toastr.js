import AbstractElement from '../AbstractElement.js';
import {Notyf} from 'notyf';

class AppToastrElement extends AbstractElement {
    static properties = {
        duration: {type: Number},
        positionX: {type: String, attribute: 'position-x'},
        positionY: {type: String, attribute: 'position-y'},
        dismissible: {type: Boolean},
        message: {type: String},
        type: {type: String},
    };

    static notyf = new Notyf({
        types: [
            {
                type: 'warning',
                className: 'toastr-warning',
                background: 'var(--toastr-background)',
            },
            {
                type: 'message',
                className: 'toastr-message',
                background: 'var(--toastr-background)',
            },
            {
                type: 'info',
                className: 'toastr-info',
                background: 'var(--toastr-background)',
            },
            {
                type: 'error',
                className: 'toastr-error',
                background: 'var(--toastr-background)',
            },
            {
                type: 'success',
                className: 'toastr-success',
                background: 'var(--toastr-background)',
            }
        ]
    });

    constructor() {
        super();
        this.duration = 5000;
        this.positionX = 'right';
        this.positionY = 'bottom';
        this.dismissible = false;
        this.type = 'message';
    }

    update(changed) {
        super.update(changed);

        AppToastrElement.notyf.open({
            duration: this.duration,
            position: {x: this.positionX, y: this.positionY},
            dismissible: this.dismissible,
            type: this.type,
            message: this.message,
        });
    }
}

customElements.define('app-toastr', AppToastrElement);
