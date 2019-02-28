import './app.scss';
import $ from 'jquery';
import App from 'zfe';

window.jQuery = $;
window.$ = $;

require('bootstrap-sass');

window.App = App;

App.init();
