import './app.scss';
import $ from 'jquery';
import App from 'zfe';
import plupload from 'plupload';

window.jQuery = $;
window.$ = $;

require('bootstrap-sass');

window.App = App;

App.init();

const containers = $('.plupload');
containers.each((index, cont) => {
  const $cont = $(cont);
  const modelName = $cont.data('model');
  const itemId = $cont.data('id');
  const code = $cont.data('code');

  var uploader = new plupload.Uploader({
    browse_button: $cont.find('.plupload-browse')[0], // this can be an id of a DOM element or the DOM element itself
    url: `/upload.php?m=${modelName}&id=${itemId}&c=${code}`,
    chunk_size: '2mb',
    max_retries: 3,
  });

  uploader.bind('FilesAdded', function(up, files) {
    let html = '';
    plupload.each(files, function(file) {
      html += '<li id="file-' + file.id + '" class="list-group-item">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></li>';
    });
    $cont.parents('.panel').find('.files-list').append(html);
    //document.getElementById('plupload-ls').innerHTML += html;
  });

  uploader.bind('UploadProgress', function(up, file) {
    document.getElementById('file-' + file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
  });

  uploader.bind('Error', function(up, err) {
    $cont.find('.plupload-console')[0].innerHTML += "\nError #" + err.code + ": " + err.message;
  });

  uploader.init();

  $cont.find('.plupload-start').on('click', () => {
    uploader.start();
  });

});


// 150 + 97 + 393 = 247 + 393 = 640 ms
//