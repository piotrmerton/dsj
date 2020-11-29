//we are importing stylesheets related files here, because putting non-js files as webpack entries generate js as well, see: https://github.com/webpack-contrib/extract-text-webpack-plugin/issues/518
import '../scss/global.scss';

import { UI } from './ui';

document.addEventListener("DOMContentLoaded", () => { 
    UI.init();
    UI.tabs.bind();
} );

window.addEventListener('resize', () => { UI.init() } );