window._ = require('lodash');

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    window.Noty = require('noty');
} catch (e) {}

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Noty.overrideDefaults({
    layout: 'topRight',
    theme: 'relax',
    closeWith: ['click', 'button'],
});