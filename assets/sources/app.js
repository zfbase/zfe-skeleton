import './app.scss';
import $ from 'jquery';
import App from 'zfe';
import plupload from 'plupload';

window.jQuery = $;
window.$ = $;

require('bootstrap-sass');

window.App = App;

App.init();


const cont = $('#plupload');
const modelName = cont.data('model');
const itemId = cont.data('id');

var uploader = new plupload.Uploader({
  browse_button: 'plupload-browse', // this can be an id of a DOM element or the DOM element itself
  url: `/upload.php?m=${modelName}&id=${itemId}`,
  chunk_size: '2mb',
  max_retries: 3,
});

uploader.bind('PostInit', () => {
  console.log('plupload inited');
});

uploader.bind('FilesAdded', function(up, files) {
  var html = '';
  plupload.each(files, function(file) {
    html += '<li id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></li>';
  });
  document.getElementById('plupload-ls').innerHTML += html;
});

uploader.bind('UploadProgress', function(up, file) {
  document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
});

uploader.bind('Error', function(up, err) {
  document.getElementById('plupload-console').innerHTML += "\nError #" + err.code + ": " + err.message;
});

uploader.init();

document.getElementById('plupload-start').onclick = function() {
  uploader.start();
};

// 150 + 97 + 393 = 247 + 393 = 640 ms
//