export const HTMLSafeString = (function(text) {

    this.textContent = text;
    return this.innerHTML;

}).bind(document.createElement('div'));
