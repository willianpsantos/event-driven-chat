HTMLElement.prototype.disable = function () {
    this.setAttribute('disabled', 'disabled');
};

HTMLElement.prototype.enable = function () {
    this.removeAttribute('disabled');
};

HTMLFormElement.prototype.disable = function () {
    const items = this.querySelectorAll('input, button, select, textarea');

    items.forEach(item => {
        item.setAttribute('disabled', 'disabled');
    });
};

HTMLFormElement.prototype.enable = function () {
    const items = this.querySelectorAll('input, button, select, textarea');

    items.forEach(item => {
        item.removeAttribute('disabled');
    });
};

HTMLElement.prototype.show = function(display) {
    if ( display === undefined || display === null || display === "") {
        display = "block";
    }

    this.style.display = display;
}

HTMLElement.prototype.hide = function() {
    this.style.display = 'none';
}

HTMLCollection.prototype.forEach = function (callback) {
    for (let i = 0; i < this.length; i++) {
        const item = this.item(i);
        callback.call(this, item);
    }
};